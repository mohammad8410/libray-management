<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'store a book']);


        $role1 = Role::create(['name' => 'super-admin']);
        $role1->syncPermissions(['store a book']);

        $role2 = Role::create(['name' => 'user']);
        $role2->syncPermissions([]);
    }
}
