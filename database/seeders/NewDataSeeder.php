<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('process_category')->insert([
            [
                'id' => '279',
                'name' => ' CASH WITHDRAWAL LOCAL CURRENCY',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Add more data rows here
        ]);
    }
}
