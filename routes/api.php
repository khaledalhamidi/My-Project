<?php

use App\Http\Controllers\CacheWorksReportController;
use App\Http\Controllers\CouponReportController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StudentCourseController;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkController;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//middleware with workcontroller
Route::middleware('setlocale')->group(function () {
    Route::apiResource('works', WorkController::class);
});
//Tamam Report Task

Route::get('coupons', [CouponReportController::class, 'index']);




// Login/Registration/Logout
Route::post('registration', [UserController::class, 'registration']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');


Route::get('/generate-daily-report', [CacheWorksReportController::class, 'generateDailyReport']);
//to show reports
Route::get('/reports', [CacheWorksReportController::class, 'showReports']);


Route::apiResource('users', UserController::class);
Route::apiResource('employee', EmployeeController::class);
Route::apiResource('departments', DepartmentController::class);
// for updating employee task in employee table

Route::put('/employee/{employee}/task/{task}/status', [EmployeeController::class, 'updateTaskStatus']);


Route::middleware('auth:sanctum')->group(function () {
    // CRUD except index
    Route::apiResource('products', ProductController::class)->except(['destroy', 'index']);

    // Toggle active status
    Route::put('products/{product}/toggle-active', [ProductController::class, 'toggleActiveStatus']);
});

// Public or authenticated route for product list
Route::get('products', [ProductController::class, 'index']);

// Movement-related routes
Route::post('products/{product}/movements/add', [ProductController::class, 'addMovement']);
Route::post('products/{product}/movements/withdraw', [ProductController::class, 'withdrawMovement']);
Route::get('products/{product}/movements', [ProductController::class, 'movementHistory']);
