<?php

namespace App\Jobs;

use App\Mail\SendEmailTest;
use App\Models\Nv_Download;
use App\Models\Nv_DownloadStatus;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PDO;
use ZipArchive;
use Illuminate\Support\Facades\File;


class DownloadRecordsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $dsql;
    protected $reference_id;
    protected $nv_download_name;
    protected $file_id;
    protected $link;




    // protected $details;

    public function __construct($dsql, $nv_download_name, $reference_id, $file_id,$link)
    {
        $this->dsql = $dsql;
        $this->link = $link;
        $this->file_id = $file_id;
        $this->reference_id = $reference_id;
        $this->nv_download_name = $nv_download_name;
        // $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $select_dsql = '/select \* from/i';

        if (isset($this->dsql) && preg_match($select_dsql, $this->dsql)) {
            $dsn = 'pgsql:host=139.59.186.114'  . ';dbname=icomply_database';
            $username = 'icomply_user';
            $password = 'icomply_p77ss1212';

            $conn = new PDO($dsn, $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare($this->dsql);
            $stmt->execute();
            $result = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }
            $conn = null;
            // 
            $data = $result;
            $chunkSize = 100; // Number of records per chunk
            $totalRecords = count($data);
            $zipChunkCount = ceil($totalRecords / $chunkSize);
            // Check if the data needs to be chunked
            if (count($data) > $chunkSize) {
                $tempDirectoryName = $this->reference_id;
                $tempDirectory = storage_path('app/' . $tempDirectoryName);

                if (!File::exists($tempDirectory)) {
                    File::makeDirectory($tempDirectory);
                }
                $chunks = array_chunk($data, $chunkSize);
                // Iterate over the chunks and create individual CSV files
                foreach ($chunks as $index => $chunk) {
                    // Open the temporary file for writing
                    $tempFilePath = $tempDirectory . '/page_' . ($index + 1) . '.csv';
                    $file = fopen($tempFilePath, 'w');

                    // Write CSV header for each chunk
                    $header = array_keys((array)$chunk[0]);
                    fputcsv($file, $header);

                    // Write data to the CSV file
                    foreach ($chunk as $row) {
                        fputcsv($file, (array)$row);
                    }

                    // Close the file
                    fclose($file);

                    // Set correct permissions for the file
                    chmod($tempFilePath, 0644);
                }

                // Set the desired file name for download

                // $download_name = '_exported_data.zip';
                $zipFileName = $this->nv_download_name . "_" . $this->reference_id . ".zip";
                // Create a ZIP archive containing the chunked CSV files
                $zip = new ZipArchive();
                $zip->open($tempDirectory . '/' . $zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);
                $files = glob($tempDirectory . '/*.csv');
                foreach ($files as $file) {
                    $zip->addFile($file, basename($file));
                }
                
                $zip->close();
                $file = $tempDirectory . '/' . $zipFileName;
                // Remove the temporary directory and its content
                $currentDate = new DateTime();
                $currentDate->modify('+1 hour');
                $expiration_date = $currentDate->format('Y-m-d H:i:s');
                // Generate the download link
                $download = Nv_Download::find($this->file_id);
                $download->download_link = $this->link. $zipFileName."/";
                $download->status = 1;
                $download->file_name = $zipFileName;
                $download->expiration_date = $expiration_date;
                $download->saveOrFail();


            } else {
                // $fileName =  uniqid() . '_exported_data.csv';
                $tempDirectoryName = $this->reference_id;
                $tempDirectory = storage_path('app/' . $tempDirectoryName);

                $FileName = $this->nv_download_name . "_" . $this->reference_id . ".csv";

                if (!File::exists($tempDirectory)) {
                    File::makeDirectory($tempDirectory);
                }

                $filePath = $tempDirectory . '/' . $FileName;

                $file = fopen($filePath, 'w');
                $header = array_keys((array)$data[0]);
                fputcsv($file, $header);
                foreach ($data as $row) {
                    fputcsv($file, (array)$row);
                }
                fclose($file);


                $currentDate = new DateTime();
                $currentDate->modify('+1 hour');
                $expiration_date = $currentDate->format('Y-m-d H:i:s');
                // Generate the download link
                $download = Nv_Download::find($this->file_id);
                $download->download_link =$this->link. $FileName. "/";
                $download->status = 1;
                $download->file_name = $FileName;
                $download->expiration_date = $expiration_date;
                $download->saveOrFail();
                // log the response
                Log::info($FileName."--------------------------------". $tempDirectoryName);
            }
        } else {
            Log::info('here it did not work');
            return response()->json(['Error' => 'INVALID REQUEST ']);
        }
    }
}
