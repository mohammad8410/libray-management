<?php

use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/books',[BookController::class,'index'])
    ->middleware('auth')
    ->name('book.index');

Route::post('/books',[BookController::class,'store'])
    ->middleware('auth')
    ->name('book.store');

Route::put('/books/{book}',[BookController::class,'update'])
    ->middleware('auth')
    ->name('book.update');

Route::get('/books/{book}',[BookController::class,'show'])
    ->middleware('auth')
    ->name('book.show');






