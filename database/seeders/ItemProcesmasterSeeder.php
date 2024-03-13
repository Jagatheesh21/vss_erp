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
        $processMaster1 = ItemProcesmaster::create([
            'operation' => 'Purchase Order',
            'operation_type' => 'STOCKING POINT',
            'valuation_rate' => '0',
            'prepared_by'=>'1'
        ]);
        $processMaster2 = ItemProcesmaster::create([
            'operation' => 'RM Inward',
            'operation_type' => 'STOCKING POINT',
            'valuation_rate' => '0',
            'prepared_by'=>'1'
        ]);
        $processMaster3 = ItemProcesmaster::create([
            'operation' => 'Store',
            'operation_type' => 'STOCKING POINT',
            'valuation_rate' => '0',
            'prepared_by'=>'1'
        ]);

        $processMaster4 = ItemProcesmaster::create([
            'operation' => 'CNC',
            'operation_type' => 'OPERATION',
            'valuation_rate' => '70',
            'prepared_by'=>'1'
        ]);
        $processMaster5 = ItemProcesmaster::create([
            'operation' => 'Straitening/Shearing',
            'operation_type' => 'OPERATION',
            'valuation_rate' => '70',
            'prepared_by'=>'1'
        ]);

        $processMaster6 = ItemProcesmaster::create([
            'operation' => 'Semifinished1',
            'operation_type' => 'STOCKING POINT',
            'valuation_rate' => '70',
            'prepared_by'=>'1'
        ]);

        $processMaster7 = ItemProcesmaster::create([
            'operation' => 'Semifinished2',
            'operation_type' => 'STOCKING POINT',
            'valuation_rate' => '70',
            'prepared_by'=>'1'
        ]);
        $processMaster8 = ItemProcesmaster::create([
            'operation' => 'Semifinished3',
            'operation_type' => 'STOCKING POINT',
            'valuation_rate' => '70',
            'prepared_by'=>'1'
        ]);
        $processMaster9 = ItemProcesmaster::create([
            'operation' => 'Manual Area - Big Spring',
            'operation_type' => 'OPERATION',
            'valuation_rate' => '70',
            'prepared_by'=>'1'
        ]);

        $processMaster10 = ItemProcesmaster::create([
            'operation' => 'Manual Area - End Grinding',
            'operation_type' => 'OPERATION',
            'valuation_rate' => '70',
            'prepared_by'=>'1'
        ]);

        $processMaster11 = ItemProcesmaster::create([
            'operation' => 'Manual Area - ABC Ring',
            'operation_type' => 'OPERATION',
            'valuation_rate' => '70',
            'prepared_by'=>'1'
        ]);
        $processMaster12 = ItemProcesmaster::create([
            'operation' => 'Manual Small Spring',
            'operation_type' => 'OPERATION',
            'valuation_rate' => '70',
            'prepared_by'=>'1'
        ]);
        $processMaster13 = ItemProcesmaster::create([
            'operation' => 'Press1',
            'operation_type' => 'OPERATION',
            'valuation_rate' => '70',
            'prepared_by'=>'1'
        ]);
        $processMaster14 = ItemProcesmaster::create([
            'operation' => 'Firewall + FI',
            'operation_type' => 'OPERATION',
            'valuation_rate' => '70',
            'prepared_by'=>'1'
        ]);
        $processMaster15 = ItemProcesmaster::create([
            'operation' => 'Subcontract',
            'operation_type' => 'OPERATION',
            'valuation_rate' => '70',
            'prepared_by'=>'1'
        ]);
        $processMaster16 = ItemProcesmaster::create([
            'operation' => 'FG For S/C',
            'operation_type' => 'STOCKING POINT',
            'valuation_rate' => '70',
            'prepared_by'=>'1'
        ]);
        $processMaster17 = ItemProcesmaster::create([
            'operation' => 'To S/C',
            'operation_type' => 'STOCKING POINT',
            'valuation_rate' => '70',
            'prepared_by'=>'1'
        ]);

        $processMaster18 = ItemProcesmaster::create([
            'operation' => 'PAINTSHOP',
            'operation_type' => 'OPERATION',
            'valuation_rate' => '70',
            'prepared_by'=>'1'
        ]);
        $processMaster19 = ItemProcesmaster::create([
            'operation' => 'CLE UNIT 2',
            'operation_type' => 'OPERATION',
            'valuation_rate' => '70',
            'prepared_by'=>'1'
        ]);
        $processMaster20 = ItemProcesmaster::create([
            'operation' => 'FG For Painting',
            'operation_type' => 'OPERATION',
            'valuation_rate' => '70',
            'prepared_by'=>'1'
        ]);

        $processMaster21 = ItemProcesmaster::create([
            'operation' => 'From S/C',
            'operation_type' => 'STOCKING POINT',
            'valuation_rate' => '70',
            'prepared_by'=>'1'
        ]);

        $processMaster22 = ItemProcesmaster::create([
            'operation' => 'FG For Invoicing',
            'operation_type' => 'STOCKING POINT',
            'valuation_rate' => '90',
            'prepared_by'=>'1'
        ]);
        $processMaster23 = ItemProcesmaster::create([
            'operation' => 'Rework',
            'operation_type' => 'STOCKING POINT',
            'valuation_rate' => '70',
            'prepared_by'=>'1'
        ]);

        $processMaster24 = ItemProcesmaster::create([
            'operation' => 'FG For Scrap',
            'operation_type' => 'STOCKING POINT',
            'valuation_rate' => '90',
            'prepared_by'=>'1'
        ]);

        $processMaster25 = ItemProcesmaster::create([
            'operation' => 'Dummy',
            'operation_type' => 'STOCKING POINT',
            'valuation_rate' => '0',
            'prepared_by'=>'1'
        ]);



    }
}
