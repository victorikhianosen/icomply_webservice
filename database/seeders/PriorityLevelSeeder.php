<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriorityLevelSeeder extends Seeder
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
                'name' => 'Low',
                'slug' => 'low',
                'description' => 'Low Priority'

            ],
            [
                'name' => 'Medium',
                'slug' => 'medium',
                'description' => 'Medium Priority'

            ],
            [
                'name' => 'High',
                'slug' => 'high',
                'description' => 'High Priority'

            ],

        ];

        DB::table('priority_level')->insert($data);
    }
}
