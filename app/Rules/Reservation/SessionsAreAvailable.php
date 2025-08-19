<?php

namespace App\Rules\Reservation;

use App\Domains\Schedule\Model\SiprRoomSessionReservationRequest;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SessionsAreAvailable implements ValidationRule
{
    /**
     * ID ruangan yang akan divalidasi.
     *
     * @var int
     */
    protected $roomId;

    /**
     * Tanggal reservasi yang akan divalidasi.
     *
     * @var string
     */
    protected $reservationDate;

    /**
     * Menyimpan detail sesi yang bentrok untuk pesan error.
     *
     * @var mixed
     */
    protected $conflictingReservation = null;

    /**
     * Buat instance rule baru.
     *
     * @param  int|null  $roomId
     * @param  string|null  $reservationDate
     * @return void
     */
    public function __construct($roomId, $reservationDate)
    {
        $this->roomId = $roomId;
        $this->reservationDate = $reservationDate;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // $value di sini adalah array berisi ID sesi dari input
        $sessionIdsFromInput = $value;

        // Cari reservasi yang sudah ada untuk ruangan dan tanggal yang sama,
        // yang memiliki salah satu sesi yang dipilih oleh pengguna.
        $conflict = SiprRoomSessionReservationRequest::whereHas('roomReservation', function ($query) {
                $query->where('room_id', $this->roomId)
                      ->where('reservation_date', $this->reservationDate);
            })
            ->whereIn('room_session_id', $sessionIdsFromInput)
            ->with('roomSession') // Eager load untuk pesan error yang lebih baik
            ->first();

        // Jika ditemukan konflik, simpan datanya dan gagalkan validasi.
        if ($conflict) {
            $this->conflictingReservation = $conflict;
            $fail('Salah satu sesi yang Anda pilih sudah dipesan.');
        }
    }

    /**
     * Dapatkan pesan error validasi.
     *
     * @return string
     */
    public function message()
    {
        if ($this->conflictingReservation) {
            $session = $this->conflictingReservation->roomSession;
            return "Sesi pada jam {$session->room_session_start} - {$session->room_session_end} sudah dipesan.";
        }

        return 'Salah satu sesi yang Anda pilih tidak tersedia.';
    }
}
