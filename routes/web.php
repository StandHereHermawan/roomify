<?php

use App\Http\Middleware\Custom\Authentication\EnsureUserIsLogin;
use App\Http\Middleware\Custom\Authentication\EnsureUserIsNotYetLogin;
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

Route::get('/', [\App\Domains\Home\Controller\MainController::class, 'main']);

Route::middleware(EnsureUserIsNotYetLogin::class)->group(function () {
    Route::prefix('/registration')->group(function () {
        Route::get('', [App\Domains\User\Controller\UserController::class, "registerForm"])
            ->name('registration');

        Route::post('', [App\Domains\User\Controller\UserController::class, "submitFormRegister"]);
    });

    Route::prefix('/login')->group(function () {
        Route::get('', [App\Domains\User\Controller\AuthController::class, "loginForm"])
            ->name('login');

        Route::post('', [App\Domains\User\Controller\AuthController::class, "submitFormLogin"]);
    });
});

Route::middleware(EnsureUserIsLogin::class)->group(function () {
    Route::post('/logout', [App\Domains\User\Controller\AuthController::class, "submitLogout"])
        ->name('logout');

    Route::prefix('/room')->group(function () {
        Route::get('', [App\Domains\Room\Controller\RoomController::class, "roomSearchPaginate"])
            ->name('list-of-room');

        Route::prefix('/add')->group(function () {
            Route::get('', [App\Domains\Room\Controller\RoomController::class, "addRoomForm"])
                ->name('add-room');

            Route::post('', [App\Domains\Room\Controller\RoomController::class, "submitAddRoomForm"]);
        });

        Route::prefix('/{id}/detail')->group(function () {
            Route::get('', [App\Domains\Room\Controller\RoomController::class, "roomDetail"])
                ->name('detail-room');
        });

        Route::prefix('/reservation')->group(function () {
            Route::prefix('/request')->group(function () {

                Route::prefix('/add')->group(function () {
                    Route::get('', [App\Domains\Schedule\Controller\RoomReservationController::class, "addRoomReservationForm"])
                        ->name('room-reservation-request');
                    Route::post('', [App\Domains\Schedule\Controller\RoomReservationController::class, "submitAddRoomReservationForm"]);
                });

                Route::prefix('/list')->group(function () {
                    Route::get('', [App\Domains\Schedule\Controller\RoomReservationController::class, "listOfAllRoomReservationRequest"])
                        ->name('list-of-room-reservation-request');

                    Route::prefix('/me')->group(function () {
                        Route::get('', [App\Domains\Schedule\Controller\RoomReservationController::class, "listOfMyRoomReservationRequest"])
                            ->name('list-of-my-room-reservation-request');
                    });

                    Route::prefix('/manage')->group(function () {
                        Route::get('', [App\Domains\Schedule\Controller\RoomReservationController::class, "manageByAdminListOfRoomReservationRequest"])
                            ->name('manage-list-of-room-reservation-request');
                    });
                });

                Route::prefix('/delete')->group(function () {
                    Route::post('/hard', [App\Domains\Schedule\Controller\RoomReservationController::class, "deleteFromDatabaseRoomReservationRequest"])
                        ->name('delete-room-reservation-request-from-database');

                    Route::post('/soft', [App\Domains\Schedule\Controller\RoomReservationController::class, "softDeleteRoomReservationRequest"])
                        ->name('soft-delete-room-reservation-request');
                });

                Route::post('/accept', [App\Domains\Schedule\Controller\RoomReservationController::class, "acceptRoomReservationRequest"])
                    ->name('accept-room-reservation-request');

                Route::post('/reject', [App\Domains\Schedule\Controller\RoomReservationController::class, "rejectRoomReservationRequest"])
                    ->name('reject-room-reservation-request');
            });
        });

        Route::prefix('/session')->group(function () {
            Route::get('', [App\Domains\Room\Controller\RoomSessionController::class, "roomSessionPaginate"])
                ->name('list-of-room-session');

            Route::post('/delete', [App\Domains\Room\Controller\RoomSessionController::class, "submitDeleteRoomSession"])
                ->name('delete-session');

            Route::prefix('/modify')->group(function () {
                Route::get('', [App\Domains\Room\Controller\RoomSessionController::class, "editRoomSessionForm"])
                    ->name('edit-room-session');

                Route::post('', [App\Domains\Room\Controller\RoomSessionController::class, "submitEditRoomSessionForm"]);
            });

            Route::prefix('/add')->group(function () {
                Route::get('', [App\Domains\Room\Controller\RoomSessionController::class, "addRoomSessionForm"])
                    ->name('add-room-session');

                Route::post('', [App\Domains\Room\Controller\RoomSessionController::class, "submitAddRoomSessionForm"]);
            });
        });
    });

    Route::prefix('/dashboard')->group(function () {
        Route::get('', [App\Domains\Room\Controller\RoomController::class, "dashboard"])
            ->name('dashboard');

        Route::prefix('/account')->group(function () {
            Route::get('/list', [App\Domains\User\Controller\UserController::class, "listOfRegisteredAccount"])
                ->name('list-of-account');

            Route::get('/current', [App\Domains\User\Controller\UserController::class, "accountDetail"])
                ->name('account');

            Route::prefix('/email')->group(function () {
                Route::prefix('/add')->group(function () {
                    Route::get('', [App\Domains\User\Controller\UserController::class, "addEmailForm"])
                        ->name('add-email');
                    Route::post('', [App\Domains\User\Controller\UserController::class, "submitAddEmailForm"]);
                });
                Route::prefix('/edit')->group(function () {
                    Route::get('', [App\Domains\User\Controller\UserController::class, "editEmailForm"])
                        ->name('edit-email');
                    Route::post('', [App\Domains\User\Controller\UserController::class, "submitEditEmailForm"]);
                });
                Route::post('/delete', [App\Domains\User\Controller\UserController::class, "deleteEmail"])
                    ->name('delete-email');
            });

            Route::prefix('/phone-number')->group(function () {
                Route::prefix('/add')->group(function () {
                    Route::get('', [App\Domains\User\Controller\UserController::class, "addPhoneNumberForm"])
                        ->name('add-phone-number');
                    Route::post('', [App\Domains\User\Controller\UserController::class, "submitAddPhoneNumberForm"]);
                });
                Route::prefix('/edit')->group(function () {
                    Route::get('', [App\Domains\User\Controller\UserController::class, "editPhoneNumberForm"])
                        ->name('edit-phone-number');
                    Route::post('', [App\Domains\User\Controller\UserController::class, "submitEditPhoneNumberForm"]);
                });
                Route::post('/delete', [App\Domains\User\Controller\UserController::class, "deletePhoneNumber"])
                    ->name('delete-phone-number');
            });
        });
    });
});
