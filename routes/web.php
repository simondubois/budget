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

Route::view('/', 'home');

Route::get('fetch-rates', function () {
    $output = new Symfony\Component\Console\Output\BufferedOutput();
    Artisan::call('rate:fetch', [], $output);
    return nl2br($output->fetch());
});

Route::get('seed', function () {
    abort_unless(env('APP_ENV') === 'demo', 404);
    $output = new Symfony\Component\Console\Output\BufferedOutput();
    Artisan::call('migrate:refresh', ['--seed' => true], $output);
    return nl2br($output->fetch());
});
