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

Route::get('/', function() {
    // $crawler = Goutte::request('GET', 'http://www.nettruyentop.com/');
    // $crawler->filter('img.lazy')->each(function ($node) {
    //   dump($node->text());
    // });
    return view('welcome');
});
