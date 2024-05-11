<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CustomerProductMaster;

class CustomerProductMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $customerProductMaster1 = CustomerProductMaster::create([
            'cus_id' => 1,
            'part_id' => 1,
            'part_hsnc'=>73209090,
            'cus_po_id'=>1,
            'packing_charges'=>0.5,
            'trans_mode'=>'BY ROAD',
            'currency_id'=>'1',
            'part_rate'=>'2',
            'part_per'=>'1',
            'uom_id'=>'2',
            'cgst'=>'9',
            'sgst'=>'9',
            'igst'=>'0',
            'prepared_by'=>'1'
        ]);
        $customerProductMaster2 = CustomerProductMaster::create([
            'cus_id' => 1,
            'part_id' => 2,
            'part_hsnc'=>73209090,
            'cus_po_id'=>2,
            'packing_charges'=>0.5,
            'trans_mode'=>'BY ROAD',
            'currency_id'=>'1',
            'part_rate'=>'4',
            'part_per'=>'1',
            'uom_id'=>'2',
            'cgst'=>'9',
            'sgst'=>'9',
            'igst'=>'0',
            'prepared_by'=>'1'
        ]);

        $customerProductMaster3 = CustomerProductMaster::create([
            'cus_id' => 1,
            'part_id' => 3,
            'part_hsnc'=>73209090,
            'cus_po_id'=>3,
            'packing_charges'=>0.5,
            'trans_mode'=>'BY ROAD',
            'currency_id'=>'1',
            'part_rate'=>'2.50',
            'part_per'=>'1',
            'uom_id'=>'2',
            'cgst'=>'9',
            'sgst'=>'9',
            'igst'=>'0',
            'prepared_by'=>'1'
        ]);
        $customerProductMaster4 = CustomerProductMaster::create([
            'cus_id' => 1,
            'part_id' => 4,
            'part_hsnc'=>73209090,
            'cus_po_id'=>3,
            'packing_charges'=>0.5,
            'trans_mode'=>'BY ROAD',
            'currency_id'=>'1',
            'part_rate'=>'3.00',
            'part_per'=>'1',
            'uom_id'=>'2',
            'cgst'=>'9',
            'sgst'=>'9',
            'igst'=>'0',
            'prepared_by'=>'1'
        ]);
        $customerProductMaster5 = CustomerProductMaster::create([
            'cus_id' => 1,
            'part_id' => 5,
            'part_hsnc'=>73209090,
            'cus_po_id'=>3,
            'packing_charges'=>0.5,
            'trans_mode'=>'BY ROAD',
            'currency_id'=>'1',
            'part_rate'=>'3.50',
            'part_per'=>'1',
            'uom_id'=>'2',
            'cgst'=>'9',
            'sgst'=>'9',
            'igst'=>'0',
            'prepared_by'=>'1'
        ]);
    }
}
