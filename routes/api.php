<?php

use App\Http\Controllers\EntryController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\TenantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/tenants', [TenantController::class, 'create']);
Route::middleware('tenant')->group(function () {
    Route::post('/forms/sync', [FormController::class, 'sync']);
    Route::post('/forms/', [FormController::class, 'sync']);
    Route::post('/entries/store', [EntryController::class, 'store']);
});
