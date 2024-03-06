<?php

use App\Http\Controllers\Admin\Api\BlogFileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\API\FrontController;
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

Route::group(['prefix' => 'v1', 'as' => 'api.v1.'], function () {
    Route::post('file/upload', [BlogFileController::class, 'store'])
        ->middleware('auth.basic.one')
        ->name('blog.file.store');

    Route::get('/page/{menuEng?}', [FrontController::class, 'menuPost'])->name('page.index');
});
