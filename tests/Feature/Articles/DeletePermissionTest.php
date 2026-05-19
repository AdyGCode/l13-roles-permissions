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

test('admin can delete an article', function () {
    $article = Article::factory()
        ->create(['user_id' => $this->admin->id]);

    $response = $this->actingAs($this->admin)
        ->delete(route('articles.destroy', $article));

    $response->assertRedirect(route('articles.index'));
    $this->assertDatabaseMissing('articles', ['id' => $article->id]);
});

test('editor cannot delete an article', function () {
    $article = Article::factory()
        ->create(['user_id' => $this->editor->id]);

    $response = $this->actingAs($this->editor)
        ->delete(route('articles.destroy', $article));
    $response->assertStatus(403);

    $this->assertDatabaseHas('articles', ['id' => $article->id]);
});

test('viewer cannot delete an article', function () {
    $article = Article::factory()
        ->create(['user_id' => $this->admin->id]);

    $response = $this->actingAs($this->viewer)
        ->delete(route('articles.destroy', $article));
    $response->assertStatus(403);
});
