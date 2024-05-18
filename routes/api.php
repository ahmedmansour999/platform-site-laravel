<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CourseContentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VedioController;
use App\Http\Controllers\YearController;
use App\Models\Course_Content;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'Register']);
Route::post('login', [AuthController::class, 'Login'])->name('login');
Route::get('logout', [AuthController::class, 'Logout'])->name('logout');




// Route::group(['middleware' => ['checkAuth']], function () {



    // video Api
    Route::resource('vedio', VedioController::class);
    Route::get('allVedio', [VedioController::class, 'allVedio']);
    Route::get('vediolecturer/{id}', [VedioController::class, 'vedioLecturer']);
    Route::post('updateVedio/{id}', [VedioController::class, 'updateVedio']);

    Route::resource('users', UserController::class);

    Route::resource('lecture', LectureController::class);
    Route::get('lecturerPdf/{id}', [LectureController::class, 'lecturerLPdf']);
    Route::post('updateLecture/{id}', [LectureController::class, 'updateLecture']);

    Route::resource('content', CourseContentController::class);
    Route::get('courseContent/{id}', [CourseContentController::class, 'courseContent']);

    Route::get('lecturer-course/{id}', [CourseController::class, 'lecturerCourse']);

    Route::resource('course', CourseController::class);
    Route::resource('year', YearController::class);
    Route::resource('student', StudentController::class);
    Route::resource('lecturer', LecturerController::class);


    // admin routes
    Route::get('admin/{id}', [AdminController::class, 'index']);
    Route::delete('deleteAdmin/{id}', [AdminController::class, 'destroy']);
    Route::get('currentAdmin/{id}', [AdminController::class, 'show']);
    Route::post('admin/{id}', [AdminController::class, 'update']);
    Route::resource('cart' , CartController::class) ;
    Route::get('userCarts/{id}' , [CartController::class , "Usercart"]) ;

// });
