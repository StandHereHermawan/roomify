<?php

namespace App\Http\Requests\Room;

use App\Domains\Room\Model\SiprRoom;
use App\Domains\Room\Model\SiprRoomSession;
use Illuminate\Foundation\Http\FormRequest;

use App\Traits\Logs\CustomLogger;
use Illuminate\Support\Facades\Auth;

class CreateRoomRequest extends FormRequest
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
            SiprRoom::COLUMN_ROOM_NAME_ITS_NAME => $this->input('nama-ruangan'),
            SiprRoom::COLUMN_ROOM_CODE_ITS_NAME => $this->input('kode-ruangan'),
            SiprRoom::COLUMN_ROOM_FLOOR_WIDE_ITS_NAME => $this->input('luas-ruangan'),
            SiprRoom::COLUMN_ROOM_HEIGHT_ITS_NAME => $this->input('tinggi-ruangan'),
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            SiprRoom::COLUMN_ROOM_NAME_ITS_NAME => [
                'required'
            ],
            SiprRoom::COLUMN_ROOM_CODE_ITS_NAME => [
                'required',
                "unique:" . SiprRoom::TABLE_NAME . "," . SiprRoom::COLUMN_ROOM_CODE_ITS_NAME
            ],
            SiprRoom::COLUMN_ROOM_HEIGHT_ITS_NAME => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^\d+(\.\d+)?$/', $value)) {
                        $fail('Nilai harus menggunakan titik (.) sebagai pemisah desimal. Contoh 3.5.');
                    }
                },
            ],
            SiprRoom::COLUMN_ROOM_FLOOR_WIDE_ITS_NAME => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^\d+(\.\d+)?$/', $value)) {
                        $fail('Nilai harus menggunakan titik (.) sebagai pemisah desimal. Contoh 3.5.');
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        $room_code = $this->input(SiprRoom::COLUMN_ROOM_CODE_ITS_NAME);
        return [
            SiprRoom::COLUMN_ROOM_NAME_ITS_NAME . ".required" => "nama ruangan tidak boleh kosong.",
            SiprRoom::COLUMN_ROOM_CODE_ITS_NAME . ".required" => "kode ruangan tidak boleh kosong.",
            SiprRoom::COLUMN_ROOM_HEIGHT_ITS_NAME . ".required" => "tinggi ruangan tidak boleh kosong.",
            SiprRoom::COLUMN_ROOM_FLOOR_WIDE_ITS_NAME . ".required" => "luas ruangan tidak boleh kosong.",
            SiprRoom::COLUMN_ROOM_CODE_ITS_NAME . ".unique" => "kode ruangan $room_code sudah tersedia, silahkan input kode ruangan yang lain.",
        ];
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
            if ($validator->errors()->has(SiprRoom::COLUMN_ROOM_NAME_ITS_NAME)) {
                $errorMessage = $validator->errors()->first(SiprRoom::COLUMN_ROOM_NAME_ITS_NAME);
                $validator->errors()->add('nama-ruangan', $errorMessage);
                $validator->errors()->forget(SiprRoomSession::SESSION_START);
            }

            if ($validator->errors()->has(SiprRoom::COLUMN_ROOM_CODE_ITS_NAME)) {
                $errorMessage = $validator->errors()->first(SiprRoom::COLUMN_ROOM_CODE_ITS_NAME);
                $validator->errors()->add('kode-ruangan', $errorMessage);
                $validator->errors()->forget(SiprRoom::COLUMN_ROOM_CODE_ITS_NAME);
            }

            if ($validator->errors()->has(SiprRoom::COLUMN_ROOM_FLOOR_WIDE_ITS_NAME)) {
                $errorMessage = $validator->errors()->first(SiprRoom::COLUMN_ROOM_FLOOR_WIDE_ITS_NAME);
                $validator->errors()->add('luas-ruangan', $errorMessage);
                $validator->errors()->forget(SiprRoom::COLUMN_ROOM_FLOOR_WIDE_ITS_NAME);
            }

            if ($validator->errors()->has(SiprRoom::COLUMN_ROOM_HEIGHT_ITS_NAME)) {
                $errorMessage = $validator->errors()->first(SiprRoom::COLUMN_ROOM_HEIGHT_ITS_NAME);
                $validator->errors()->add('tinggi-ruangan', $errorMessage);
                $validator->errors()->forget(SiprRoom::COLUMN_ROOM_HEIGHT_ITS_NAME);
            }
        });

        // $this->logDebugFinish(__FUNCTION__, [], $millis_start);
    }
}
