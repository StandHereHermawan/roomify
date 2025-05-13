<?php

namespace App\Domains\User\Controller;

use App\Domains\User\Model\SiprEmail;
use App\Domains\User\Model\SiprPhoneNumber;
use App\Domains\User\Model\SiprUser;
use App\Domains\User\Model\SiprUserHasEmail;
use App\Domains\User\Model\SiprUserHasPhoneNumber;
use App\Domains\User\Model\SiprUserHasSession;

use App\Domains\User\Service\Contracts\SiprAccountService;

use App\Http\Controllers\Controller;

use DB;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Log;

class AccountManagementController extends Controller
{
    private SiprAccountService $siprAccountService;

    public function __construct(
        SiprAccountService $siprAccountService
    ) {
        $this->siprAccountService = $siprAccountService;
    }

    private function registerValidation()
    {
        return [
            "username" => ["required", "min:8", "max:255", "lowercase", "unique:sipr_users,username"],
            "name" => ["required", "min:8", "max:255"],
            "email" => ["required", "email", "max:255", "unique:sipr_emails,email"],
            "telephone" => ["required", "regex:^\+(?:[0-9][0-9]?)-\d{3}-\d{4}-\d+^", "unique:sipr_phone_number_contacts,phone_number"],
            "agreedTermsOfUse" => "required",
            "password" => Password::min(8)->letters()->numbers()->symbols()->mixedCase()
        ];
    }

    private function loginValidation()
    {
        return [
            "email" => "exists:sipr_emails,email",
        ];
    }

    public function formRegister()
    {
        return response()->view('management-account.registration');
        ;
    }

    public function submitFormRegister(Request $request)
    {
        $siprAccountService = $this->siprAccountService;
        Log::debug(json_encode("AccountManagementController@submitFormRegister.\$request"), $request->toArray());
        // $username = $request->only("username")["username"];
        // $name = $request->only("name")["name"];
        // $email = $request->only("email")["email"];
        // $password = $request->only("password")["password"];
        // $telephone = $request->only("telephone")["telephone"];
        // $role = $request->only("role")["role"];
        // $agreedTermOfUse = $request->only("agreedTermsOfUse")["agreedTermsOfUse"];
        // $registerInput["role"];

        $registerInput = $request->only([
            "username",
            "name",
            "email",
            "password",
            "telephone",
            "role",
            "agreedTermsOfUse"
        ]);

        $validator = Validator::make($registerInput, $this->registerValidation());
        $errorMessage = $validator->getMessageBag();

        if ($validator->fails()) {
            return response(
                view("management-account.registration")
                    ->with("errorUsernameInput", $errorMessage->get("username")[0] ?? null)
                    ->with("errorNameInput", $errorMessage->get("name")[0] ?? null)
                    ->with("errorEmailInput", $errorMessage->get("email")[0] ?? null)
                    ->with("errorPasswordInput", $errorMessage->get("password")[0] ?? null)
                    ->with("errorTelephoneInput", $errorMessage->get("telephone")[0] ?? null)
                    ->with("errorTermsOfUseInput", $errorMessage->get("agreedTermsOfUse")[0] ?? null),
                422
            );
        }

        $siprAccountService->createCompleteAccountWithFields(
            $registerInput["username"],
            $registerInput["name"],
            $registerInput["email"],
            $registerInput["password"],
            $registerInput["telephone"],
        );

        return redirect()->action([AccountManagementController::class, "submitFormLogin"]);
    }

    public function formLogin()
    {
        return response(view("management-account.login"));
    }

    public function submitFormLogin(Request $request)
    {
        Log::debug(json_encode("AccountManagementController@submitFormLogin.\$request"), $request->toArray());
        $userService = $this->siprAccountService->getUserService();
        $emailService = $this->siprAccountService->getEmailService();
        $userHasEmailService = $this->siprAccountService->getUserHasEmailService();
        $userHasSessionService = $this->siprAccountService->getUserHasSessionService();

        $loginInput = $request->only([
            "email",
            "password"
        ]);

        $validator = Validator::make($loginInput, $this->loginValidation());

        // 1.1.0 checking does the email validation fails.
        if ($validator->fails()) {
            $errorMessage = $validator->getMessageBag();
            return response(
                view("management-account.login")
                    ->with("errorEmailInput", $errorMessage->get("email")[0] ?? null)
                    ->with("errorPasswordInput", "Password validation needs registered email."),
                422
            );
        }
        // end of 1.1.0 checking does the email validation fails

        $emailInput = $loginInput["email"];
        $passwordInput = $loginInput["password"];

        $emailModel = $emailService->findEmailModelByEmail($emailInput);
        $idEmail = $emailModel->getId();
        Log::debug(json_encode("AccountManagementController@submitFormLogin.\$emailModel"), ["emailModel" => $emailModel]);

        $userHasEmailModel = $userHasEmailService->findModelUserHasEmailRelationshipByEmailId($idEmail);
        $userId = $userHasEmailModel->getUserId();
        Log::debug(json_encode("AccountManagementController@submitFormLogin.\$userHasEmailModel"), ["userHasEmailModel" => $userHasEmailModel]);

        $userModel = $userService->findUserModelById($userId);
        $passwordFromDatabase = $userModel->getPassword();
        Log::debug(json_encode("AccountManagementController@submitFormLogin.\$userModel"), ["userModel" => $userModel]);

        $passwordInputIsCorrect = Hash::check($passwordInput, $passwordFromDatabase);
        Log::debug(json_encode("AccountManagementController@submitFormLogin"), ["passwordInputIsCorrect" => $passwordInputIsCorrect]);

        // 1.0.3 does input password user is key for given hash from database
        if ($passwordInputIsCorrect === false) {
            return response(
                view("management-account.login")
                    ->with("errorPasswordInput", "The password did not match."),
                422
            );
        }

        $userHasSessionModel = $userHasSessionService->createOrFindAndReturnBackUserHasSessionModel($userModel->getId(), $userModel->getUsername());
        $sessionToken = $userHasSessionModel->getSession();

        $durationDivideBy60000 = $userHasSessionModel->getDurationLeftSessionExpired() / 60_000;

        return redirect("/account-management/dashboard")->cookie("X-SIPR-TOKEN", $sessionToken, $durationDivideBy60000);
    }

    public function dashboard()
    {
        return response()->view("management-account.dashboard");
    }

    public function account(Request $request)
    {
        $idUser = null;
        $idEmail = null;
        $idPhoneNumber = null;

        $userHasSessionModel = SiprUserHasSession::select()
            ->where("session", "=", $request->cookie("X-SIPR-TOKEN"))
            ->first();

        if ($userHasSessionModel != null) {
            # code...
            $idUser = $userHasSessionModel->getIdUser();
        }

        $userHasEmailModel = SiprUserHasEmail::where("user_id", "=", $idUser)->first();
        $userHasPhoneNumberModel = SiprUserHasPhoneNumber::where("user_id", "=", $idUser)->first();

        if ($userHasEmailModel != null) {
            # code...
            $idEmail = $userHasEmailModel->getEmailId();
        }

        if ($userHasPhoneNumberModel != null) {
            # code...
            $idPhoneNumber = $userHasPhoneNumberModel->getIdPhoneNumber();
        }

        $userModel = SiprUser::select()->where("id", "=", $idUser)->first();
        $emailModel = SiprEmail::select()->where("id", "=", $idEmail)->first();
        $phoneNumberModel = SiprPhoneNumber::select()->where("id", "=", $idPhoneNumber)->first();

        $username = null;
        $name = null;
        $email = null;
        $phoneNumber = null;

        if ($userModel != null) {
            $username = $userModel->getUsername();
            $name = $userModel->getName();
        }

        if ($emailModel != null) {
            $email = $emailModel->getEmail();
        }

        if ($phoneNumberModel != null) {
            $phoneNumber = $phoneNumberModel->getphoneNumber();
        }

        // section for email pagination
        $requestLimit = $request->only([
            "limitEmailPage",
            "offsetTotalEmailPage",
            "limitPhoneNumberPage",
            "offsetTotalPhoneNumberPage"
        ]);

        $limitEmailPage = $requestLimit["limitEmailPage"] ?? 2;
        $offsetTotalEmailPage = $requestLimit["offsetTotalEmailPage"] ?? 0;

        $limitPhoneNumberPage = $requestLimit["limitPhoneNumberPage"] ?? 2;
        $offsetTotalPhoneNumberPage = $requestLimit["offsetTotalPhoneNumberPage"] ?? 0;

        if ($userModel != null) {
            $email = $userModel->getEmails($limitEmailPage, $offsetTotalEmailPage);
            $phoneNumber = $userModel->getPhoneNumbers($limitPhoneNumberPage, $offsetTotalPhoneNumberPage);
        }

        if ($offsetTotalEmailPage <= 0) {
            // $addOffsetEmailPage = $requestLimit["addOffsetEmailPage"] ?? 0;
            // $subtractOffsetEmailPage = $requestLimit["subtractOffsetEmailPage"] ?? 0;
            // $currentOffsetEmailPage = $requestLimit["currentOffsetEmailPage"] ?? 0;
            // if ($addOffsetEmailPage != 0) {
            // $currentOffsetEmailPage = $currentOffsetEmailPage + $addOffsetEmailPage;
            // }
            // if ($subtractOffsetEmailPage != 0) {
            // $subtractOffsetEmailPage = $currentOffsetEmailPage - $addOffsetEmailPage;
            // }
            // if ($currentOffsetEmailPage != 0) {
            // $offsetTotalEmailPage = $currentOffsetEmailPage;
            // }
            $offsetTotalEmailPage = 0;
        }

        if ($offsetTotalPhoneNumberPage <= 0) {
            $offsetTotalPhoneNumberPage = 0;
        }
        // end section for email pagination

        return response()->view("management-account.account", [
            "username" => $username,
            "name" => $name,
            "limitEmailPage" => $limitEmailPage,
            "offsetTotalEmailPage" => $offsetTotalEmailPage,
            "limitPhoneNumberPage" => $limitPhoneNumberPage,
            "offsetTotalPhoneNumberPage" => $offsetTotalPhoneNumberPage,
            "email" => $email,
            "phoneNumber" => $phoneNumber
        ]);
    }

    public function editUsernameForm(Request $request)
    {
        $username = null;
        if (isset($request->only("username")["username"])) {
            $username = $request->only("username")["username"];
        }
        return response()->view("management-account.change-username", ["username" => $username]);
    }

    public function submitEditUsernameForm(Request $request)
    {
        $newUsernameInput = $request->only([
            "old-username",
            "new-username"
        ]);

        $validator = Validator::make($newUsernameInput, [
            "old-username" => "exists:sipr_users,username",
            "new-username" => ["required", "min:8", "max:255", "lowercase", "unique:sipr_users,username"],
        ]);

        $oldUsername = $newUsernameInput["old-username"];
        $newUsername = $newUsernameInput["new-username"];

        if ($validator->fails()) {

            $errorMessage = $validator->getMessageBag();

            $error = null;
            $newUsernameError = null;
            $oldUsernameError = null;

            if ($errorMessage->get("new-username") != null) {
                # code...
                $newUsernameError = $errorMessage->get("new-username")[0];
            }

            if ($errorMessage->get("old-username") != null) {
                # code...
                $oldUsernameError = $errorMessage->get("old-username")[0];
            }

            $error = $newUsernameError . " " . $oldUsernameError;

            return response(
                view("management-account.change-username", ["username" => $oldUsername])
                    ->with("errorNewUsernameInput", $error ?? null),
                422
            );
        }

        $userModel = SiprUser::select()->where("username", "=", $oldUsername)->first();
        $userModel->update(["username" => $newUsername]);
        $userModel->save();

        return redirect()->action([AccountManagementController::class, "account"]);
    }

    public function editNameForm(Request $request)
    {
        $name = null;
        $username = null;

        if (isset($request->only("name")["name"])) {
            $name = $request->only("name")["name"];
        }

        if (isset($request->only("username")["username"])) {
            $username = $request->only("username")["username"];
        }

        return response()->view("management-account.change-name", ["name" => $name, "username" => $username]);
    }

    public function submitEditNameForm(Request $request)
    {
        $newNameInput = $request->only([
            "old-username",
            "old-name",
            "new-name"
        ]);

        $validator = Validator::make($newNameInput, [
            "old-username" => "exists:sipr_users,username",
            "new-name" => ["required", "min:8", "max:255"],
        ]);

        $oldUsername = $newNameInput["old-username"];
        $oldName = $newNameInput["old-name"];
        $newName = $newNameInput["new-name"];

        if ($validator->fails()) {

            $errorMessage = $validator->getMessageBag();

            $error = null;
            $newNameError = null;
            $oldUsernameError = null;

            if ($errorMessage->get("new-name") != null) {
                # code...
                $newNameError = $errorMessage->get("new-name")[0];
            }

            if ($errorMessage->get("old-name") != null) {
                # code...
                $oldUsernameError = $errorMessage->get("old-name")[0];
            }

            $error = $newNameError . " " . $oldUsernameError;

            return response(
                view("management-account.change-name", ["username" => $oldUsername, "name" => $oldName])
                    ->with("errorNewNameInput", $error ?? null),
                422
            );
        }

        $userModel = SiprUser::select()->where("username", "=", $oldUsername)->first();
        $userModel->update(["name" => $newName]);
        $userModel->save();

        return redirect()->action([AccountManagementController::class, "account"]);
    }

    public function addEmailForm(Request $request)
    {
        $username = null;

        if (isset($request->only("username")["username"])) {
            $username = $request->only("username")["username"];
        }

        return response()->view("management-account.add-email", ["username" => $username]);
    }

    public function submitAddEmailForm(Request $request)
    {
        $newEmailInput = $request->only([
            "username",
            "new-email"
        ]);

        $validator = Validator::make($newEmailInput, [
            "username" => "exists:sipr_users,username",
            "new-email" => ["required", "email", "min:8", "max:255", "unique:sipr_emails,email"],
        ]);

        $username = $newEmailInput["username"];
        $newEmail = $newEmailInput["new-email"];

        if ($validator->fails()) {
            $errorMessage = $validator->getMessageBag();

            $error = null;
            $newNameError = null;

            if ($errorMessage->get("new-email") != null) {
                # code...
                $newNameError = $errorMessage->get("new-email")[0];
            }

            $error = $newNameError;

            return response(
                view("management-account.add-email", ["username" => $username])
                    ->with("errorNewEmailInput", $error ?? null),
                422
            );
        }

        $userModel = SiprUser::select()->where("username", "=", $username)->first();

        $idUser = null;
        if ($userModel != null) {
            # code...
            $idUser = $userModel->getId();
        }

        $emailModel = SiprEmail::create(["email" => $newEmail, "created_at" => Carbon::now()]);

        $idEmail = null;
        if ($emailModel != null) {
            # code...
            $idEmail = $emailModel->getId();
        }

        SiprUserHasEmail::create(["user_id" => $idUser, "email_id" => $idEmail, "created_at" => Carbon::now()]);

        return redirect()->action([AccountManagementController::class, "account"]);
    }

    public function editEmailForm(Request $request)
    {
        $username = null;
        $oldEmail = null;

        if (isset($request->only("username")["username"])) {
            $username = $request->only("username")["username"];
        }

        if (isset($request->only("oldEmail")["oldEmail"])) {
            $oldEmail = $request->only("oldEmail")["oldEmail"];
        }

        return response()->view("management-account.edit-email", ["username" => $username, "oldEmail" => $oldEmail]);
    }

    public function submitEditEmailForm(Request $request)
    {
        $newEmailInput = $request->only([
            "username",
            "oldEmail",
            "updated-email"
        ]);

        $validator = Validator::make($newEmailInput, [
            "username" => "exists:sipr_users,username",
            "oldEmail" => ["required", "exists:sipr_emails,email"],
            "updated-email" => ["required", "email", "min:8", "max:255", "unique:sipr_emails,email"],
        ]);

        $username = $newEmailInput["username"];
        $oldEmail = $newEmailInput["oldEmail"];
        $updatedEmail = $newEmailInput["updated-email"];

        if ($validator->fails()) {
            $errorMessage = $validator->getMessageBag();

            $error = null;
            $updatedEmailErrorMessage = null;
            $oldEmailErrorMessage = null;

            if ($errorMessage->get("updated-email") != null) {
                # code...
                $updatedEmailErrorMessage = $errorMessage->get("updated-email")[0];
            }

            if ($errorMessage->get("oldEmail") != null) {
                # code...
                $oldEmailErrorMessage = $errorMessage->get("oldEmail")[0];
            }

            $error = $updatedEmailErrorMessage . " " . $oldEmailErrorMessage;

            return response(
                view("management-account.edit-email", ["username" => $username, "oldEmail" => $oldEmail])
                    ->with("errorUpdatedEmailInput", $error ?? null),
                422
            );
        }

        $emailModel = SiprEmail::select()->where("email", "=", $oldEmail)->first();
        if ($emailModel !== null) {
            # code...
            $emailModel->update(["email" => $updatedEmail]);
        }

        return redirect()->action([AccountManagementController::class, "account"]);
    }

    public function deleteEmail(Request $request)
    {
        $emailTobeDeleted = null;

        if (isset($request->only("email")["email"])) {
            $emailTobeDeleted = $request->only("email")["email"];
        }

        $emailTobeDeletedModel = SiprEmail::select()->where("email", "=", $emailTobeDeleted)->first();
        Log::debug("AccountManagementController@deleteEmail", ["emailTobeDeletedModel" => $emailTobeDeletedModel]);

        $idEmail = null;
        if ($emailTobeDeleted !== null) {
            # code...
            $idEmail = $emailTobeDeletedModel->getId();
        }

        $userHasEmailModel = SiprUserHasEmail::select()->where("email_id", "=", $idEmail)->first();
        Log::debug("AccountManagementController@deleteEmail", ["userHasEmailModel" => $userHasEmailModel]);

        $idUser = null;
        if ($emailTobeDeleted !== null) {
            # code...
            $idUser = $userHasEmailModel->getUserId();
        }

        $registeredEmailSummary = SiprUserHasEmail::select()->where("user_id", "=", $idUser)->where("deleted_at", "=", null)->get();
        $result = $registeredEmailSummary->count();
        Log::debug("AccountManagementController@deleteEmail", ["registeredEmailSummary" => $registeredEmailSummary]);
        Log::debug("AccountManagementController@deleteEmail", ["result" => $result]);

        if ($result > 1) {
            DB::transaction(function () use ($userHasEmailModel, $emailTobeDeletedModel) {
                $userHasEmailModel->delete();
                $emailTobeDeletedModel->delete();
            });
        } else {
            return response(view("management-account.edit-email", ["oldEmail" => $emailTobeDeleted])
                ->with("errorUpdatedEmailInput", "Cannot delete email cause it was last registered email for this account."), 422);
        }

        return redirect()->action([AccountManagementController::class, "account"]);
    }

    public function editPhoneNumberForm(Request $request)
    {
        $username = null;
        $oldPhoneNumber = null;

        if (isset($request->only("username")["username"])) {
            $username = $request->only("username")["username"];
        }

        if (isset($request->only("oldPhoneNumber")["oldPhoneNumber"])) {
            $oldPhoneNumber = $request->only("oldPhoneNumber")["oldPhoneNumber"];
        }

        return response()->view("management-account.edit-phone-number", ["username" => $username, "oldPhoneNumber" => $oldPhoneNumber]);
    }

    public function submitEditPhoneNumberForm(Request $request)
    {
        $newEmailInput = $request->only([
            "username",
            "oldPhoneNumber",
            "updated-phone-number"
        ]);

        $validator = Validator::make($newEmailInput, [
            "username" => "exists:sipr_users,username",
            "oldPhoneNumber" => ["required", "exists:sipr_phone_number_contacts,phone_number", "regex:^\+(?:[0-9][0-9]?)-\d{3}-\d{4}-\d+^"],
            "updated-phone-number" => ["required", "regex:^\+(?:[0-9][0-9]?)-\d{3}-\d{4}-\d+^", "unique:sipr_phone_number_contacts,phone_number"],
        ]);

        $username = $newEmailInput["username"];
        $oldPhoneNumber = $newEmailInput["oldPhoneNumber"];
        $updatedPhoneNumber = $newEmailInput["updated-phone-number"];

        if ($validator->fails()) {
            $errorMessage = $validator->getMessageBag();

            $error = null;
            $updatedEmailErrorMessage = null;
            $oldEmailErrorMessage = null;

            if ($errorMessage->get("updated-phone-number") != null) {
                # code...
                $updatedEmailErrorMessage = $errorMessage->get("updated-phone-number")[0];
            }

            if ($errorMessage->get("oldPhoneNumber") != null) {
                # code...
                $oldEmailErrorMessage = $errorMessage->get("oldPhoneNumber")[0];
            }

            $error = $updatedEmailErrorMessage . " " . $oldEmailErrorMessage;

            return response(
                view("management-account.edit-phone-number", ["username" => $username, "oldPhoneNumber" => $oldPhoneNumber])
                    ->with("errorUpdatedPhoneNumberInput", $error ?? null),
                422
            );
        }

        $phoneNumberModel = SiprPhoneNumber::select()->where("phone_number", "=", $oldPhoneNumber)->first();
        if ($phoneNumberModel !== null) {
            # code...
            $phoneNumberModel->update(["phone_number" => $updatedPhoneNumber]);
        }

        return redirect()->action([AccountManagementController::class, "account"]);
    }

    public function deletePhoneNumber(Request $request)
    {
        $phoneNumberTobeDeleted = null;

        if (isset($request->only("phone-number")["phone-number"])) {
            $phoneNumberTobeDeleted = $request->only("phone-number")["phone-number"];
        }

        if ($phoneNumberTobeDeleted === null) {
            return response(view("management-account.edit-phone-number", ["oldPhoneNumber" => $phoneNumberTobeDeleted])
                ->with("errorUpdatedPhoneNumberInput", "Old phone number not found."), 422);
        }

        Log::debug("AccountManagementController@deletePhoneNumber", ["phoneNumberTobeDeleted" => $phoneNumberTobeDeleted]);

        $phoneNumberTobeDeletedModel = SiprPhoneNumber::select()->where("phone_number", "=", $phoneNumberTobeDeleted)->first();
        Log::debug("AccountManagementController@deletePhoneNumber", ["phoneNumberTobeDeletedModel" => $phoneNumberTobeDeletedModel]);

        $idPhoneNumber = null;
        if ($phoneNumberTobeDeleted !== null) {
            # code...
            $idPhoneNumber = $phoneNumberTobeDeletedModel->getId();
        }

        $userHasPhoneNumberModel = SiprUserHasPhoneNumber::select()->where("phone_number_id", "=", $idPhoneNumber)->first();
        Log::debug("AccountManagementController@deletePhoneNumber", ["userHasPhoneNumberModel" => $userHasPhoneNumberModel]);

        $idUser = null;
        if ($userHasPhoneNumberModel !== null) {
            # code...
            $idUser = $userHasPhoneNumberModel->getUserId();
        }

        $registeredEmailSummary = SiprUserHasPhoneNumber::select()->where("user_id", "=", $idUser)->where("deleted_at", "=", null)->get();
        $result = $registeredEmailSummary->count();
        Log::debug("AccountManagementController@deletePhoneNumber", ["registeredEmailSummary" => $registeredEmailSummary]);
        Log::debug("AccountManagementController@deletePhoneNumber", ["result" => $result]);

        if ($result > 1) {
            DB::transaction(function () use ($userHasPhoneNumberModel, $phoneNumberTobeDeletedModel) {
                $userHasPhoneNumberModel->delete();
                $phoneNumberTobeDeletedModel->delete();
            });
        } else {
            return response(view("management-account.edit-phone-number", ["oldPhoneNumber" => $phoneNumberTobeDeleted])
                ->with("errorUpdatedPhoneNumberInput", "Cannot delete email cause it was last registered phone number for this account."), 422);
        }

        return redirect()->action([AccountManagementController::class, "account"]);
    }

    public function addPhoneNumberForm(Request $request)
    {
        $username = null;

        if (isset($request->only("username")["username"])) {
            $username = $request->only("username")["username"];
        }

        return response()->view("management-account.add-phone-number", ["username" => $username]);
    }

    public function submitAddPhoneNumberForm(Request $request)
    {
        $newEmailInput = $request->only([
            "username",
            "new-phone-number"
        ]);

        $validator = Validator::make($newEmailInput, [
            "username" => "exists:sipr_users,username",
            "new-phone-number" => ["required", "regex:^\+(?:[0-9][0-9]?)-\d{3}-\d{4}-\d+^", "unique:sipr_phone_number_contacts,phone_number"],
        ]);

        $username = $newEmailInput["username"];
        $newPhoneNumber = $newEmailInput["new-phone-number"];

        if ($validator->fails()) {
            $errorMessage = $validator->getMessageBag();

            $error = null;
            $newNameError = null;

            if ($errorMessage->get("new-phone-number") != null) {
                # code...
                $newNameError = $errorMessage->get("new-phone-number")[0];
            }

            $error = $newNameError;

            return response(
                view("management-account.add-phone-number", ["username" => $username])
                    ->with("errorNewPhoneNumberInput", $error ?? null),
                422
            );
        }

        $userModel = SiprUser::select()->where("username", "=", $username)->first();

        $idUser = null;
        if ($userModel != null) {
            # code...
            $idUser = $userModel->getId();
        }

        var_dump($idUser);

        $phoneNumberModel = SiprPhoneNumber::create(["phone_number" => $newPhoneNumber, "created_at" => Carbon::now()]);

        $idPhoneNumber = null;
        if ($phoneNumberModel != null) {
            # code...
            $idPhoneNumber = $phoneNumberModel->getId();
        }

        var_dump($idPhoneNumber);

        SiprUserHasPhoneNumber::create(["user_id" => $idUser, "phone_number_id" => $idPhoneNumber, "created_at" => Carbon::now()])->save();

        return redirect()->action([AccountManagementController::class, "account"]);
    }

    public function logout(Request $request)
    {
        $userHasSessionModel = SiprUserHasSession::select()->where("session", "=", $request->cookie("X-SIPR-TOKEN"))->first();
        $userHasSessionModel->forceDelete();
        return redirect()->action([AccountManagementController::class, "formLogin"])->cookie("X-SIPR-TOKEN", "", -3600);
    }
}
