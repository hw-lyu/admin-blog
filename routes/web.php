<?php

use App\Http\Controllers\BlogInformationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Storage;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/', [BlogInformationController::class, 'index']);

    Route::resource('/information', BlogInformationController::class);
});

//Route::post('/test', function (\Illuminate\Http\Request $request) {
//    $file = $request->file('cover_img');
//
//    $path = Storage::disk('s3')->put($file->getClientOriginalName(), file_get_contents($file));
//
//    dump($path);
//});

// 로그인
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
