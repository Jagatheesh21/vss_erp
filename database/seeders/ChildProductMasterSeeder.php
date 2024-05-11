<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ChildProductMaster;

class ChildProductMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $childProductMaster1 = ChildProductMaster::create([
            'stocking_point' => '22',
            'child_part_no' => '29192718',
            'part_id' => '1',
            'prepared_by'=>'1'
        ]);
        $childProductMaster2 = ChildProductMaster::create([
            'stocking_point' => '22',
            'child_part_no' => '29192710',
            'part_id' => '2',
            'prepared_by'=>'1'
        ]);
        $childProductMaster3 = ChildProductMaster::create([
            'stocking_point' => '22',
            'child_part_no' => '29371408',
            'item_type'=> 1,
            'part_id' => '3',
            'prepared_by'=>'1'
        ]);
        $childProductMaster4 = ChildProductMaster::create([
            'stocking_point' => '17',
            'child_part_no' => '29371408-S',
            'part_id' => '3',
            'item_type'=> 1,
            'no_item_id' => '1',
            'prepared_by'=>'1'
        ]);
        $childProductMaster5 = ChildProductMaster::create([
            'stocking_point' => '17',
            'child_part_no' => '29371408-T',
            'part_id' => '3',
            'item_type'=> 1,
            'no_item_id' => '2',
            'prepared_by'=>'1'
        ]);
        $childProductMaster6 = ChildProductMaster::create([
            'stocking_point' => '22',
            'child_part_no' => '29374193',
            'part_id' => '4',
            'item_type'=> 1,
            'no_item_id' => '1',
            'prepared_by'=>'1'
        ]);
        $childProductMaster7 = ChildProductMaster::create([
            'stocking_point' => '22',
            'child_part_no' => '29374193-S',
            'part_id' => '4',
            'item_type'=> 1,
            'no_item_id' => '1',
            'prepared_by'=>'1'
        ]);
        $childProductMaster8 = ChildProductMaster::create([
            'stocking_point' => '22',
            'child_part_no' => '29374193-T',
            'part_id' => '4',
            'item_type'=> 1,
            'no_item_id' => '2',
            'prepared_by'=>'1'
        ]);
        $childProductMaster9 = ChildProductMaster::create([
            'stocking_point' => '22',
            'child_part_no' => '29192710/J',
            'part_id' => '4',
            'item_type'=> 0,
            'no_item_id' => '1',
            'prepared_by'=>'1'
        ]);
    }
}
