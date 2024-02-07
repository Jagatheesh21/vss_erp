<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RackStockmaster;

class RackStockmasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $rack_stockmaster=RackStockmaster::create([
            'name'=>'Stores',
            'prepared_by'=>'1'
        ]);
    }
}
