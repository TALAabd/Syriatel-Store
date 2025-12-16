<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view products',
            'create products',
            'edit products',
            'delete products',
            'view orders',
            'create orders',
            'edit orders',
            'delete orders',
            'manage users'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $supplier = Role::firstOrCreate(['name' => 'supplier']);
        $customer = Role::firstOrCreate(['name' => 'customer']);

        $admin->givePermissionTo(Permission::all());

        $supplier->givePermissionTo([
            'view products',
            'create products',
            'edit products',
            'view orders'
        ]);

        $customer->givePermissionTo([
            'view products',
            'create orders',
            'view orders'
        ]);
    }
}
