<?php

namespace App\Http\Requests\Emails;

use Illuminate\Foundation\Http\FormRequest;

use App\Domains\User\Model\SiprSecondaryEmail;
use App\Domains\User\Model\SiprUserHasSecondaryEmail;

use App\Traits\Logs\CustomLogger;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DeleteEmailRequest extends FormRequest
{
    use CustomLogger;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // $this->logDebugStart(__FUNCTION__);
        // $millis_start = microtime(true);

        $user_model = Auth::user();
        $old_email = $this->input('old-email');

        $email_model = SiprSecondaryEmail::select()
            ->where(SiprSecondaryEmail::EMAIL, '=', $old_email)
            ->first();

        if ($user_model === null) {
            return false;
        }

        if ($email_model === null) {
            return true;
        }

        $user_id = $user_model->getId();
        $email_id = $email_model->getId();

        
        $user_has_email_model = SiprUserHasSecondaryEmail::select()
        ->where(SiprUserHasSecondaryEmail::EMAIL_ID, '=', $email_id)
        ->first();
        
        if ($user_has_email_model === null) {
            $log_context = [
                "user_id" => $user_id,
                "email_id" => $email_id,
            ];
            // $this->logDebugMessage(
                // __FUNCTION__,
                // "Owner of email with id: {email_id} is not found.",
                // $log_context
            // );

            return false;
        }

        // $this->logDebugFinish(__FUNCTION__, [], $millis_start);
        return $user_id === $user_has_email_model->getUserId();
        ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "old-email" => ['required', "exists:" . SiprSecondaryEmail::TABLE_NAME . "," . SiprSecondaryEmail::EMAIL, "email", "max:255"]
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $username = null;
        $user_model = Auth::user();

        if ($user_model !== null) {
            $username = $user_model->getUsername();
            $message = $validator->getMessageBag()->get('old-email')[0];

            throw new \Illuminate\Http\Exceptions\HttpResponseException(response(
                view("account.management.email.edit")
                    ->with('error_updated_email_input', $message)
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
        return [
            "old-email.exists" => "Email tidak ada di catatan kami.",
            "old-email.required" => "Input email tidak boleh kosong.",
            "old-email.email" => "Format email tidak valid.",
            "old-email.max" => "Format email tidak bisa lebih panjang dari 255 karakter.",
        ];
    }
}
