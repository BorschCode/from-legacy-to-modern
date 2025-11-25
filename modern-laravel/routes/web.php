<?php

use App\Http\Controllers\CartridgeController;
use Illuminate\Support\Facades\Route;

// Redirect root to cartridges index
Route::get('/', function () {
    return redirect()->route('cartridges.index');
});

// Cartridge Resource Routes
Route::resource('cartridges', CartridgeController::class);

// Cartridge History Route
Route::get('cartridges/{cartridge}/history', [CartridgeController::class, 'history'])
    ->name('cartridges.history');
