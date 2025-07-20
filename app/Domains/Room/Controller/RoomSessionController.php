<?php

namespace App\Domains\Room\Controller;

use App\Domains\Room\Model\SiprRoomSession;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RoomSessionController extends Controller
{
    public function roomSessionPaginate(Request $request)
    {
        Log::debug("Controller: RoomSessionController | method: roomSessionPaginate | called.");

        $room_session_pagination = SiprRoomSession::select()
            ->paginate(5, ['*'], 'room_ession_page')
            ->appends($request->query());

        Log::debug("Controller: RoomSessionController | method: roomSessionPaginate | before main return.");

        return view('session.index')
            ->with('listOfSession', $room_session_pagination);
    }

    public function editRoomSessionForm(Request $request)
    {
        Log::debug("Controller: RoomSessionController | method: editRoomSessionForm | called.");

        // $input = $request->only([
        //     'room-session-id',
        //     'error_updated_session_end',
        //     'error_updated_session_start'
        // ]);

        $input = $request->only(['room-session-id']);

        $room_session_id = $input['room-session-id'];

        //
        // $error_updated_session_end = $input['error_updated_session_end'] ?? null;
        // $error_updated_session_start = $input['error_updated_session_start'] ?? null;
        //

        if ($room_session_id === null) {
            Log::debug("Controller: RoomSessionController | method: editRoomSessionForm | room_session_id is null.");
            Log::debug("Controller: RoomSessionController | method: editRoomSessionForm | returning to other page.");
            return redirect()->route('list-of-room-session');
        }

        $siprRoomSessionModel = SiprRoomSession::select()
            ->where(
                SiprRoomSession::COLUMN_ID_NAME,
                '=',
                $room_session_id
            )
            ->first();

        //
        // if ($error_updated_session_end !== null && $error_updated_session_start !== null) {
        //     return view('session.edit')
        //         ->with('room_session_id', $room_session_id)
        //         ->with('error_updated_session_start', $error_updated_session_start)
        //         ->with('error_updated_session_end', $error_updated_session_end)
        //         ->with('old_room_session_start', $siprRoomSessionModel->getRoomSessionStart())
        //         ->with('old_room_session_end', $siprRoomSessionModel->getRoomSessionEnd());
        // }
        // 
        // if ($error_updated_session_end !== null) {
        //     return view('session.edit')
        //         ->with('room_session_id', $room_session_id)
        //         ->with('error_updated_session_end', $error_updated_session_end)
        //         ->with('old_room_session_start', $siprRoomSessionModel->getRoomSessionStart())
        //         ->with('old_room_session_end', $siprRoomSessionModel->getRoomSessionEnd());
        // }
        // 
        // if ($error_updated_session_start !== null) {
        //     return view('session.edit')
        //         ->with('room_session_id', $room_session_id)
        //         ->with('error_updated_session_start', $error_updated_session_start)
        //         ->with('old_room_session_start', $siprRoomSessionModel->getRoomSessionStart())
        //         ->with('old_room_session_end', $siprRoomSessionModel->getRoomSessionEnd());
        // }
        //

        
        Log::debug("Controller: RoomSessionController | method: editRoomSessionForm | before main return.");
        return view('session.edit')
            ->with('room_session_id', $room_session_id)
            ->with('old_room_session_start', $siprRoomSessionModel->getRoomSessionStart())
            ->with('old_room_session_end', $siprRoomSessionModel->getRoomSessionEnd());
    }

    public function addRoomSessionForm(Request $request)
    {
        $input = $request->only([
            'error_updated_session_end',
            'error_updated_session_start'
        ]);

        $error_updated_session_end
            = $input['error_updated_session_end'] ?? null;
        $error_updated_session_start
            = $input['error_updated_session_start'] ?? null;

        if ($error_updated_session_end !== null && $error_updated_session_start !== null) {
            return view('session.add')
                ->with('error_updated_session_start', $error_updated_session_start)
                ->with('error_updated_session_end', $error_updated_session_end);
        }

        if ($error_updated_session_end !== null) {
            return view('session.add')
                ->with('error_updated_session_end', $error_updated_session_end);
        }

        if ($error_updated_session_start !== null) {
            return view('session.add')
                ->with('error_updated_session_start', $error_updated_session_start);
        }

        return view('session.add');
    }

    public function submitEditRoomSessionForm(Request $request)
    {
        Log::debug("Controller: RoomSessionController | method: submitEditRoomSessionForm | called.");
        
        $input = $request->only([
            'updated-room-session-start',
            'updated-room-session-end',
            'room-session-id'
        ]);

        $validator = Validator::make($input, [
            'updated-room-session-start' => ['required'],
            'updated-room-session-end' => ['required'],
        ], [
            "updated-room-session-start.required" => "Sesi Ruangan Dimulai tidak bisa kosong.",
            "updated-room-session-end.required" => "Sesi Ruangan Berakhir tidak bisa kosong.",
        ]);

        if ($validator->fails()) {
            Log::debug("Controller: RoomSessionController | method: submitEditRoomSessionForm | validation fails from Validator class.");

            $error_message_updated_room_session_start = $validator->getMessageBag()->get('updated-room-session-start')[0] ?? null;
            $error_message_updated_room_session_ends = $validator->getMessageBag()->get('updated-room-session-end')[0] ?? null;

            return $this->editRoomSessionForm($request)
                ->with('error_updated_session_end', $error_message_updated_room_session_ends)
                ->with('error_updated_session_start', $error_message_updated_room_session_start);
        }

        $room_session_id = $input['room-session-id'];
        $input_room_session_start = $input['updated-room-session-start'];
        $input_room_session_end = $input['updated-room-session-end'];

        //
        // if ($input_room_session_end === null && $input_room_session_start === null) {
        //     return redirect(
        //         url()->route('edit-room-session') .
        //         "?room-session-id={$room_session_id}" . "&" .
        //         "error_updated_session_end=\"Room Session Ends cannot null.\"" . "&" .
        //         "error_updated_session_start=\"Room Session Start cannot null.\""
        //     );
        // }
        //
        // if ($input_room_session_end === null) {
        //     return redirect(
        //         url()->route('edit-room-session') .
        //         "?room-session-id={$room_session_id}" . "&" .
        //         "error_updated_session_end=\"Room Session Ends cannot null.\""
        //     );
        // }
        // 
        // if ($input_room_session_start === null) {
        //     return redirect(
        //         url()->route('edit-room-session') .
        //         "?room-session-id={$room_session_id}" . "&" .
        //         "error_updated_session_start=\"Room Session Start cannot null.\""
        //     );
        // }
        //

        if ($input_room_session_end === $input_room_session_start) {

            Log::debug("Controller: RoomSessionController | method: submitEditRoomSessionForm | validation fails caused by same input room session.");
            return $this->editRoomSessionForm($request)
                ->with('error_updated_session_end', "Sesi Ruangan Dimulai tidak bisa di waktu yang sama dengan Sesi Ruangan Berakhir.")
                ->with('error_updated_session_start', "Sesi Ruangan Dimulai tidak bisa di waktu yang sama dengan Sesi Ruangan Berakhir.");
        }

        $siprRoomSessionModel = SiprRoomSession::select()
            ->where(
                SiprRoomSession::COLUMN_ID_NAME,
                '=',
                $room_session_id
            )
            ->first();

        $room_session_start_name = SiprRoomSession::COLUMN_ROOM_SESSION_START_NAME;
        $room_session_end_name = SiprRoomSession::COLUMN_ROOM_SESSION_END_NAME;

        DB::beginTransaction();

        $siprRoomSessionModel->update([
            "{$room_session_start_name}" => $input_room_session_start,
            "{$room_session_end_name}" => $input_room_session_end,
        ]);

        DB::commit();

        Log::debug("Controller: RoomSessionController | method: submitEditRoomSessionForm | before main return.");
        return redirect(url()->route('list-of-room-session'));
    }

    public function submitAddRoomSessionForm(Request $request)
    {
        Log::debug("Controller: RoomSessionController | method: submitAddRoomSessionForm | called.");

        $room_session_table_name = SiprRoomSession::TABLE_NAME;
        $room_session_start_column_name = SiprRoomSession::COLUMN_ROOM_SESSION_START_NAME;
        $room_session_end_column_name = SiprRoomSession::COLUMN_ROOM_SESSION_END_NAME;

        $input = $request
            ->only([
                'room-session-start',
                'room-session-end'
            ]);

        $validator = Validator::make($input, [
            "room-session-start" => ['required', "unique:{$room_session_table_name},{$room_session_start_column_name}", "unique:{$room_session_table_name},{$room_session_end_column_name}"],
            "room-session-end" => ['required', "unique:{$room_session_table_name},{$room_session_end_column_name}", "unique:{$room_session_table_name},{$room_session_start_column_name}"],
        ], [
            "room-session-start.required" => "Sesi Ruangan Dimulai tidak boleh kosong.",
            "room-session-end.required" => "Sesi Ruangan Berakhir tidak boleh kosong.",
        ]);

        if ($validator->fails()) {
            Log::debug("Controller: RoomSessionController | method: submitAddRoomSessionForm | validation fails from Validator.");
            
            $errorMessage = $validator->getMessageBag();

            $error_updated_session_end = isset($errorMessage->get('room-session-start')[0])
                ? $errorMessage->get('room-session-start')[0]
                : "";

            $error_updated_session_start = isset($errorMessage->get('room-session-end')[0])
                ? $errorMessage->get('room-session-end')[0]
                : "";

            // return redirect(
            //     url()->route('add-room-session') .
            //     "?" .
            //     "error_updated_session_start=\"{$error_updated_session_start}\"" . "&" .
            //     "error_updated_session_end=\"{$error_updated_session_end}\""
            // );

            return $this->addRoomSessionForm($request)
                ->with('error_updated_session_start', $error_updated_session_start)
                ->with('error_updated_session_end', $error_updated_session_end);
        }

        //
        // if ($input_room_session_end === $input_room_session_start) {
        //     return redirect(
        //         url()->route('add-room-session') . "?" .
        //         "error_updated_session_end=\"Room Session Start and End cannot the same time.\""
        //     );
        // }
        //

        $input_room_session_start
            = $input['room-session-start'];

        $input_room_session_end
            = $input['room-session-end'];

        if ($input_room_session_end === $input_room_session_start) {
            Log::debug("Controller: RoomSessionController | method: submitAddRoomSessionForm | validation fails from same room session value.");

            return $this->editRoomSessionForm($request)
                ->with('error_updated_session_end', "Sesi Ruangan Dimulai tidak bisa di waktu yang sama dengan Sesi Ruangan Berakhir.")
                ->with('error_updated_session_start', "Sesi Ruangan Dimulai tidak bisa di waktu yang sama dengan Sesi Ruangan Berakhir.");
        }

        DB::beginTransaction();

        SiprRoomSession::create([
            "{$room_session_start_column_name}" => $input_room_session_start,
            "{$room_session_end_column_name}" => $input_room_session_end,
        ]);

        DB::commit();

        Log::debug("Controller: RoomSessionController | method: submitAddRoomSessionForm | before main return.");
        return redirect(url()->route('list-of-room-session'));
    }

    public function submitDeleteRoomSession(Request $request)
    {
        Log::debug("Controller: RoomSessionController | method: submitDeleteRoomSession | called.");
        
        $input = $request->only([
            'room-session-id',
        ]);

        $room_session_id
            = $input['room-session-id'];

        $siprRoomSessionModel = SiprRoomSession::select()
            ->where(
                SiprRoomSession::COLUMN_ID_NAME,
                '=',
                $room_session_id
            )
            ->first();

        DB::beginTransaction();

        $siprRoomSessionModel->delete();

        DB::commit();

        Log::debug("Controller: RoomSessionController | method: submitDeleteRoomSession | before main return.");
        return redirect(url()->route('list-of-room-session'));
    }
}
