<?php

namespace App\Domains\User\Request;

use App\Domains\User\Model\SiprSession;
use App\Domains\User\Model\SiprUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class UserAddPhoneNumberRequests extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        Log::debug('class: UserAddPhoneNumberRequests | method: authorize | called.');
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
        Log::debug('class: UserAddPhoneNumberRequests | method: rules | called.');

        $phone_number_table_name = \App\Domains\User\Model\SiprPhoneNumber::TABLE_NAME;
        $phone_number_column_name = \App\Domains\User\Model\SiprPhoneNumber::COLUMN_PHONE_NUMBER_ITS_NAME;

        return [
            "new-phone-number" => [
                'required',
                "unique:{$phone_number_table_name},{$phone_number_column_name}",
                "regex:^\+(?:[0-9][0-9]?)-\d{3}-\d{4}-\d+^",
                'max:20'
            ]
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        Log::debug('class: UserAddPhoneNumberRequests | method: failedValidation | called.');

        $user_id = null;
        $username = null;
        $decrypted_cookie = null;
        $user_model = null;
        $session_id_from_cookie = null;

        $cookie_value = Cookie::get(config('session.cookie'));

        Log::debug(
            'class: UserAddPhoneNumberRequests | method: failedValidation | retrieved cookie with length: {len} from request, its value: {cookie}.',
            ["cookie" => $cookie_value ?? null, "len" => strlen($cookie_value)]
        );

        if (strlen($cookie_value) >= 41) {
            Log::debug('class: UserAddPhoneNumberRequests | method: failedValidation | the cookie_value length is more than 40.');
            Log::debug('class: UserAddPhoneNumberRequests | method: failedValidation | assuming cookie_value is encrypted caused by its length more than 40.');
            Log::debug('class: UserAddPhoneNumberRequests | method: failedValidation | attempt to decrypt cookie_value.');

            $decrypted_cookie = decrypt($cookie_value, false);

            Log::debug('class: UserAddPhoneNumberRequests | method: failedValidation | decrypted cookie_value: {cookie}.', ["cookie" => $decrypted_cookie]);
            Log::debug('class: UserAddPhoneNumberRequests | method: failedValidation | decrypted cookie_value its length: {cookie_length}.', ["cookie_length" => strlen($decrypted_cookie)]);
            Log::debug('class: UserAddPhoneNumberRequests | method: failedValidation | attempt to retrieve session_id from decrypted cookie value.');

            list($hmac, $session_id_from_decrypted_cookie) = explode('|', $decrypted_cookie);

            Log::debug('class: UserAddPhoneNumberRequests | method: failedValidation | retrieved from decrypted cookie session_id: {from_cookie}.', ["from_cookie" => $session_id_from_decrypted_cookie]);
            Log::debug('class: UserAddPhoneNumberRequests | method: failedValidation | retrieved from decrypted cookie hmac: {hmac}.', ["hmac" => $hmac]);
            Log::debug('class: UserAddPhoneNumberRequests | method: failedValidation | attempt to check session_id from decrypted cookie value state in database.');

            $session_id_from_cookie = $session_id_from_decrypted_cookie;
        }

        if (strlen($cookie_value) <= 40) {
            Log::debug('class: UserAddPhoneNumberRequests | method: failedValidation | the cookie_value length is doesnt beyond than 40.');
            Log::debug('class: UserAddPhoneNumberRequests | method: failedValidation | assuming cookie_value is not encrypted caused by its doesnt beyond than 40.');
            Log::debug('class: UserAddPhoneNumberRequests | method: failedValidation | attempt to check not encrypted cookie_value state in database.');

            $session_id_from_cookie = $cookie_value;
        }

        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id_from_cookie)
            ->first();

        if ($session_model !== null) {
            Log::debug('class: UserAddPhoneNumberRequests | method: failedValidation | session_id: {session_id} was exist in database.', ["session_id" => $session_id_from_cookie]);
            $user_id = $session_model->getUserId();
        }

        if ($user_id !== null) {
            Log::debug('class: UserAddPhoneNumberRequests | method: failedValidation | session_id: {session_id} was owned by user with id: {id}.', ["session_id" => $session_id_from_cookie, "id" => $user_id]);
            $user_model = SiprUser::select()
                ->where(SiprUser::COLUMN_ID_ITS_NAME, '=', $user_id)
                ->first();
        }

        if ($user_model !== null) {
            $username = $user_model->getUsername();
            $message = $validator->getMessageBag()->get('new-phone-number')[0];
            throw new \Illuminate\Http\Exceptions\HttpResponseException(response(
                view("account.management.phone.add")
                    ->with('error_new_phone_number_input', $message)
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
        Log::debug('class: UserAddPhoneNumberRequests | method: messages | called.');

        $phone_number = $this->input("new-phone-number");

        return [
            "new-phone-number.unique" => "Nomor $phone_number sudah ada yang memiliki. coba nomor hp yang lain.",
            "new-phone-number.required" => "Input nomor telpon baru tidak boleh kosong.",
            "new-phone-number.regex" => "Format nomor telpon baru tidak valid.",
            "new-phone-number.max" => "Format nomor telpon baru tidak bisa lebih panjang dari 20 karakter.",
        ];
    }
}
