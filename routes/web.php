<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/showcase', function () {
    return view('getcase');
})->name('showcase');


Route::post('/close-this-case/{id}', [App\Http\Controllers\CaseManagementController::class, 'close_Case'])->name('close-this-case');

Route::get('/closecase', function () {
    return view('closecase');
})->name('closecase');

Route::get('/userlogin', function () {
    return view('userlogin');
})->name('userlogin');


Route::get('/case-details/{id}', function ($id) {
    return view('case-details', ['id' => $id]);
})->middleware('auth');



    // Route::get('/case-details/{id}', [\App\Http\Controllers\CaseManagementController::class, 'getCaseDetails']);
