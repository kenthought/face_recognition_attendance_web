<?php

use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentPictureController;
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

Auth::routes();

Route::get('/', function () {
    return view('home');
});
Route::get('/home', function () {
    return view('home');
});
Route::get('/attendance', function () {
    return view('home');
});
Route::get('/teachers', function () {
    return view('home');
});
Route::get('/students', function () {
    return view('home');
});
Route::get('/subjects', function () {
    return view('home');
});


Route::get("getTeachers", [TeacherController::class, 'index']);
Route::post("addTeacher", [TeacherController::class, 'store']);
Route::put("editTeacher/{id}", [TeacherController::class, 'update']);
Route::delete("deleteTeacher/{id}", [TeacherController::class, 'destroy']);

Route::get("getStudents", [StudentController::class, 'index']);
Route::post("addStudent", [StudentController::class, 'store']);
Route::put("editStudent/{id}", [StudentController::class, 'update']);
Route::delete("deleteStudent/{id}", [StudentController::class, 'destroy']);

Route::get("getSubjects", [SubjectController::class, 'index']);
Route::post("addSubject", [SubjectController::class, 'store']);
Route::put("editSubject/{id}", [SubjectController::class, 'update']);
Route::delete("deleteSubject/{id}", [SubjectController::class, 'destroy']);

Route::get("getAttendance", [SubjectController::class, 'index']);
Route::post("addAttendance", [SubjectController::class, 'store']);
Route::put("editAttendance/{id}", [SubjectController::class, 'update']);
Route::delete("deleteAttendance/{id}", [SubjectController::class, 'destroy']);


Route::post("addStudentPicture", [StudentPictureController::class, 'store']);
