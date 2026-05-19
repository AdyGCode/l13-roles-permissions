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

test('admin can view article list', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('articles.index'));
    $response->assertStatus(200);
});

test('viewer can view article list', function () {
    $response = $this->actingAs($this->viewer)
        ->get(route('articles.index'));
    $response->assertStatus(200);
});

test('unauthenticated user is redirected to login', function () {
    $response = $this->get(route('articles.index'));
    $response->assertRedirect(route('login'));
});
