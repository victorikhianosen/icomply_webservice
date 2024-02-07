<?php

namespace App\Console\Commands;

use App\Mail\ReportEmail;
use App\Models\Alert;
use App\Models\ExceptionsLogs;
use App\Models\Process;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class ExecuteQueriesIn5Minutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queries:execute-in-5minutes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute scheduled queries every 5 minutes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rows = DB::table('exception_process')->where('frequency', 'none')->get();
        $validResults = [];
        $invalidIds = [];
        $validIds = [];
        $email = [];
        $rowId = '';
        $report = [];

        foreach ($rows as $row) {
            $tableName = $row->table_name;
            $sql = $row->sql_text;
            $exceptionName = $row->name;
            $rowId = $row->id;

            // Check if the table exists
            if (Schema::hasTable($tableName)) {
                // Execute the SQL query
                $results = DB::select(DB::raw($sql));
                $validResults[] = $results;
                $validIds[] = $row->id;
                $email[] = $row->email_to;
            } else {
                $invalidIds[] = $row->id;
            }
            $report = [
                "validResults" => $validResults,
                "exceptionName" => $exceptionName
            ];
            // return $report;
            foreach ($email as $value) {
                $recipients = explode(',', $value); // Split the comma-separated list of email addresses
                foreach ($recipients as $recipient) {
                    // Mail::to(trim($recipient))->send(new ReportEmail($report));
                }
            }
        }

        // Check if results are found
        if (!empty($validResults)) {
            $view = view('email.reports_template', ['report' => $report])->render();
            // return view('reports_template', ['report' => $report]);
            $exception_process = Process::find($rowId);
            // return $exception_process;
            $exceptions_logs = ExceptionsLogs::create([
                'status_id' => $this->setNullIfEmpty($exception_process->state),
                'exception_process_id' => $this->setNullIfEmpty($exception_process->id),
                'user_id' => $this->setNullIfEmpty($exception_process->user_id),
                'title' => $this->setNullIfEmpty($exception_process->process_name),
                'created_at' => date('Y-m-d H:i'),
                'rating_id' => $this->setNullIfEmpty($exception_process->risk_rating_id),
                'category_id' => $this->setNullIfEmpty(21),
                'process_id' => $this->setNullIfEmpty($exception_process->id),
            ]);
            $alertid = Alert::create([                            //
                'mail_to' => $email,
                'status_id' => $this->setNullIfEmpty($exception_process->state),
                'alert_action' => $this->setNullIfEmpty($exception_process->narration),
                'alert_group_id' => $this->setNullIfEmpty($exception_process->alert_group_id),
                'exception_process_id' => $this->setNullIfEmpty($exception_process->id),
                'alert_subject' => $this->setNullIfEmpty($exception_process->name),
                'alert_name' => "$exception_process->name - ALERT" . random_int(5, 10000000000000),
                'user_id' => $this->setNullIfEmpty($exception_process->user_id),
                // 'exception_category_id' => $this->setNullIfEmpty($exception_process->category_id),
                'email' => $view
            ]);
            $exceptions_logs->update([
                'alert_id' => $alertid->id,
            ]);
            return response()->json(['result' => $validResults]);
        }
        // Save the rendered view to the database

        $this->info('Scheduled queries executed successfully (every 5 minutes).');
    }
}
