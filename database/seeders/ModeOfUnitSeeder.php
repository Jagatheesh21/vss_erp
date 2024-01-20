<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ModeOfUnit;

class ModeOfUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
                  // Creating ModeOfUnit
                  $uom1 = ModeOfUnit::create([
                    'name' => 'KGS',
                    'desc' => 'Kilograms',
                    'prepared_by'=>'1'
                ]);

                $uom2 = ModeOfUnit::create([
                    'name' => 'NOS',
                    'desc' => 'Numbers',
                   'prepared_by'=>'1'
                ]);

                $uom3 = ModeOfUnit::create([
                    'name' => 'LTR',
                    'desc' => 'Litres',
                   'prepared_by'=>'1'
                ]);
    }
}
