<?php

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\PermissionRegistrar;

uses(RefreshDatabase::class);

beforeEach(function () {
    app()[PermissionRegistrar::class]->forgetCachedPermissions();

    $this->seed(RolePermissionSeeder::class);

    $this->admin = User::factory()
        ->create()
        ->assignRole('admin');
    $this->editor = User::factory()
        ->create()
        ->assignRole('editor');
    $this->viewer = User::factory()
        ->create()
        ->assignRole('viewer');

});

test('admin can access create form', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('articles.create'));
    $response->assertStatus(200);
});

test('editor can access create form', function () {
    $response = $this->actingAs($this->editor)
        ->get(route('articles.create'));
    $response->assertStatus(200);
});

test('viewer cannot access create form', function () {
    $response = $this->actingAs($this->viewer)
        ->get(route('articles.create'));
    $response->assertStatus(403);
});

test('admin can store an article', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('articles.store'), [
            'title' => 'Admin Article',
            'content' => 'Content by admin.',
            'status' => 'published',
        ]);

    $response->assertRedirect(route('articles.index'));
    $this->assertDatabaseHas('articles', ['title' => 'Admin Article']);
});

test('viewer cannot store an article', function () {
    $response = $this->actingAs($this->viewer)
        ->post(route('articles.store'), [
            'title' => 'Viewer Article',
            'content' => 'This should fail.',
            'status' => 'draft',
        ]);

    $response->assertStatus(403);
    $this->assertDatabaseMissing('articles', ['title' => 'Viewer Article']);
});
