<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaseStatusSeeder extends Seeder
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
                'name' => 'Opened',
                'slug' => 'opened',
                'description' => 'Open Case'
            ],
            [
                'name' => 'Closed',
                'slug' => 'closed',
                'description' => 'Closed Case'
            ],
            // Add more records as needed
        ];

        DB::table('case_status')->insert($data);
    }
}
