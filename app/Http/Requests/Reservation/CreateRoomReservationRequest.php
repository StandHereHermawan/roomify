<?php

namespace App\Http\Requests\Reservation;

use Illuminate\Foundation\Http\FormRequest;

use App\Domains\Room\Model\SiprRoom;
use App\Domains\Room\Model\SiprRoomSession;

use App\Rules\Reservation\SessionsAreAvailable;

use Illuminate\Support\Facades\Auth;

class CreateRoomReservationRequest extends FormRequest
{
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
            "room_id" => [
                'required',
                'integer',
                'exists:' . SiprRoom::TABLE_NAME . ',' . SiprRoom::ID
            ],
            "date_room_reservation" => [
                'required', 'date',
            ],
            'session' => [
                'required',
                'array',
                'min:1',
                // Gunakan custom rule di sini.
                // Kita teruskan room_id dan tanggal dari input ke dalam rule.
                new SessionsAreAvailable($this->input('room_id'), $this->input('date_room_reservation'))
            ],
            "session.*" => [
                'required',
                'integer',
                'exists:' . SiprRoomSession::TABLE_NAME . ',' . SiprRoomSession::ID
            ],
        ];
    }

    /**
     * Custom message untuk validasi bawaan.
     */
    public function messages(): array
    {
        return [
            'room_id.required' => 'Pilih ruangan yang tersedia.',
            'session.required' => 'Pilih sesi yang tersedia.',
            'session.min' => 'Anda harus memilih minimal satu sesi.',
        ];
    }
}
