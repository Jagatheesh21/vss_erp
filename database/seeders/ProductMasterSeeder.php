<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductMaster;

class ProductMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $productMaster1 = ProductMaster::create([
            'part_no' => '29192718',
            'part_desc' => 'Spring',
            'prepared_by'=>'1'
        ]);
        $productMaster2 = ProductMaster::create([
            'part_no' => '29192710',
            'part_desc' => 'Spring',
            'prepared_by'=>'1'
        ]);
        $productMaster3 = ProductMaster::create([
            'part_no' => '29371408',
            'part_desc' => 'Spring',
            'prepared_by'=>'1'
        ]);
    }
}
