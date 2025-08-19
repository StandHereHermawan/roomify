<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rules\Password;

use Illuminate\Contracts\Validation\Validator;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Exceptions\HttpResponseException;

use App\Domains\User\Model\SiprUser;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user() === null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            SiprUser::USERNAME => ["required", "min:8", "max:255", "lowercase", "unique:" . SiprUser::TABLE_NAME . "," . SiprUser::USERNAME],
            SiprUser::NAME => ["required", "min:8", "max:255"],
            SiprUser::PASSWORD => [Password::min(8)->letters()->numbers()->symbols()->mixedCase()->max(100)],
            "agreedTermsOfUse" => "required",
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errorMessage = $validator->getMessageBag();

        $error_username_message = $errorMessage->get(SiprUser::USERNAME)[0] ?? null;
        $error_name_message = $errorMessage->get(SiprUser::NAME)[0] ?? null;
        $error_password_message = $errorMessage->get(SiprUser::PASSWORD)[0] ?? null;
        $error_terms_of_use_message = $errorMessage->get("agreedTermsOfUse")[0] ?? null;

        throw new HttpResponseException(response(
            view("account.auth.registration")
                ->with("errorUsernameInput", $error_username_message)
                ->with("errorNameInput", $error_name_message)
                ->with("errorPasswordInput", $error_password_message)
                ->with("errorTermsOfUseInput", $error_terms_of_use_message),
            422
        ));
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            "agreedTermsOfUse.required" => "Harus mengisi persetujuan penggunaan.",
        ];
    }
}
