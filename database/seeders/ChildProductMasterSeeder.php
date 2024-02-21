<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ChildProductMaster;

class ChildProductMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $childProductMaster1 = ChildProductMaster::create([
            'stocking_point' => '10',
            'child_part_no' => '29192718',
            'part_id' => '1',
            'prepared_by'=>'1'
        ]);
        $childProductMaster2 = ChildProductMaster::create([
            'stocking_point' => '10',
            'child_part_no' => '29192710',
            'part_id' => '2',
            'prepared_by'=>'1'
        ]);
    }
}
