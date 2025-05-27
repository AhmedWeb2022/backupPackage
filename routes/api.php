<?php

use App\Http\Controllers\UploadFileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




    Route::get('upload_file', [UploadFileController::class, '__invoke']);

