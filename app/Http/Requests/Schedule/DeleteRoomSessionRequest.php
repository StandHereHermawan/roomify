<?php

namespace App\Http\Requests\Schedule;

use App\Domains\Room\Model\SiprRoomSession;
use Illuminate\Foundation\Http\FormRequest;

class DeleteRoomSessionRequest extends FormRequest
{
    /**
     * === Prepare the data for validation. ===
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            SiprRoomSession::ID => $this->route('model')->getId(),
        ]);
    }

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
        return [
            SiprRoomSession::ID => [
                'required',
                "exists:" . SiprRoomSession::TABLE_NAME . "," . SiprRoomSession::ID,
            ]
        ];
    }
}
