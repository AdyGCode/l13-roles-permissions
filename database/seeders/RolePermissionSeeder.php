<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        ];

        foreach ($seedRoles as $role) {
            $role = Role::create($role);
        }

        foreach ($seedPermissions as $seedPermission) {
            $newPermission = ['name' => $seedPermission['permission']];
            $permission = Permission::create($newPermission);
            $permission->syncRoles($seedPermission['roles']);
        }
    }
}
