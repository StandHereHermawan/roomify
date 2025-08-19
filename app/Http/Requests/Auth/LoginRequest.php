<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

use App\Traits\Logs\CustomLogger;
use App\Domains\User\Model\SiprUser;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginRequest extends FormRequest
{
    use CustomLogger;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);

        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
        return Auth::user() === null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);

        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
        return [
            "username" => ["required", "exists:" . SiprUser::TABLE_NAME . "," . SiprUser::USERNAME],
            "password" => ["required"]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);

        $errorMessage = $validator->getMessageBag();

        $error_username_message = $errorMessage->get("username")[0] ?? null;
        $error_password_message = $errorMessage->get("password")[0] ?? null;

        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
        throw new HttpResponseException(response(
            view("account.auth.login")
                ->with("errorUsernameInput", $error_username_message)
                ->with("errorPasswordInput", $error_password_message),
            400
        ));
    }

    public function messages()
    {
        // $this->logDebugStart(__FUNCTION__, []);
        // $millis_start = microtime(true);
        
        // $this->logInfoFinish(__FUNCTION__, [], $millis_start);
        return [
            "username.required" => "Username or password is wrong.",
            "username.exists" => "Username or password is wrong.",
            "password.required" => "Username or password is wrong.",
        ];
    }
}
