<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BomMaster;

class BomMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $bomMaster1 = BomMaster::create([
            'child_part_id' => 1,
            'rm_id' => 1,
            'uom_id' => 1,
            'input_usage' => 0.0260850,
            'output_usage' => 0.0260850,
            'foreman' => 'LEAN',
            'prepared_by'=>'1'
        ]);
        $bomMaster2 = BomMaster::create([
            'child_part_id' => 2,
            'rm_id' => 1,
            'uom_id' => 1,
            'input_usage' => 0.0040800,
            'output_usage' => 0.0040800,
            'foreman' => 'NON-LEAN',
            'prepared_by'=>'1'
        ]);
        $bomMaster3 = BomMaster::create([
            'child_part_id' => 3,
            'rm_id' => 1,
            'uom_id' => 1,
            'input_usage' => 0.0040800,
            'output_usage' => 0.0040800,
            'foreman' => 'NON-LEAN',
            'prepared_by'=>'1'
        ]);
        $bomMaster4 = BomMaster::create([
            'child_part_id' => 4,
            'rm_id' => 1,
            'uom_id' => 1,
            'input_usage' => 0.0041800,
            'output_usage' => 0.0041800,
            'foreman' => 'NON-LEAN',
            'prepared_by'=>'1'
        ]);
        $bomMaster5 = BomMaster::create([
            'child_part_id' => 5,
            'rm_id' => 1,
            'uom_id' => 1,
            'input_usage' => 0.0041800,
            'output_usage' => 0.0041800,
            'foreman' => 'NON-LEAN',
            'prepared_by'=>'1'
        ]);
    }
}
