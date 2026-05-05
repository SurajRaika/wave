<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ScannerController;

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

Route::middleware('auth:api')->group(function() {
    Route::get('/user', function (Request $request) {
        return auth()->user();
    });

    Route::post('/scanner', [ScannerController::class, 'scan'])->name('api.scanner');
});

Wave::api();
