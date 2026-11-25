<?php

use App\Http\Controllers\Api\HotelApiController;
use Illuminate\Support\Facades\Route;

Route::get('/rooms/availability', [HotelApiController::class, 'availability']);
Route::get('/rooms/popular', [HotelApiController::class, 'popular']);