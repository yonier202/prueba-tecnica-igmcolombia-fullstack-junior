<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create([
            'id' => 1,
            'name' => 'admin',
        ]);

        $user = Role::create([
            'id' => 2,
            'name' => 'user',
        ]);

        Permission::create([
            'id' => 1,
            'name' => 'administrador'
        ])->assignRole($adminRole);
    }
}
