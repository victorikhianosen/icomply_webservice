<?php

use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/laravel-log', function () {
//     return view('log');
// });

Route::get('/laravel-log', [LogController::class, 'index'])->name('log.viewer');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/opencase', function () {
    return view('create_case_mail');
});

Route::get('/updatecase', function () {
    return view('respond_to_case_mail');
});

Route::get('/closecase', function () {
    return view('close_case_mail');
});

Route::get('/file_upload', function () {
    return view('test_file_upload');
});

Route::get('/report_temp',[App\Http\Controllers\CaseManagementController::class, 'query']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/showcase', function () {
//     return view('getcase');
// })->name('showcase');


// Route::post('/close-this-case/{id}', [App\Http\Controllers\CaseManagementController::class, 'close_Case'])->name('close-this-case');

// Route::get('/closecase', function () {
//     return view('closecase');
// })->name('closecase');

Route::get('/userlogin', function () {
    return view('userlogin');
})->name('userlogin');


// Route::get('/case-details/{id}', function ($id) {
//     return view('case-details', ['id' => $id]);
// })->middleware('auth');

Route::get('/test-case/{id}', function ($id) {
    return view('test-case', ['id' => $id]);
})->middleware('auth');


// Route::get('/docu', function () {
//     return view('documentation');
// });
Route::get('/docu', [App\Http\Controllers\CaseManagementController::class, 'getDocumentation']);


    // Route::get('/case-details/{id}', [\App\Http\Controllers\CaseManagementController::class, 'getCaseDetails']);
