<?php

namespace App\Console\Commands;

use App\Events\DatabaseInsertEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class StartInsertListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     *
     *
     * @var string
     */

    /**
     * Execute the console command.
     *
     * @return int
     */
    protected $signature = 'pgsql:listen';
    protected $description = 'Listen for PostgreSQL notifications and trigger events';


    public function __construct()
    {
        parent::__construct();
    }

    // public function handle()
    // {
    //     $dbo = DB::connection('pgsql')->getPdo();
    //     $dbo->exec('LISTEN "events"');

    //     while (true) {
    //         $event = $dbo->pgsqlGetNotify(\PDO::FETCH_ASSOC);

    //         if ($event) {
    //             $payload = json_decode($event['payload']);
    //             $tableName = $payload->table;
    //             $action = $payload->action;

    //             if ($action === 'INSERT') {
    //                 $rowId = $payload->id; // Replace with the actual row ID key
    //                 event(new DatabaseInsertEvent($tableName, $rowId));
    //             }
    //         }
    //     }
    // }

    public function handle(){
        Log::info("cron is working fine");

        //add your logic here
    }
}
