<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\PermissionServiceProvider;

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
        Permission::create(['name' => 'increase book count']);
        Permission::create(['name' => 'decrease book count']);
        Permission::create(['name' => 'borrow a book']);
        Permission::create(['name' => 'return a book']);


        Permission::create(['name' => 'view any user']);
        Permission::create(['name' => 'view own info']);
        Permission::create(['name' => 'update own info']);
        Permission::create(['name' => 'delete own account']);



        $role1 = Role::create(['name' => 'super-admin']);
        $role1->syncPermissions(['view any book','store a book','update a book','delete a book'
            ,'increase book count','decrease book count','borrow a book','return a book'
            ,'view own info','view any user','update own info']);
        $role2 = Role::create(['name' => 'user']);
        $role2->syncPermissions(['view any book','borrow a book','return a book','view own info'
            ,'update own info','delete own account']);
    }
}
