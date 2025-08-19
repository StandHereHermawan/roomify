<?php

namespace App\Http\Requests\Emails;

use Illuminate\Foundation\Http\FormRequest;

use App\Traits\Logs\CustomLogger;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AddEmailRequest extends FormRequest
{
    use CustomLogger;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Log::debug(
            // sprintf(
                // '[class: %s] | [method: %s] | called.',
                // static::class,
                // __FUNCTION__
            // )
        // );

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Log::debug(
            // sprintf(
                // '[class: %s] | [method: %s] | called.',
                // static::class,
                // __FUNCTION__
            // )
        // );

        $email_table_name = \App\Domains\User\Model\SiprSecondaryEmail::TABLE_NAME;
        $email_column_name = \App\Domains\User\Model\SiprSecondaryEmail::EMAIL;

        return [
            "new-email" => ['required', "unique:{$email_table_name},{$email_column_name}", "email", "max:255"]
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // Log::debug(
            // sprintf(
                // '[class: %s] | [method: %s] | called.',
                // static::class,
                // __FUNCTION__
            // )
        // );

        $username = null;
        $user_model = Auth::user();

        if ($user_model !== null) {
            $username = $user_model->getUsername();
            // Log::debug(
                // 'class: UserAddEmailRequests | method: failedValidation | User authenticated right now: {username} with id: {id}.',
                // ["username" => $username, "id" => $user_model->getId()]
            // );

            $message = $validator->getMessageBag()->get('new-email')[0];
            throw new \Illuminate\Http\Exceptions\HttpResponseException(response(
                view("account.management.email.add")
                    ->with('error_new_email_input', $message)
                    ->with('username', $username)
                ,
                422
            ));
        }

        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response(redirect(route('login')), 401)
        );
    }

    public function messages()
    {
        // Log::debug(
            // sprintf(
                // '[class: %s] | [method: %s] | called.',
                // static::class,
                // __FUNCTION__
            // )
        // );

        $phone_number = $this->input("new-email");

        return [
            "new-email.unique" => "Email $phone_number sudah ada yang memiliki. coba email yang lain.",
            "new-email.required" => "Input email tidak boleh kosong.",
            "new-email.email" => "Format email tidak valid.",
            "new-email.max" => "Format email tidak bisa lebih panjang dari 255 karakter.",
        ];
    }
}
