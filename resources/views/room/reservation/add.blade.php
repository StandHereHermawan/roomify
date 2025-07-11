@php

    $title = "Pinjam Ruangan";
    $prefix = "Pengajuan ";
    $full_title = $prefix . $title;

@endphp

<x-layout.main :title="$full_title">
    <x-navbar></x-navbar>
    <style>
        .bs-max-card-height-20rem {
            max-height: 20rem;
        }
    </style>
    <div class="mt-3">
        <div class="container-fluid container-lg">
            {{--
            <div class="col-auto col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">
                --}}
                <div class="">
                    {{-- add room form with style --}}
                    <div class="p-4 border rounded-3 shadow">
                        <h1 class="mb-4 text-center text-primary">{{ $full_title }}</h1>
                        <div class="col my-3">
                            {{-- search room specific accordion --}}
                            <div class="accordion shadow-sm" id="accordion-room-search-specific">
                                <div class="accordion-item">
                                    {{-- Tombol tampil/hilang akordeon --}}
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#room-search-accordeon-specific" aria-expanded="true"
                                            aria-controls="room-search-accordeon-specific" style="">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="currentColor" class="bi bi-search me-3" viewBox="0 0 16 16">
                                                <path
                                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                            </svg>
                                            Cari Ruangan Spesifik
                                        </button>
                                    </h2>
                                    {{-- end of Tombol tampil/hilang akordeon --}}
                                    {{-- body search accordion --}}
                                    <div id="room-search-accordeon-specific" class="accordion-collapse collapse show"
                                        data-bs-parent="#accordion-room-search-specific">
                                        {{-- search room specific --}}
                                        <div class="accordion-body">
                                            <form id="myForm-2" action="#" method="get">
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <label for="search-kode-ruangan-label" class="form-label">
                                                            Kode Ruangan
                                                        </label>
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control"
                                                                name="search-kode-ruangan"
                                                                value="{{ $search_kode_ruangan ?? ""}}"
                                                                id="search-kode-ruangan-label" placeholder="Password">
                                                            <label for="search-kode-ruangan-label">Kode Ruangan</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="d-flex justify-content-center mb-3 mb-lg-0">
                                                        <button class="btn btn-primary w-100 shadow-sm" type="submit">
                                                            {{--
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="22"
                                                                height="22" fill="currentColor" class="bi bi-search"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                                            </svg>
                                                            --}}
                                                            <i class="bi bi-search"></i>
                                                            Cari
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        {{-- end of search room specific --}}
                                    </div>
                                    {{-- end of body search accordion --}}
                                </div>
                            </div>
                            {{-- end of search room specific accordion --}}
                        </div>
                        {{-- header form --}}
                        <div>
                            <div class="fs-2 ">Ruangan yang akan dipinjam</div>
                        </div>
                        {{-- end header form --}}
                        <form id="myForm" action="#" method="post" novalidate>
                            @csrf
                            <div class="row row-cols-1 row-cols-xl-2 gx-3">
                                {{-- id ruangan --}}
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input name="room_id" type="text" class="form-control shadow-sm"
                                            value="{{ $room_model->id ?? "" }}" id="nama-ruangan-label"
                                            placeholder="nama-ruangan-input" readonly>
                                        <label for="nama-ruangan-label">Id Ruangan</label>
                                        {{-- room name error message --}}
                                        @isset($error_add_room_name)
                                            @if (strlen($error_add_room_name) > 2)
                                                <div class="text-danger"> {{ $error_add_room_name }} </div>
                                            @endif
                                        @endisset
                                        {{-- end room name error message --}}
                                    </div>
                                </div>
                                {{-- end of id ruangan --}}
                                {{-- tanggal Peminjaman --}}
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input name="date_room_reservation" type="date" class="form-control shadow-sm"
                                            id="date_room_reservation" placeholder="date_room_reservation">
                                        <label for="date_room_reservation">Tanggal Peminjaman</label>
                                        {{-- room name error message --}}
                                        @isset($error_add_room_name)
                                            @if (strlen($error_add_room_name) > 2)
                                                <div class="text-danger"> {{ $error_add_room_name }} </div>
                                            @endif
                                        @endisset
                                        {{-- end room name error message --}}
                                    </div>
                                </div>
                                {{-- end of tanggal Peminjaman --}}
                                {{-- nama ruangan --}}
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input name="nama-ruangan" type="text" class="form-control shadow-sm"
                                            value="{{ $room_model->name ?? "" }}" id="nama-ruangan-label"
                                            placeholder="nama-ruangan-input" disabled>
                                        <label for="nama-ruangan-label">Nama Ruangan</label>
                                        {{-- room name error message --}}
                                        @isset($error_add_room_name)
                                            @if (strlen($error_add_room_name) > 2)
                                                <div class="text-danger"> {{ $error_add_room_name }} </div>
                                            @endif
                                        @endisset
                                        {{-- end room name error message --}}
                                    </div>
                                </div>
                                {{-- end of nama ruangan --}}
                                {{-- kode ruangan --}}
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        <input name="kode-ruangan" type="text" class="form-control shadow-sm"
                                            value="{{ $room_model->room_code ?? "" }}" id="kode-ruangan-label"
                                            placeholder="kode-ruangan-input" disabled>
                                        <label for="kode-ruangan-label">Kode Ruangan</label>
                                        {{-- room code error message --}}
                                        @isset($error_add_room_code)
                                            @if (strlen($error_add_room_code) > 2)
                                                <div class="text-danger"> {{ $error_add_room_code }} </div>
                                            @endif
                                        @endisset
                                        {{-- end room code error message --}}
                                    </div>
                                </div>
                                {{-- end of kode ruangan --}}
                                {{-- tinggi ruangan --}}
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        @if (isset($room_model) && $room_model !== null)
                                            <input name="tinggi-ruangan" type="text" class="form-control shadow-sm"
                                                value="{{ round($room_model->getRoomHeight(), 2) . " Meter." }}"
                                                id="tinggi-ruangan-label" placeholder="tinggi-ruangan-input" disabled />
                                            <label for="tinggi-ruangan-label">Tinggi Ruangan</label>
                                        @else
                                            <input name="tinggi-ruangan" type="text" class="form-control shadow-sm"
                                                value="{{ "" }}" id="tinggi-ruangan-label"
                                                placeholder="tinggi-ruangan-input" disabled>
                                            <label for="tinggi-ruangan-label">Tinggi Ruangan</label>
                                        @endif
                                        {{-- error message --}}
                                        @isset($error_add_room_height)
                                            @if (strlen($error_add_room_height) > 2)
                                                <div class="text-danger"> {{ $error_add_room_height }} </div>
                                            @endif
                                        @endisset
                                        {{-- end error message --}}
                                    </div>
                                </div>
                                {{-- end of tinggi ruangan --}}
                                {{-- luas ruangan --}}
                                <div class="col">
                                    <div class="form-floating mb-3">
                                        @if (isset($room_model) && $room_model !== null)
                                            <input name="luas-ruangan" type="text" class="form-control shadow-sm"
                                                value="{{ round($room_model->meter_squared_floor_wide, 2) . " Meter Persegi" }}"
                                                id="luas-ruangan-label" placeholder="luas-ruangan-input" disabled>
                                            <label for="luas-ruangan-label">Luas Ruangan</label>
                                        @else
                                            <input name="luas-ruangan" type="text" class="form-control shadow-sm"
                                                value="{{ "" }}" id="luas-ruangan-label" placeholder="luas-ruangan-input"
                                                disabled>
                                            <label for="luas-ruangan-label">Luas Ruangan</label>
                                        @endif
                                        {{-- error message --}}
                                        @isset($error_add_room_wide)
                                            @if (strlen($error_add_room_wide) > 2)
                                                <div class="text-danger"> {{ $error_add_room_wide }} </div>
                                            @endif
                                        @endisset
                                        {{-- end error message --}}
                                    </div>
                                </div>
                                {{-- end of luas ruangan --}}
                            </div>
                            @isset($error_room_search_input)
                                @if (strlen($error_room_search_input) > 2)
                                    <div class="text-danger fs-3 text-center">{{ $error_room_search_input }}</div>
                                @endif
                            @endisset
                            <div>
                                <div class="fs-2 ">Sesi Pinjam Ruangan</div>
                            </div>
                            <div class="col">
                                <div class="row row-cols-1 gx-3" id="input-session-container">
                                    {{--
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input name="sesi-ruangan[]" type="text" class="form-control shadow-sm"
                                                value="{{ " Not yet available" }}" id="sesi-ruangan-label[]"
                                                placeholder="sesi-ruangan-input[]" readonly>
                                            <label for="sesi-ruangan-label[]">Sesi Ruangan</label>
                                        </div>
                                    </div>
                                    --}}
                                    <table class="table">
                                        {{-- table header --}}
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    <div class="fs-3 text-primary">
                                                        identitas
                                                    </div>
                                                </th>
                                                <th scope="col">
                                                    <div class="fs-3 text-primary">
                                                        Sesi Mulai
                                                    </div>
                                                </th>
                                                <th scope="col">
                                                    <div class="fs-3 text-primary">
                                                        Sesi Berakhir
                                                    </div>
                                                </th>
                                                <th scope="col">
                                                    <div class="fs-3 text-primary">
                                                        Option
                                                    </div>
                                                </th>

                                                {{--
                                                <th scope="col">
                                                    <div class="fs-3 text-primary me-1">
                                                        Option
                                                    </div>
                                                </th>
                                                --}}
                                                {{-- <th scope="col">Handle</th> --}}
                                            </tr>
                                        </thead>
                                        {{-- end of table header --}}
                                        {{-- table body --}}
                                        <tbody class="table-group-divider text-primary">
                                            @if (isset($list_of_room_session) && is_iterable($list_of_room_session))
                                                {{-- Pagination Navigation --}}
                                                <div class="mt-2">
                                                    {{ $list_of_room_session->links() }}
                                                </div>
                                                {{-- End of Pagination Navigation --}}
                                                @foreach ($list_of_room_session as $sessions)
                                                    {{-- Row --}}
                                                    <tr>
                                                        <th scope="row">
                                                            <div class="fs-3">
                                                                {{ $sessions->id }}
                                                            </div>
                                                        </th>
                                                        <td scope="row">
                                                            <div class="fs-3">
                                                                {{ $sessions->getRoomSessionStart() }}
                                                            </div>
                                                        </td>
                                                        <td scope="row">
                                                            <div class="fs-3">
                                                                {{ $sessions->getRoomSessionEnd() }}
                                                            </div>
                                                        </td>
                                                        <td scope="row">
                                                            <div class="fs-6">
                                                                <input type="checkbox" name="session[]"
                                                                    value="{{ $sessions->id }}" id="sesi-dipilih">
                                                                <label class="form-check-label" for="sesi-dipilih">
                                                                    Sesi dipilih
                                                                </label>
                                                            </div>
                                                        </td>
                                                        {{--
                                                        <td scope="row">
                                                            <div class="d-flex">
                                                                <form action="{{ url()->route('edit-room-session') }}"
                                                                    method="get">
                                                                    <input type="hidden" name="room-session-id"
                                                                        value="{{ $sessions->id }}">
                                                                    <button class="btn btn-primary me-1" type="submit">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                            height="24" fill="currentColor"
                                                                            class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                            <path
                                                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                                            <path fill-rule="evenodd"
                                                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                                        </svg>
                                                                    </button>
                                                                </form>
                                                                <form action="{{ url()->route('delete-session') }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="room-session-id"
                                                                        value="{{ $sessions->id }}">
                                                                    <button class="btn btn-primary" type="submit">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                            height="24" fill="currentColor"
                                                                            class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                                            <path
                                                                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                                                        </svg>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                        --}}
                                                    </tr>
                                                    {{-- End of Row --}}
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td scope="row">
                                                        <div class="fs-6">
                                                            Lorem Ipsum
                                                        </div>
                                                    </td>
                                                    <td scope="row">
                                                        <div class="fs-6">
                                                            Lorem Ipsum
                                                        </div>
                                                    </td>
                                                    <td scope="row">
                                                        <div class="fs-6">
                                                            Lorem Ipsum
                                                        </div>
                                                    </td>
                                                    <td scope="row">
                                                        <div class="fs-6">
                                                            Lorem Ipsum
                                                        </div>
                                                    </td>
                                                    <td scope="row">
                                                        <div class="fs-6">
                                                            Lorem Ipsum
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                        {{-- end of table body --}}
                                    </table>
                                </div>
                            </div>
                            {{-- error session --}}
                            @isset($error_session_input)
                                @if (strlen($error_session_input) > 2)
                                    <div class="text-danger fs-3 text-center"> {{ $error_session_input }} </div>
                                @endif
                            @endisset
                            {{-- end of error session --}}
                            {{-- submit button --}}
                            <div class="shadow my-3">
                                <x-form.submit.button :name="$title"></x-form.submit.button>
                            </div>
                            {{-- end of submit button --}}
                        </form>
                        {{-- session pagination --}}
                        <div>
                            @if (isset($room_pagination))
                                <div class="mt-3">
                                    {{ $room_pagination->links() }}
                                </div>
                                <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3">
                                    @foreach ($room_pagination as $room)
                                        <div class="col">
                                            <div class="card h-100 shadow-sm">
                                                {{-- Gray Placeholder --}}
                                                <svg aria-label="Placeholder: Image cap" class="bd-placeholder-img card-img-top"
                                                    height="140" preserveAspectRatio="xMidYMid slice" role="img" width="100%"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <title>Placeholder</title>
                                                    <rect width="100%" height="100%" fill="#868e96"></rect>
                                                    <text x="50%" y="50%" fill="#dee2e6" dy=".3em">Image cap</text>
                                                </svg>
                                                {{-- End of Gray Placeholder --}}

                                                {{-- Card --}}
                                                <div class="card-body">
                                                    <div class="d-flex w-100 justify-content-between">
                                                        <div class="fs-4 fw-bold text-primary">
                                                            {{ $room->getRoomCode() }}
                                                        </div>
                                                        <div class="opacity-50 fs-4 fs-lg-5 fw-light">
                                                            {{ $room->getName() }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="opacity-75 fs-6">
                                                            Tinggi:
                                                            {{ (round($room->getRoomHeight(), 2) ?? "?") . " " . "meter." }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="opacity-75 fs-6 mb-1">
                                                            Luas Lantai:
                                                            {{ (round($room->meter_squared_floor_wide, 2) ?? "?") }}
                                                            <sup>2</sup>
                                                            {{ " " . "meter." }}
                                                        </div>
                                                    </div>
                                                    <form action="{{ route('detail-room') }}" method="get">
                                                        <input type="hidden" name="id" value="{{ $room->getId() }}">
                                                        <button type="submit"
                                                            class="btn btn-outline-primary w-100 shadow-sm">Lihat</button>
                                                    </form>
                                                </div>
                                                {{-- End of Card --}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        {{-- end of session pagination --}}
                        {{-- back to room session page --}}
                        <a href="{{ route('list-of-room') }}">
                            <div class="form-floating mt-3 shadow">
                                <button type="reset" class="btn btn-outline-secondary w-100">
                                    Back to List of Room
                                </button>
                            </div>
                        </a>
                        {{-- end of back to room session page --}}
                    </div>
                    {{-- end of add room form with style --}}
                </div>
            </div>
        </div>
    </div>
    <script>
        const input = document.getElementById('date_room_reservation');
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        input.value = `${yyyy}-${mm}-${dd}`;
    </script>
</x-layout.main>