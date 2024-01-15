<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        DB::table('nv_download_status')->insert([
            [
                'id' => 1,
                'name' => 'Completed',
                'slug' => 'completed',
                'description' => 'download completed',
                'value_id' => 1,
                'created_at' => now(),

            ],
            [
                'id' => 2,
                'name' => 'Processing',
                'slug' => 'processing',
                'description' => 'processing download',
                'value_id' => 2,
                'created_at' => now(),

            ],
            [
                'id'=>3,
                'name' => 'Failed',
                'slug' => 'failed',
                'description' => 'download failed',
                'value_id' => 3,
                'created_at' => now(),

            ],

            //M LOAN CHARGE

            // Add more data rows here
        ]);
    }
}
