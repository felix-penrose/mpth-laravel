<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrganisationController;
use Illuminate\Http\Request;

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

Route::post('login', [AuthController::class, 'authenticate']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('organisation')->group(function () {
    Route::get('', [OrganisationController::class, 'index']);
    Route::post('', [OrganisationController::class, 'create']);
});
