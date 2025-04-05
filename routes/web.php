<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/registration', function () {
    return view('registration');
});

Route::get('/login', function () {
    return view('login');
});

Route::prefix('/dashboard')->group(function () {
    
    Route::get('', function () {
        return view('dashboard');
    });

    Route::prefix('/account')->group(function () {
        Route::get('', function () {
            return view('account');
        });
        Route::get('/add-phone-number', function () {
            return view('add-phone-number');
        });
    });
    
});
