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

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

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

    public function formRegister()
    {
        return response()->view('management-account.registration');
        ;
    }

    public function submitFormRegister(Request $request)
    {
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

        $siprAccountService = $this->siprAccountService;

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
        $userService = $this->siprAccountService->getUserService();
        $emailService = $this->siprAccountService->getEmailService();
        $userHasEmailService = $this->siprAccountService->getUserHasEmailService();

        $loginInput = $request->only([
            "email",
            "password"
        ]);

        $validator = Validator::make($loginInput, [
            "email" => "exists:sipr_emails,email",
        ]);

        $emailInput = $loginInput["email"];
        $passwordInput = $loginInput["password"];

        // $emailModel = SiprEmail::select()->where("email", "=", $emailInput)->first();
        $emailModel = $emailService->findModelEmailByEmail($emailInput);

        $idEmail = null;
        // checking so it will not have call some method on null exception
        if ($emailModel == null) {
            return response(
                view("management-account.login")
                    ->with("errorEmailInput", "$emailInput was not registered.")
                    ->with("errorPasswordInput", "Password validation needs registered email."),
                422
            );
        } else {
            $idEmail = $emailModel->getId();
        }

        // $userHasEmailModel = SiprUserHasEmail::select()->where("email_id", "=", $idEmail)->first();
        $userHasEmailModel = $userHasEmailService->findModelUserHasEmailRelationshipByEmailId($idEmail);

        $userId = null;
        $userModel = null;
        $passwordFromDatabase = null;
        // checking so it will not have call some method on null exception
        if ($userHasEmailModel != null) {
            $userId = $userHasEmailModel->getUserId();
            $userModel = SiprUser::select()->where("id", "=", $userId)->first();
            $passwordFromDatabase = $userModel->getPassword() ?? null;
        } else {
            return response(
                view("management-account.login")
                    ->with("errorEmailInput", "")
                    ->with("errorPasswordInput", "Password validation needs registered email."),
                422
            );
        }

        $hashCheckResult = false;
        // cek apakah input password user adalah kunci dari hash 
        if ($passwordFromDatabase != null) {
            $hashCheckResult = Hash::check($passwordInput, $passwordFromDatabase);
        } else {
            return response(
                view("management-account.login")
                    ->with("errorPasswordInput", "The password didn't match."),
                422
            );
        }
        // end of cek apakah input password user adalah kunci dari hash 


        // Cek
        if ($validator->fails()) {

            $errorMessage = $validator->getMessageBag();
            if (!$hashCheckResult) {
                return response(
                    view("management-account.login")
                        ->with("errorEmailInput", $errorMessage->get("email")[0] ?? null)
                        ->with("errorPasswordInput", "Password validation needs registered email."),
                    422
                );
            }

            return response(
                view("management-account.login")
                    ->with("errorEmailInput", $errorMessage->get("email")[0] ?? null),
                422
            );

        } else {

            if ($passwordFromDatabase == null) {
                return response(
                    view("management-account.login")
                        ->with("errorPasswordInput", "Email Exist but password not match."),
                    422
                );
            } elseif (!$hashCheckResult) {

            }
        }

        function hash256($data)
        {
            return hash('sha256', $data);
        }

        $json = json_encode(["idUser" => $userModel->getId(), "username" => $userModel->getUsername()]);
        $sha256HashedIdAndUsername = hash256($json);

        $userHasSessionModel = null;
        $sessionToken = null;

        // cek apakah ada session dengan username dan idUser yang baru submit login
        $checkingIfSessionExists = SiprUserHasSession::select()
            ->where("session", "=", $sha256HashedIdAndUsername)
            ->first();

        // jika checkingIfSessionExists tetap null, maka session user yang login belum ada di database.
        // lalu userHasSessionModel membuat session ke database dan balikin modelnya.
        if ($checkingIfSessionExists == null) {
            $sessionToken = hash256($json); // Session dengan hash sha256
            $userHasSessionModel = SiprUserHasSession::create([
                "user_id" => $userModel->getId(),
                "username" => $userModel->getUsername(),
                "session" => $sessionToken,
                "created_at" => Carbon::now(),
                "expired_at" => Carbon::now()->addDays(7),
            ]);

        } else {
            // kalau ternyata ada session user di database, userHasSessionModel tetap null.
            $sessionToken = $checkingIfSessionExists->getSession();
        }

        // jika userHasSessionModel tidak null, 
        // session untuk user baru dibuat.
        if ($userHasSessionModel != null) {
            $sessionToken = $userHasSessionModel->getSession();
        } else {
            $userHasSessionModel = $checkingIfSessionExists;
        }

        $durationDivideBy10000 = $userHasSessionModel->getDurationLeftSessionExpired() / 60_000;

        return redirect("/account-management/dashboard")->cookie("X-SIPR-TOKEN", $sessionToken, $durationDivideBy10000);
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

        $userHasSessionModel = SiprUserHasSession::select()->where("session", "=", $request->cookie("X-SIPR-TOKEN"))->first();

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

        return response()->view("management-account.account", [
            "username" => $username,
            "name" => $name,
            "email" => $email,
            "phoneNumber" => $phoneNumber
        ]);
    }

    public function logout(Request $request)
    {
        return redirect()->action([AccountManagementController::class, "formLogin"])->cookie("X-SIPR-TOKEN", "", -3600);
    }
}
