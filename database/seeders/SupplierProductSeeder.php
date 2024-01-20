<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SupplierProduct;

class SupplierProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $Supplier_product1=SupplierProduct::create([
            'supplier_id'=>'1',
            'raw_material_category_id'=>'1',
            'raw_material_id' => '1',
            'products_hsnc'=>'73209090',
            'uom_id'=>'1',
            'products_rate'=>'5.50',
            'prepared_by'=>'1'
        ]);
    }
}
