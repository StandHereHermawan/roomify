<?php

namespace App\Domains\User\Request;

use App\Domains\User\Model\SiprUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator;

class UserRegistrationRequests extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $username_column_name = SiprUser::COLUMN_USERNAME_ITS_NAME;
        $user_table_name = SiprUser::TABLE_NAME;

        return [
            "username" => ["required", "min:8", "max:255", "lowercase", "unique:{$user_table_name},{$username_column_name}"],
            "name" => ["required", "min:8", "max:255"],
            "password" => [Password::min(8)->letters()->numbers()->symbols()->mixedCase()->max(100)],
            "agreedTermsOfUse" => "required",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errorMessage = $validator->getMessageBag();

        $error_username_message = $errorMessage->get("username")[0] ?? null;
        $error_name_message = $errorMessage->get("name")[0] ?? null;
        $error_password_message = $errorMessage->get("password")[0] ?? null;
        $error_terms_of_use_message = $errorMessage->get("agreedTermsOfUse")[0] ?? null;

        throw new HttpResponseException(response(
            view("account.auth.registration")
                ->with("errorUsernameInput", $error_username_message)
                ->with("errorNameInput", $error_name_message)
                ->with("errorPasswordInput", $error_password_message)
                ->with("errorTermsOfUseInput", $error_terms_of_use_message)
            ,
            422
        ));
    }

    public function messages()
    {
        return [
            "agreedTermsOfUse.required" => "Harus mengisi persetujuan penggunaan.",
        ];
    }
}
