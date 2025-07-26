<?php

namespace App\Domains\Home\Controller;

use App\Domains\Room\Model\SiprRoom;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function main(Request $request)
    {
        $paginated_rooms = SiprRoom::select()
            ->paginate(4, ['*'], 'room_page')
            ->withQueryString()
            ->appends($request->getQueryString());
            
        return view('home')
            ->with('paginated_rooms', $paginated_rooms);
    }
}
