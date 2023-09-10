<?php

namespace App\Http\Controllers;

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
use App\Models\Process;
use App\Models\System;
use App\Models\SystemAllocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Rules\UniqueArray;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Nette\Utils\Random;
use PDO;
use PDOException;
use PhpParser\Node\Stmt\Return_;

use function PHPUnit\Framework\isNull;

class CaseManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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

        return response()->json([
            'message' => 'Case created Successfully',
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



    //THIS IS THE METHOD HANDLING THE QUERY TO DATABASE
    public function query(Request $request)
    {
        $case_notification = [
            'title' => 'Notification Mail',
            'body' => 'This is to notify you that a case was just created',
            'link' => 'http://127.0.0.1:8000/case-details/'
        ];

        
        $serverName = "localhost";
        $connectionOptions = array(
                "dbname" => "casedb",
                "user" => "postgres",
                "password" => "leonard",
                "host" => $serverName,
                "driver" => "pdo_pgsql"
            );

        try {
            $conn = new PDO("pgsql:host={$connectionOptions['host']};dbname={$connectionOptions['dbname']}", $connectionOptions['user'], $connectionOptions['password']);
            // Set PDO attributes if needed
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $tsql = $request->header('sql');

            $stmt = $conn->prepare($tsql);
            $stmt->execute();

            $result = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }

            // Close the connection
            $conn = null;

            // <----------------------CREATE CASE_MANAGEMENT ---------------------------->

            $insertpattern = '/INSERT\s+INTO\s+case_management/i';
            if (preg_match($insertpattern, $tsql)) {
                $rowId = [];

                foreach ($result as $item) {
                    $rowId[] = $item['id'];
                }

                $recipients = CaseManagement::find($rowId)->first();

                $supervisor_id = json_decode($recipients->supervisor_id, true);
                

                $recipientsId = [];
                if (isset($recipients->assigned_user)) {
                    $recipientsId[] = $recipients->assigned_user;
                }
                if (isset($supervisor_id["id"])) {
                    $recipientsId = array_merge($recipientsId, $supervisor_id["id"]);
                }
                $randomNumber = random_int(5, 10000000000);
                $emails = User::whereIn('id', $recipientsId)->pluck('email')->toArray();
                
                
                $department = Department::find($recipients->department_id);
                
                $deptarr[]=$department->email;
                $allmail []= array_merge($emails, $deptarr);
            
                Alert::create([
                    'mail_to' => $allmail,
                    'case_status_id' => $recipients->case_status_id,
                    'description' => $recipients->description,
                    'department_id' => $recipients->department_id,
                    'process_id'=> $recipients->process_id ,
                    'alert_action'=> $recipients->case_action ,
                    'name'=>'ALERT'.$randomNumber,
                    'user_id'=> $recipients->user_id
                ]);
                foreach ($allmail as $email) {
                    Mail::to($email)->send(new CaseMail($case_notification));
                }
                return response()->json([
                    'message' => 'Case Was Successfully Created!.'
                ]);
            }



            $updatepattern = '/UPDATE\s+case_management\s+SET\s+assigned_user_response[^;]*WHERE\s+id\s*=\s*(\d+);/i';

            if (preg_match($updatepattern, $tsql, $matches)) {

                $UpdatedRowId = $matches[1];
                $recipients = CaseManagement::find($UpdatedRowId)->first();
                $supervisor_id = json_decode($recipients->supervisor_id, true);

                $recipientsId = [];
                if (isset($recipients->user_id)) {
                    $recipientsId[] = $recipients->user_id;
                }
                if (isset($supervisor_id["id"])) {
                    $recipientsId = array_merge($recipientsId, $supervisor_id["id"]);
                }
                $randomNumber = random_int(5, 10000000000);
                $emails = User::whereIn('id', $recipientsId)->pluck('email')->toArray();


                $department = Department::find($recipients->department_id);

                $deptarr[] = $department->email;
                $allmail[] = array_merge($emails, $deptarr);
            
                 $responder = $recipients->assigned_user;
                $email_info = [
                    'title' => 'Notification Mail',
                    'body' => 'This is to notify you that a case was just responded to',
                    'responder_id'=> $responder,
                    'response'=>$recipients->assigned_user_response,
                    'link' => 'http://127.0.0.1:8000/case-details/'. $UpdatedRowId
                ];
                Alert::create([
                    'mail_to' => $allmail,
                    'case_status_id' => $recipients->case_status_id,
                    'description' => $recipients->description,
                    'department_id' => $recipients->department_id,
                    'process_id' => $recipients->process_id,
                    'alert_action' => $recipients->case_action,
                    'name' => 'ALERT' . $randomNumber,
                    'user_id' => $recipients->user_id
                ]);
                
                foreach ($allmail as $email) {
                    Mail::to($email)->send(new SendMail($email_info));
                }
                return response()->json([
                    'message' => 'Response Sent!.'
                ]);
            };


            $closepattern ='/UPDATE\s+case_management\s+SET\s+case_status_id\s*=\s*2[^;]*WHERE\s+id\s*=\s*(\d+);/i';

            if (preg_match($closepattern, $tsql, $matches)) {
                $id = $matches[1];

                $recipients = CaseManagement::find($id)->first();
                $supervisor_id = json_decode($recipients->supervisor_id, true);

                $recipientsId = [];
                if (isset($recipients->user_id)) {
                    $recipientsId[] = $recipients->user_id;
                }
                if (isset($recipients->assigned_user)) {
                    $recipientsId[] = $recipients->assigned_user;
                }
                if (isset($supervisor_id["id"])) {
                    $super[]= $supervisor_id["id"];
                    $recipientsId = array_merge($recipientsId, $super);
                }
                
                
                $creator = $recipients->user_id;
                $close_case = [
                    'title' => 'Notification Mail',
                    'body' => 'This is to notify you that a case was closed',
                    'creator_id' => $creator,
                    'reason_for_close' => $recipients->reason_for_close,
                    'link' => 'http://127.0.0.1:8000/case-details/' . $id
                ];
                $randomNumber = random_int(5, 10000000000);
                $emails = User::whereIn('id', $recipientsId)->pluck('email')->toArray();


                $department = Department::find($recipients->department_id);

                $deptarr[] = $department->email;
                $allmail[] = array_merge($emails, $deptarr);
                Alert::create([
                    'mail_to' => $allmail,
                    'case_status_id' => $recipients->case_status_id,
                    'description' => $recipients->description,
                    'department_id' => $recipients->department_id,
                    'process_id' => $recipients->process_id,
                    'alert_action' => $recipients->case_action,
                    'name' => 'ALERT' . $randomNumber,
                    'user_id' => $recipients->user_id
                ]);
                foreach ($allmail as $email) {
                    Mail::to($email)->send(new CaseMail($close_case));
                }
                return response()->json([
                    'message' => 'Case Closed Successfully!.'
                ]);
            }


            //< --------------CREATE DOCUMENT ----------------------->

            $insertprocess = '/INSERT\s+INTO\s+document/i';
            if (preg_match($insertprocess, $tsql)) {
                $rowId = [];

                foreach ($result as $item) {
                    $rowId[] = $item['id'];
                }

                $recipients=Document::find($rowId)->first();
                
                    $recipientsId[] = $recipients->first_owner_id;
                $recipientsId[] = $recipients->second_owner_id;
                $recipientsId[] = $recipients->user_id;

                $emails = User::whereIn('id', $recipientsId)->pluck('email')->toArray();

                $document_notification = [
                    'title' => 'New Document Notification',
                    'document' => 'This is to notify you that a new document was created',
                    'creator_id' => $recipients->user_id,
                    'id'=>$rowId,
                    'link'=>'',
                ];
                foreach ($emails as $email) {
                    Mail::to($email)->send(new DocumentMail($document_notification));
                }
                return response()->json([
                    'message' => 'Document Was Successfully Created!.'
                ]);
            }

            //----------------------------UPDATE DOCUMENT STATUS-------------------->

            $update_process_status = '/UPDATE\s+document\s+SET\s+status[^;]*WHERE\s+id\s*=\s*(\d+);/i';

            if (preg_match($update_process_status, $tsql, $matches)) {

                $UpdatedRowId = $matches[1];
                $recipients = Document::find($UpdatedRowId)->first();

                $recipientsId[] = $recipients->first_line_owner;
                $recipientsId[] = $recipients->second_line_owner;
                $recipientsId[] = $recipients->user_id;
                $recipientsId[] = $recipients->approver_id;

                $randomNumber = random_int(5, 10000000000);

                $emails = User::whereIn('id', $recipientsId)->pluck('email')->toArray();
                $document_notification = [
                    'Update_title' => 'Document Approved',
                    'update_document' => 'This is to notify you that a document id '.$UpdatedRowId .'was just appeoved',
                    'approver_id' => $recipients->approver_id,
                    'link' => ''
                ];
                Alert::create([
                    'mail_to' => $emails,
                    'description' => $recipients->description,
                    'process_id' => $recipients->process_id,
                    'alert_action' => $recipients->status,
                    'name' => 'ALERT' . $randomNumber,
                    'user_id' => $recipients->user_id
                ]);

                foreach ($emails as $email) {
                    Mail::to($email)->send(new DocumentMail($document_notification));
                }
                return response()->json([
                    'message' => 'Document Updated!.'
                ]);
            };

            //<-------------------------- CREATE SYSTEM ---------------------------->
            $insertsystem = '/INSERT\s+INTO\s+system/i';
            if (preg_match($insertsystem, $tsql)) {
                $rowId = [];

                foreach ($result as $item) {
                    $rowId[] = $item['id'];
                }

                $recipients = System::find($rowId)->first();

                $recipientsId[] = $recipients->owner_1;
                $recipientsId[] = $recipients->owner_2;
                $recipientsId[] = $recipients->approver_id;

                $emails = User::whereIn('id', $recipientsId)->pluck('email')->toArray();
                $randomNumber = random_int(5, 10000000000);

                Alert::create([
                    'mail_to' => $emails,
                    'description' => $recipients->additional_comment,
                    'process_id' => $recipients->process_id,
                    'alert_action' => $recipients->additional_comment,
                    'name' => 'ALERT' . $randomNumber,
                    'user_id' => $recipients->approver_id
                ]);

                $system = [
                    'systemtitle' => 'New System Notification',
                    'system' => 'This is to notify you that a new system was added',
                    'approver_id' => $recipients->approver_id,
                    'link' => '',
                ];
                foreach ($emails as $email) {
                    Mail::to($email)->send(new SystemMail($system));
                }
                return response()->json([
                    'message' => 'System Was Successfully Created!.'
                ]);
            }

            //---------------------CREATE SYSTEM ALLOCATION --------------------------->

            $system_all = '/INSERT\s+INTO\s+system_allocation/i';
            if (preg_match($system_all, $tsql)) {
                $rowId = [];

                foreach ($result as $item) {
                    $rowId[] = $item['id'];
                }

                $recipients = SystemAllocation::find($rowId)->first();

                $recipientsId[] = $recipients->user_id;
                $recipientsId[] = $recipients->responsible_id;
                $recipientsId[] = $recipients->approver_id;

                $emails = User::whereIn('id', $recipientsId)->pluck('email')->toArray();
                $randomNumber = random_int(5, 10000000000);

                Alert::create([
                    'mail_to' => $emails,
                    'description' => $recipients->description,
                    'alert_action' => $recipients->description,
                    'name' => 'ALERT' . $randomNumber,
                    'user_id' => $recipients->user_id
                ]);

                $system = [
                    'allocate_title' => 'New System Allocation',
                    'allocate' => 'This Is To Notify You That a New System Was Allocated',
                    'allocator' => $recipients->user_id,
                    'link' => '',
                ];
                foreach ($emails as $email) {
                    Mail::to($email)->send(new SystemMail($system));
                }
                return response()->json([
                    'message' => 'System Allocation Was Successful!.'
                ]);
            }

            //<----------------------SYSTEM ALLOCATION UPDATE----------------------->
            $update_system_all = '/UPDATE\s+system_allocation\s+SET\s+status[^;]*WHERE\s+id\s*=\s*(\d+);/i';

            if (preg_match($update_system_all, $tsql, $matches)) {

                $UpdatedRowId = $matches[1];
                $recipients = SystemAllocation::find($UpdatedRowId)->first();

                $recipientsId[] = $recipients->user_id;
                $recipientsId[] = $recipients->responsible_id;
                $recipientsId[] = $recipients->approver_id;


                $randomNumber = random_int(5, 10000000000);

                $emails = User::whereIn('id', $recipientsId)->pluck('email')->toArray();
                Alert::create([
                    'mail_to' => $emails,
                    'description' => $recipients->description,
                    'alert_action' => $recipients->description,
                    'name' => 'ALERT' . $randomNumber,
                    'user_id' => $recipients->approver_id
                ]);

                $system = [
                    'update_allocate_title' => 'System Allocation Notification',
                    'update_allocate' => 'This is to notify you that system id '. $UpdatedRowId.' that was allocated has been approved',
                    'allocator' => $recipients->user_id,
                    'link' => '',
                ];

                foreach ($emails as $email) {
                    Mail::to($email)->send(new SystemMail($system));
                }
                return response()->json([
                    'message' => 'System Allocation Approved!.'
                ]);
            };

            return response()->json([
                $result,
                'message' => 'Query Execution Was Successful.'
            ]);
        } catch (PDOException  $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
