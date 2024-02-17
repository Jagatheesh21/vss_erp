<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ItemProcesmaster;

class ItemProcesmasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $purchaseDepartment = ItemProcesmaster::create([
            'operation' => 'Store',
            'operation_type' => 'STOCKING POINT',
            'valuation_rate' => '0',
            'prepared_by'=>'1'
        ]);
    }
}
