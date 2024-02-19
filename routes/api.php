<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserCourseController;
use App\Http\Controllers\CourseUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('courses', CourseController::class);
Route::apiResource('users', UsersController::class);
Route::apiResource('usercourses', UserCourseController::class);
Route::get('/courses-by-title', [UserCourseController::class, 'getCoursesByTitle']);
Route::get('/courses-not-in-title', [UserCourseController::class, 'getCoursesNotInTitle']);
Route::get('/course-stats', [UserCourseController::class, 'getCourseStats']);

Route::get('/mentor-stats', [UserCourseController::class, 'getMentorStats']);

