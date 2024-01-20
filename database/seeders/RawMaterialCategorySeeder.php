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
        $rm_category=RawMaterialCategory::create([
            'name' => 'Spring Steel Wire',
            'prepared_by'=>'1'
        ]);
    }
}
