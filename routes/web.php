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
// user route
Route::prefix('/user')->group(function() {
    Route::view('/', 'template.login', ['title'=>'Login'])->name('login')->middleware(['guest']);
    Route::post('/login', 'UserController@loginProcess')->name('login.process');
    Route::get('/logout', 'UserController@logoutProcess')->name('logout.process');
});
// student route
Route::prefix('/student')->middleware(['auth'])->group(function() {
    Route::get('/', 'StudentController@index')->name('student');
    Route::view('/createPage', 'template.create', ['title'=>'Add Student'])->name('student.createPage');
    Route::post('/create', 'StudentController@create')->name('student.create');
    Route::post('/editPage', 'StudentController@editPage')->name('student.editPage');
    Route::post('/edit', 'StudentController@edit')->name('student.edit');
    Route::post('/delete', 'StudentController@delete')->name('student.delete');
    Route::post('/multiDelete', 'StudentController@multiDelete')->name('student.multiDelete');
});