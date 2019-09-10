<?php

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

Route::apiResource('currencies', CurrencyController::class)
    ->only(['index', 'show']);

Route::apiResource('accounts/history', AccountHistoryController::class)
    ->parameters(['history' => 'account'])
    ->only(['index', 'show']);

Route::apiResource('accounts', AccountController::class)
    ->only(['index', 'show']);

Route::apiResource('envelopes/history', EnvelopeHistoryController::class)
    ->parameters(['history' => 'envelope'])
    ->only(['index', 'show']);

Route::apiResource('envelopes', EnvelopeController::class)
    ->only(['index', 'show']);

Route::apiResource('operations', OperationController::class)
    ->only(['index', 'show']);
