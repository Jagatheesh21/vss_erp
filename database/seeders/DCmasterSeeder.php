<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DcMaster;

class DcMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $DCMaster1 = DcMaster::create([
            'supplier_id' => 1,
            'part_id' => 1,
            'operation_id' => 17,
            'prepared_by'=>1
        ]);
    }
}
