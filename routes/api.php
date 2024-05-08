<?php

use App\Http\Controllers\PlayerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(PlayerController::class)->group(function () {
    Route::get('/players', 'getPlayers');
    Route::get('/players/{jerseyNumber}', 'getPlayerByJerseyNumber');
});
