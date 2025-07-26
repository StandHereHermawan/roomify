<?php

namespace App\Domains\User\Request;

use App\Domains\User\Model\SiprSession;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UserAddPhoneNumberRequests extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // 
        // $session_id = $this->session()->getId();
        // $session_model = SiprSession::select()
        //     ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id)
        //     ->first();
        // 
        // if ($session_model !== null) {
        //     # code...
        //     return $session_model->user_id !== null;
        // }
        // 

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $phone_number_table_name = \App\Domains\User\Model\SiprPhoneNumber::TABLE_NAME;
        $phone_number_column_name = \App\Domains\User\Model\SiprPhoneNumber::COLUMN_PHONE_NUMBER_ITS_NAME;

        return [
            "new-phone-number" => [
                'required',
                "unique:{$phone_number_table_name},{$phone_number_column_name}",
                "regex:^\+(?:[0-9][0-9]?)-\d{3}-\d{4}-\d+^"
            ]
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $session_id = $this->session->getId();
        $cookie_value = $this->cookie(config('session.cookie'));

        Log::debug(
            'class: UserAddPhoneNumberRequests | method: failedValidation | session_id: {session_id} and cookie_value: {cookie}.',
            ["session_id" => $session_id ?? null, "cookie" => $cookie_value]
        );

        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id)
            ->with('ownedByUser')
            ->first();

        if ($session_model === null) {
            Log::debug(
                'class: UserAddPhoneNumberRequests | method: failedValidation | session_id: {session_id} not registered in database.',
                ["session_id" => $session_id ?? null]
            );

            # code...
            $cookie_value = decrypt($cookie_value, false);
            Log::debug(
                'class: UserAddPhoneNumberRequests | method: failedValidation | decrypted cookie_value: {cookie}, with cookie_value length: {cookie_length}.',
                ["cookie" => $cookie_value, "cookie_length" => strlen($cookie_value),]
            );

            list($hmac, $session_id_from_cookie) = explode('|', $cookie_value);
            $session_id = $session_id_from_cookie;
        
            Log::debug(
                'class: UserAddPhoneNumberRequests | method: failedValidation | checking session_id_from_cookie: {session_id} state in database.',
                ["session_id" => $session_id_from_cookie ?? null]
            );

            $session_model = SiprSession::select()
                ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id)
                ->with('ownedByUser')
                ->first();
        }

        if ($session_model !== null) {
            Log::debug(
                'class: UserAddPhoneNumberRequests | method: failedValidation | session_id: {session_id} from cookie are exist in database.',
                ["session_id" => $session_id ?? null]
            );

            $username = $session_model->ownedByUser()->first()->getUsername();
        }

        $message = $validator->getMessageBag()->get('new-phone-number')[0];

        throw new \Illuminate\Http\Exceptions\HttpResponseException(response(
            view("account.management.phone.add")
                ->with('error_new_phone_number_input', $message)
                ->with('username', $username),
            422
        ));
    }

    public function messages()
    {
        $phone_number = $this->input("new-phone-number");

        return [
            "new-phone-number.unique" => "Nomor $phone_number sudah ada yang memiliki. coba nomor hp yang lain.",
            "new-phone-number.required" => "Input nomor telpon baru tidak boleh kosong.",
            "new-phone-number.regex" => "Format nomor telpon baru tidak valid.",
        ];
    }
}
