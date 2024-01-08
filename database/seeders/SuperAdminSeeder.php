<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'SuperAdmin', 
            'email' => 'admin@admin.com',
            'username' => '100',
            'password' => Hash::make('admin@123')
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Edp', 
            'email' => 'edp@vssipl.com',
            'username' => '101',
            'password' => Hash::make('vssipl@1234')
        ]);
        $admin->assignRole('Admin');

        // Creating Product Manager User
        $productManager = User::create([
            'name' => 'Abdul Muqeet', 
            'email' => 'muqeet@allphptricks.com',
            'username' => '102',
            'password' => Hash::make('muqeet1234')
        ]);
        $productManager->assignRole('Product Manager');
    }
}
