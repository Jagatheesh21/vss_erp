<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;


class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $Supplier1=Supplier::create([
            'supplier_code'=>'JAI',
            'name'=>'JAI SYSTEMS PVT LTD',
            'gst_number' => '33AAS56789FG97D',
            'address'=>'COVAI',
            'contact_number'=>'9456220001',
            'packing_charges'=> 0,
            'trans_mode' => 'BY ROAD',
            'cgst' => 6,
            'sgst' => 6,
            'igst' => 0,
            'currency_id' => 1,
            'prepared_by'=> 1
        ]);
    }
}
