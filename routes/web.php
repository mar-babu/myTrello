<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Auth\LoginController;
use \App\Http\Controllers\DashboardController;
use \App\Http\Controllers\ProjectController;
use \App\Http\Controllers\UserController;

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

Route::group(['middleware' => ['guest', 'web']], function() {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    Route::get('/login', [LoginController::class ,'showLoginForm'])->name('login');
    Route::get('/registration', [LoginController::class ,'showRegistrationForm'])->name('registration');
    Route::post('/register', [LoginController::class ,'register'])->name('register');
    Route::post('/login', [LoginController::class ,'login'])->name('loginProcess');

});

Route::get('/users', [UserController::class, 'index']);

Route::group(['middleware' => ['auth', 'web']], function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    //project related route
    Route::get('/project/index', [ProjectController::class, 'index'])->name('project.list');
    Route::get('/project/create', [ProjectController::class, 'create'])->name('project.create');
    Route::post('/project/store', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/project/{project_id}/space', [ProjectController::class, 'projectSpace']);
    Route::post('/project/{project_id}/member', [ProjectController::class, 'makeProjectMember'])->name('project.member');
    //project related route
    Route::get('/project/filter', [ProjectController::class, 'filter'])->name('project.filter');;

});
