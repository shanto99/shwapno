<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\RiderController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\OutletController;

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
//Route::middleware('x-authorization-header')->group(function() {

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/get_user', [AuthController::class, 'get_user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/get_customer_by_phone/{phone}', [CustomerController::class, 'get_customer_by_phone']);
    Route::post('/make_delivery', [DeliveryController::class, 'make_delivery']);
    Route::get('/all_deliveries/{from?}/{to?}', [DeliveryController::class, 'all_deliveries']);
    Route::get('/riders', [RiderController::class, 'get_riders']);
    Route::get('/all_status', [StatusController::class, 'all_status']);
    Route::post('/update_delivery_status', [DeliveryController::class, 'update_delivery_status']);
    Route::post('/send_otp', [OtpController::class, 'send_otp']);
    Route::post('/verify_otp', [OtpController::class, 'verify_otp']);
    Route::post('/start_delivery', [DeliveryController::class, 'start_delivery']);
    Route::get('/deliveries_by_rider/{riderId}', [DeliveryController::class, 'get_rider_delivery']);
    Route::post('/store_device_token', [PushNotificationController::class, 'store_device_token']);
    Route::post('/post_location', [DeliveryController::class, 'save_delivery_location']);
    Route::get('/outlets', [OutletController::class, 'get_outlets']);
});
//});

Route::get('/make_undelivered_deliveries_before_24_hours', [DeliveryController::class, 'make_undelivered']);

