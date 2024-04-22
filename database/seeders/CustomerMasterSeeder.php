<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CustomerMaster;

class CustomerMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $customerMaster1 = CustomerMaster::create([
            'cus_code' => 'UNIT-12',
            'cus_name' => 'BRAKES INDIA PVT LTD',
            'cus_gst_number' => '33AAACB2533Q1ZP',
            'cus_pan_no'=>'AAACB2533Q',
            'cus_address'=>'UNIT 12 (CAM BRAKE UNIT)',
            'cus_address1'=>'BRAKE DIVISION',
            'cus_city'=>'CHENNAI',
            'cus_state'=>'TAMIL NADU',
            'cus_country'=>'INDIA',
            'cus_pincode'=>'631102',
            'delivery_cus_name'=>'BRAKES INDIA PVT LTD',
            'delivery_cus_gst_number'=>'33AAACB2533Q1ZP',
            'delivery_cus_pan_no'=>'AAACB2533Q',
            'delivery_cus_address'=>'UNIT 12 (CAM BRAKE UNIT)',
            'delivery_cus_address1'=>'BRAKE DIVISION',
            'delivery_cus_city'=>'CHENNAI',
            'delivery_cus_state'=>'TAMIL NADU',
            'delivery_cus_country'=>'INDIA',
            'delivery_cus_pincode'=>'631102',
            'supplier_vendor_code'=>'100283',
            'distance'=>'520',
            'prepared_by'=>'1'
        ]);
    }
}
