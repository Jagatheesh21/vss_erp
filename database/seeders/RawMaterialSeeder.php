<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RawMaterial;

class RawMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $rm=RawMaterial::create([
            'material_code'=>'RM000000001',
            'raw_material_category_id'=>'1',
            'name' => '1.0 MM Spring Steel GR-3 DH',
            'minimum_stock'=>'10',
            'maximum_stock'=>'100',
            'prepared_by'=>'1'
        ]);
        $rm2=RawMaterial::create([
            'material_code'=>'RM000000002',
            'raw_material_category_id'=>'1',
            'name' => '2.0 MM Spring Steel GR-3 DH',
            'minimum_stock'=>'25',
            'maximum_stock'=>'500',
            'prepared_by'=>'1'
        ]);
        $rm3=RawMaterial::create([
            'material_code'=>'RM000000003',
            'raw_material_category_id'=>'2',
            'name' => '1.0 MM Sheet CR-2',
            'minimum_stock'=>'50',
            'maximum_stock'=>'500',
            'prepared_by'=>'1'
        ]);
    }
}
