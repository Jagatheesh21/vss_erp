<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rackmaster;

class RackmasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rack_master=Rackmaster::create([
            'raw_material_category_id'=>'1',
            'raw_material_id' => '1',
            'stocking_id' => '1',
            'rack_name' => 'A-1',
            'prepared_by'=>'1'
        ]);
    }
}
