<?php

use App\MailChimp;
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



    $MailChimp = new MailChimp(env('MAILCHIMP_API_KEY'), env('MAILCHIMP_API_URL'));
    dump($MailChimp->get('lists'));
    dump($MailChimp->get('lists/4a5b12d128/members'));

    return view('welcome');
});

