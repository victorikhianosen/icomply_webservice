<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProcessCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [

            
            [
                'id' => '305',
                'name' => 'DOMICILIARY OUTFLOW PROCESSING',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'id'=>'333',
                'name' => 'ACCOUNT OFFICER CONFIRMATION',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'id' => '282',
                'name' => 'AMBIENCE(FUNCTIONAL TOILET,CLEAN FLAGS ETC)',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'id' => '436',
                'name' => 'CASH SWAP WITH OTHER BANKS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
           
           

        ];
        DB::table('process_category')->insert($data);

        
    }
}
