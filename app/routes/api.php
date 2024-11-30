<?php

use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {
    Route::prefix('book')->controller(BookController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{bookId}', 'show');
        Route::post('/', 'create');
        Route::put('/{bookId}', 'update');
        Route::delete('/{bookId}', 'delete');
    });
});
