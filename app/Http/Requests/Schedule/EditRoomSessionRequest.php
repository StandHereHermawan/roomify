<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

use App\Traits\Logs\CustomLogger;
use App\Domains\Room\Model\SiprRoomSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EditRoomSessionRequest extends FormRequest
{
    use CustomLogger;

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // $this->logDebugStart(__FUNCTION__);
        // $millis_start = microtime(true);

        $record = $this->route('model');

        $updated_session_start = $this->input('updated-room-session-start');
        $updated_session_end = $this->input('updated-room-session-end');

        if ($updated_session_start === null || $updated_session_start === $record->getRoomSessionStart()) {
            $updated_session_start = $record->getRoomSessionStart();
        }

        if ($updated_session_end === null || $updated_session_end === $record->getRoomSessionStart()) {
            $updated_session_end = $record->getRoomSessionStart();
        }

        // $this->logDebugFinish(__FUNCTION__, [], $millis_start);
        $this->merge([
            SiprRoomSession::SESSION_START => $updated_session_start,
            SiprRoomSession::SESSION_END => $updated_session_end,
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // $this->logDebugStart(__FUNCTION__);
        // $millis_start = microtime(true);
        // 
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
        // 
        // $this->logDebugFinish(__FUNCTION__, [], $millis_start);
        return [
            SiprRoomSession::SESSION_START => [
                'required_without_all:' . SiprRoomSession::SESSION_START . ',' . SiprRoomSession::SESSION_END,
             // "unique:" . SiprRoomSession::TABLE_NAME . "," . SiprRoomSession::SESSION_START,
                "unique:" . SiprRoomSession::TABLE_NAME . "," . SiprRoomSession::SESSION_END,
                "different:room-session-end",
                "before:" . SiprRoomSession::SESSION_END
            ],
            SiprRoomSession::SESSION_END => [
                'required_without_all:' . SiprRoomSession::SESSION_START . ',' . SiprRoomSession::SESSION_END,
                "unique:" . SiprRoomSession::TABLE_NAME . "," . SiprRoomSession::SESSION_START,
                // "unique:" . SiprRoomSession::TABLE_NAME . "," . SiprRoomSession::SESSION_END,
                "different:room-session-end",
            ],
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
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $this->logDebugStart(__FUNCTION__);
        $millis_start = microtime(true);

        $exception = $validator->getException();

        $this->logDebugFinish(__FUNCTION__, [], $millis_start);
        throw (new $exception($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }

    /**
     * Konfigurasi instance validator.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(\Illuminate\Validation\Validator $validator): void
    {
        $this->logDebugStart(__FUNCTION__);
        $millis_start = microtime(true);

        // === Method 'after' called AFTER validation finished. ===
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

        $this->logDebugFinish(__FUNCTION__, [], $millis_start);
    }
}
