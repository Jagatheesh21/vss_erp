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
            'email' => 'edp@venkateswarasteels.com',
            'username' => '100',
            'password' => Hash::make('admin@123'),
            'prepared_by'=>'1'
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Edp',
            'email' => 'edp@venkateswarasteels.com',
            'username' => '101',
            'password' => Hash::make('vssipl@1234'),
            'prepared_by'=>'1'
        ]);
        $admin->assignRole('Admin');

        // Creating Product Manager User
        $productManager = User::create([
            'name' => 'PPC',
            'email' => 'pur@venkateswarasteels.com',
            'username' => '102',
            'password' => Hash::make('ppc@12345'),
            'prepared_by'=>'1'
        ]);
        $productManager->assignRole('Product Manager');

        $purchase = User::create([
            'name' => 'Purchase',
            'email' => 'pur1@venkateswarasteels.com',
            'username' => '103',
            'password' => Hash::make('pur1@12345'),
            'prepared_by'=>'1'
        ]);
        $purchase->assignRole('Purchase');

        $storekeeper = User::create([
            'name' => 'SakthiVel',
            'email' => 'stores@venkateswarasteels.com',
            'username' => '104',
            'password' => Hash::make('stores@12345'),
            'prepared_by'=>'1'
        ]);
        $storekeeper->assignRole('Store Keeper');

        $sfstorekeeper = User::create([
            'name' => 'Manoj',
            'email' => 'stores@venkateswarasteels.com',
            'username' => '105',
            'password' => Hash::make('sfstores@12345'),
            'prepared_by'=>'1'
        ]);
        $sfstorekeeper->assignRole('SF Store Keeper');

        $fgstorekeeper = User::create([
            'name' => 'KESAVALU',
            'email' => 'stores@venkateswarasteels.com',
            'username' => '106',
            'password' => Hash::make('fg@12345'),
            'prepared_by'=>'1'
        ]);
        $fgstorekeeper->assignRole('FG Store Keeper');

        $salesManager = User::create([
            'name' => 'Saravanan',
            'email' => 'sales@venkateswarasteels.com',
            'username' => '107',
            'password' => Hash::make('sales@12345'),
            'prepared_by'=>'1'
        ]);
        $salesManager->assignRole('Sales Manager');

        $iqc = User::create([
            'name' => 'Dharani',
            'email' => 'qad@venkateswarasteels.com',
            'username' => '108',
            'password' => Hash::make('iqc@12345'),
            'prepared_by'=>'1'
        ]);
        $iqc->assignRole('Incoming QC');

        $fqc = User::create([
            'name' => 'SakthiVel',
            'email' => 'upload@venkateswarasteels.com',
            'username' => '109',
            'password' => Hash::make('fg@12345'),
            'prepared_by'=>'1'
        ]);
        $fqc->assignRole('Final QC');

        $qc_manager = User::create([
            'name' => 'Thaigarajan',
            'email' => 'qam@venkateswarasteels.com',
            'username' => '110',
            'password' => Hash::make('qam@12345'),
            'prepared_by'=>'1'
        ]);
        $qc_manager->assignRole('Quality Manager');

        $scrap_incharge = User::create([
            'name' => 'Kalimuthu',
            'email' => 'qad@venkateswarasteels.com',
            'username' => '111',
            'password' => Hash::make('Kalimuthu@12345'),
            'prepared_by'=>'1'
        ]);
        $scrap_incharge->assignRole('Scrap Incharge');

        $user=User::create([
            'name' => 'User',
            'email' => 'edp@venkateswarasteels.com',
            'username' => '112',
            'password' => Hash::make('user@12345'),
            'prepared_by'=>'1'
        ]);
        $user->assignRole('User');
    }
}
