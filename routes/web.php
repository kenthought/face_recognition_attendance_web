<?php

use App\Http\Controllers\TeacherController;
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
