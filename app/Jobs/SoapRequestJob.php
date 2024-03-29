<?php

namespace App\Jobs;

use App\Mail\SendEmailTest;
use App\Models\Nv_Download;
use App\Models\Nv_DownloadStatus;
use App\Models\TestStaff;
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
            Log::info("error -- " . $error_message);
            // Handle the error appropriately
        }

        // Close the cURL session
        curl_close($curl);

        // Parse the SOAP response XML
        $xml = simplexml_load_string($response);

        // Find all the <sr> elements
        $srElements = $xml->xpath('//sr');
        $SR_count = count($srElements);

        // Delete records that exist in the database but not in the XML response
        // $emailsInXml = [];
        // $counter = 0;

        // foreach ($srElements as $srElement) {
        //     $email = (string) $srElement->email;
        //     $emailsInXml[] = $email;
        // }
        // // Iterate over the <sr> elements and extract the data
        // foreach ($srElements as $srElement) {
        //     $counter++;

        //     $fullname = (string) $srElement->fullname;
        //     $email = (string) $srElement->email;
        //     $staffid = (int) $srElement->staffid;
        //     $deptname = (string) $srElement->deptname;

        //     // Check if the staff record already exists in the database
        //     $existingStaff = TestStaff::where('email', $email)->first();

        //     if ($existingStaff) {
        //         // Compare the attributes with the existing record
        //         if ( $existingStaff->staff_name != $fullname ) {
        //             $existingStaff->update([
        //                 'staff_name' => $fullname,
        //             ]);
        //         }
        //         if
        //         ($existingStaff->department != $deptname) {
        //             $existingStaff->update([
        //                 'department' => $deptname,
        //             ]);

        //         }
        //         if ($existingStaff->email != $email
        //         ) {
        //             $existingStaff->update([
        //                 'email' => $email,
        //             ]);
        //         }
        //         if ($existingStaff->staff_id != $staffid) {
        //             $existingStaff->update([
        //                 'staff_id' => $staffid,
        //             ]);
        //         }

        //     } else {
        //         // Create a new Staff model instance and set the attributes
        //         TestStaff::create([
        //             'staff_name' => $fullname,
        //             'email' => $email,
        //             'staff_id' => $staffid,
        //             'department' => $deptname
        //         ]);
        //     }
        //     if ($counter == $SR_count) {
        //         TestStaff::whereNotIn('email', $emailsInXml)->delete();
        //         Log::info("Successful");
        //         exit;
        //     }
        // }

        $values = [];
        foreach ($srElements as $sr) {
            $rowOrder = (string) $sr->attributes('urn:schemas-microsoft-com:xml-msdata')->rowOrder;
            $values[] = $rowOrder;
        }

        foreach ($srElements as $index => $srElement) {
            $counter = $index + 1;

            $fullname = (string) $srElement->fullname;
            $email = (string) $srElement->email;
            $staffid = (int) $srElement->staffid;
            $deptname = (string) $srElement->deptname;
            $id = $values[$index]; // Use the msdata:rowOrder value as the ID

            // Check if the staff record already exists in the database
            $existingStaff = TestStaff::where('email', $email)->first();

            if ($existingStaff) {
                // Compare the attributes with the existing record
                if ($existingStaff->staff_name != $fullname) {
                    $existingStaff->update([
                        'staff_name' => $fullname,
                    ]);
                }
                if ($existingStaff->department != $deptname) {
                    $existingStaff->update([
                        'department' => $deptname,
                    ]);
                }
                if ($existingStaff->email != $email) {
                    $existingStaff->update([
                        'email' => $email,
                    ]);
                }
                if ($existingStaff->staff_id != $staffid) {
                    $existingStaff->update([
                        'staff_id' => $staffid,
                    ]);
                }
            } else {
                // Create a new Staff model instance and set the attributes
                TestStaff::create([
                    'id' => $id,
                    'staff_name' => $fullname,
                    'email' => $email,
                    'staff_id' => $staffid,
                    'department' => $deptname
                ]);
            }

            if ($counter == $SR_count) {
                // Delete records that exist in the database but not in the XML response
                TestStaff::whereNotIn('email', $email)->delete();
                Log::info("Successful");
                exit;
            }
        }

    }
}
