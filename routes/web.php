<?php

use App\Http\Controllers\Admin\BlogInformationController;
use App\Http\Controllers\Admin\BlogMenuController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Front\FrontController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::domain(config('app.admin_domain'))
    ->group(function () {
        // 포스트 관리
        Route::middleware(['auth'])->group(function () {
            Route::get('/', [BlogInformationController::class, 'index']);

            Route::resource('/information', BlogInformationController::class);
            Route::resource('/menu', BlogMenuController::class);
            Route::resource('/post', BlogPostController::class);
        });

        // 로그인
        Route::get('/login', [LoginController::class, 'index'])->name('login');
        Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
    });

// 사용자 화면
Route::domain(config('app.user_domain'))
    ->group(function () {
        Route::group(['as' => 'front.'], function () {
            Route::get('/', [FrontController::class, 'index'])->name('index');
            Route::get('/page/{menuEng?}', [FrontController::class, 'menuPost'])->name('page.index');
            Route::get('/view/{id}', [FrontController::class, 'show'])->name('show');
        });
    });
