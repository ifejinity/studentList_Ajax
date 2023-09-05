<?php

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

Route::get('/', function () {
    return view('welcome');
});

// log in route
Route::prefix('/login')->middleware(['guest'])->group(function() {
    Route::view('/', 'template.login')->name('login');
    Route::post('/process', 'StudentController@loginProcess')->name('login.process');
});
// student route
Route::prefix('/student')->middleware(['auth'])->group(function() {
    Route::view('/', 'template.home')->name('student');
});