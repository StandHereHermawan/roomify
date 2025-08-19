<?php

namespace App\Http\Requests\PhoneNumbers;

use App\Domains\User\Model\SiprPhoneNumber;
use App\Domains\User\Model\SiprUserHasPhoneNumber;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DeletePhoneNumberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        Log::debug(
            sprintf('[class: %s] | [method: %s] | called.', static::class, __FUNCTION__)
        );

        $user_model = Auth::user();
        $old_email = $this->input('old-phone-number');
        $email_id = null;

        Log::debug(
            'class: DeletePhoneNumberRequest | method: authorize | Phone number to be deleted {email}.',
            ["email" => $old_email]
        );

        $email_model = SiprPhoneNumber::select()
            ->where(SiprPhoneNumber::PHONE_NUMBER, '=', $old_email)
            ->first();

        if ($email_model !== null) {
            Log::debug(
                'class: DeletePhoneNumberRequest | method: authorize | Phone number: {email} exist on database.',
                ["email" => $old_email]
            );

            $email_id = $email_model->getId();
        }

        if ($user_model !== null) {
            Log::debug(
                'class: DeletePhoneNumberRequest | method: authorize | Attempt to check is user are owner of the email.',
                ["email" => $old_email]
            );

            $user_has_email = SiprUserHasPhoneNumber::select()
                ->where(SiprUserHasPhoneNumber::COLUMN_PHONE_NUMBER_ID_ITS_NAME, '=', $email_id)
                ->first();

            return $user_model->getId() === $user_has_email->getUserId();
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        Log::debug(
            sprintf('[class: %s] | [method: %s] | called.', static::class, __FUNCTION__)
        );

        $email_table_name = SiprPhoneNumber::TABLE_NAME;
        $email_column_name = SiprPhoneNumber::PHONE_NUMBER;
        return [
            "old-phone-number" => ['required', "exists:{$email_table_name},{$email_column_name}", "regex:^\+(?:[0-9][0-9]?)-\d{3}-\d{4}-\d+^", "max:20"]
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        Log::debug(
            sprintf('[class: %s] | [method: %s] | called.', static::class, __FUNCTION__)
        );

        $username = null;
        $user_model = Auth::user();

        if ($user_model !== null) {
            $username = $user_model->getUsername();
            Log::debug(
                'class: DeletePhoneNumberRequest | method: failedValidation | User authenticated in this request: {username} with id: {id}.',
                ["username" => $username, "id" => $user_model->getId()]
            );

            $message = $validator->getMessageBag()->get('old-phone-number')[0];
            throw new \Illuminate\Http\Exceptions\HttpResponseException(response(
                view("account.management.phone.edit")
                    ->with('$error_updated_phone_number_input', $message)
                    ->with('username', $username),
                422
            ));
        }

        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response(redirect(route('login')), 401)
        );
    }

    public function messages()
    {
        Log::debug(
            sprintf('[class: %s] | [method: %s] | called.', static::class, __FUNCTION__)
        );

        $phone_number = $this->input("old-phone-number");

        return [
            "old-phone-number.exists" => "Nomor $phone_number tidak terdaftar.",
            "old-phone-number.required" => "Input nomor telpon tidak boleh kosong.",
            "old-phone-number.regex" => "Format nomor telpon tidak valid.",
            "old-phone-number.max" => "Format nomor telpon tidak bisa lebih panjang dari 20 karakter.",
        ];
    }
}
