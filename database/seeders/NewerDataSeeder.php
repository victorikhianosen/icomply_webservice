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
                'id' => '1',
                'name' => 'Bank Wide',
                'slug' => 'bank',
            ],

            [
                'id' => '2',
                'name' => 'Account',
                'slug' => 'account',

            ],
            [
                'id' => '4',
                'name' => 'Branch Wide',
                'slug' => 'branch',

            ],

            [
                'id' => '22',
                'name' => 'AML',
                'slug' => 'aml',

            ],

            [
                'id' => '23',
                'name' => 'Compliance',
                'slug' => 'compliance',

            ],

            [
                'id' => '24',
                'name' => 'Case Manager',
                'slug' => 'case-manager',

            ],

            [
                'id' => '61',
                'name' => 'Transaction Scoring',
                'slug' => 'transaction-scoring',

            ],

            [
                'id' => '41',
                'name' => 'Customer Risk Scoring',
                'slug' => 'customer-risk-scoring',

            ],
            [
                'id' => '25',
                'name' => 'User Statistics',
                'slug' => 'user',

            ],
            // Add more records as needed
        ];
        
        $data8=[
            [
                'name' => 'policy',

            ],
             [
                'name' => 'procedure',

            ],
        ];

        DB::table('document_type')->insert($data8);
    }
}
