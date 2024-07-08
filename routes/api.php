<?php

use App\Http\Controllers\NationalityController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PositionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(PlayerController::class)->group(function () {
    Route::get('/players', 'getPlayers');
    Route::post('/players', 'addPlayer');
    Route::get('/players/{jerseyNumber}', 'getPlayerByJerseyNumber');
    Route::put('/players/{jerseyNumber}', 'updatePlayer');
    Route::patch('/players/{jerseyNumber}', 'changePlayerStatus');
    Route::delete('/players/{jerseyNumber}', 'deletePlayer');
});

Route::get('/positions', [PositionController::class, 'getPositions']);
Route::get('/nationalities', [NationalityController::class, 'getNationalities']);
