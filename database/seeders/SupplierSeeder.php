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
            'supplier_code'=>'A & D',
            'name'=>'A & D STEELS PVT LTD',
            'gst_number' => '33AAS56789FG97D',
            'address'=>'COVAI',
            'contact_person'=>'Ganesh',
            'email'=>'purchase@adasteels.com',
            'contact_number'=>'9443****01',
            'packing_charges'=> 0,
            'trans_mode' => 'BY ROAD',
            'cgst' => 6,
            'sgst' => 6,
            'igst' => 0,
            'currency_id' => 1,
            'prepared_by'=> 1
        ]);
        $Supplier2=Supplier::create([
            'supplier_code'=>'Madras HTS',
            'name'=>'Madras Hard Tools PVT LTD',
            'gst_number' => '33AAS56789FG45D',
            'address'=>'COVAI',
            'contact_person'=>'Ramesh',
            'email'=>'purchase@madrashts.com',
            'contact_number'=>'9445****01',
            'packing_charges'=> 0,
            'trans_mode' => 'BY ROAD',
            'cgst' => 6,
            'sgst' => 6,
            'igst' => 0,
            'currency_id' => 1,
            'prepared_by'=> 1
        ]);
        $Supplier3=Supplier::create([
            'supplier_code'=>'SAIL',
            'name'=>'SALEM STEEL PLANT',
            'gst_number' => '33AAS56789FG47D',
            'address'=>'SALEM',
            'contact_person'=>'Suresh',
            'email'=>'purchase@salemsteel.com',
            'contact_number'=>'9435****03',
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
