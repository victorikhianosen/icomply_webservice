<?php

namespace App\Listeners;

use App\Events\DatabaseInsertEvent;
use App\Mail\SendMail;
use App\Models\CaseManagement;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DatabaseInsertListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(DatabaseInsertEvent $event)
    {
        $tableName = $event->tableName;
        $rowId = $event->rowId;

        Log::info("Row inserted in table '$tableName' with ID: $rowId");
    }

    // public function handlee(DatabaseInsertEvent $event)
    // {
    //     $payload = json_decode($event->payload, true);
    //     $supervisor_ids = $payload['supervisor_id']; // Replace with the actual column name
    //     $assigned_user = $payload['assigned_user']; // Replace with the actual column name

    //     // Merge the IDs from the JSONB column
    //     $mergedValues = [];
    //     foreach ($supervisor_ids as $supervisor_id) {
    //         $mergedValue = $supervisor_id. $assigned_user;
    //         $mergedValues[] = $mergedValue;
    //     }

    //     // Fetch user data
    //     $user = DB::table('users')->where('id', $payload['row_id'])->first();

    //     if ($user) {
    //         foreach ($mergedValues as $mergedValue) {
    //             $email_info = [
    //                 'title' => 'Notification Mail',
    //                 'body' => 'Merged value: ' . $mergedValue,
    //                 'link' => 'http://127.0.0.1:8000/case-details/'
    //             ];

    //             // Send an email
    //             Mail::to($user->email)->send(new SendMail($email_info));
    //         }
    //     }
    // }
}
