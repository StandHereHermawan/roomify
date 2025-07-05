<?php

namespace App\Domains\Room\Controller;

use App\Domains\Room\Model\SiprRoomSession;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomSessionController extends Controller
{
    public function roomSessionPaginate(Request $request)
    {
        $siprRoomSessionModel = SiprRoomSession::select()
            ->paginate(5, ['*'], 'roomSessionPage')
            ->appends($request->query());

        return view('session.index')
            ->with(
                'listOfSession',
                $siprRoomSessionModel
            );
    }

    public function editRoomSessionForm(Request $request)
    {
        $input = $request->only([
            'room-session-id',
            'error_updated_session_end',
            'error_updated_session_start'
        ]);

        $room_session_id
            = $input['room-session-id'];

        $error_updated_session_end
            = $input['error_updated_session_end'] ?? null;
        $error_updated_session_start
            = $input['error_updated_session_start'] ?? null;

        if ($room_session_id === null) {
            return redirect()->route('list-of-room-session');
        }

        $siprRoomSessionModel = SiprRoomSession::select()
            ->where(
                SiprRoomSession::COLUMN_ID_NAME,
                '=',
                $room_session_id
            )
            ->first();

        if ($error_updated_session_end !== null && $error_updated_session_start !== null) {
            return view('session.edit')
                ->with('room_session_id', $room_session_id)
                ->with('error_updated_session_start', $error_updated_session_start)
                ->with('error_updated_session_end', $error_updated_session_end)
                ->with('old_room_session_start', $siprRoomSessionModel->getRoomSessionStart())
                ->with('old_room_session_end', $siprRoomSessionModel->getRoomSessionEnd());
        }

        if ($error_updated_session_end !== null) {
            return view('session.edit')
                ->with('room_session_id', $room_session_id)
                ->with('error_updated_session_end', $error_updated_session_end)
                ->with('old_room_session_start', $siprRoomSessionModel->getRoomSessionStart())
                ->with('old_room_session_end', $siprRoomSessionModel->getRoomSessionEnd());
        }

        if ($error_updated_session_start !== null) {
            return view('session.edit')
                ->with('room_session_id', $room_session_id)
                ->with('error_updated_session_start', $error_updated_session_start)
                ->with('old_room_session_start', $siprRoomSessionModel->getRoomSessionStart())
                ->with('old_room_session_end', $siprRoomSessionModel->getRoomSessionEnd());
        }

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
        $input_room = $request
            ->only([
                'updated-room-session-start',
                'updated-room-session-end',
                'room-session-id'
            ]);

        $room_session_id
            = $input_room['room-session-id'];

        $input_room_session_start
            = $input_room['updated-room-session-start'];

        $input_room_session_end
            = $input_room['updated-room-session-end'];

        if ($input_room_session_end === null && $input_room_session_start === null) {
            return redirect(
                url()->route('edit-room-session') .
                "?room-session-id={$room_session_id}" . "&" .
                "error_updated_session_end=\"Room Session Ends cannot null.\"" . "&" .
                "error_updated_session_start=\"Room Session Start cannot null.\""
            );
        }

        if ($input_room_session_end === null) {
            return redirect(
                url()->route('edit-room-session') .
                "?room-session-id={$room_session_id}" . "&" .
                "error_updated_session_end=\"Room Session Ends cannot null.\""
            );
        }

        if ($input_room_session_start === null) {
            return redirect(
                url()->route('edit-room-session') .
                "?room-session-id={$room_session_id}" . "&" .
                "error_updated_session_start=\"Room Session Start cannot null.\""
            );
        }

        if ($input_room_session_end === $input_room_session_start) {
            return redirect(
                url()->route('edit-room-session') .
                "?room-session-id={$room_session_id}" . "&" .
                "error_updated_session_end=\"Room Session Start and Ends cannot the same time.\""
            );
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

        return redirect(url()->route('list-of-room-session'));
    }

    public function submitAddRoomSessionForm(Request $request)
    {
        $input = $request
            ->only([
                'room-session-start',
                'room-session-end'
            ]);

        $validator = Validator::make($input, [
            "room-session-start" => ['required', "unique:sipr_room_sessions,room_session_end"],
            'room-session-end' => ['required', "unique:sipr_room_sessions,room_session_start"],
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->getMessageBag();

            $error_updated_session_end = isset($errorMessage->get('room-session-start')[0]) ? $errorMessage->get('room-session-start')[0] : "";
            $error_updated_session_start = isset($errorMessage->get('room-session-end')[0]) ? $errorMessage->get('room-session-end')[0] : "";

            return redirect(
                url()->route('add-room-session') .
                "?" .
                "error_updated_session_start=\"{$error_updated_session_start}\"" . "&" .
                "error_updated_session_end=\"{$error_updated_session_end}\""
            );
        }

        $input_room_session_start
            = $input['room-session-start'];

        $input_room_session_end
            = $input['room-session-end'];

        if ($input_room_session_end === $input_room_session_start) {
            return redirect(
                url()->route('add-room-session') . "?" .
                "error_updated_session_end=\"Room Session Start and End cannot the same time.\""
            );
        }

        $room_session_start_name
            = SiprRoomSession::COLUMN_ROOM_SESSION_START_NAME;
        $room_session_end_name
            = SiprRoomSession::COLUMN_ROOM_SESSION_END_NAME;

        DB::beginTransaction();

        SiprRoomSession::create([
            "{$room_session_start_name}" => $input_room_session_start,
            "{$room_session_end_name}" => $input_room_session_end,
        ]);

        DB::commit();

        return redirect(url()->route('list-of-room-session'));
    }

    public function submitDeleteRoomSession(Request $request)
    {
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

        return redirect(url()->route('list-of-room-session'));
    }
}
