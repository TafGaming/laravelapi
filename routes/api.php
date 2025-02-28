<?php

use App\Http\Controllers\StudentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('students', StudentsController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
