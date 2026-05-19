<?php

use App\Models\Article;
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

test('admin can edit an article', function () {
    $article = Article::factory()
        ->create(['user_id' => $this->admin->id]);

    $response = $this->actingAs($this->admin)
        ->get(route('articles.edit', $article));
    $response->assertStatus(200);
});

test('editor can edit an article', function () {
    $article = Article::factory()
        ->create(['user_id' => $this->editor->id]);

    $response = $this->actingAs($this->editor)
        ->get(route('articles.edit', $article));
    $response->assertStatus(200);
});

test('viewer cannot edit an article', function () {
    $article = Article::factory()->create(['user_id' => $this->admin->id]);

    $response = $this->actingAs($this->viewer)
        ->get(route('articles.edit', $article));
    $response->assertStatus(403);
});
