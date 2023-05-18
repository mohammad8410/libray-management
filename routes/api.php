<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
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

Route::delete('/book/{book}',[BookController::class,'delete'])
    ->middleware('auth')
    ->name('book.delete');

Route::post('/book/{book}/inc/{incCount}',[BookController::class,'increase'])
    ->middleware('auth')
    ->name('book.increase');

Route::post('/book/{book}/dec/{decCount}',[BookController::class,'decrease'])
    ->middleware('auth')
    ->name('book.decrease');

Route::post('/books/{book}/borrow',[BookController::class,'borrow'])
    ->middleware('auth')
    ->name('book.borrow');

Route::post('/books/{book}/return',[BookController::class,'returning'])
    ->middleware('auth')
    ->name('book.return');


Route::get('/users',[UserController::class,'index'])
    ->middleware('auth')
    ->name('user.index');




