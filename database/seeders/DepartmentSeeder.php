<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
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
                'id' => '40',
                'name' => 'OPERATIONS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'id' => '45',
                'name' => 'FINANCIAL CONTROL',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'id' => '50',
                'name' => 'INFORMATION SECURITY',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'id' => '55',
                'name' => 'RISK MANAGEMENT',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'id' => '72',
                'name' => 'FOREIGN OPERATIONS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                
            ],

                [

                'id' => '42',
                'name' => 'DOMESTIC OPERATIONS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

                ],

[
            'id' => '43',
            'name' => 'BUSINESS BANKING',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),],

                [

                'id' => '46',
                'name' => 'INTERNAL AUDIT',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                ],

                [

                'id' => '48',
                'name' => 'FINANCIAL CONTROL',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

                ],

                [

                'id' => '53',
                'name' => 'PUBLIC SECTOR',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                ],

                [
            'id' => '51',
            'name' => 'RETAIL BANKING',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
                ],

                [

                'id' => '54',
                'name' => 'INFORMATION SECURITY',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

                ],
                [

                'id' => '56',
                'name' => 'SHARIAH AUDIT',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                ],

                [

                'id' => '58',
                'name' => 'SHARIAH DEPARTMENT',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

                ],

            [

                'id' => '59',
                'name' => 'TRANSFORMATION',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            
            [

                'id' => '60',
                'name' => 'APPLICATION DEVELOPMENT',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            
            [

                'id' => '62',
                'name' => 'CONTACT CENTER',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [

                'id' => '63',
                'name' => 'MD\'S\ DIRECTORATE',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [

                'id' => '66',
                'name' => 'E-BUSINESS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [

                'id' => '67',
                'name' => 'MARKETING',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [

                'id' => '68',
                'name' => 'PRIVATE BANKING',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [

                'id' => '69',
                'name' => 'OPERATIONS-NASS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [

                'id' => '71',
                'name' => 'CUSTOMER SERVICE',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [

                'id' => '74',
                'name' => 'OPERATIONS-KANO',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [

                'id' => '77',
                'name' => 'HUMAN RESOURCES',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [

                'id' => '78',
                'name' => 'CORPORATE SERVICES',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [

                'id' => '95',
                'name' => 'TREASURY',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

            [

                'id' => '94',
                'name' => 'INFORMATION TECHNONOLOGY',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

            [

                'id' => '92',
                'name' => 'DEVELOPMENT FINANCE',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

            [

                'id' => '91',
                'name' => 'OPERATIONS-LAGOS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

            [

                'id' => '89',
                'name' => 'Head office',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

            [

                'id' => '87',
                'name' => 'LEGAL',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

            [

                'id' => '104',
                'name' => 'BUISNESS BANKING GROUP',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

            [

                'id' => '102',
                'name' => 'AGRIC BUSINESS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

            [

                'id' => '101',
                'name' => 'BUSINESS DEVELOPMENT',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

            [

                'id' => '100',
                'name' => 'CORPORATE TREASURY',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

            [

                'id' => '99',
                'name' => 'INTERNATIONAL OPERATIONS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

            [

                'id' => '98',
                'name' => 'E-BANKING OPERATIONS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

            [

                'id' => '97',
                'name' => 'ED BUSINESS DEVELOPMENT, DIRECTORATE',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

            [

                'id' => '96',
                'name' => 'TREASURY OPERATIONS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

            [

                'id' => '105',
                'name' => 'MARKETING COMMUNICATIONS',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

            [

                'id' => '107',
                'name' => 'TAJMALL',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

            [

                'id' => '44',
                'name' => 'COMPLIANCE',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],

            [

                'id' => '1',
                'name' => 'INTERNAL CONTROL',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],	

            

        ];
        DB::table('department')->insert($data);

    }
}
