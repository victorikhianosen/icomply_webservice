<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaseManagementSeeder extends Seeder
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
                'user_id' => '4',
                'case_status_id' => '1',
                'priority_level_id' => '1',
                'description' => 'newly opened case',
                'supervisor_name' => 'leonard',
            ],

            [
                'user_id' => '5',
                'case_status_id' => '1',
                'priority_level_id' => '1',
                'description' => 'novajii opened case',
                'supervisor_name' => 'novajii',
            ]

        ];

        DB::table('case_management')->insert($data);
    }
}
