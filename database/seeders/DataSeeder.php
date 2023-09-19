<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('process')->insert([

            // Add more data rows here
            [
                'process_id' => '279',
                'name' => 'Dual control not observed',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'No cash officer Sign off on supply slip ',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'process_id' => '279',
                'name' => 'Instruction not signature verified',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'process_id' => '279',
                'name' => 'Cash Analysis',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'process_id' => '279',
                'name' => 'Wrong Classification	',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'process_id' => '279',
                'name' => 'Wrong Account	',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'process_id' => '279',
                'name' => 'Tellers stamp not ok or not in line with the tellers 	',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'process_id' => '279',
                'name' => 'Self-check register not signed by tellers and updated',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'process_id' => '279',
                'name' => 'Instrument not sv',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'process_id' => '279',
                'name' => 'Alteration in customers instruction',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'process_id' => '279',
                'name' => 'No deposit printed for cash lodgement',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'process_id' => '279',
                'name' => 'Stale date on instrument',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'process_id' => '279',
                'name' => 'Tellers till not balanced with the system',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'process_id' => '279',
                'name' => 'Cash wrapper not stamped',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'Counter cheque issued not registered	',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'Details of Beneficiary not received',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'attendance not maintained or updated ',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'Deposit receipt printout not signed by the customer	',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'Instruction not timestamped',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'No cash analysis on exchange ticket',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'Wrong date on time stamp machine',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'Payment to unauthorized signatory',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'Unauthorized Transaction',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            //
            [
                'process_id' => '279',
                'name' => 'Unauthorized Transaction',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'Amount Mismatch',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'Cheque paid but not confirmed.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'Amount Mismatch',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'No deposit receipt printed for cash lodgement',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'UV light not functional	',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'Not within TAT/ticket missing',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'Wrong/no filing',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'Value date set up error',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'No cash analysis',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'boxed cash not in vault',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'Amount wrongly posted',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'Triplicate Cash Exchange Ticket not properly distributed',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'process_id' => '279',
                'name' => 'Loss of Income',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
					

        ]);
           

  
    }
}
