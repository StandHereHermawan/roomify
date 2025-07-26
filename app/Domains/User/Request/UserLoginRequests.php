<?php

namespace App\Domains\User\Request;

use App\Domains\User\Model\SiprUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserLoginRequests extends FormRequest
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
        $user_table_its_name = SiprUser::TABLE_NAME;
        $username_column_its_name = SiprUser::COLUMN_USERNAME_ITS_NAME;

        return [
            "username" => ["required", "exists:$user_table_its_name,$username_column_its_name"],
            "password" => ["required"]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errorMessage = $validator->getMessageBag();

        $error_username_message = $errorMessage->get("username")[0] ?? null;
        $error_password_message = $errorMessage->get("password")[0] ?? null;

        throw new HttpResponseException(response(
            view("account.auth.login")
                ->with("errorUsernameInput", $error_username_message)
                ->with("errorPasswordInput", $error_password_message)
            ,
            400
        ));
    }

    public function messages()
    {
        return [
            "username.required" => "Username or password is wrong.",
            "username.exists" => "Username or password is wrong.",
            "password.required" => "Username or password is wrong.",
        ];
    }
}
