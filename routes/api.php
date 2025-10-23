<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
Route::post('/pastes', [\App\Http\Controllers\Api\PasteController::class, 'store']);
Route::get('/pastes/latest-public', [\App\Http\Controllers\Api\PasteController::class, 'getLastPastes']);
Route::get('/pastes/latest-user', [\App\Http\Controllers\Api\PasteController::class, 'getLastUserPastes']);
Route::get('/pastes/{hashId}', [\App\Http\Controllers\Api\PasteController::class, 'getPaste']);
Route::get('/pastes/s/{uuid}', [\App\Http\Controllers\Api\PasteController::class, 'getUnlistedPaste']);
Route::post('/pastes/{hashId}/complaint', [\App\Http\Controllers\Api\PasteController::class, 'addComplaint']);
Route::post('/pastes/s/{uuid}/complaint', [\App\Http\Controllers\Api\PasteController::class, 'addComplaint']);

});
