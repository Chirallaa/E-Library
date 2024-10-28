<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ResetPasswordController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rute untuk mereset password
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('api.password.update');

// Hapus rute untuk mengirim OTP
// Route::post('password/send-otp', [ResetPasswordController::class, 'sendOtp'])->name('api.password.sendOtp');