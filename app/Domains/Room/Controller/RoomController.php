<?php

namespace App\Domains\Room\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function roomPaginate()
    {
        return view('room.index');
    }
}
