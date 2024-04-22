<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CustomerPoMaster;

class CustomerPoMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $customerPoMaster1 = CustomerPoMaster::create([
            'create_date' => '2024-04-22',
            'cus_id' => 1,
            'part_id' => 1,
            'cus_po_no'=>'5200005732',
            'cus_po_date'=>'2024-04-01',
            'cus_po_item_no'=>1,
            'cus_po_qty'=>1000,
            'uom_id'=>'2',
            'part_per'=>'1',
            'rate'=>'2',
            'prepared_by'=>'1'
        ]);
        $customerPoMaster2 = CustomerPoMaster::create([
            'create_date' => '2024-04-22',
            'cus_id' => 1,
            'part_id' => 2,
            'cus_po_no'=>'5200005732',
            'cus_po_date'=>'2024-04-01',
            'cus_po_item_no'=>2,
            'cus_po_qty'=>1000,
            'uom_id'=>'2',
            'part_per'=>'1',
            'rate'=>'4',
            'prepared_by'=>'1'
        ]);
        $customerPoMaster3 = CustomerPoMaster::create([
            'create_date' => '2024-04-22',
            'cus_id' => 1,
            'part_id' => 3,
            'cus_po_no'=>'5200005732',
            'cus_po_date'=>'2024-04-01',
            'cus_po_item_no'=>3,
            'cus_po_qty'=>1000,
            'uom_id'=>'2',
            'part_per'=>'1',
            'rate'=>'2.50',
            'prepared_by'=>'1'
        ]);
    }
}
