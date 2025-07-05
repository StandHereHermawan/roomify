<?php

namespace App\Domains\Room\Controller;

use App\Domains\Room\Model\SiprRoom;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
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
                ->whereBetween(SiprRoom::COLUMN_ROOM_HEIGHT_ITS_NAME, [$tinggi_ruangan_terkecil, $tinggi_ruangan_terbesar])
                ->whereBetween(SiprRoom::COLUMN_ROOM_FLOOR_WIDE_ITS_NAME, [$luas_ruangan_terkecil, $luas_ruangan_terbesar])
                ->paginate(4, ['*'], 'roomPage')
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
                ->paginate(4, ['*'], 'roomPage')
                ->withQueryString()
                ->appends($request->getQueryString());
        }

        if (
            $luas_ruangan_terkecil !== null &&
            $luas_ruangan_terbesar !== null
        ) {
            $paginatedRooms = SiprRoom::select()
                ->whereBetween(SiprRoom::COLUMN_ROOM_FLOOR_WIDE_ITS_NAME, [$luas_ruangan_terkecil, $luas_ruangan_terbesar])
                ->paginate(4, ['*'], 'roomPage')
                ->withQueryString()
                ->appends($request->getQueryString());
        }

        if (
            $tinggi_ruangan_terkecil !== null &&
            $tinggi_ruangan_terbesar !== null
        ) {
            $paginatedRooms = SiprRoom::select()
                ->whereBetween(SiprRoom::COLUMN_ROOM_HEIGHT_ITS_NAME, [$tinggi_ruangan_terkecil, $tinggi_ruangan_terbesar])
                ->paginate(4, ['*'], 'roomPage')
                ->withQueryString()
                ->appends($request->getQueryString());
        }

        return view('room.index')
            ->with(
                'paginatedRooms',
                $paginatedRooms
            )
            ->with(
                'tinggi_ruangan_terkecil',
                $tinggi_ruangan_terkecil
            )->with(
                'tinggi_ruangan_terbesar',
                $tinggi_ruangan_terbesar
            )->with(
                'luas_ruangan_terkecil',
                $luas_ruangan_terkecil
            )->with(
                'luas_ruangan_terbesar',
                $luas_ruangan_terbesar
            );
    }

    public function roomDetail(Request $request)
    {
        $room_input = $request
            ->only(['id']);

        $room_id
            = $room_input['id'];

        $room_model = SiprRoom::select()
            ->where(SiprRoom::COLUMN_ID_ITS_NAME, '=', $room_id)
            ->first()
        ;

        return view('room.detail')
            ->with(
                'room',
                $room_model
            )
        ;
    }

    public function addRoomForm(Request $request)
    {
        $input = $request->only([
            'error_add_room_code',
            'error_add_room_name',
            'error_add_room_height',
            'error_add_room_wide'
        ]);

        $error_add_room_code
            = $input['error_add_room_code'] ?? null;
        $error_add_room_name
            = $input['error_add_room_name'] ?? null;
        $error_add_room_height
            = $input['error_add_room_height'] ?? null;
        $error_add_room_wide
            = $input['error_add_room_wide'] ?? null;

        if ($error_add_room_code !== null && $error_add_room_name !== null && $error_add_room_height !== null && $error_add_room_wide !== null) {
            return view('room.add')
                ->with('error_add_room_name', $error_add_room_name)
                ->with('error_add_room_height', $error_add_room_height)
                ->with('error_add_room_wide', $error_add_room_wide)
                ->with('error_add_room_code', $error_add_room_code);
        }

        if ($error_add_room_code !== null) {
            return view('room.add')
                ->with('error_add_room_code', $error_add_room_code);
        }

        if ($error_add_room_name !== null) {
            return view('room.add')
                ->with('error_add_room_name', $error_add_room_name);
        }

        return view('room.add');
    }

    public function submitAddRoomForm(Request $request)
    {
        $input = $request->only([
            'nama-ruangan',
            'kode-ruangan',
            'tinggi-ruangan',
            'luas-ruangan'
        ]);

        $validator = Validator::make($input, [
            "nama-ruangan" => ['required'],
            'kode-ruangan' => ['required', "unique:sipr_rooms,room_code"],
            'tinggi-ruangan' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^\d+(\.\d+)?$/', $value)) {
                        $fail('Nilai harus menggunakan titik (.) sebagai pemisah desimal.');
                    }
                },
            ],
            'luas-ruangan' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^\d+(\.\d+)?$/', $value)) {
                        $fail('Nilai harus menggunakan titik (.) sebagai pemisah desimal.');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->getMessageBag();

            $error_nama = isset($errorMessage->get('nama-ruangan')[0]) ? $errorMessage->get('nama-ruangan')[0] : "";
            $error_kode = isset($errorMessage->get('kode-ruangan')[0]) ? $errorMessage->get('kode-ruangan')[0] : "";
            $error_height = isset($errorMessage->get('tinggi-ruangan')[0]) ? $errorMessage->get('tinggi-ruangan')[0] : "";
            $error_wide = isset($errorMessage->get('luas-ruangan')[0]) ? $errorMessage->get('luas-ruangan')[0] : "";

            return redirect(
                url()->route('add-room') .
                "?" .
                "error_add_room_code=\"{$error_kode}\"" . "&" .
                "error_add_room_height=\"{$error_height}\"" . "&" .
                "error_add_room_wide=\"{$error_wide}\"" . "&" .
                "error_add_room_name=\"{$error_nama}\""
            );
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

        $nama_kolom_nama_ruangan = SiprRoom::COLUMN_ROOM_NAME_ITS_NAME;
        $nama_kolom_kode_ruangan = SiprRoom::COLUMN_ROOM_CODE_ITS_NAME;
        $nama_kolom_tinggi_ruangan = SiprRoom::COLUMN_ROOM_HEIGHT_ITS_NAME;
        $nama_kolom_luas_ruangan = SiprRoom::COLUMN_ROOM_FLOOR_WIDE_ITS_NAME;

        SiprRoom::create([
            "{$nama_kolom_nama_ruangan}" => $input_nama_ruangan,
            "{$nama_kolom_kode_ruangan}" => $input_kode_ruangan,
            "{$nama_kolom_tinggi_ruangan}" => $input_tinggi_ruangan,
            "{$nama_kolom_luas_ruangan}" => $input_luas_ruangan,
        ]);

        DB::commit();

        return view('room.add');
    }
}
