<?php

namespace App\Jobs;

use App\Mail\SendEmailTest;
use App\Models\Nv_Download;
use App\Models\Nv_DownloadStatus;
use App\Models\Staff;
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


class SoapRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $xmlBody;
   
    // protected $details;

    public function __construct($xmlBody)
    {
        $this->xmlBody = $xmlBody;
      
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://10.0.0.217/bankservice/ldap.asmx',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $this->xmlBody,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/xml',
            ),
        ));

        // Execute the cURL request
        $response = curl_exec($curl);

        // Check for cURL errors
        if (curl_errno($curl)) {
            $error_message = curl_error($curl);
            Log::info("error  ---- " . $error_message);

            // Handle the error appropriately
        }

        // Close the cURL session
        curl_close($curl);

        // Parse the SOAP response XML
        $xml = simplexml_load_string($response);

        // Find all the <sr> elements
        $srElements = $xml->xpath('//sr');
        $SR_count = count($srElements);

        // Iterate over the <sr> elements and extract the data
        foreach ($srElements as $srElement) {
            $fullname = (string) $srElement->fullname;
            $email = (string) $srElement->email;
            $staffid = (int) $srElement->staffid;
            $deptname = (string) $srElement->deptname;

            // Create a new Staff model instance and set the attributes
            Staff::create([
                'staff_name' => $fullname,
                'email' => $email,
                'staff_id' => $staffid,
                'department' => $deptname
            ]);
        }
        $success_element= "Number of <sr> elements: $SR_count";
        Log::info("Successful  ---- " . $success_element);
        // return 'Successful ' .$success_element ;

     }
}
