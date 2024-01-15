<?php

namespace App\Console\Commands;

use App\Models\Nv_Download;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class DeleteExpiredFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:delete-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired files and their records from the database';

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

        // 
        $expiredFiles = Nv_Download::where('expiration_date', '<=', Carbon::now())->get();

        foreach ($expiredFiles as $file) {
            // $filename = $file->filename;

            // Delete file from storage
            $tempDirectoryName=$file->reference_id;
            $tempDirectory = storage_path('app/' . $tempDirectoryName);

            File::deleteDirectory($tempDirectory);
            // Delete record from the database
            $file->delete();
            
        }
        Log::info('here it got here!');

        $this->info('Expired files & file record have been deleted.');
    }
}
