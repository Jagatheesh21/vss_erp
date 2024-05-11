<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CustomerPoRateRevise;

class CustomerPoRateReviseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $customerPoRateReviseMaster1 = CustomerPoRateRevise::create([
            'cus_id' => 1,
            'part_id' => 1,
            'cus_po_id'=>1,
            'cus_po_qty'=>1000,
            'uom_id'=>'2',
            'part_per'=>'1',
            'rate'=>'2',
            'prepared_by'=>'1'
        ]);
        $customerPoRateReviseMaster2 = CustomerPoRateRevise::create([
            'cus_id' => 1,
            'part_id' => 2,
            'cus_po_id'=>2,
            'cus_po_qty'=>1000,
            'uom_id'=>'2',
            'part_per'=>'1',
            'rate'=>'4',
            'prepared_by'=>'1'
        ]);
        $customerPoRateReviseMaster3 = CustomerPoRateRevise::create([
            'cus_id' => 1,
            'part_id' => 3,
            'cus_po_id'=>3,
            'cus_po_qty'=>1000,
            'uom_id'=>'2',
            'part_per'=>'1',
            'rate'=>'2.50',
            'prepared_by'=>'1'
        ]);
        $customerPoRateReviseMaster4 = CustomerPoRateRevise::create([
            'cus_id' => 1,
            'part_id' => 4,
            'cus_po_id'=>4,
            'cus_po_qty'=>1000,
            'uom_id'=>'2',
            'part_per'=>'1',
            'rate'=>'3.00',
            'prepared_by'=>'1'
        ]);
        $customerPoRateReviseMaster5 = CustomerPoRateRevise::create([
            'cus_id' => 1,
            'part_id' => 5,
            'cus_po_id'=>5,
            'cus_po_qty'=>1000,
            'uom_id'=>'2',
            'part_per'=>'1',
            'rate'=>'3.50',
            'prepared_by'=>'1'
        ]);
    }
}
