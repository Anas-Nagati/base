<?php

use App\Http\Controllers\EntryController;
use App\Http\Controllers\FormController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::middleware('tenant')->group(function () {
    Route::post('/forms/sync', [FormController::class, 'sync']);
    Route::post('/forms/', [FormController::class, 'sync']);
    Route::post('/entries/store', [EntryController::class, 'store']);
});
