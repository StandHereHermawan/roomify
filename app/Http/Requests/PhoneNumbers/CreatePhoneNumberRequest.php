<?php

namespace App\Http\Requests\PhoneNumbers;

use App\Domains\User\Model\SiprPhoneNumber;
use App\Traits\Logs\CustomLogger;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CreatePhoneNumberRequest extends FormRequest
{
    use CustomLogger;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // $this->logDebugStart(__FUNCTION__);
        // $millis_start = microtime(true);

        // $this->logDebugFinish(__FUNCTION__, [], $millis_start);
        return Auth::user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // $this->logDebugStart(__FUNCTION__);
        // $millis_start = microtime(true);

        // $this->logDebugFinish(__FUNCTION__, [], $millis_start);
        return [
            "new-phone-number" => [
                'required',
                "unique:" . SiprPhoneNumber::TABLE_NAME . "," . SiprPhoneNumber::PHONE_NUMBER,
                "regex:^\+(?:[0-9][0-9]?)-\d{3}-\d{4}-\d+^",
                'max:20'
            ]
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // $this->logDebugStart(__FUNCTION__);
        // $millis_start = microtime(true);


        $username = null;
        $user_model = Auth::user();

        if ($user_model !== null) {
            $username = $user_model->getUsername();
            $message = $validator->getMessageBag()->get('new-phone-number')[0];
            // $this->logDebugFinish(__FUNCTION__, [], $millis_start);
            throw new \Illuminate\Http\Exceptions\HttpResponseException(response(
                view("account.management.phone.add")
                    ->with('error_new_phone_number_input', $message)
                    ->with('username', $username)
                ,
                422
            ));
        }

        // $this->logDebugFinish(__FUNCTION__, [], $millis_start);
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response(redirect(route('login')), 401)
        );
    }

    public function messages()
    {
        // $this->logDebugStart(__FUNCTION__);
        // $millis_start = microtime(true);

        $phone_number = $this->input("new-phone-number");
        
        // $this->logDebugFinish(__FUNCTION__, [], $millis_start);
        return [
            "new-phone-number.unique" => "Nomor $phone_number sudah ada yang memiliki. coba nomor hp yang lain.",
            "new-phone-number.required" => "Input nomor telpon baru tidak boleh kosong.",
            "new-phone-number.regex" => "Format nomor telpon baru tidak valid.",
            "new-phone-number.max" => "Format nomor telpon baru tidak bisa lebih panjang dari 20 karakter.",
        ];
    }
}
