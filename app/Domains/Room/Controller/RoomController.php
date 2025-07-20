<?php

namespace App\Domains\Room\Controller;

use App\Domains\Room\Model\SiprRoom;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function dashboard(Request $request)
    {
        Log::debug("Controller: RoomController | method: dashboard | called.");
        return redirect(route('list-of-room'));
    }

    public function roomSearchPaginate(Request $request)
    {
        Log::debug("Controller: RoomController | method: roomSearchPaginate | called.");

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
                ->whereBetween(SiprRoom::COLUMN_ROOM_HEIGHT_ITS_NAME, [$tinggi_ruangan_terkecil, $tinggi_ruangan_terbesar])
                ->whereBetween(SiprRoom::COLUMN_ROOM_FLOOR_WIDE_ITS_NAME, [$luas_ruangan_terkecil, $luas_ruangan_terbesar])
                
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
                ->whereBetween(SiprRoom::COLUMN_ROOM_FLOOR_WIDE_ITS_NAME, [$luas_ruangan_terkecil, $luas_ruangan_terbesar])
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
                ->whereBetween(SiprRoom::COLUMN_ROOM_HEIGHT_ITS_NAME, [$tinggi_ruangan_terkecil, $tinggi_ruangan_terbesar])
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

    public function roomDetail(Request $request, string $id)
    {
        Log::debug("Controller: RoomController | method: roomDetail | called.");

     // $room_input = $request->only(['id']);
        $room_id = $id;
        $room_model = SiprRoom::select()
            ->where(SiprRoom::COLUMN_ID_ITS_NAME, '=', $room_id)
            ->first();

        if ($room_model == null) {
            return $this->dashboard($request);
        }

        return view('room.detail')
            ->with('room', $room_model);
    }

    public function addRoomForm(Request $request)
    {
        Log::debug("Controller: RoomController | method: addRoomForm | called.");

        //
        // $input = $request->only([
        //     'error_add_room_code',
        //     'error_add_room_name',
        //     'error_add_room_height',
        //     'error_add_room_wide'
        // ]);
        // 
        // $error_add_room_code
        //     = $input['error_add_room_code'] ?? null;
        // $error_add_room_name
        //     = $input['error_add_room_name'] ?? null;
        // $error_add_room_height
        //     = $input['error_add_room_height'] ?? null;
        // $error_add_room_wide
        //     = $input['error_add_room_wide'] ?? null;
        // 
        // if (
        //     $error_add_room_code !== null &&
        //     $error_add_room_name !== null &&
        //     $error_add_room_height !== null &&
        //     $error_add_room_wide !== null
        // ) {
        //     return view('room.add')
        //         ->with('error_add_room_name', $error_add_room_name)
        //         ->with('error_add_room_height', $error_add_room_height)
        //         ->with('error_add_room_wide', $error_add_room_wide)
        //         ->with('error_add_room_code', $error_add_room_code);
        // }
        // 
        // if ($error_add_room_code !== null) {
        //     return view('room.add')
        //         ->with('error_add_room_code', $error_add_room_code);
        // }
        // 
        // if ($error_add_room_name !== null) {
        //     return view('room.add')
        //         ->with('error_add_room_name', $error_add_room_name);
        // }
        //

        return view('room.add');
    }

    public function submitAddRoomForm(Request $request)
    {
        Log::debug("Controller: RoomController | method: submitAddRoomForm | called.");

        $name_of_room_table = SiprRoom::TABLE_NAME;
        $room_name_column_its_name = SiprRoom::COLUMN_ROOM_NAME_ITS_NAME;
        $room_code_column_its_name = SiprRoom::COLUMN_ROOM_CODE_ITS_NAME;
        $room_height_column_its_name = SiprRoom::COLUMN_ROOM_HEIGHT_ITS_NAME;
        $room_floor_wide_column_its_name = SiprRoom::COLUMN_ROOM_FLOOR_WIDE_ITS_NAME;

        $input = $request->only([
            'nama-ruangan',
            'kode-ruangan',
            'tinggi-ruangan',
            'luas-ruangan'
        ]);

        $validator = Validator::make($input, [
            "nama-ruangan" => ['required'],
            'kode-ruangan' => ['required', "unique:{$name_of_room_table},{$room_code_column_its_name}"],
            'tinggi-ruangan' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^\d+(\.\d+)?$/', $value)) {
                        $fail('Nilai harus menggunakan titik (.) sebagai pemisah desimal. Contoh 3.5.');
                    }
                },
            ],
            'luas-ruangan' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^\d+(\.\d+)?$/', $value)) {
                        $fail('Nilai harus menggunakan titik (.) sebagai pemisah desimal. Contoh 3.5.');
                    }
                },
            ],
        ], [
            "nama-ruangan.required" => "nama ruangan tidak boleh kosong.",
            "kode-ruangan.required" => "kode ruangan tidak boleh kosong.",
            "kode-ruangan.unique" => "kode ruangan sudah tersedia, silahkan input kode ruangan yang lain.",
            "tinggi-ruangan.required" => "tinggi ruangan tidak boleh kosong.",
            "luas-ruangan.required" => "luas ruangan tidak boleh kosong.",
        ]);

        if ($validator->fails()) {
            Log::debug("There is invalid input.");

            $errorMessage = $validator->getMessageBag();

            $error_nama =
                isset($errorMessage->get('nama-ruangan')[0]) ?
                $errorMessage->get('nama-ruangan')[0] : "";

            $error_kode =
                isset($errorMessage->get('kode-ruangan')[0]) ?
                $errorMessage->get('kode-ruangan')[0] : "";

            $error_height =
                isset($errorMessage->get('tinggi-ruangan')[0]) ?
                $errorMessage->get('tinggi-ruangan')[0] : "";

            $error_wide =
                isset($errorMessage->get('luas-ruangan')[0]) ?
                $errorMessage->get('luas-ruangan')[0] : "";


            // return redirect(
            //     url()->route('add-room') .
            //     "?" .
            //     "error_add_room_code=\"{$error_kode}\"" . "&" .
            //     "error_add_room_height=\"{$error_height}\"" . "&" .
            //     "error_add_room_wide=\"{$error_wide}\"" . "&" .
            //     "error_add_room_name=\"{$error_nama}\""
            // );

            return $this->addRoomForm($request)
                ->with('error_add_room_code', $error_kode)
                ->with('error_add_room_height', $error_height)
                ->with('error_add_room_wide', $error_wide)
                ->with('error_add_room_name', $error_nama);
        }

        $input_nama_ruangan
            = $input['nama-ruangan'] ?? null;
        $input_kode_ruangan
            = $input['kode-ruangan'] ?? null;
        $input_tinggi_ruangan
            = $input['tinggi-ruangan'] ?? null;
        $input_luas_ruangan
            = $input['luas-ruangan'] ?? null;

        DB::beginTransaction();

        SiprRoom::create([
            "{$room_name_column_its_name}" => $input_nama_ruangan,
            "{$room_code_column_its_name}" => $input_kode_ruangan,
            "{$room_height_column_its_name}" => $input_tinggi_ruangan,
            "{$room_floor_wide_column_its_name}" => $input_luas_ruangan,
        ]);

        DB::commit();
        return $this->roomSearchPaginate($request);
    }
}
