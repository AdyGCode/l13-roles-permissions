<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seedRoles = [
            // Roles depend on the application's requirements
            ['name' => 'super-admin'],
            ['name' => 'admin'],
            ['name' => 'staff'],
            ['name' => 'client'],
            ['name' => 'editor'],
            ['name' => 'writer'],

        ];

        $seedPermissions = [
            //     [ 'permission'=>'', 'roles'=>['']],
            ['permission' => 'user-add', 'roles' => ['admin', 'staff']],
            ['permission' => 'user-edit', 'roles' => ['admin', 'staff']],
            ['permission' => 'user-browse', 'roles' => ['admin', 'staff']],
            ['permission' => 'user-read', 'roles' => ['admin']],
            ['permission' => 'user-delete', 'roles' => ['admin']],

            ['permission' => 'users-count', 'roles' => ['admin', 'staff']],
            ['permission' => 'client-only', 'roles' => ['client']],
            ['permission' => 'staff-only', 'roles' => ['staff']],
            ['permission' => 'admin-only', 'roles' => ['admin']],

            ['permission' => 'articles-view', 'roles' => ['admin', 'staff', 'editor', 'writer', 'client']],
            ['permission' => 'articles-add', 'roles' => ['admin', 'writer']],
            ['permission' => 'articles-edit', 'roles' => ['admin', 'writer', 'editor']],
            ['permission' => 'articles-publish', 'roles' => ['admin', 'editor', 'staff']],

        ];

        foreach ($seedRoles as $newRole) {
            $role = Role::findOrCreate($newRole['name']);
        }

        foreach ($seedPermissions as $seedPermission) {
            $permission = Permission::findOrCreate($seedPermission['permission']);
            $permission->syncRoles($seedPermission['roles']);
        }
    }
}
