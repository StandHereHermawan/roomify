<?php

use App\Domains\User\Middleware\CheckIfAlreadyLoginMiddleware;
use App\Domains\User\Middleware\SessionMiddleware;
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

Route::prefix('/account-management')->group(function () {

    Route::middleware(CheckIfAlreadyLoginMiddleware::class)->group(function () {

        Route::prefix("/registration")->group(function () {
            
            Route::post("", [App\Domains\User\Controller\AccountManagementController::class, "submitFormRegister"]);
            Route::get("", [App\Domains\User\Controller\AccountManagementController::class, "formRegister"]);

        });

        Route::prefix("/login")->group(function () {
            Route::post("", [App\Domains\User\Controller\AccountManagementController::class, "submitFormLogin"]);
            Route::get("", [App\Domains\User\Controller\AccountManagementController::class, "formLogin"]);
        });
    });


    // Route::get('/login', function () {
        // return view('management-account.login');
    // });

    Route::middleware(SessionMiddleware::class)->prefix('/dashboard')->group(function () {

        Route::get('', [App\Domains\User\Controller\AccountManagementController::class, "dashboard"]);

        Route::prefix('/account')->group(function () {
            Route::get('', [App\Domains\User\Controller\AccountManagementController::class, "account"]);
        });

        Route::get('/logout', [App\Domains\User\Controller\AccountManagementController::class, "logout"]);

    });
});
