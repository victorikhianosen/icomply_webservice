<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetUserCaseRequest;
use App\Models\CaseManagement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            $success['token'] = $authUser->createToken('MyAuthApp')->plainTextToken;
            $success['full_name'] =  $authUser->full_name;
            session()->put('token', $success['token']);
            return $this->sendResponse($success, 'User signed in');
        } else {

            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            $token =  $authUser->createToken('MyAuthApp')->plainTextToken;
            $request->session()->put('token', $token);
            $success['token'] =  $token;
            $success['full_name'] =  $authUser->full_name;

            
        } else {
            return back()->with(['email' => 'Invalid credentials']);
        }
    }
    public function register(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'full_name' => 'required|alpha',
            'email' => 'required|email',
            'phone_number' => 'required|numeric',
            'branch_code' => 'required',
            'company_code' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
        $success['full_name'] =  $user->full_name;

        return $this->sendResponse($success, 'User created successfully.');
    }

    public function makeSupervisor(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $id = $input['id'];
        $user = User::where('id', '=', $id)->first();
        $usercheck = User::where('id', '=', $id)->where(['is_supervisor' => true])->first();


        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if ($usercheck) {
            return response()->json(['message' => 'User is already a supervisor'], 404);
        }

        $user->update(['is_supervisor' => true]);

        return response()->json([
            'message' => 'User is now a supervisor',
            'user' => $user
        ]);
    }

    public function getUserCase(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $id = $input['id'];
        $user = User::where('id', $id)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $case = $user->case;
        if (!$user->case->isNotEmpty()) {
            return response()->json(['message' => 'User has no case'], 404);
        }

        return response()->json(['User case' => $case, 'id' => $id]);
    }
}
