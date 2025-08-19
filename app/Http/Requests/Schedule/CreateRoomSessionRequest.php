<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;
use App\Domains\Room\Model\SiprRoomSession;
use App\Traits\Logs\CustomLogger;
use Illuminate\Support\Facades\Auth;

class CreateRoomSessionRequest extends FormRequest
{
    use CustomLogger;

    /**
     * === Prepare the data for validation. ===
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            SiprRoomSession::SESSION_START => $this->input('room-session-start'),
            SiprRoomSession::SESSION_END => $this->input('room-session-end'),
        ]);
    }

    /**
     * === Determine if the user is authorized to make this request. ===
     */
    public function authorize(): bool
    {
        return Auth::user() !== null;
    }

    /**
     * === Get the validation rules that apply to the request. ===
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // $this->logDebugStart(__FUNCTION__);
        // $millis_start = microtime(true);
        // 
        // $this->logDebugFinish(__FUNCTION__, [], $millis_start);
        return [
            SiprRoomSession::SESSION_START => [
                'required',
                "unique:" . SiprRoomSession::TABLE_NAME . "," . SiprRoomSession::SESSION_START,
                "unique:" . SiprRoomSession::TABLE_NAME . "," . SiprRoomSession::SESSION_END,
                "before:" . SiprRoomSession::SESSION_END,
                "different:" . SiprRoomSession::SESSION_END,
                "before:" . SiprRoomSession::SESSION_END
            ],
            SiprRoomSession::SESSION_END => [
                'required',
                "unique:" . SiprRoomSession::TABLE_NAME . "," . SiprRoomSession::SESSION_START,
                "unique:" . SiprRoomSession::TABLE_NAME . "," . SiprRoomSession::SESSION_END,
                "different:" . SiprRoomSession::SESSION_START,
            ],
        ];
    }

    /**
     * === Handle a failed validation attempt. ===
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // $this->logDebugStart(__FUNCTION__);
        // $millis_start = microtime(true);

        $exception = $validator->getException();

        // $this->logDebugFinish(__FUNCTION__, [], $millis_start);
        throw (new $exception($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }

    /**
     * === Konfigurasi instance validator. ===
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(\Illuminate\Validation\Validator $validator): void
    {
        // $this->logDebugStart(__FUNCTION__);
        // $millis_start = microtime(true);

        /**
         * === Method 'after' called AFTER validation finished. ===
         * 
         */
        $validator->after(function ($validator) {
            if ($validator->errors()->has(SiprRoomSession::SESSION_START)) {
                $errorMessage = $validator->errors()->first(SiprRoomSession::SESSION_START);
                $validator->errors()->add('updated-room-session-start', $errorMessage);
                $validator->errors()->forget(SiprRoomSession::SESSION_START);
            }

            if ($validator->errors()->has(SiprRoomSession::SESSION_END)) {
                $errorMessage = $validator->errors()->first(SiprRoomSession::SESSION_END);
                $validator->errors()->add('updated-room-session-end', $errorMessage);
                $validator->errors()->forget(SiprRoomSession::SESSION_END);
            }
        });

        // $this->logDebugFinish(__FUNCTION__, [], $millis_start);
    }
}
