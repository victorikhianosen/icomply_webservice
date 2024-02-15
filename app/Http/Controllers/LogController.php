<?php

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FacadesFile;

class LogController extends Controller
{
    //

    // public function show(Request $request)
    // {
    //     $logFilePath = storage_path('logs');
    //     $logFileName = "laravel-$request.log";
    //     $logFileFullPath = "$logFilePath/$logFileName";

    //     if (!FacadesFile::exists($logFileFullPath)) {
    //         return response()->json(['error' => 'The log file does not exist.'], 404);
    //     }
    //     $logContent = FacadesFile::get($logFileFullPath);

    //     // return response()->json(['log' => $logContent]);
    //     return response()->view('log', ['log' => $logContent]);
    // }

    public function show($date) // Now accepts a date parameter
    {
        $logFilePath = storage_path('logs');
        $logFileName = "laravel-{$date}.log"; // Dynamically create log file name based on date
        $logFileFullPath = "$logFilePath/$logFileName";

        if (!FacadesFile::exists($logFileFullPath)) {
            return response()->json(['error' => 'The log file does not exist.'], 404);
        }

        $logContent = FacadesFile::get($logFileFullPath);

        return response($logContent, 200);
    }

    public function index() // This method will render the view with the dates dropdown
    {
        $logFilePath = storage_path('logs');
        $files = FacadesFile::files($logFilePath);

        $dates = collect($files)->map(function ($file) {
            // Assuming your log files are named "laravel-YYYY-MM-DD.log"
            return substr($file->getFilename(), 8, 10); // Extracts date part
        })->toArray();

        $http = "http://";
        $http_host = $_SERVER['HTTP_HOST'];
        if ($http_host !== "127.0.0.1:8000") {

            $script_name = $_SERVER['SCRIPT_NAME'];
            $link = $http . $http_host . "/" . $script_name . "/";
        } else {
            $script_name = '';
            $link = $http . $http_host;
        }

        return view('log', ['dates' => $dates,'link'=>$link]); // Make sure your view is named 'logViewer.blade.php'
    }

}
