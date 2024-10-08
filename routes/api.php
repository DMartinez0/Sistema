<?php

use App\Http\Controllers\RemotePrintController;
use App\Http\Controllers\SyncController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/impresiones', [RemotePrintController::class, 'index'])
->middleware(['guest'])
->name('impresiones.index');

Route::post('/impresiones', [RemotePrintController::class, 'store'])
->middleware(['guest'])
->name('impresiones.store');

Route::get('/impresiones/cantidad', [RemotePrintController::class, 'contador'])
->middleware(['guest'])
->name('impresiones.cantidad');

Route::post('/process-sync', [SyncController::class, 'processSync']);