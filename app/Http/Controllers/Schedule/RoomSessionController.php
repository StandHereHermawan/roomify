<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;

use App\Http\Requests\Schedule\CreateRoomSessionRequest;
use App\Http\Requests\Schedule\DeleteRoomSessionRequest;
use App\Http\Requests\Schedule\EditRoomSessionRequest;
use App\Traits\Logs\CustomLogger;

use Illuminate\Http\Request;

use App\Domains\Room\Model\SiprRoomSession;

use Illuminate\Support\Facades\DB;

class RoomSessionController extends Controller
{
    use CustomLogger;

    public function roomSessionPaginate(Request $request)
    {
      

        $room_session_pagination = SiprRoomSession::select()
            ->paginate(5, ['*'], 'room_session_page')
            ->appends($request->query())
            ->withQueryString();

        return view('session.index')
            ->with('listOfSession', $room_session_pagination);
    }

    public function addRoomSessionForm()
    {
      
        
        return view('session.add');
    }

    public function submitAddRoomSessionForm(CreateRoomSessionRequest $request)
    {
      

        $input = $request->validated();

        $this->logDebugMessage(
            __FUNCTION__,
            "Attempt to create room session start at {room-session-start} ended at {room-session-end}",
            $input
        );

        DB::beginTransaction();

        SiprRoomSession::create($input);

        DB::commit();

        $this->logDebugMessage(
            __FUNCTION__,
            "Success create room session start at {room-session-start} ended at {room-session-end}",
            $input
        );
        
        return redirect(url()->route('list-of-room-session'));
    }

    public function editRoomSessionForm(SiprRoomSession $model)
    {
      
        
        return view('session.edit')
            ->with('room_session_id', $model->getId())
            ->with('old_room_session_start', $model->getRoomSessionStart())
            ->with('old_room_session_end', $model->getRoomSessionEnd());
    }

    public function submitEditRoomSessionForm(EditRoomSessionRequest $request, SiprRoomSession $model)
    {
      

        $this->logDebugMessage(
            __FUNCTION__,
            "Attempt to update room session with id: {id}, " .
            "room session start: {room_session_start} and " .
            "room session end: {room_session_end}",
            $model->toArray()
        );

        $input = $request->validated();

        $this->logDebugMessage(
            __FUNCTION__,
            "Newer " .
            "room session start: {room_session_start} and " .
            "room session end: {room_session_end}",
            $input
        );

        DB::beginTransaction();
        $model->update($input);
        DB::commit();

        $this->logDebugMessage(
            __FUNCTION__,
            "Success updated room session with id: {id}, " .
            "room session start: {room_session_start} and " .
            "room session end {room_session_end}",
            $model->toArray()
        );
        
        return redirect(url()->route('list-of-room-session'));
    }

    public function submitDeleteRoomSession(DeleteRoomSessionRequest $request, SiprRoomSession $model)
    {

        $this->logDebugMessage(
            __FUNCTION__,
            "Attempt to delete room session with id: {id}, " .
            "room session start: {" . SiprRoomSession::SESSION_START . "} and " .
            "room session end: {" . SiprRoomSession::SESSION_END . "}",
            $model->toArray() + $request->toArray()
        );

        $millis_start = microtime(true);

        DB::beginTransaction();
        $operation_success = $model->delete();
        DB::commit();

        if ($operation_success) {
            $this->logDebugMessage(
                __FUNCTION__,
                "Success delete room session with id: {id}, " .
                "room session start: {" . SiprRoomSession::SESSION_START . "} and " .
                "room session end: {" . SiprRoomSession::SESSION_END . "}",
                $model->toArray() + $request->toArray()
            );
        }

        return redirect(url()->route('list-of-room-session'));
    }
}
