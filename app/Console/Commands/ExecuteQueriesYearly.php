<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ExecuteQueriesYearly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queries:execute-yearly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute scheduled queries yearly';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rows = DB::table('exception_process')->where('frequency', 'year')->get();
        $validResults = [];
        $invalidIds = [];
        $validIds = [];

        foreach ($rows as $row) {
            $tableName = $row->table_name;
            $sql = $row->sql_text;

            // Check if the table exists
            if (Schema::hasTable($tableName)) {
                // Execute the SQL query
                $results = DB::select($sql);
                $validResults[] = $results;
                $validIds[] = $row->id;
            } else {
                $invalidIds[] = $row->id;
            }
        }

        // Check if results are found
        if (!empty($validResults) || !empty($invalidIds)) {
            $view = view('email.reports_template', compact('validResults'))->render();

            return response()->json(['result' => $validResults, 'valid query' => $validIds, 'invalid query' => $invalidIds]);
        }

        // Save the rendered view to the database


        $this->info('Scheduled queries executed successfully (every 5 minutes).');
    }
}
