<?php

use App\Http\Controllers\CaseManagementController;
use App\Http\Controllers\UserController;
use App\Http\Requests\GetUserCaseRequest;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
// Route::post('/users/login', [UserController::class, 'userLogin']);

//API ROUTE HANDLING QUERY TO DATABASE
Route::post('/send-request', [CaseManagementController::class, 'query']);
//API ROUTE HANDLING DOWNLOAD
Route::get('/download/{filename}/{userId}', [CaseManagementController::class, 'downloadFile']);

// API ROUTE HANDLING EMAILS
Route::post('/send-mail', [CaseManagementController::class, 'sendMail']);

Route::get('/case/allcase',  [CaseManagementController::class, 'showCase']);



Route::middleware('auth:sanctum')->group(function () {
    Route::post('/users/make-supervisor',  [UserController::class, 'makeSupervisor']);
    Route::get('/case/statuslist',  [CaseManagementController::class, 'showCaseByStatus']);
    Route::get('/case/prioritylist',  [CaseManagementController::class, 'showCaseByPriority']);
    Route::get('/users/get/usercase', [UserController::class, 'getUserCase']);
    Route::post('/case/closecase/{id}',  [CaseManagementController::class, 'closeCase']);
    Route::post('/case/createcase', [CaseManagementController::class, 'createCase']);
    // Route::get('/case/details/{id}', [CaseManagementController::class, 'getCaseDetails'])->name('case-details');
    Route::get('/send-case-id', [CaseManagementController::class, 'showCaseById'])->name('send-case-id');
    Route::get('/send/case/{id}', [CaseManagementController::class, 'getCaseDetails']);
});

Route::get('/test',function(){
    return 'Testing complete';
});