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

Route::get('/', [App\Http\Controllers\Room\RoomController::class, 'dashboard']);
Route::middleware('guest')->group(function () {
    Route::prefix('/registration')->controller(App\Http\Controllers\Users\UserController::class)->group(function () {
        Route::get('', "registerForm")->name('registration');
        Route::post('', "submitFormRegister");
    });
    Route::prefix('/login')->controller(App\Http\Controllers\Users\AuthController::class)->group(function () {
        Route::get('', "loginForm")->name('login');
        Route::post('', "submitFormLogin");
    });
});
Route::middleware('auth')->group(function () {
    Route::prefix('/room')->group(function () {
        Route::controller(App\Http\Controllers\Room\RoomController::class)->group(function () {
            Route::get('', "roomSearchPaginate")->name('list-of-room');
            Route::prefix('/add')->group(function () {
                Route::get('', "addRoomForm")->name('add-room');
                Route::post('', "submitAddRoomForm");
            });
            Route::prefix('/{model}')->group(function () {
                Route::get('/detail', "roomDetail")->name('detail-room');
            });
        });
        Route::prefix('/reservation')->controller(App\Http\Controllers\Reservation\RoomReservationController::class)->group(function () {
            Route::prefix('/request')->group(function () {
                Route::prefix('/add')->group(function () {
                    Route::get('', "addRoomReservationForm")->name('room-reservation-request');
                    Route::post('', "submitAddRoomReservationForm");
                });
                Route::prefix('/list')->group(function () {
                    Route::get('', "listOfAllRoomReservationRequest")->name('list-of-room-reservation-request');
                    Route::prefix('/me')->group(function () {
                        Route::get('', 'listOfCurrentUserRoomReservationRequest')->name('list-of-my-room-reservation-request');
                    });
                    Route::prefix('/manage')->group(function () {
                        Route::get('', "manageByAdminListOfRoomReservationRequest")->name('manage-list-of-room-reservation-request');
                    });
                });
                Route::prefix('/delete')->group(function () {
                    Route::post('/hard', "deleteFromDatabaseRoomReservationRequest")->name('delete-room-reservation-request-from-database');
                    Route::post('/soft', "softDeleteRoomReservationRequest")->name('soft-delete-room-reservation-request');
                });
                Route::post('/accept', "acceptRoomReservationRequest")->name('accept-room-reservation-request');
                Route::post('/reject', "rejectRoomReservationRequest")->name('reject-room-reservation-request');
            });
        });
        Route::prefix('/session')->controller(App\Http\Controllers\Schedule\RoomSessionController::class)->group(function () {
            Route::get('', "roomSessionPaginate")->name('list-of-room-session');
            Route::prefix('/modify/{model}')->group(function () {
                Route::get('', "editRoomSessionForm")->name('edit-room-session');
                Route::post('', "submitEditRoomSessionForm");
            });
            Route::prefix('/add')->group(function () {
                Route::get('', "addRoomSessionForm")->name('add-room-session');
                Route::post('', "submitAddRoomSessionForm");
            });
            Route::post('/delete/{model}', "submitDeleteRoomSession")->name('delete-room-session');
        });
    });
    Route::prefix('/dashboard')->group(function () {
        Route::get('', [App\Http\Controllers\Room\RoomController::class, "dashboard"])->name('dashboard');
        Route::prefix('/account')->group(function () {
            Route::prefix('')->controller(App\Http\Controllers\Users\UserController::class)->group(function () {
                Route::get('/list', "listOfRegisteredAccount")->name('list-of-account');
                Route::get('/current', "accountDetail")->name('account');
            });
            Route::prefix('/email')->controller(App\Http\Controllers\Users\Contacts\EmailController::class)->group(function () {
                Route::prefix('/add')->group(function () {
                    Route::get('', "addEmailForm")->name('add-email');
                    Route::post('', "submitAddEmailForm");
                });
                Route::prefix('/edit')->group(function () {
                    Route::get('/{id}', "editEmailForm")->name('edit-email');
                    Route::post('', "submitEditEmailForm");
                });
                Route::post('/delete', "deleteEmail")->name('delete-email');
            });
            Route::prefix('/phone-number')->controller(App\Http\Controllers\Users\Contacts\PhoneNumberController::class)->group(function () {
                Route::prefix('/add')->group(function () {
                    Route::get('', "addPhoneNumberForm")->name('add-phone-number');
                    Route::post('', "submitAddPhoneNumberForm");
                });
                Route::prefix('/edit')->group(function () {
                    Route::get('/{id}', "editPhoneNumberForm")->name('edit-phone-number');
                    Route::post('', "submitEditPhoneNumberForm");
                });
                Route::post('/delete', "deletePhoneNumber")->name('delete-phone-number');
            });
        });
    });
    Route::post('/logout', [App\Http\Controllers\Users\AuthController::class, "submitLogout"])->name('logout');
});
