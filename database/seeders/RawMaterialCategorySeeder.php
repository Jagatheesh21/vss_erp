<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RawMaterialCategory;

class RawMaterialCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $rm_category1=RawMaterialCategory::create([
            'name' => 'Spring Steel',
            'prepared_by'=>'1'
        ]);
        $rm_category2=RawMaterialCategory::create([
            'name' => 'Sheet Metal',
            'prepared_by'=>'1'
        ]);
    }
}
