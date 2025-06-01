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

Route::get('/room', [App\Domains\Room\Controller\RoomController::class, "roomPaginate"]);

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

    Route::middleware(SessionMiddleware::class)->prefix('/dashboard')->group(function () {

        Route::get('', [App\Domains\User\Controller\AccountManagementController::class, "dashboard"]);

        Route::prefix('/account')->group(function () {

            Route::get('', [App\Domains\User\Controller\AccountManagementController::class, "account"]);

            Route::get('/edit-username', [App\Domains\User\Controller\AccountManagementController::class, "editUsernameForm"]);
            Route::post('/edit-username', [App\Domains\User\Controller\AccountManagementController::class, "submitEditUsernameForm"]);

            Route::get('/edit-name', [App\Domains\User\Controller\AccountManagementController::class, "editNameForm"]);
            Route::post('/edit-name', [App\Domains\User\Controller\AccountManagementController::class, "submitEditNameForm"]);

            Route::get('/add-email', [App\Domains\User\Controller\AccountManagementController::class, "addEmailForm"]);
            Route::post('/add-email', [App\Domains\User\Controller\AccountManagementController::class, "submitAddEmailForm"]);

            Route::get('/edit-email', [App\Domains\User\Controller\AccountManagementController::class, "editEmailForm"]);
            Route::post('/edit-email', [App\Domains\User\Controller\AccountManagementController::class, "submitEditEmailForm"]);

            Route::get('/delete-email', [App\Domains\User\Controller\AccountManagementController::class, "deleteEmail"]);

            Route::get('/edit-phone-number', [App\Domains\User\Controller\AccountManagementController::class, "editPhoneNumberForm"]);
            Route::post('/edit-phone-number', [App\Domains\User\Controller\AccountManagementController::class, "submitEditPhoneNumberForm"]);

            Route::get('/delete-phone-number', [App\Domains\User\Controller\AccountManagementController::class, "deletePhoneNumber"]);

            Route::get('/add-phone-number', [App\Domains\User\Controller\AccountManagementController::class, "addPhoneNumberForm"]);
            Route::post('/add-phone-number', [App\Domains\User\Controller\AccountManagementController::class, "submitAddPhoneNumberForm"]);
        });

        Route::get('/logout', [App\Domains\User\Controller\AccountManagementController::class, "logout"]);

    });

});
