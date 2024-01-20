<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currency1=Currency::create([
            'name' => 'INR',
            'prepared_by'=>'1'
        ]);
        $currency2=Currency::create([
            'name' => 'USD',
            'prepared_by'=>'1'
        ]);
    }
}
