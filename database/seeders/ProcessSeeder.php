<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcessSeeder extends Seeder
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
                
                'name' => 'Unauthorized Transaction',
                'process_id'=> '305',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '305',
                'name' => 'Incomplete documentation',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '305',
                'name' => 'Signature Verification Incomplete',
                'created_at'=> Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '305',
                'name' => 'Wrong Account',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [

                'name' => 'Incomplete Transaction',
                'process_id' => '333',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '333',
                'name' => 'Duplicate Transaction',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '333',
                'name' => 'No RM  name and signature on cofirmation',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '282',
                'name' => 'Leaking pipes',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '282',
                'name' => 'Faulty priming machine',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '282',
                'name' => 'No back up Generator set',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '436',
                'name' => 'Missing/Delayed Tickets',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '436',
                'name' => 'Dual control not observed',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ];
        DB::table('process')->insert($data);

    }
}
