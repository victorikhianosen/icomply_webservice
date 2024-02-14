<?php

namespace App\Console\Commands;

use App\Jobs\SoapRequestJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class UpdateStaffWeekly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sterling:update-weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update sterling bank staff table weekly';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $xmlBody = '<?xml version="1.0" encoding="utf-8"?>
                    <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                    <soap:Body>
                        <searchUsersAll xmlns="http://tempuri.org/">
                        <text>string</text>
                        </searchUsersAll>
                    </soap:Body>
                    </soap:Envelope>';
        SoapRequestJob::dispatch($xmlBody);
    }
}
