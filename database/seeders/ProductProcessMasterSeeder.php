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
            'foreman_id' => 1,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster2 = ProductProcessMaster::create([
            'part_id' => 1,
            'process_master_id' => 2,
            'process_order_id' => 2,
            'foreman_id' => 1,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster3 = ProductProcessMaster::create([
            'part_id' => 1,
            'process_master_id' => 3,
            'process_order_id' => 3,
            'foreman_id' => 1,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster4 = ProductProcessMaster::create([
            'part_id' => 1,
            'process_master_id' => 6,
            'process_order_id' => 4,
            'foreman_id' => 1,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster5 = ProductProcessMaster::create([
            'part_id' => 1,
            'process_master_id' => 12,
            'process_order_id' => 5,
            'foreman_id' => 1,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster6 = ProductProcessMaster::create([
            'part_id' => 1,
            'process_master_id' => 15,
            'process_order_id' => 6,
            'foreman_id' => 1,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster7 = ProductProcessMaster::create([
            'part_id' => 1,
            'process_master_id' => 17,
            'process_order_id' => 7,
            'foreman_id' => 1,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster8 = ProductProcessMaster::create([
            'part_id' => 1,
            'process_master_id' => 18,
            'process_order_id' => 8,
            'foreman_id' => 1,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster9 = ProductProcessMaster::create([
            'part_id' => 1,
            'process_master_id' => 19,
            'process_order_id' => 9,
            'foreman_id' => 1,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster10 = ProductProcessMaster::create([
            'part_id' => 1,
            'process_master_id' => 20,
            'process_order_id' => 10,
            'foreman_id' => 1,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster11 = ProductProcessMaster::create([
            'part_id' => 1,
            'process_master_id' => 21,
            'process_order_id' => 11,
            'foreman_id' => 1,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster12= ProductProcessMaster::create([
            'part_id' => 1,
            'process_master_id' => 22,
            'process_order_id' => 12,
            'foreman_id' => 1,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster13 = ProductProcessMaster::create([
            'part_id' => 2,
            'process_master_id' => 1,
            'process_order_id' => 1,
            'foreman_id' => 1,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster14= ProductProcessMaster::create([
            'part_id' => 2,
            'process_master_id' => 2,
            'process_order_id' => 2,
            'foreman_id' => 1,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster15 = ProductProcessMaster::create([
            'part_id' => 2,
            'process_master_id' => 3,
            'process_order_id' => 3,
            'foreman_id' => 1,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster15 = ProductProcessMaster::create([
            'part_id' => 2,
            'process_master_id' => 8,
            'process_order_id' => 4,
            'foreman_id' => 1,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster16 = ProductProcessMaster::create([
            'part_id' => 2,
            'process_master_id' => 14,
            'process_order_id' => 5,
            'foreman_id' => 1,
            'prepared_by'=>'1'
        ]);
        $productProcessMaster17 = ProductProcessMaster::create([
            'part_id' => 2,
            'process_master_id' => 22,
            'process_order_id' =>6,
            'foreman_id' => 1,
            'prepared_by'=>'1'
        ]);

    }
}
