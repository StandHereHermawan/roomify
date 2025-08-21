<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;

use App\Http\Requests\Room\CreateRoomRequest;
use Illuminate\Http\Request;

use App\Traits\Logs\CustomLogger;
use App\Domains\Room\Model\SiprRoom;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    use CustomLogger;

    public function dashboard(Request $request)
    {

        $paginatedRooms = SiprRoom::select()
            ->paginate(4, ['*'], 'room_page')
            ->withQueryString()
            ->appends($request->getQueryString());

        return view('home')
            ->with('paginated_rooms', $paginatedRooms);
    }

    public function roomSearchPaginate(Request $request)
    {


        $input = $request->only([
            "search-tinggi-terkecil-ruangan",
            "search-tinggi-terbesar-ruangan",
            "search-luas-terkecil-ruangan",
            "search-luas-terbesar-ruangan",
        ]);

        $tinggi_ruangan_terkecil = $input["search-tinggi-terkecil-ruangan"] ?? null;
        $tinggi_ruangan_terbesar = $input["search-tinggi-terbesar-ruangan"] ?? null;
        $luas_ruangan_terkecil = $input["search-luas-terkecil-ruangan"] ?? null;
        $luas_ruangan_terbesar = $input["search-luas-terbesar-ruangan"] ?? null;

        $paginatedRooms = null;

        if (
            isset($tinggi_ruangan_terkecil) &&
            isset($tinggi_ruangan_terbesar) &&
            isset($luas_ruangan_terkecil) &&
            isset($luas_ruangan_terbesar)
        ) {
            $paginatedRooms = SiprRoom::select()
                ->whereBetween(SiprRoom::HEIGHT, [$tinggi_ruangan_terkecil, $tinggi_ruangan_terbesar])
                ->whereBetween(SiprRoom::FLOOR_WIDE, [$luas_ruangan_terkecil, $luas_ruangan_terbesar])

                ->paginate(4, ['*'], 'room_page')
                ->withQueryString()
                ->appends($request->getQueryString());
        }

        if (
            $luas_ruangan_terkecil !== null &&
            $luas_ruangan_terbesar !== null
        ) {
            Log::debug("Query Parameter luas_ruangan terisi. terkecil: {lrk}, terbesar {lrb}", ["lrk" => $luas_ruangan_terkecil, "lrb" => $luas_ruangan_terbesar]);
            $paginatedRooms = SiprRoom::select()
                ->whereBetween(SiprRoom::FLOOR_WIDE, [$luas_ruangan_terkecil, $luas_ruangan_terbesar])
                ->paginate(4, ['*'], 'room_page')
                ->withQueryString()
                ->appends($request->getQueryString());
        }

        if (
            $tinggi_ruangan_terkecil !== null &&
            $tinggi_ruangan_terbesar !== null
        ) {
            Log::debug("Query Parameter tinggi_ruangan terisi. terkecil: {trk}, terbesar {trb}", ["trk" => $tinggi_ruangan_terkecil, "trb" => $tinggi_ruangan_terbesar]);
            $paginatedRooms = SiprRoom::select()
                ->whereBetween(SiprRoom::HEIGHT, [$tinggi_ruangan_terkecil, $tinggi_ruangan_terbesar])
                ->paginate(4, ['*'], 'room_page')
                ->withQueryString()
                ->appends($request->getQueryString());
        }

        if (
            $tinggi_ruangan_terkecil === null &&
            $tinggi_ruangan_terbesar === null &&
            $luas_ruangan_terkecil === null &&
            $luas_ruangan_terbesar === null
        ) {
            $paginatedRooms = SiprRoom::select()
                ->paginate(4, ['*'], 'room_page')
                ->withQueryString()
                ->appends($request->getQueryString());
        }

        return view('room.index')
            ->with('paginatedRooms', $paginatedRooms)
            ->with('tinggi_ruangan_terkecil', $tinggi_ruangan_terkecil)
            ->with('tinggi_ruangan_terbesar', $tinggi_ruangan_terbesar)
            ->with('luas_ruangan_terkecil', $luas_ruangan_terkecil)
            ->with('luas_ruangan_terbesar', $luas_ruangan_terbesar);
    }

    public function roomDetail(SiprRoom $model)
    {

        return view('room.detail')
            ->with('room', $model);
    }

    public function addRoomForm()
    {

        return view('room.add');
    }

    public function submitAddRoomForm(CreateRoomRequest $request)
    {
        $input = $request->validated();

        DB::beginTransaction();
        SiprRoom::create($input);
        DB::commit();

        return redirect(route('list-of-room'));
    }
}
