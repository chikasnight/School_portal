<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\SubmitAssignmentController;



Route::post('login',[UserController::class,'login']);
Route::post('register',[UserController::class, 'register']);

Route::group(['middleware' =>'auth:sanctum'],function(){
  
    Route::post('change/assword',[UserController::class, 'changePassword']);
    Route::get('search',[UserController::class, 'search']);
    Route::get('get/all/user',[UserController::class, 'getAllUser']);
    Route::put('update/profile',[UserController::class, 'updateProfile']);
    Route::post('logout',[UserController::class,'logout']);
    
    Route::post('assignments',[AssignmentController::class,'assignment']);
    Route::get('assignments',[AssignmentController::class,'getAssignment']);

    Route::post('messages',[MessageController::class,'message']);
    Route::get('messages',[MessageController::class,'getMessage']);

    Route::post('notices',[NoticeController::class,'notice']);

    Route::post('records',[RecordController::class,'record']);
    Route::put('records',[RecordController::class,'editRecord']);
    Route::get('records',[RecordController::class,'getRecord']);

    Route::post('assignment/submit',[SubmitAssignmentController::class,'assignmentSubmit']);

});
