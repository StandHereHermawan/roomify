<?php

namespace App\Domains\Schedule\Controller;

use App\Domains\Room\Model\SiprRoom;
use App\Domains\Room\Model\SiprRoomSession;
use App\Domains\Schedule\Model\SiprRoomReservationRequest;
use App\Domains\Schedule\Model\SiprRoomSessionReservationRequest;
use App\Domains\User\Model\SiprSession;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoomReservationController extends Controller
{
    public function listOfAllRoomReservationRequest(Request $request)
    {
        Log::debug("Controller: RoomReservationController | method: listOfAllRoomReservationRequest | called.");

        $input = $request->only(["room_paginate_size"]);
        $room_paginate_size = $input["room_paginate_size"] ?? 10;

        $room_reservation_pending_pagination = SiprRoomReservationRequest::select()
            ->with('userRequest')
            ->with('roomReserved')
            ->with('sessionBorrowed')
            
            ->where(SiprRoomReservationRequest::COLUMN_STATUS_ITS_NAME, '=', "PENDING")
            ->paginate($room_paginate_size, ['*'], 'reservation_pending_page')
            ->withQueryString();

        $room_reservation_accepted_pagination = SiprRoomReservationRequest::select()
            ->with('userRequest')
            ->with('roomReserved')
            ->with('sessionBorrowed')
            ->where(SiprRoomReservationRequest::COLUMN_STATUS_ITS_NAME, '=', "ACCEPTED")
            ->paginate($room_paginate_size, ['*'], 'reservation_accepted_page')
            ->withQueryString();

        $room_reservation_rejected_pagination = SiprRoomReservationRequest::select()
            ->with('userRequest')
            ->with('roomReserved')
            ->with('sessionBorrowed')
            ->where(SiprRoomReservationRequest::COLUMN_STATUS_ITS_NAME, '=', "REJECTED")
            ->paginate($room_paginate_size, ['*'], 'reservation_rejected_page')
            ->withQueryString();

        return view('room.reservation.request.all.list')
            ->with('list_of_room_reservation_request_pending', $room_reservation_pending_pagination)
            ->with('list_of_room_reservation_request_accepted', $room_reservation_accepted_pagination)
            ->with('list_of_room_reservation_request_rejected', $room_reservation_rejected_pagination)
            ;
    }

    public function listOfMyRoomReservationRequest(Request $request)
    {
        $input = $request->only(["room_paginate_size"]);
        $room_paginate_size = $input["room_paginate_size"] ?? 10;

        $user_id = null;
        $session_id = $request->session()->getId();

        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id)
            ->first();

        if ($session_model !== null) {
            $user_id = $session_model->user_id;
        }

        if ($user_id === null) {
            return redirect(route('login'));
        }

        $room_reservation_model = SiprRoomReservationRequest::select()
            ->with('userRequest')
            ->with('roomReserved')
            ->with('sessionBorrowed')
            ->where(SiprRoomReservationRequest::COLUMN_USER_ID_ITS_NAME, '=', $user_id)
            ->paginate($room_paginate_size)
            ->withQueryString();

        return view('room.reservation.request.list.myself')
            ->with('list_of_room_reservation_request', $room_reservation_model);
    }

    public function manageByAdminListOfRoomReservationRequest(Request $request)
    {
        $room_reservation_model_pending = SiprRoomReservationRequest::select()
            ->with('userRequest')
            ->with('roomReserved')
            ->with('sessionBorrowed')
            ->where(SiprRoomReservationRequest::COLUMN_STATUS_ITS_NAME, '=', 'PENDING')
            ->paginate(6, ['*'], 'room_pending_page')
            ->appends($request->query())
            ->withQueryString();

        $room_reservation_model_accepted = SiprRoomReservationRequest::select()
            ->with('userRequest')
            ->with('roomReserved')
            ->with('sessionBorrowed')
            ->where(SiprRoomReservationRequest::COLUMN_STATUS_ITS_NAME, '=', 'ACCEPTED')
            ->paginate(6, ['*'], 'room_accepted_page')
            ->appends($request->query())
            ->withQueryString();

        $room_reservation_model_rejected = SiprRoomReservationRequest::select()
            ->with('userRequest')
            ->with('roomReserved')
            ->with('sessionBorrowed')
            ->where(SiprRoomReservationRequest::COLUMN_STATUS_ITS_NAME, '=', 'REJECTED')
            ->paginate(6, ['*'], 'room_rejected_page')
            ->appends($request->query())
            ->withQueryString();

        return view('room.reservation.request.option.manage')
            ->with('list_of_room_reservation_request_pending', $room_reservation_model_pending)
            ->with('list_of_room_reservation_request_accepted', $room_reservation_model_accepted)
            ->with('list_of_room_reservation_request_rejected', $room_reservation_model_rejected)
        ;
    }

    public function acceptRoomReservationRequest(Request $request)
    {
        $input = $request->only(["room_reservation_id"]);

        $room_reservation_id = $input["room_reservation_id"];
        $room_reservation_model = SiprRoomReservationRequest::select()
            ->where(SiprRoomReservationRequest::COLUMN_ID_ITS_NAME, '=', $room_reservation_id)
            ->first();

        $column_DETERMINED_AT_its_name = SiprRoomReservationRequest::COLUMN_DETERMINED_AT_ITS_NAME;
        $column_STATUS_its_name = SiprRoomReservationRequest::COLUMN_STATUS_ITS_NAME;

        DB::beginTransaction();

        $room_reservation_model->update([
            "{$column_STATUS_its_name}" => "ACCEPTED",
            "{$column_DETERMINED_AT_its_name}" => Carbon::now(),
        ]);

        DB::commit();

        return redirect(route('manage-list-of-room-reservation-request'));
    }

    public function rejectRoomReservationRequest(Request $request)
    {
        $input = $request->only(["room_reservation_id"]);

        $room_reservation_id = $input["room_reservation_id"];
        $room_reservation_model = SiprRoomReservationRequest::select()
            ->where(SiprRoomReservationRequest::COLUMN_ID_ITS_NAME, '=', $room_reservation_id)
            ->first();

        $column_DETERMINED_AT_its_name = SiprRoomReservationRequest::COLUMN_DETERMINED_AT_ITS_NAME;
        $column_STATUS_its_name = SiprRoomReservationRequest::COLUMN_STATUS_ITS_NAME;

        DB::beginTransaction();

        $room_reservation_model->update([
            "{$column_STATUS_its_name}" => "REJECTED",
            "{$column_DETERMINED_AT_its_name}" => Carbon::now(),
        ]);

        DB::commit();

        return redirect(route('manage-list-of-room-reservation-request'));
    }

    public function softDeleteRoomReservationRequest(Request $request)
    {
        $input = $request->only(["room_reservation_id"]);
        var_dump($input);
        var_dump($request->url());
    }

    public function deleteFromDatabaseRoomReservationRequest(Request $request)
    {
        $input = $request->only(["room_reservation_id"]);
        var_dump($input);
        var_dump($request->url());
    }

    public function addRoomReservationForm(Request $request)
    {
        $input = $request->only([
            "search-kode-ruangan"
        ]);

        $room_code = $input["search-kode-ruangan"] ?? "";
        $room_model = null;
        $search_attempt = false;

        if (isset($input["search-kode-ruangan"])) {
            $room_model = SiprRoom::select()
                ->where(SiprRoom::COLUMN_ROOM_CODE_ITS_NAME, '=', $room_code)
                ->first();

            $search_attempt = true;
        }

        $paginated_rooms = SiprRoom::select()
            ->paginate(4, ['*'], 'room_page')
            ->withQueryString()
            ->appends($request->getQueryString());

        $paginated_room_sessions = SiprRoomSession::select()
            ->paginate(6, ['*'], 'room_session_page')
            ->withQueryString()
            ->appends($request->getQueryString());

        if ($room_model === null && $search_attempt === true) {
            $room_not_found_message = "Ruangan dengan kode $room_code belum tersedia";
        }

        return view('room.reservation.request.add')
            ->with('room_pagination', $paginated_rooms)
            ->with('list_of_room_session', $paginated_room_sessions)
            ->with('search_kode_ruangan', $input["search-kode-ruangan"] ?? null)
            ->with('error_room_search_input', $room_not_found_message ?? null)
            ->with('room_model', $room_model);
    }

    /*
    |
    | Fungsi ini bertanggung jawab menambah data tabel 
    | sipr_room_reservation_request dan sipr_room_session_reservation_request.
    | untuk menyimpan informasi reservasi ruangan pada tanggal dan sesi tertentu.
    |
    */
    public function submitAddRoomReservationForm(Request $request)
    {
        $column_room_reservation_table_user_id_name = SiprRoomReservationRequest::COLUMN_USER_ID_ITS_NAME;
        $column_room_reservation_table_room_id_name = SiprRoomReservationRequest::COLUMN_ROOM_ID_ITS_NAME;
        $column_room_reservation_table_reservation_date_name = SiprRoomReservationRequest::COLUMN_RESERVATION_DATE_ITS_NAME;

        $column_room_session_reservation_table_user_id_name = SiprRoomSessionReservationRequest::COLUMN_USER_ID_ITS_NAME;
        $column_room_session_reservation_table_room_reservation_id_name = SiprRoomSessionReservationRequest::COLUMN_ROOM_RESERVATION_ID_ITS_NAME;
        $column_room_session_reservation_table_room_session_id_name = SiprRoomSessionReservationRequest::COLUMN_ROOM_SESSION_ID_ITS_NAME;
        $column_room_session_reservation_table_reservation_date_name = SiprRoomSessionReservationRequest::COLUMN_RESERVATION_DATE_ITS_NAME;

        $session_id = $request->session()->getId();
        $input = $request->only([
            "room_id",
            "date_room_reservation",
            "session"
        ]);

        /*
        |
        |   wajib memilih salah satu sesi yang tersedia di database.
        |
        */
        if (!isset($input['session'])) {
            return $this->addRoomReservationForm($request)
                ->with('error_room_search_input', "Pilih sesi yang tersedia.");
        }

        /*
        |
        |   wajib memilih salah satu ruangan yang tersedia di database.
        |
        */
        if (!isset($input['room_id'])) {
            return $this->addRoomReservationForm($request)
                ->with('error_room_search_input', "Pilih ruangan yang tersedia.");
        }

        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id)
            ->first();

        $user_id = null;
        $room_code = null;
        $room_reservation_id = null;
        $room_session_reservation_collection_from_database = null;

        $room_id = $input["room_id"];
        $room_session_id_collection_from_input = $input["session"];
        $room_reservation_date = $input["date_room_reservation"];

        $formatted_room_reservation_date = Carbon::parse($room_reservation_date)->translatedFormat("d F Y");

        /*
        |
        |   Peminjam ruangan berdasarkan siapa akun pemilik sesi.
        |
        */
        if ($session_model !== null && $session_model->getUserId() !== null) {
            $user_id = $session_model->getUserId();
            Log::debug(
                "Pengguna dengan id: {user_id} hendak meminjam ruangan.",
                ["user_id" => $user_id]
            );
        }

        $room_model = SiprRoom::select()
            ->where(SiprRoom::COLUMN_ID_ITS_NAME, '=', $room_id)
            ->first();

        if ($room_model !== null) {
            $room_code = $room_model->room_code;
            Log::debug(
                "Ruangan dengan kode ruangan: {room_code} akan dipinjam.",
                ["room_code" => $room_code]
            );
        }

        $room_reservation_model = SiprRoomReservationRequest::select()
            ->where(SiprRoomReservationRequest::COLUMN_RESERVATION_DATE_ITS_NAME, '=', $room_reservation_date)
            ->where(SiprRoomReservationRequest::COLUMN_ROOM_ID_ITS_NAME, '=', $room_id)
            ->first();

        if ($room_reservation_model !== null) {
            Log::debug(
                "Pengajuan pinjam ruangan dengan kode ruangan: {room_code} tanggal: {reservation_date} sudah ada.",
                ["user_id" => $user_id, "room_code" => $room_code, "reservation_date" => $formatted_room_reservation_date]
            );

            $room_reservation_id = $room_reservation_model->getId();
            $room_session_reservation_collection_from_database = SiprRoomSessionReservationRequest::select()
                ->where(SiprRoomSessionReservationRequest::COLUMN_RESERVATION_DATE_ITS_NAME, '=', $room_reservation_date)
                ->where(SiprRoomSessionReservationRequest::COLUMN_ROOM_RESERVATION_ID_ITS_NAME, '=', $room_reservation_id)
                ->where(SiprRoomSessionReservationRequest::COLUMN_USER_ID_ITS_NAME, '=', $user_id)
                ->with('userRequest')
                ->with('roomSession')
                ->limit(100)
                ->get();
        }

        /*
        |
        |   validasi input dari user apakah tanggal reservasi dan sesi reservasi sudah ada di database.
        |   jika ada, balikkan response.
        |   Jika ruangan sudah di reservasi di tanggal dan sesi yang sama, beri tahu user.
        |
        */
        if ($room_session_reservation_collection_from_database !== null) {
            foreach ($room_session_id_collection_from_input as $room_session_id_from_input) {
                foreach ($room_session_reservation_collection_from_database as $room_session_reservation_from_database) {

                    $room_session_id_from_database = $room_session_reservation_from_database->room_session_id;
                    if ($room_session_id_from_input == $room_session_id_from_database) {

                        $room_session_start = $room_session_reservation_from_database->roomSession->room_session_start;
                        $room_session_end = $room_session_reservation_from_database->roomSession->room_session_end;
                        $message = "Ruangan $room_code tanggal $formatted_room_reservation_date pada sesi $room_session_start sampai $room_session_end sudah direservasi.";
                        return $this->addRoomReservationForm($request)->with('error_room_search_input', $message);
                    }
                }
            }
        }

        DB::beginTransaction();
        $room_reservation_request_model = SiprRoomReservationRequest::create([
            "{$column_room_reservation_table_user_id_name}" => $user_id,
            "{$column_room_reservation_table_room_id_name}" => $room_id,
            "{$column_room_reservation_table_reservation_date_name}" => $room_reservation_date,
        ]);

        foreach ($room_session_id_collection_from_input as $room_session_id_from_input) {
            SiprRoomSessionReservationRequest::create([
                "{$column_room_session_reservation_table_room_reservation_id_name}" => $room_reservation_request_model->id,
                "{$column_room_session_reservation_table_room_session_id_name}" => $room_session_id_from_input,
                "{$column_room_session_reservation_table_user_id_name}" => $user_id,
                "{$column_room_session_reservation_table_reservation_date_name}" => $room_reservation_date,
            ]);
        }
        DB::commit();

        return redirect(route('room-reservation-request'));
    }
}
