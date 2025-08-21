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
            SiprRoom::NAME => $this->input('nama-ruangan'),
            SiprRoom::CODE => $this->input('kode-ruangan'),
            SiprRoom::FLOOR_WIDE => $this->input('luas-ruangan'),
            SiprRoom::HEIGHT => $this->input('tinggi-ruangan'),
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
            SiprRoom::NAME => [
                'required'
            ],
            SiprRoom::CODE => [
                'required',
                "unique:" . SiprRoom::TABLE_NAME . "," . SiprRoom::CODE
            ],
            SiprRoom::HEIGHT => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^\d+(\.\d+)?$/', $value)) {
                        $fail('Nilai harus menggunakan titik (.) sebagai pemisah desimal. Contoh 3.5.');
                    }
                },
            ],
            SiprRoom::FLOOR_WIDE => [
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
        $room_code = $this->input(SiprRoom::CODE);
        return [
            SiprRoom::NAME . ".required" => "nama ruangan tidak boleh kosong.",
            SiprRoom::CODE . ".required" => "kode ruangan tidak boleh kosong.",
            SiprRoom::HEIGHT . ".required" => "tinggi ruangan tidak boleh kosong.",
            SiprRoom::FLOOR_WIDE . ".required" => "luas ruangan tidak boleh kosong.",
            SiprRoom::CODE . ".unique" => "kode ruangan $room_code sudah tersedia, silahkan input kode ruangan yang lain.",
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
            if ($validator->errors()->has(SiprRoom::NAME)) {
                $errorMessage = $validator->errors()->first(SiprRoom::NAME);
                $validator->errors()->add('nama-ruangan', $errorMessage);
                $validator->errors()->forget(SiprRoomSession::SESSION_START);
            }

            if ($validator->errors()->has(SiprRoom::CODE)) {
                $errorMessage = $validator->errors()->first(SiprRoom::CODE);
                $validator->errors()->add('kode-ruangan', $errorMessage);
                $validator->errors()->forget(SiprRoom::CODE);
            }

            if ($validator->errors()->has(SiprRoom::FLOOR_WIDE)) {
                $errorMessage = $validator->errors()->first(SiprRoom::FLOOR_WIDE);
                $validator->errors()->add('luas-ruangan', $errorMessage);
                $validator->errors()->forget(SiprRoom::FLOOR_WIDE);
            }

            if ($validator->errors()->has(SiprRoom::HEIGHT)) {
                $errorMessage = $validator->errors()->first(SiprRoom::HEIGHT);
                $validator->errors()->add('tinggi-ruangan', $errorMessage);
                $validator->errors()->forget(SiprRoom::HEIGHT);
            }
        });

        // $this->logDebugFinish(__FUNCTION__, [], $millis_start);
    }
}
