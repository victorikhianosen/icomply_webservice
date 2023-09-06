<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewerDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $data7 = [
            [
                'id' => '21',
                'name' => 'Automated Transactional Alerts',
                'code' => 'trans',
                'description'=> 'Automated Transactional Alerts'
            ],
            [
                'id' => '1',
                'name' => 'Case Manager Exception Processes',
                'code' => 'non-trans',
                'description' => 'Case Manager Exception Processes'

            ],

           
            // Add more records as needed
        ];

        DB::table('exception_category')->insert($data7);

      
    }
}
