<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductProcessMaster;

class ProductProcessMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $productProcessMaster1 = ProductProcessMaster::create([
            'part_id' => 1,
            'process_master_id' => 1,
            'process_order_id' => 1,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster2 = ProductProcessMaster::create([
            'part_id' => 1,
            'process_master_id' => 2,
            'process_order_id' => 2,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster3 = ProductProcessMaster::create([
            'part_id' => 1,
            'process_master_id' => 4,
            'process_order_id' => 3,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster4 = ProductProcessMaster::create([
            'part_id' => 1,
            'process_master_id' => 9,
            'process_order_id' => 4,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster5 = ProductProcessMaster::create([
            'part_id' => 1,
            'process_master_id' => 10,
            'process_order_id' => 5,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster6 = ProductProcessMaster::create([
            'part_id' => 1,
            'process_master_id' => 11,
            'process_order_id' => 6,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster7 = ProductProcessMaster::create([
            'part_id' => 2,
            'process_master_id' => 1,
            'process_order_id' => 1,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster8 = ProductProcessMaster::create([
            'part_id' => 2,
            'process_master_id' => 2,
            'process_order_id' => 2,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster9 = ProductProcessMaster::create([
            'part_id' => 2,
            'process_master_id' => 3,
            'process_order_id' => 3,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster10 = ProductProcessMaster::create([
            'part_id' => 2,
            'process_master_id' => 6,
            'process_order_id' => 4,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster11 = ProductProcessMaster::create([
            'part_id' => 2,
            'process_master_id' => 9,
            'process_order_id' => 5,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster12 = ProductProcessMaster::create([
            'part_id' => 2,
            'process_master_id' => 10,
            'process_order_id' =>6,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster13 = ProductProcessMaster::create([
            'part_id' => 2,
            'process_master_id' => 11,
            'process_order_id' => 7,
            'prepared_by'=>'1'
        ]);
    }
}
