<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('fetch-rates', function () {
    $output = new Symfony\Component\Console\Output\BufferedOutput();
    Artisan::call('rate:fetch', [], $output);
    return nl2br($output->fetch());
});
