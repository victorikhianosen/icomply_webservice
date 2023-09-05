<?php

namespace App\Http\Controllers;

use App\Mail\CaseMail;
use App\Mail\CloseMail;
use App\Mail\SendMail;
use App\Models\CaseManagement;
use App\Models\CaseStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Rules\UniqueArray;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PDO;
use PDOException;

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

    public function getEverything(Request $request)
    {

        $query = $request->input('query');

        try {
            // Check if the query starts with SELECT (case-insensitive)
            if (preg_match('/^\s*select/i', $query)) {
                $results = DB::select($query);

                // Paginate the results
                // $perPage = $request->input('per_page', 10); // Number of results per page
                // $page = $request->input('page', 1); // Current page

                // $paginatedResults = collect($results)->paginate($perPage, ['*'], 'page', $page);

                return  response()->json($results);
            } else {
                DB::statement($query);
                return response()->json(['message' => 'Query executed successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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

            $insertpattern = '/INSERT\s+INTO\s+case_management/i';
            if (preg_match($insertpattern, $tsql)) {
                $rowId = [];

                foreach ($result as $item) {
                    $rowId[] = $item['id'];
                }

                $recipients = CaseManagement::select('assigned_user', 'supervisor_id')->where('id', $rowId)->first();
                $supervisor_id = json_decode($recipients->supervisor_id, true);

                $recipientsId = [];
                if (isset($recipients->assigned_user)) {
                    $recipientsId[] = $recipients->assigned_user;
                }
                if (isset($supervisor_id["id"])) {
                    $recipientsId = array_merge($recipientsId, $supervisor_id["id"]);
                }

                $emails = User::whereIn('id', $recipientsId)->pluck('email');
                foreach ($emails as $email) {
                    Mail::to($email)->send(new CaseMail($case_notification));
                }
                return response()->json([
                    'message' => 'Case Was Successfully Created, Emails sent!.'
                ]);
            }



            $updatepattern = '/UPDATE\s+case_management\s+SET\s+assigned_user_response[^;]*WHERE\s+id\s*=\s*(\d+);/i';

            if (preg_match($updatepattern, $tsql, $matches)) {

                $UpdatedRowId = $matches[1];
                $recipients = CaseManagement::select('supervisor_id','user_id','assigned_user', 'assigned_user_response')->where('id', $UpdatedRowId)->first();
                $supervisor_id = json_decode($recipients->supervisor_id, true);

                $recipientsId = [];
                if (isset($recipients->user_id)) {
                    $recipientsId[] = $recipients->user_id;
                }
                if (isset($supervisor_id["id"])) {
                    $recipientsId = array_merge($recipientsId, $supervisor_id["id"]);
                }
                $emails = User::whereIn('id', $recipientsId)->pluck('email');
                 $responder = $recipients->assigned_user;
                $email_info = [
                    'title' => 'Notification Mail',
                    'body' => 'This is to notify you that a case was just responded to',
                    'responder_id'=> $responder,
                    'response'=>$recipients->assigned_user_response,
                    'link' => 'http://127.0.0.1:8000/case-details/'. $UpdatedRowId
                ];
                foreach ($emails as $email) {
                    Mail::to($email)->send(new SendMail($email_info));
                }
                return response()->json([
                    'message' => 'Case Was Successfully Updated, Emails sent!.'
                ]);
            };


            $closepattern = '/UPDATE\s+case_management\s+SET\s+case_status_id[^;]*WHERE\s+id\s*=\s*(\d+);/i';


            if (preg_match($closepattern, $tsql, $matches)) {
                $id = $matches[1];

                $recipients = CaseManagement::select('supervisor_id', 'user_id', 'assigned_user', 'reason_for_close')->where('id', $id)->first();
                $supervisor_id = json_decode($recipients->supervisor_id, true);

                $recipientsId = [];
                if (isset($recipients->user_id)) {
                    $recipientsId[] = $recipients->user_id;
                }
                if (isset($recipients->assigned_user)) {
                    $recipientsId[] = $recipients->assigned_user;
                }
                if (isset($supervisor_id["id"])) {
                    $recipientsId = array_merge($recipientsId, $supervisor_id["id"]);
                }
                $emails = User::whereIn('id', $recipientsId)->pluck('email');
                $creator = $recipients->user_id;
                $close_case = [
                    'title' => 'Notification Mail',
                    'body' => 'This is to notify you that a case was closed',
                    'creator_id' => $creator,
                    'reason_for_close' => $recipients->reason_for_close,
                    'link' => 'http://127.0.0.1:8000/case-details/' . $id
                ];

                foreach ($emails as $email) {
                    Mail::to($email)->send(new CloseMail($close_case));
                }
                return response()->json([
                    'message' => 'Case Closed Successfully!.'
                ]);
            }           


            return response()->json([
                $result,
                'message' => 'Query Execution Was Successful.'
            ]);
        } catch (PDOException  $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
