<?php

namespace App\Domains\Schedule\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomReservationController extends Controller
{
    public function listOfRoomReserved(Request $request)
    {
        return redirect(route('list-of-room'));
    }

    public function addRoomReservationForm(Request $request)
    {
        return redirect(route('list-of-room'));
    }
}
