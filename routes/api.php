<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StudentCourseController;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkController;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
//to create all rout in once

Route::apiResource('posts', PostController::class);
//Route::apiResource('works', WorkController::class);

//middleware with workcontroller
Route::middleware('setlocale')->group(function () {
    Route::apiResource('works', WorkController::class);
});
Route::post('registration', [UserController::class, 'registration']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('users',UserController::class);
Route::apiResource('employee', EmployeeController::class);
Route::apiResource('departments', DepartmentController::class);
Route::apiResource('employee', EmployeeController::class);
// for updating employee task in employee table
Route::put('/employee/{employee}/task/{task}/status', [EmployeeController::class, 'updateTaskStatus']);



Route::get('test', function () {
    return  DB::table('course_student')->select('student_id')->get();
});

