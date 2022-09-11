<?php

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RideController;
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

Route::post('/login', [UserController::class, 'login']); // DONE
Route::post('/register', [UserController::class, 'register']);
Route::get('/rides', [RideController::class, 'index']); // DONE

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [UserController::class, 'logout']); // DONE

    Route::get('/users/{user}/reservations', [UserController::class, 'reservations']); // DONE
    Route::get('/users/{user}/rides', [UserController::class, 'rides']); // DONE

    Route::post('/rides', [RideController::class, 'store']); // DONE
    Route::get('/rides/{ride}', [RideController::class, 'show']); // DONE
    Route::put('/rides/{ride}', [RideController::class, 'update']); // DONE
    Route::delete('/rides/{ride}', [RideController::class, 'destroy']); // DONE

    Route::post('/reservations', [ReservationController::class, 'store']); // DONE
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy']); // DONE
});
