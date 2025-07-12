<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StudentCourseController;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PostController;
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
Route::apiResource('works', WorkController::class);
Route::apiResource('employee', EmployeeController::class);
Route::apiResource('departments', DepartmentController::class);
Route::apiResource('employee', EmployeeController::class);
// for updating employee task in employee table
Route::put('/employee/{employee}/task/{task}/status', [EmployeeController::class, 'updateTaskStatus']);



Route::get('test', function () {
    return  DB::table('course_student')->select('student_id')->get();
});

// // عرض كل المنشورات (GET /api/posts)
// Route::get('posts', [PostController::class, 'index']);

// // إنشاء منشور جديد (POST /api/posts)
// Route::post('posts', [PostController::class, 'store']);

// // عرض منشور معين (GET /api/posts/{id})
// Route::get('posts/{id}', [PostController::class, 'show']);

// // تحديث منشور معين (PUT/PATCH /api/posts/{id})
// Route::put('posts/{id}', [PostController::class, 'update']);
// Route::patch('posts/{id}', [PostController::class, 'update']);

// // حذف منشور معين (DELETE /api/posts/{id})
// Route::delete('posts/{id}', [PostController::class, 'destroy']);
