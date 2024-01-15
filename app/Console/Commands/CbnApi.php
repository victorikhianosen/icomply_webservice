<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CbnApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cbn:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calling Cbn Api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::get('http://46.101.23.167:5001/update_database');

        // Process the API response if needed

        // Process the API response if the request was successful
        $data = $response->json();

        foreach ($data as $value) {
            if (!is_numeric($value) && !is_int($value + 0)) {

                Log::info('Error:' . $value);
            }
        }
    }
}
