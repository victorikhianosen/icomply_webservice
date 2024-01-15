<?php
// App\Jobs\DownloadDataJob.php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;

class DownloadDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tempDirectory;
    public $zipFileName;

    public function __construct($tempDirectory, $zipFileName)
    {
        $this->tempDirectory = $tempDirectory;
        $this->zipFileName = $zipFileName;
    }

    public function handle()
    {
        // Your existing download logic here
        $response = new StreamedResponse(function () {
            // Output the file to the browser
            readfile($this->tempDirectory . '/' . $this->zipFileName);
            // Clean up - delete the file and the directory
            unlink($this->tempDirectory . '/' . $this->zipFileName);
            rmdir($this->tempDirectory);
        });

        $response->headers->set('Content-Type', 'application/zip');
        $response->headers->set('Content-Disposition', 'attachment; filename=' . $this->zipFileName);
        $response->headers->set('Cache-Control', 'must-revalidate');

        $response->send();
    }
}
