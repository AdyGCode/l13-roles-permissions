<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seedUsers = [
            [
                'id' => 100,
                'name' => 'Ad Ministrator',
                'email' => 'admin@example.com',
                'password' => bcrypt('Password1'),
                'permissions' => [],
                'roles' => ['admin']
            ],
            [
                'id' => 200,
                'name' => 'Staff Member',
                'email' => 'staff@example.com',
                'password' => bcrypt('Password1'),
                'permissions' => [],
                'roles' => ['staff']
            ],
            [
                'id' => 1000,
                'name' => 'Client User',
                'email' => 'client@example.com',
                'password' => bcrypt('Password1'),
                'permissions' => [],
                'roles' => ['client']
            ],
        ];

        foreach ($seedUsers as $seedUser) {
            $permissions = $seedUser['permissions'];
            $roles = $seedUser['roles'];
            unset($seedUser['permissions']);
            unset($seedUser['roles']);

            $user = User::create($seedUser);
            $user->permissions()->sync($permissions);
            $user->syncRoles($roles);
        }
    }
}
