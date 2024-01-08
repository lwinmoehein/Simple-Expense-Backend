<?php

use Illuminate\Support\Facades\Route;

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
    return response()->json(['message'=>'Simple Expense API is online.Since I\'m just a broke ass solo dev, I can\'t reward any money for you if you find a vulnerability.But I will be very happy to listen about it.If you care enough , lmhdadada@gmail.com is my email.' ]);
})->name('home');

