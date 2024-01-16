<?php

namespace App\Http\Controllers;

// ini_set('memory_limit', '4096M');

use App\Events\ApiRequestEvent;
use App\Events\MyEvent;
use App\Jobs\DownloadDataJob;
use App\Jobs\DownloadRecordsJob;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Http\UploadedFile;
use App\Mail\CaseMail;
use App\Mail\CloseMail;
use App\Mail\DocumentMail;
use App\Mail\ExceptionMail;
use App\Mail\SendMail;
use App\Mail\SystemMail;
use App\Models\Alert;
use App\Models\AlertGroup;
use App\Models\CaseManagement;
use App\Models\CaseStatus;
use App\Models\Department;
use App\Models\Document;
use App\Models\DownLoadNotifier;
use App\Models\DownLoadQueue;
use App\Models\Nv_Download as ModelsNv_Download;
use App\Models\Nv_DownloadStatus;
use App\Models\Process;
use App\Models\Staff;
use App\Models\StrTransactions;
use App\Models\System;
use App\Models\SystemAllocation;
use App\Models\User;
use App\Nv_Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Rules\UniqueArray;
use Carbon\Carbon;
use Carbon\PHPStan\Macro;
use DateTime;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Random;
use PDO;
use PDOException;
use PharIo\Manifest\Url;
use PhpParser\Node\Stmt\Return_;
use ZipArchive;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

use function PHPUnit\Framework\isNull;

class CaseManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function server_info()
    {
        // return $_SERVER;

        var_dump($_SERVER);
    }

    public function showCase()
    {
        $case = CaseManagement::all();
        if (!$case->isNotEmpty()) {
            return response()->json(['message' => 'No case found'], 404);
        }
        return response()->json([
            'message' => 'Case retrived Successfully',
            'allcase' => $case
        ]);
    }

    public function showCaseByStatus(Request $request, CaseManagement $caseStatus)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'case_status_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 401);
        }
        $statusid = $input['case_status_id'];
        $case = $caseStatus->where('case_status_id', '=', $statusid)->get();
        if (!$case->isNotEmpty()) {
            return response()->json(['message' => 'No case found'], 404);
        }
        return response()->json([
            'message' => 'Record(s) retrived',
            'case' => $case,
            'case status id' => $statusid
        ]);
    }


    public function showCaseByPriority(Request $request, CaseManagement $caseStatus)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'priority_level_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 401);
        }
        $priorityid = $input['priority_level_id'];
        $case = $caseStatus->where('priority_level_id', '=', $priorityid)->get();
        if (!$case->isNotEmpty()) {
            return response()->json(['message' => 'No case found'], 404);
        }
        return response()->json([
            'message' => 'Record(s) retrived',
            'case' => $case,
            'priority id' => $priorityid
        ]);
    }


    public function createCase(Request $request)
    {
        $unique = new UniqueArray;
        $input = $request->all();
        $validator = Validator::make($input, [
            'priority_level_id' => 'required|in:1,2,3',
            'description' => 'required|regex:/^[a-zA-Z\s\-]+$/',
            'users' => [
                'required',
                $unique,
                'array',
                'size:' . $input['priority_level_id']
            ],

        ], [
            'users.size' => 'users must contain ' . $input['priority_level_id'] . ' IDs',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $authuser = Auth()->id();
        $initiatingUser_ = User::find($authuser);



        if (is_null($initiatingUser_) || !$authuser) {
            return response()->json(['Unknown User' => 'User not found'], 404);
        }


        $supervisorIds = collect($input['users'])
            ->toArray();

        $validSupervisorIds = User::whereIn('id', $supervisorIds)->where('is_supervisor', '=', true)->pluck('id')->toArray();


        if ($validSupervisorIds != $supervisorIds) {
            return response()->json(['Unauthorized' => 'One or more User ids are not valid supervisors'], 400);
        }


        CaseManagement::create([
            'user_id' => $authuser,
            'case_status_id' => 1,
            'description' => $input['description'],
            'priority_level_id' => $input['priority_level_id'],
        ]);

        $case = CaseManagement::where('case_status_id', 1)
            ->where('description', $input['description'])
            ->where('priority_level_id', $input['priority_level_id'])
            ->value('id');

        $email_info = [
            'title' => 'Notification Mail',
            'body' => 'This is to notify you that a case was just created',
            'link' => 'http://127.0.0.1:8000/case-details/' . $case
        ];

        $userIds = collect($input['users'])->toArray();
        foreach ($userIds as $userId) {
            $user = User::findOrFail($userId);
            Mail::to($user->email)->send(new SendMail($email_info));
        }
        $data = '';
        return response()->json([
            'message' => $data,
        ]);
    }


    public function closeCase(Request $request, $id)
    {
        $input = $request->validate([
            'reason_for_close' => 'required|regex:/^[a-zA-Z\s\-]+$/',
        ]);

        $case = CaseManagement::find($id);

        if (is_null($case)) {
            $checkErr = 'Case not found!';
            return redirect('/showcase')->with(['checkErr' => $checkErr]);
            exit;
        }

        if ($case->case_status_id == 2) {
            $checkErr = 'Case has already been closed';
            return response()->json(['checkErr' => $checkErr]);
        }

        $case->update([
            'case_status_id' => 2,
            'reason_for_close' => $input['reason_for_close'],
            'supervisor_name' => auth()->user()->full_name,
        ]);

        $link = 'http://127.0.0.1:8000/case-details/' . $id;

        $email_info = [
            'title' => 'Notification Mail',
            'body' => 'This is to notify you that a case was closed',
            'name' => 'User who closed the case: ' . auth()->user()->full_name,
            'reason' => 'Reason For Close: ' . $input['reason_for_close'],
            'id' => 'Case ID: ' . $id,
            'link' => $link,
        ];


        // if ($case->case_status_id !== 2 || $case) {
        //     Mail::to($case->user->email)->send(new CaseMail($email_info));
        // }
        return response()->json(['message' => 'Case has been closed!']);
    }

    public function showCaseById(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
        ]);

        $case = CaseManagement::find($request->id);
        if (is_null($case)) {
            $errorMessage = "Case not found!";
            return back()->with('this_error', $errorMessage);
        }

        return redirect('/case-details/' . $request->id);
    }



    public function getCaseDetails($id)
    {
        $case = CaseManagement::find($id);
        if (is_null($case)) {
            $errorMessage = "Case does not exist!";
            return response()->json([$errorMessage]);
        }

        return response()->json($case);
    }

    public function simplee()
    {
        $he = 'hello my world!';
        return response()->json($he);
    }

    private function setNullIfEmpty($value)
    {
        return $value ?? null;
    }


    public function fetch()
    {

        $data = DB::connection('pgsql2')->select('select * from am_staff');
        return $data;
    }
    //THIS IS THE METHOD HANDLING THE QUERY TO DATABASE
    public function query(Request $request)
    {

        $case_notification = [
            'title' => 'Notification Mail',
            'body' => 'This is to notify you that a case was just created',
            'link' => 'http://127.0.0.1:8000/case-details/'
        ];



        $dsn = 'pgsql:host=139.59.186.114'  . ';dbname=icomply_database';
        $username = 'icomply_user';
        $password = 'icomply_p77ss1212';

        try {
            // Set PDO attributes if needed
            $conn = new PDO($dsn, $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //all crud operation
            $tsql = $request->input('sql');
            $file = $request->file('file');


            //file size validation
            $upload_file_size = '2048';
            $rules = [
                'file' => 'required|file|max:' . $upload_file_size, // Max file size is 2MB (2 * 1024 KB)
            ];
            $messages = [
                'file.max' => 'The file size should not exceed 2MB.',
            ];
            $validator = Validator::make(['file' => $file], $rules, $messages);


            //read only and download
            $dsql = $request->input('dsql');
            $nv_download_name = $request->input('download_name');
            //pagination
            $pgnsql = $request->input('pgnsql');
            $from = $request->input('page');
            $record_per_page = $request->input('record_per_page');

            if (isset($tsql)) {
                $stmt = $conn->prepare($tsql);
                $stmt->execute();
                // Continue with processing the result if needed              
            }

            if (isset($dsql)) {
                $stmt = $conn->prepare($dsql);
                $stmt->execute();
                // Continue with processing the result if needed
            }

            if (isset($pgnsql)) {
                $stmt = $conn->prepare($pgnsql);
                $stmt->execute();
                // Continue with processing the result if needed
            }


            $result = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }

            // Close the connection
            $conn = null;


            $formattedDate = date('Y-m-d H:i:s');
            $randomNumber = random_int(
                5,
                10000000000
            );



            // <----------------------CREATE CASE_MANAGEMENT ---------------------------->

            $insertpattern = '/INSERT\s+INTO\s+cases/i';
            if (preg_match($insertpattern, $tsql)) {
                $rowId = [];

                foreach ($result as $item) {
                    $rowId[] = $item['id'];
                }
                if (empty($rowId)) {
                    return response()->json(['error' => 'Returning id not included in your query!']);
                }
                $recipients = CaseManagement::findOrFail($rowId)->first();
                $user_emails = User::where('id',  $recipients->user_id)->pluck('email')->toArray();
                $staff_emails = Staff::where('id',  $recipients->staff_id)->pluck('email')->toArray();

                $emails = [];
                if (isset($user_emails)) {
                    $emails[] = $user_emails;
                }
                if (isset($staff_emails)) {
                    $emails[] =   $staff_emails;
                }

                $department = Department::find($recipients->team_id);

                $deptarr = [];
                $allmail = [];

                if (!empty($department->email)) {
                    $deptarr[] = $department->email;
                }

                if (empty($deptarr)) {
                    $allmail = $emails;
                } elseif (!empty($emails) && !empty($deptarr)) {
                    $allmail = array_merge($allmail, $emails, $deptarr);
                }


                $view = view('email.notification_email', compact('case_notification'))->render();

                $alertid = Alert::create([
                    'mail_to' => $allmail,
                    'status_id' => $this->setNullIfEmpty($recipients->status_id),
                    'alert_description' => $this->setNullIfEmpty($recipients->cases_description),
                    'team_id' => $this->setNullIfEmpty($recipients->team_id),
                    'exception_process_id' => $this->setNullIfEmpty($recipients->exception_process_id),
                    'alert_subject' => $this->setNullIfEmpty($case_notification['body']),
                    'alert_name' => 'ALERT' . $randomNumber,
                    'user_id' => $this->setNullIfEmpty($recipients->user_id),
                    'email' => $view
                ]);

                $recipients->update([
                    'alert_id' => $alertid->id
                ]);

                if (!empty($allmail)) {
                    # code...
                    foreach ($allmail as $email) {
                        Mail::to($email)->send(new CaseMail($case_notification));
                    }
                }

                return response()->json([
                    'message' => 'Case Was Successfully Created!.'
                ]);
            }



            $updatepattern = '/UPDATE\s+cases\s+SET\s+(response_note\s*=\s*(\'|"|\')(.*?)\\2|[^;])*WHERE\s+id\s*=\s*(\d+);?/i';

            if (preg_match($updatepattern, $tsql, $matches)) {


                $UpdatedRowId = $matches[4];
                $response_msg = $matches[3];

                $recipients = CaseManagement::findOrFail($UpdatedRowId);

                $user_emails = User::where('id',  $recipients->user_id)->pluck('email')->toArray();
                $staff_emails = Staff::where('id',  $recipients->staff_id)->pluck('email')->toArray();

                $newArrayValue = json_encode(['response' => $response_msg, 'timestamp' => $formattedDate]);

                $currentResponses = $recipients->responses ?: '[]';

                $currentArray = json_decode($currentResponses, true);
                $currentArray[] = json_decode($newArrayValue);
                $updatedResponses = json_encode($currentArray);
                $recipients->responses = $updatedResponses;
                $recipients->save();
                $lastResponse = json_decode($recipients->responses);

                $emails = [];
                if (isset($user_emails)) {
                    $emails[] = $user_emails;
                }
                if (isset($staff_emails)) {
                    $emails[] =   $staff_emails;
                }
                $department = Department::findOrFail($recipients->team_id);

                $deptarr = [];
                $allmail = [];

                if (!empty($department->email)) {
                    $deptarr[] = $department->email;
                }

                if (empty($deptarr)) {
                    $allmail = $emails;
                } elseif (!empty($emails) && !empty($deptarr)) {
                    $allmail = array_merge($allmail, $emails, $deptarr);
                }

                $responder = $recipients->staff_id;
                $email_info = [
                    'title' => 'Notification Mail',
                    'body' => 'This is to notify you that a case was just responded to',
                    'responder_id' => $responder,
                    'response' => $recipients->assigned_user_response,
                    'link' => 'http://127.0.0.1:8000/case-details/' . $UpdatedRowId
                ];

                $view = view('email._email', compact('email_info'))->render();
                $alertid = Alert::create([
                    'mail_to' => $allmail,
                    'status_id' => $this->setNullIfEmpty($recipients->status_id),
                    'alert_action' => $this->setNullIfEmpty($recipients->case_action),
                    'alert_description' => $this->setNullIfEmpty($recipients->cases_description),
                    'team_id' => $this->setNullIfEmpty($recipients->team_id),
                    'exception_process_id' => $this->setNullIfEmpty($recipients->exception_process_id),
                    'alert_subject' => $this->setNullIfEmpty($email_info['body']),
                    'alert_name' => 'ALERT' . $randomNumber,
                    'user_id' => $this->setNullIfEmpty($recipients->user_id),
                    'email' => $view
                ]);

                $recipients->update([
                    'alert_id' => $alertid->id
                ]);

                if (!empty($allmail)) {
                    # code...

                    foreach ($allmail as $email) {
                        Mail::to($email)->send(new SendMail($email_info));
                    }
                }
                return response()->json([
                    'message' => 'Response Sent!.'
                ]);
            };


            $closepattern = '/UPDATE\s+cases\s+SET\s+status_id\s*=\s*2[^;]*WHERE\s+id\s*=\s*(\d+);?/i';

            if (preg_match($closepattern, $tsql, $matches)) {
                $id = $matches[1];

                $recipients = CaseManagement::find($id);
                $user_emails = User::where('id', $recipients->user_id)->pluck('email');
                $staff_emails = Staff::where('id', $recipients->staff_id)->pluck('email');


                $emails = [];
                if (isset($user_emails)) {
                    $emails[] = $user_emails;
                }
                if (isset($staff_emails)) {
                    $emails[] =   $staff_emails;
                }


                $creator = $recipients->user_id;
                $close_case = [
                    'title' => 'Notification Mail',
                    'body' => 'This is to notify you that a case was closed',
                    'creator_id' => $creator,
                    'reason_for_close' => $recipients->case_action,
                    'link' => 'http://127.0.0.1:8000/case-details/'
                ];
                $view = view('email.notification_email', compact('close_case'))->render();
                $department = Department::find($recipients->team_id);

                $deptarr = [];
                $allmail = [];

                if (!empty($department->email)) {
                    $deptarr[] = $department->email;
                }

                if (empty($deptarr)) {
                    $allmail = $emails;
                } elseif (!empty($emails) && !empty($deptarr)) {
                    $allmail = array_merge($allmail, $emails, $deptarr);
                }

                $alertid = Alert::create([
                    'mail_to' => $allmail,
                    'status_id' => $this->setNullIfEmpty($recipients->status_id),
                    'alert_action' => $this->setNullIfEmpty($recipients->case_action),
                    'alert_description' => $this->setNullIfEmpty($recipients->cases_description),
                    'team_id' => $this->setNullIfEmpty($recipients->team_id),
                    'exception_process_id' => $this->setNullIfEmpty($recipients->exception_process_id),
                    'alert_subject' => $close_case['body'],
                    'alert_name' => $this->setNullIfEmpty('ALERT' . $randomNumber),
                    'user_id' => $this->setNullIfEmpty($recipients->user_id),
                    'email' => $view
                ]);

                $recipients->update([
                    'alert_id' => $alertid->id
                ]);
                if (!empty($allmail)) {
                    # code...
                    foreach ($allmail as $email) {
                        Mail::to($email)->send(new CaseMail($close_case));
                    }
                }

                return response()->json([
                    'message' => 'Case Closed Successfully!.'
                ]);
            }


            $insertprocess_type = '/INSERT\s+INTO\s+exception_process_type/i';
            if (preg_match($insertprocess_type, $tsql)) {
                return response()->json([
                    $result,
                    'message' => 'Query Execution Was Successful.'
                ]);
            }


            //<-------------------PROCESS---------------------------->
            $insertprocess = '/INSERT\s+INTO\s+exception_process/i';
            if (preg_match($insertprocess, $tsql)) {
                $rowId = [];

                foreach ($result as $item) {
                    $rowId[] = $item['id'];
                }
                if (empty($rowId)) {
                    return response()->json(['error' => 'Returning id not included in your query!']);
                }
                $recipients = Process::findOrFail($rowId)->first();
                $recipientsId = [];
                if (!is_null($recipients->first_owner_id)) {
                    $recipientsId[] = $recipients->first_owner_id;
                }
                if (!is_null($recipients->second_owner_id)) {
                    $recipientsId[] = $recipients->second_owner_id;
                }
                if (!is_null($recipients->user_id)) {
                    $recipientsId[] = $recipients->user_id;
                }

                $id = $rowId[0];
                $status = $recipients->state;
                if ($status == 'active') {
                    $status = 1;
                } else {
                    $status = 2;
                }



                $document_notification = [
                    'title' => 'New Process Notification',
                    'document' => 'This is to notify you that a process was created',
                    'creator_id' => $recipients->user_id,
                    'id' => $id,
                    'link' => '',
                ];
                if (!empty($recipientsId)) {
                    # code...
                    $emails_ = User::whereIn('id', $recipientsId)->pluck('email')->toArray();
                }
                $view = view('email.document_email', compact('document_notification'))->render();

                Alert::create([
                    'mail_to' => $emails_,
                    'status_id' => $this->setNullIfEmpty($status),
                    'alert_description' => $this->setNullIfEmpty($recipients->narration),
                    'exception_process_id' => $this->setNullIfEmpty($recipients->process_id),
                    'alert_action' => $this->setNullIfEmpty($document_notification['document']),
                    'alert_subject' => $this->setNullIfEmpty($document_notification['document']),
                    'alert_name' => $this->setNullIfEmpty('ALERT' . $randomNumber),
                    'user_id' => $this->setNullIfEmpty($recipients->user_id),
                    'email' => $view
                ]);

                if (!empty($emails_)) {
                    # code...
                    foreach ($emails_ as $email) {
                        Mail::to($email)->send(new DocumentMail($document_notification));
                    }
                }

                return response()->json([
                    'message' => 'Process Was Successfully Created!.'
                ]);
            }

            //< --------------CREATE DOCUMENT ----------------------->


            $insertdocument = '/INSERT\s+INTO\s+ctl_document/i';
            if (preg_match($insertdocument, $tsql)) {
                $rowId = [];

                foreach ($result as $item) {
                    $rowId[] = $item['id'];
                }
                if (empty($rowId)) {
                    return response()->json(['error' => 'Returning id not included in your query!']);
                }

                $recipients = Document::findOrFail($rowId)->first();
                $recipientsId = [];
                if (!is_null($recipients->first_owner_id)) {
                    $recipientsId[] = $recipients->first_owner_id;
                }
                if (!is_null($recipients->second_owner_id)) {
                    $recipientsId[] = $recipients->second_owner_id;
                }
                if (!is_null($recipients->user_id)) {
                    $recipientsId[] = $recipients->user_id;
                }


                $id = $rowId[0];
                $document_notification = [
                    'title' => 'New Document Notification',
                    'document' => 'This is to notify you that a new document was created',
                    'creator_id' => $recipients->user_id,
                    'id' => $id,
                    'link' => '',
                ];
                $status = $recipients->status;
                if ($status == 'approved') {
                    $status = 1;
                } else {
                    $status = 2;
                }

                if (!empty($recipientsId)) {
                    # code...
                    $emails = User::whereIn('id', $recipientsId)->pluck('email')->toArray();
                }

                $view = view('email.document_email', compact('document_notification'))->render();
                $alertid = Alert::create([
                    'mail_to' => $emails,
                    'status_id' => $this->setNullIfEmpty($status),
                    'alert_description' => $this->setNullIfEmpty($recipients->narration),
                    'exception_process_id' => $this->setNullIfEmpty($recipients->process_id),
                    'alert_action' => $this->setNullIfEmpty($document_notification['document']),
                    'alert_subject' => $this->setNullIfEmpty($document_notification['document']),
                    'alert_name' => 'ALERT' . $randomNumber,
                    'user_id' => $this->setNullIfEmpty($recipients->user_id),
                    'created_at' => $formattedDate,
                    'email' => $view

                ]);

               
                if (isset($file)) {
                    if (!$file) {
                        // Handle the case when the file input is not present or empty
                        return response()->json(['error' => 'No file provided.'], 400);
                    }
                    if ($validator->fails()) {
                        // If validation fails, return the validation errors
                        return response()->json(['errors' => $validator->errors()], 400);
                    }
                    $new_file = $file->store('allfiles');
                    if ($new_file) {

                        
                        $file_name = basename($new_file);
                        $original_name = $file->getClientOriginalName();
                        $file->move(public_path('allfiles'), $file_name);
                        $imageUrl = url(asset('allfiles/' . $file_name));
                        $recipients->source_file = $imageUrl;
                        $recipients->file_name = $original_name;
                        $recipients->save();
                        
                    }
                    
                }
                if (!empty($emails)) {
                    # code...
                    foreach ($emails as $email) {
                        Mail::to($email)->send(new DocumentMail($document_notification));
                    }
                }
               
                $response = [
                    'message' => 'Document Created successfully',
                ];

                if (isset($imageUrl)) {
                    $response['fileUrl'] = $imageUrl;
                }
                $response = array_filter($response, function ($value) {
                    return !empty($value);
                });

                return response()->json($response);
            }

            //----------------------------UPDATE DOCUMENT STATUS-------------------->
            $update_document_status = '/UPDATE\s+ctl_document\s+SET\s+status[^;]*WHERE\s+id\s*=\s*(\d+);?/i';

            // $update_document_status = '/update\s+ctl_document\s+set\s+status[^;]*where\s+id\s*=\s*(\d+);/i';

            if (preg_match($update_document_status, $tsql, $matches)) {

                $UpdatedRowId = $matches[1];
                $recipients = Document::find($UpdatedRowId);

                $recipientsId[] = $recipients->first_line_owner;
                $recipientsId[] = $recipients->second_line_owner;
                $recipientsId[] = $recipients->user_id;
                $recipientsId[] = $recipients->approver_id;

                if (!empty($recipientsId)) {
                    # code...
                    $emails = User::whereIn('id', $recipientsId)->pluck('email')->toArray();
                }
                $document_notification = [
                    'Update_title' => 'Document Approved',
                    'update_document' => 'This is to notify you that a document id ' . $UpdatedRowId . 'was just appeoved',
                    'approver_id' => $recipients->approver_id,
                    'link' => ''
                ];
                $view = view('email.document_email', compact('document_notification'))->render();
                Alert::create([
                    'mail_to' => $emails,
                    'status_id' => $this->setNullIfEmpty($recipients->status),
                    'alert_description' => $this->setNullIfEmpty($recipients->description),
                    'exception_process_id' => $this->setNullIfEmpty($recipients->exception_process),
                    'alert_action' => $this->setNullIfEmpty($document_notification['Update_title']),
                    'alert_subject' => $this->setNullIfEmpty($document_notification['update_document']),
                    'alert_name' => $this->setNullIfEmpty('ALERT' . $randomNumber),
                    'user_id' => $this->setNullIfEmpty($recipients->user_id),
                    'created_at' => $formattedDate,
                    'email' => $view

                ]);

                if (!empty($emails)) {
                    # code...
                    foreach ($emails as $email) {
                        Mail::to($email)->send(new DocumentMail($document_notification));
                    }
                }

                return response()->json([
                    'message' => 'Document Updated!.'
                ]);
            };



            //---------------------CREATE SYSTEM ALLOCATION --------------------------->

            $system_all = '/INSERT\s+INTO\s+ctl_system_allocation/i';
            if (preg_match($system_all, $tsql)) {
                $rowId = [];

                foreach ($result as $item) {
                    $rowId[] = $item['id'];
                }

                if (empty($rowId)) {
                    return response()->json(['error' => 'Returning id not included in your query!']);
                }
                $recipients = SystemAllocation::find($rowId)->first();

                $recipientsId = [];
                if (!is_null($recipients->responsible_id)) {
                    $recipientsId[] = $recipients->responsible_id;
                }
                if (!is_null($recipients->user_id)) {
                    $recipientsId[] = $recipients->user_id;
                }
                if (!is_null($recipients->approver_id)) {
                    $recipientsId[] = $recipients->approver_id;
                }
                if (!empty($recipientsId)) {
                    # code...
                    $emails = User::whereIn('id', $recipientsId)->pluck('email')->toArray();
                }



                $system = [
                    'allocate_title' => 'New System Allocation',
                    'allocate' => 'This Is To Notify You That a New System Was Allocated',
                    'allocator' => $recipients->user_id,
                    'link' => '',
                ];
                $view = view('email.system', compact('system'))->render();

                Alert::create([
                    'mail_to' => $this->setNullIfEmpty($emails),
                    'alert_description' => $this->setNullIfEmpty($recipients->description),
                    'alert_action' => $this->setNullIfEmpty($system['allocate']),
                    'alert_name' => 'ALERT' . $randomNumber,
                    'user_id' => $this->setNullIfEmpty($recipients->user_id),
                    'email' => $view
                ]);
                if (!empty($emails)) {
                    # code...
                    foreach ($emails as $email) {
                        Mail::to($email)->send(new SystemMail($system));
                    }
                }

                return response()->json([
                    'message' => 'System Allocation Was Successful!.'
                ]);
            }

            //<----------------------SYSTEM ALLOCATION UPDATE----------------------->
            $update_system_all = '/UPDATE\s+ctl_system_allocation\s+SET\s+status[^;]*WHERE\s+id\s*=\s*(\d+);?/i';

            if (preg_match($update_system_all, $tsql, $matches)) {

                $UpdatedRowId = $matches[1];
                $recipients = SystemAllocation::find($UpdatedRowId);

                if (!is_null($recipients->responsible_id)) {
                    $recipientsId[] = $recipients->responsible_id;
                }
                if (!is_null($recipients->user_id)) {
                    $recipientsId[] = $recipients->user_id;
                }
                if (!is_null($recipients->approver_id)) {
                    $recipientsId[] = $recipients->approver_id;
                }

                if (!empty($recipientsId)) {
                    # code...
                    $emails = User::whereIn('id', $recipientsId)->pluck('email')->toArray();
                }


                $system = [
                    'update_allocate_title' => 'System Allocation Notification',
                    'update_allocate' => 'This is to notify you that system id ' . $UpdatedRowId . ' that was allocated has been approved',
                    'allocator' => $recipients->user_id,
                    'link' => '',
                ];

                $view = view('email.system', compact('system'))->render(); //

                Alert::create([
                    'mail_to' => $this->setNullIfEmpty(
                        $emails
                    ),
                    'alert_description' => $this->setNullIfEmpty(
                        $recipients->description
                    ),
                    'alert_action' => $this->setNullIfEmpty(
                        $recipients->description
                    ),
                    'alert_name' => 'ALERT' . $randomNumber,
                    'user_id' => $this->setNullIfEmpty(
                        $recipients->approver_id
                    ),
                    'email' => $view

                ]);


                if (!empty($emails)) {
                    # code...
                    foreach ($emails as $email) {
                        Mail::to($email)->send(new SystemMail($system));
                    }
                }


                return response()->json([
                    'message' => 'System Allocation Approved!.....'
                ]);
            };

            //<-------------------------- CREATE SYSTEM ---------------------------->
            $insertsystem = '/INSERT\s+INTO\s+ctl_system/i';
            if (preg_match($insertsystem, $tsql)) {
                $rowId = [];

                foreach ($result as $item) {
                    $rowId[] = $item['id'];
                }

                if (empty($rowId)) {
                    return response()->json(['error' => 'Returning id not included in your query!']);
                }
                $recipients = System::find($rowId)->first();

                $recipientsId = [];
                if (!is_null($recipients->owner_1)) {
                    $recipientsId[] = $recipients->owner_1;
                }
                if (!is_null($recipients->owner_2)) {
                    $recipientsId[] = $recipients->owner_2;
                }
                if (!is_null($recipients->approver_id)) {
                    $recipientsId[] = $recipients->approver_id;
                }

                if (!empty($recipientsId)) {
                    $emails = User::whereIn('id', $recipientsId)->pluck('email')->toArray();
                }
                $system = [
                    'systemtitle' => 'New System Notification',
                    'system' => 'This is to notify you that a new system was added',
                    'approver_id' => $recipients->approver_id,
                    'link' => '',
                ];
                $view = view('email.system', compact('system'))->render(); //

                Alert::create([
                    'mail_to' => $this->setNullIfEmpty(
                        $emails
                    ),
                    'alert_description' => $this->setNullIfEmpty($recipients->additional_comment),
                    'process_id' => $this->setNullIfEmpty(
                        $recipients->process_id
                    ),
                    'alert_action' => $this->setNullIfEmpty(
                        $recipients->additional_comment
                    ),
                    'alert_name' => 'ALERT' . $randomNumber,
                    'user_id' => $this->setNullIfEmpty(
                        $recipients->approver_id
                    ),
                    'email' => $view
                ]);


                if (!empty($emails)) {
                    foreach ($emails as $email) {
                        Mail::to($email)->send(new SystemMail($system));
                    }
                }

                return response()->json([
                    'message' => 'System Was Successfully Created!.'
                ]);
            }

            $paginate_pattern_ =  '/select \* from/i';
            if (isset($pgnsql) && preg_match($paginate_pattern_, $pgnsql)) {

                $from  = request()->get('page', $from);


                $collection = new Collection($result);

                // Paginate the collection
                $paginatedData = $collection->forPage($from, $record_per_page);

                // Create a LengthAwarePaginator instance
                $paginator = new LengthAwarePaginator(
                    $paginatedData,
                    $collection->count(), // Total number of items
                    $record_per_page,
                    $from,
                    ['path' => url()->current()] // URL for the paginator links
                );
                return response()->json([
                    $paginator,
                    'message' => 'Query Execution Was Successful.'
                ]);
            }



            $select_dsql = '/select \* from/i';
            if (isset($dsql) && preg_match($select_dsql, $dsql)) {
                // return                 $site_ref = $_SERVER['HTTP_HOST'];

                if (!isset($nv_download_name)) {

                    return response()->json([
                        'error' => 'download_name field is required.'
                    ]);
                }
                $download_stat = Nv_DownloadStatus::where('slug', 'completed')->first();



                $reference_id = uniqid();
                // testing
                $zipFileName = $nv_download_name . "_" . $reference_id;
                // Send processing message to the user
                $download = new ModelsNv_Download();
                $download->reference_id = $reference_id;
                $download->download_name = $nv_download_name;
                // $download->download_link = $nv_download_name.'_'. $reference_id;
                $download->status = $download_stat->value_id;
                $download->created_at = $formattedDate;
                $download->saveOrFail();

                $http_host = $_SERVER['HTTP_HOST'];
                if ($http_host !== "127.0.0.1:8000") {
                    # code...

                    $script_name = $_SERVER['SCRIPT_NAME'];
                    $link = $http_host . "/" . $script_name . "/";
                } else {
                    $script_name = '';
                    $link = $http_host . "/api/download/";
                }

                DownloadRecordsJob::dispatch($dsql, $nv_download_name, $reference_id, $download->id, $link);

                return response()->json([
                    'message' => 'Request is being processed',
                    $link
                ]);
            } else if (isset($dsql) && !preg_match($select_dsql, $dsql)) {
                return response()->json([
                    'error' => 'Query is not a valid select statement.'
                ]);
            }



            $select_for_tsql = '/select \* from/i';
            // $tsql= 'select * from';
            if (isset($tsql) && preg_match($select_for_tsql, $tsql)) {

                if (empty($result)) {
                    return response()->json([
                        'message' => 'Data Not Found.'
                    ]);
                }
            }

            return response()->json([
                $result,
                'message' => 'Query Execution Was Successful.'
            ]);
        } catch (PDOException  $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    public function store(Request $request)
    {
        $message = 'hello world';
        // $request->input('message');

        return response()->json(['message' => $message]);
    }

    private function arrayToXml($data, $rootNodeName = 'data', $xml = null)
    {
        if ($xml === null) {
            $xml = new \SimpleXMLElement('<' . $rootNodeName . '/>');
        }

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $this->arrayToXml($value, $key, $xml->addChild($key));
            } else {
                $xml->addChild($key, $value);
            }
        }

        return $xml->asXML();
    }


    public function downloadFile($filename, $userId)
    {
        // Perform authentication check using $userId
        if (isset($userId, $filename)) {
            # code...
            $auth_user = Staff::find($userId);
            $download_name = ModelsNv_Download::where('file_name', $filename)->first();

            $tempDirectoryName = $download_name->reference_id;
            $filePath = storage_path('app/' . $tempDirectoryName . '/' . $filename);
            # check if the user exists
            if (!empty($auth_user)) {
                # check if the file exists
                if (file_exists($filePath)) {
                    $headers = [
                        'Content-Type' => 'application/octet-stream',
                    ];
                    // If authentication succeeds, proceed with file download
                    return response()->download($filePath, $filename, $headers);
                } else {
                    // Handle the case where the file does not exist
                    return response()->json(['message' => 'File not found'], 404);
                }
            } else {
                // Handle the case where the user does not exist
                return response()->json(['message' => 'User not Authenticated'], 404);
            }
        } else {
            // Handle the case where user or file does not exist
            return response()->json(['error' => 'Invalid request'], 404);
        }
    }

    public function notifyDownloadSuccess(Request $request)
    {
        $requestData[] = $request->all();
        $formattedDate = date('Y-m-d H:i:s');

        if (!empty($requestData)) {
            # code...
            $download = new DownLoadNotifier();
            $download->temp_dir = $requestData[0]['temp_dir'];
            $download->ip_address = $requestData[0]['user_ip'];
            $download->file_size = $requestData[0]['file_size'];
            $download->download_status = "complete";
            $download->created_at = $formattedDate;
            $download->saveOrFail();
            // Log::info($download);
        }
    }
    public function auth_user(){

        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        // Initialize the data variable
        $data = [];

        if ($contentType === "application/json") {
            // Get the JSON body from the request
            $json = file_get_contents('php://input');

            // Decode the JSON body
            $data = json_decode($json, true);
        } else {
            // Retrieve the username and password from the request
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            // Create an array with the user input
            $data = array(
                    'username' => $username,
                    'password' => $password
                );
        }

        // Validate the input
        $errors = [];

        if (empty($data['username'])) {
            $errors[] = 'Username is required.';
        }

        if (empty($data['password'])) {
            $errors[] = 'Password is required.';
        }

        if (!empty($errors)) {
            $response = array('errors' => $errors);
            return json_encode($response);
            
        }

        // Convert the data to JSON
        $data_string = json_encode($data);

        // Initialize cURL
        $curl = curl_init();

        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apex.oracle.com/pls/apex/biggy/auth/ad',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data_string,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string) // Set the Content-Length header
            ),
        ));

        // Execute the cURL request
        $response = curl_exec($curl);

        // Close the cURL session
        curl_close($curl);

        // Output the response
        return $response;
    }
}
