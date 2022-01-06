<?php

use App\Http\Controllers\Admin\Auth\LoginController AS AdminLoginController;
use App\Http\Controllers\Admin\HomeController AS AdminHomeController;
use App\Http\Controllers\User\Auth\LoginController AS UserLoginController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\HomeController AS UserHomeController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

Route::get('/home', [App\Http\Controllers\User\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'guest:admin'], function () {
        Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
        Route::post('login', [AdminLoginController::class, 'login'])->name('admin.login');
    });
    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/', [AdminHomeController::class, 'index'])->name('admin.dashboard');
        Route::post('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    });
});


Route::group(['middleware' => 'guest'], function () {
    Route::get('login', [UserLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [UserLoginController::class, 'login'])->name('login');
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('register');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [UserHomeController::class, 'index'])->name('dashboard');
    Route::post('logout', [UserLoginController::class, 'logout'])->name('logout');
});

