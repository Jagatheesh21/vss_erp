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
            'name' => '1.0 MM Spring Steel Wire',
            'minimum_stock'=>'10',
            'maximum_stock'=>'100',
            'prepared_by'=>'1'
        ]);
    }
}
