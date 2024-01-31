<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected $commands = [
        \App\Console\Commands\StartInsertListener::class,
        Commands\CbnApi::class,
        Commands\DeleteExpiredFiles::class,
        Commands\ExecuteQueriesIn5Minutes::class
       
    ];

    protected function schedule(Schedule $schedule)
    {
        //  $schedule->command('pgsql:listen')->everyMinute();
        $schedule->command('files:delete-expired')->everyMinute();
        $schedule->command('queries:execute-in-5minutes')->everyFiveMinutes();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
