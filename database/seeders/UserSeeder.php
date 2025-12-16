<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $admin = User::create([
            'name' => 'System Admin',
            'email' => 'admin@estore.com',
            'password' => Hash::make('123456'),
            'role' => 'admin', 
        ]);
        $admin->assignRole('admin');

        $supplierUser = User::create([
            'name' => 'Main Supplier',
            'email' => 'supplier@estore.com',
            'password' => Hash::make('123456'),
            'role' => 'supplier',
        ]);
        $supplierUser->assignRole('supplier');

        Supplier::create([
            'user_id' => $supplierUser->id,
            'company_name' => 'Tech Supplies',
            'company_address' => 'Damascus, Syria',
            'phone' => '0933333333',
        ]);

        $customerUser = User::create([
            'name' => 'John Customer',
            'email' => 'customer@estore.com',
            'password' => Hash::make('123456'),
            'role' => 'customer',
        ]);
        $customerUser->assignRole('customer');

        Customer::create([
            'user_id' => $customerUser->id,
            'phone' => '0999999999',
            'address' => 'Aleppo, Syria',
        ]);
    }
}
