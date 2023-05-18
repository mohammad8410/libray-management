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

        Permission::create(['name' => 'view any book']);
        Permission::create(['name' => 'store a book']);
        Permission::create(['name' => 'update a book']);
        Permission::create(['name' => 'delete a book']);

        $role1 = Role::create(['name' => 'super-admin']);
        $role1->syncPermissions(['view any book','store a book','update a book','delete a book']);

        $role2 = Role::create(['name' => 'user']);
        $role2->syncPermissions(['view any book']);
    }
}
