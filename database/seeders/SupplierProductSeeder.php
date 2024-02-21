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
        $Supplier_product2=SupplierProduct::create([
            'supplier_id'=>'1',
            'raw_material_category_id'=>'1',
            'raw_material_id' => '2',
            'products_hsnc'=>'73209090',
            'uom_id'=>'1',
            'products_rate'=>'7.50',
            'prepared_by'=>'1'
        ]);
        $Supplier_product3=SupplierProduct::create([
            'supplier_id'=>'2',
            'raw_material_category_id'=>'1',
            'raw_material_id' => '1',
            'products_hsnc'=>'73209090',
            'uom_id'=>'1',
            'products_rate'=>'5.75',
            'prepared_by'=>'1'
        ]);
        $Supplier_product4=SupplierProduct::create([
            'supplier_id'=>'2',
            'raw_material_category_id'=>'1',
            'raw_material_id' => '2',
            'products_hsnc'=>'73209090',
            'uom_id'=>'1',
            'products_rate'=>'6.5',
            'prepared_by'=>'1'
        ]);
        $Supplier_product5=SupplierProduct::create([
            'supplier_id'=>'3',
            'raw_material_category_id'=>'2',
            'raw_material_id' => '3',
            'products_hsnc'=>'73209090',
            'uom_id'=>'1',
            'products_rate'=>'8',
            'prepared_by'=>'1'
        ]);
    }
}
