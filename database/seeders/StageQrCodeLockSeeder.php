<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StageQrCodeLock;

class StageQrCodeLockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $StageQrCodeLock1=StageQrCodeLock::create([
            'stage'=>'Purchase',
            'activity'=>'PO Generation',
            'prepared_by'=> 1
        ]);

        $StageQrCodeLock2=StageQrCodeLock::create([
            'stage'=>'Store',
            'activity'=>'GRN Material Inward',
            'prepared_by'=> 1
        ]);

        $StageQrCodeLock3=StageQrCodeLock::create([
            'stage'=>'QA',
            'activity'=>'GRN Clearance',
            'prepared_by'=> 1
        ]);

        $StageQrCodeLock4=StageQrCodeLock::create([
            'stage'=>'Store',
            'activity'=>'RM Issuance',
            'prepared_by'=> 1
        ]);

    }
}
