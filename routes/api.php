<?php

use App\Http\Controllers\Api\CoffeeController;
use Illuminate\Support\Facades\Route;

Route::apiResource('coffee', CoffeeController::class)->only(['index', 'show']);
