<?php

namespace App\Domains\Schedule\Controller;

use App\Domains\Room\Model\SiprRoom;
use App\Domains\Room\Model\SiprRoomSession;
use App\Domains\Schedule\Model\SiprRoomReservationRequest;
use App\Domains\Schedule\Model\SiprRoomSessionReservationRequest;
use App\Domains\User\Model\SiprSession;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomReservationController extends Controller
{
    public function listOfRoomReserved(Request $request)
    {
        return redirect(route('list-of-room'));
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

        return view('room.reservation.add')
            ->with('room_pagination', $paginated_rooms)
            ->with('list_of_room_session', $paginated_room_sessions)
            ->with('search_kode_ruangan', $input["search-kode-ruangan"] ?? null)
            ->with('error_room_search_input', $room_not_found_message ?? null)
            ->with('room_model', $room_model);
    }

    public function submitAddRoomReservationForm(Request $request)
    {
        $session_id = $request->session()->getId();

        $input = $request->only([
            "room_id",
            "date_room_reservation",
            "session"
        ]);

        if (!isset($input['session'])) {
            return $this->addRoomReservationForm($request)
                ->with('error_session_input', "Pilih sesi yang tersedia.");
        }

        $session_model = SiprSession::select()
            ->where(SiprSession::COLUMN_ID_ITS_NAME, '=', $session_id)
            ->first();

        $room_id = $input["room_id"];
        $room_session = $input["session"];
        $date_room_reservation = $input["date_room_reservation"];
        $user_id = null;

        if ($session_model !== null && $session_model->getIdUser() !== null) {
            $user_id = $session_model->getIdUser();
        }

        $column_room_reservation_table_user_id_name = SiprRoomReservationRequest::COLUMN_USER_ID_ITS_NAME;
        $column_room_reservation_table_room_id_name = SiprRoomReservationRequest::COLUMN_ROOM_ID_ITS_NAME;
        $column_room_reservation_table_reservation_date_name = SiprRoomReservationRequest::COLUMN_RESERVATION_DATE_ITS_NAME;

        $column_room_session_reservation_table_user_id_name = SiprRoomSessionReservationRequest::COLUMN_USER_ID_ITS_NAME;
        $column_room_session_reservation_table_room_reservation_id_name = SiprRoomSessionReservationRequest::COLUMN_ROOM_RESERVATION_ID_ITS_NAME;
        $column_room_session_reservation_table_room_session_id_name = SiprRoomSessionReservationRequest::COLUMN_ROOM_SESSION_ID_ITS_NAME;
        $column_room_session_reservation_table_reservation_date_name = SiprRoomSessionReservationRequest::COLUMN_RESERVATION_DATE_ITS_NAME;

        DB::beginTransaction();

        $room_reservation_request_model = SiprRoomReservationRequest::create([
            "{$column_room_reservation_table_user_id_name}" => $user_id,
            "{$column_room_reservation_table_room_id_name}" => $room_id,
            "{$column_room_reservation_table_reservation_date_name}" => $date_room_reservation,
        ]);

        foreach ($room_session as $value) {
            SiprRoomSessionReservationRequest::create([
                "{$column_room_session_reservation_table_room_reservation_id_name}" => $room_reservation_request_model->id,
                "{$column_room_session_reservation_table_room_session_id_name}" => $value,
                "{$column_room_session_reservation_table_user_id_name}" => $user_id,
                "{$column_room_session_reservation_table_reservation_date_name}" => $date_room_reservation,
            ]);
        }

        DB::commit();

        return redirect(route('room-reservation-appointment'));
    }
}
