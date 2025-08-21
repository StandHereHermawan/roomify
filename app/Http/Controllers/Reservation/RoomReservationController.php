<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\CreateRoomReservationRequest;

use App\Domains\Room\Model\SiprRoom;
use App\Domains\Room\Model\SiprRoomSession;
use App\Domains\Schedule\Model\SiprRoomReservationRequest;
use App\Domains\Schedule\Model\SiprRoomSessionReservationRequest;
use App\Domains\User\Model\SiprSession;

use App\Traits\Logs\CustomLogger;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RoomReservationController extends Controller
{
    use CustomLogger;

    public function listOfAllRoomReservationRequest(Request $request)
    {

        $input = $request->only(["room_paginate_size"]);
        $room_paginate_size = $input["room_paginate_size"] ?? 10;

        $room_reservation_pending_pagination = SiprRoomReservationRequest::select()
            ->with('userRequest')
            ->with('roomReserved')
            ->with('sessionBorrowed')
            ->where(SiprRoomReservationRequest::STATUS, '=', "PENDING")
            ->paginate($room_paginate_size, ['*'], 'reservation_pending_page')
            ->withQueryString();

        $room_reservation_accepted_pagination = SiprRoomReservationRequest::select()
            ->with('userRequest')
            ->with('roomReserved')
            ->with('sessionBorrowed')
            ->where(SiprRoomReservationRequest::STATUS, '=', "ACCEPTED")
            ->paginate($room_paginate_size, ['*'], 'reservation_accepted_page')
            ->withQueryString();

        $room_reservation_rejected_pagination = SiprRoomReservationRequest::select()
            ->with('userRequest')
            ->with('roomReserved')
            ->with('sessionBorrowed')
            ->where(SiprRoomReservationRequest::STATUS, '=', "REJECTED")
            ->paginate($room_paginate_size, ['*'], 'reservation_rejected_page')
            ->withQueryString();

        return view('room.reservation.request.all.list')
            ->with('list_of_room_reservation_request_pending', $room_reservation_pending_pagination)
            ->with('list_of_room_reservation_request_accepted', $room_reservation_accepted_pagination)
            ->with('list_of_room_reservation_request_rejected', $room_reservation_rejected_pagination);
    }

    public function listOfCurrentUserRoomReservationRequest(Request $request)
    {

        $input = $request->only(["room_paginate_size"]);
        $room_paginate_size = $input["room_paginate_size"] ?? 10;

        $user_id = null;
        $session_id = $request->session()->getId();

        $session_model = SiprSession::select()
            ->where(SiprSession::ID, '=', $session_id)
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
            ->where(SiprRoomReservationRequest::USER_ID, '=', $user_id)
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
            ->where(SiprRoomReservationRequest::STATUS, '=', 'PENDING')
            ->paginate(6, ['*'], 'room_pending_page')
            ->appends($request->query())
            ->withQueryString();

        $room_reservation_model_accepted = SiprRoomReservationRequest::select()
            ->with('userRequest')
            ->with('roomReserved')
            ->with('sessionBorrowed')
            ->where(SiprRoomReservationRequest::STATUS, '=', 'ACCEPTED')
            ->paginate(6, ['*'], 'room_accepted_page')
            ->appends($request->query())
            ->withQueryString();

        $room_reservation_model_rejected = SiprRoomReservationRequest::select()
            ->with('userRequest')
            ->with('roomReserved')
            ->with('sessionBorrowed')
            ->where(SiprRoomReservationRequest::STATUS, '=', 'REJECTED')
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
            ->where(SiprRoomReservationRequest::ID, '=', $room_reservation_id)
            ->first();

        $column_DETERMINED_AT_its_name = SiprRoomReservationRequest::DETERMINED_AT;
        $column_STATUS_its_name = SiprRoomReservationRequest::STATUS;

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
            ->where(SiprRoomReservationRequest::ID, '=', $room_reservation_id)
            ->first();

        $column_DETERMINED_AT_its_name = SiprRoomReservationRequest::DETERMINED_AT;
        $column_STATUS_its_name = SiprRoomReservationRequest::STATUS;

        DB::beginTransaction();

        $room_reservation_model->update([
            "{$column_STATUS_its_name}" => "REJECTED",
            "{$column_DETERMINED_AT_its_name}" => Carbon::now(),
        ]);

        DB::commit();

        return redirect(route('manage-list-of-room-reservation-request'));
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
                ->where(SiprRoom::CODE, '=', $room_code)
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
            ->with('search_kode_ruangan', $room_code)
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
    public function submitAddRoomReservationForm(CreateRoomReservationRequest $request)
    {

        $validated = $request->validated();
        $user_id = Auth::user()->getId();

        DB::transaction(function ()use ($validated, $user_id) {
            $room_reservation_request_model = SiprRoomReservationRequest::create([
                SiprRoomReservationRequest::USER_ID => $user_id,
                SiprRoomReservationRequest::ROOM_ID => $validated['room_id'],
                SiprRoomReservationRequest::RESERVATION_DATE => $validated['date_room_reservation'],
            ]);
    
            foreach ($validated['session'] as $room_session_id_from_input) {
                SiprRoomSessionReservationRequest::create([
                    SiprRoomSessionReservationRequest::ROOM_RESERVATION_ID => $room_reservation_request_model->id,
                    SiprRoomSessionReservationRequest::ROOM_SESSION_ID => $room_session_id_from_input,
                    SiprRoomSessionReservationRequest::USER_ID => $user_id,
                ]);
            }
        });

        return redirect(route('room-reservation-request'));
    }
}
