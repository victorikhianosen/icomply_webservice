<?php

namespace App\Console\Commands;

use App\Mail\ReportEmail;
use App\Models\Alert;
use App\Models\ExceptionsLogs;
use App\Models\Process;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class ExecuteQueriesHourly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queries:execute-hourly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute scheduled queries hourly';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rows = DB::table('exception_process')->where('frequency', 'hour')->get();
        // Fetch the rows with 'frequency' value as 'none' from the 'exception_process' table
        foreach ($rows as $row) {
            $sql = preg_replace('/\s+/', ' ', strtolower($row->sql_text));
            // Extract the SQL query from the row
            if (isset($row->data_source)) {
                // Check if the 'data_source' is 'T24/Imal' (using postgres database for now)
                if (strtolower($row->data_source) == 'oracle132') {
                    $results = DB::connection('oracle132')->select(DB::raw($sql));
                }
                // Check if the 'data_source' is 'T24/Imal' (using postgres database for now)
                else {
                    $results = DB::select(DB::raw($sql));
                }

                // Append the results to the array of valid results
                $email = $row->email_to;
                // Get the email addresses from the row
                $exception_process = Process::find($row->id);
                // Fetch the 'Process' model by its ID
                $exceptions_logs = ExceptionsLogs::create([
                    // Create a new 'ExceptionsLogs' model instance
                    'status_id' => $row->state,
                    'exception_process_id' => $row->id,
                    'user_id' => $row->user_id,
                    'title' => $row->name,
                    'created_at' => date('Y-m-d H:i'),
                    'rating_id' => $row->risk_rating_id,
                    'category_id' => 21,
                    'process_id' => $row->id,
                ]);

                $alertid = Alert::create([
                    // Create a new 'Alert' model instance
                    'mail_to' => $email,
                    'status_id' => $row->state,
                    'alert_action' => $row->narration,
                    'alert_group_id' => $row->alert_group_id,
                    'exception_process_id' => $row->id,
                    'alert_subject' => $row->name,
                    'alert_name' => $exception_process->name . ' - ALERT' . random_int(5, 10000000000000),
                    'user_id' => $row->user_id,
                ]);

                $report = [
                    'validResults' => [$results],
                    'exceptionName' => $alertid->alert_name,
                    'Narration' => $row->narration
                ];

                $view = view('email.reports_template', ['report' => $report])->render();
                // Render the email template view with the report data

                $exceptions_logs->update([
                    'alert_id' => $alertid->id,
                    'email' => $view
                ]);

                // $recipients = explode(',', $row->email_to);
                // // Split the comma-separated list of email addresses
                // foreach ($recipients as $recipient) {
                //     Mail::to(trim($recipient))->send(new ReportEmail($report));
                //     // Send the email to each recipient using the ReportEmail Mailable
                // }
                $test_mails = "uche.l@novajii.com,hanson.e@novajii.com";
                $test_mails = explode(',', $test_mails);
                foreach ($test_mails as $test_mail) {
                    Mail::to(trim($test_mail))->send(new ReportEmail($report));
                    // Send the email to each recipient using the ReportEmail Mailable
                }
            }
        }
        return Log::info('Scheduled queries executed successfully (hourly).');
        // Return a success message
    }
}
