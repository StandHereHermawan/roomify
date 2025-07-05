<?php

use App\Domains\User\Middleware\CheckIfAlreadyLoginMiddleware;
use App\Domains\User\Middleware\SessionMiddleware;
use App\Domains\User\Model\SiprUserHasSession;
use App\Http\Middleware\Custom\Authentication\EnsureUserIsLogin;
use App\Http\Middleware\Custom\Authentication\EnsureUserIsNotYetLogin;
use Illuminate\Support\Facades\Crypt;
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
    return redirect()->route('registration'); // default: return view('welcome');
});

Route::middleware(EnsureUserIsNotYetLogin::class)->prefix('')->group(function () {
    Route::prefix('/registration')->group(function () {
        Route::get('', [App\Domains\User\Controller\AuthController::class, "registerForm"])
            ->name('registration');

        Route::post('', [App\Domains\User\Controller\AuthController::class, "submitFormRegister"]);
    });

    Route::prefix('/login')->group(function () {
        Route::get('', [App\Domains\User\Controller\AuthController::class, "loginForm"])
            ->name('login');

        Route::post('', [App\Domains\User\Controller\AuthController::class, "submitFormLogin"]);
    });
});

Route::middleware(EnsureUserIsLogin::class)->group(function () {

    Route::prefix('/room')->group(function () {
        Route::get('', [App\Domains\Room\Controller\RoomController::class, "roomSearchPaginate"])
            ->name('list-of-room');

        Route::prefix('/add')->group(function () {
            Route::get('', [App\Domains\Room\Controller\RoomController::class, "addRoomForm"])
                ->name('add-room');

            Route::post('', [App\Domains\Room\Controller\RoomController::class, "submitAddRoomForm"]);
        });

        Route::prefix('/reservation')->group(function () {
            Route::get('', [App\Domains\Schedule\Controller\RoomReservationController::class, "addRoomReservationForm"])
                ->name('room-reservation');

            Route::post('', [App\Domains\Schedule\Controller\RoomReservationController::class, "submitAddRoomReservationForm"]);
        });

        Route::prefix('/reserved')->group(function () {
            Route::get('', [App\Domains\Schedule\Controller\RoomReservationController::class, "listOfRoomReserved"])
                ->name('list-of-room-reserved');

            Route::post('', [App\Domains\Schedule\Controller\RoomReservationController::class, "submitAddRoomReservationForm"]);
        });

        Route::prefix('/detail')->group(function () {
            Route::get('', [App\Domains\Room\Controller\RoomController::class, "roomDetail"])
                ->name('detail-room');
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

        Route::post('/logout', [App\Domains\User\Controller\AuthController::class, "submitLogout"])
            ->name('logout');
    });

    Route::prefix('/dashboard')->group(function () {

        Route::get('', function () {
            return redirect(route('list-of-room'));
        })->name('dashboard');

        Route::prefix('/account')->group(function () {

            Route::get('', [App\Domains\User\Controller\UserController::class, "listOfRegisteredAccount"])
                ->name('list-of-account');

            Route::get('/current', [App\Domains\User\Controller\UserController::class, "accountDetail"])
                ->name('account');
        });
    });
});

// Route::prefix('/account-management')->group(function () {
// 
// Route::middleware(CheckIfAlreadyLoginMiddleware::class)->group(function () {
// 
// Route::prefix("/registration")->group(function () {
// Route::post("", [App\Domains\User\Controller\AccountManagementController::class, "submitFormRegister"]);
// Route::get("", [App\Domains\User\Controller\AccountManagementController::class, "formRegister"]);
// });
// 
// Route::prefix("/login")->group(function () {
// Route::post("", [App\Domains\User\Controller\AccountManagementController::class, "submitFormLogin"]);
// Route::get("", [App\Domains\User\Controller\AccountManagementController::class, "formLogin"]);
// });
// });

// Route::middleware(SessionMiddleware::class)->prefix('/dashboard')->group(function () {
// 
// Route::get('', [App\Domains\User\Controller\AccountManagementController::class, "dashboard"]);
// 
// Route::prefix('/account')->group(function () {
// 
// Route::get('', [App\Domains\User\Controller\AccountManagementController::class, "account"]);
// 
// Route::get('/edit-username', [App\Domains\User\Controller\AccountManagementController::class, "editUsernameForm"]);
// Route::post('/edit-username', [App\Domains\User\Controller\AccountManagementController::class, "submitEditUsernameForm"]);
// 
// Route::get('/edit-name', [App\Domains\User\Controller\AccountManagementController::class, "editNameForm"]);
// Route::post('/edit-name', [App\Domains\User\Controller\AccountManagementController::class, "submitEditNameForm"]);
// 
// Route::get('/add-email', [App\Domains\User\Controller\AccountManagementController::class, "addEmailForm"]);
// Route::post('/add-email', [App\Domains\User\Controller\AccountManagementController::class, "submitAddEmailForm"]);
// 
// Route::get('/edit-email', [App\Domains\User\Controller\AccountManagementController::class, "editEmailForm"]);
// Route::post('/edit-email', [App\Domains\User\Controller\AccountManagementController::class, "submitEditEmailForm"]);
// 
// Route::get('/delete-email', [App\Domains\User\Controller\AccountManagementController::class, "deleteEmail"]);
// 
// Route::get('/edit-phone-number', [App\Domains\User\Controller\AccountManagementController::class, "editPhoneNumberForm"]);
// Route::post('/edit-phone-number', [App\Domains\User\Controller\AccountManagementController::class, "submitEditPhoneNumberForm"]);
// 
// Route::get('/delete-phone-number', [App\Domains\User\Controller\AccountManagementController::class, "deletePhoneNumber"]);
// 
// Route::get('/add-phone-number', [App\Domains\User\Controller\AccountManagementController::class, "addPhoneNumberForm"]);
// Route::post('/add-phone-number', [App\Domains\User\Controller\AccountManagementController::class, "submitAddPhoneNumberForm"]);
// });
// 
// Route::get('/logout', [App\Domains\User\Controller\AccountManagementController::class, "logout"]);
// 
// });

// });
