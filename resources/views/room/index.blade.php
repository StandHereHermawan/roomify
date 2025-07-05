@php

    $default_name = "Pinjam Ruangan";
    $default_description = "Lorem ipsum dolor sit amet consectetur adipisicing elit.";
    $default_pagination_view = "vendor.custom.bootstrap-5-custom";

@endphp

<x-layout.main :title="$default_name">
    <style>
        .bs-max-card-height-20rem {
            max-height: 20rem;
        }
    </style>
    <x-navbar></x-navbar>

    {{-- <!-- item pagination  --> --}}
    <div class="container my-5">
        <div class="">
            <div class="border rounded-3 p-4 gy-3 shadow">
                {{-- Search accordion --}}
                <div class="col my-3">
                    <div class="accordion shadow-sm" id="accordion-room-search-specific">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#room-search-accordeon-specific" aria-expanded="true"
                                    aria-controls="room-search-accordeon-specific" style="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-search me-3" viewBox="0 0 16 16">
                                        <path
                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                    </svg>
                                    Cari Ruangan Spesifik
                                </button>
                            </h2>
                            <div id="room-search-accordeon-specific" class="accordion-collapse collapse show"
                                data-bs-parent="#accordion-room-search-specific">
                                <div class="accordion-body">
                                    <form action="#" method="get">
                                        <div class="row g-3 mb-3">
                                            <div class="col">
                                                <label for="search-nama-ruangan-label" class="form-label">Nama
                                                    Ruangan</label>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="search-nama-ruangan"
                                                        value="Ruang-Biasa" id="search-nama-ruangan-label"
                                                        placeholder="name@example.com">
                                                    <label for="search-nama-ruangan-label">Nama Ruangan</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label for="search-kode-ruangan-label" class="form-label">Kode
                                                    Ruangan</label>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="search-kode-ruangan"
                                                        value="A-101" id="search-kode-ruangan-label"
                                                        placeholder="Password">
                                                    <label for="search-kode-ruangan-label">Kode Ruangan</label>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="row g-3 mb-3">
                                            <div class="col">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="search-"
                                                        placeholder="name@example.com">
                                                    <label for="search-">Luas Lantai Ruangan</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="floatingPassword"
                                                        placeholder="Password">
                                                    <label for="floatingPassword">Tinggi Ruangan</label>
                                                </div>
                                            </div>
                                        </div>
                                        --}}
                                        <div class="d-flex justify-content-center mb-3 mb-lg-0">
                                            <div class="col">
                                                <button class="btn btn-primary btn-lg w-100 shadow-sm" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                        fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                        <path
                                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                                    </svg>
                                                    Cari
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col my-3">
                    <div class="accordion shadow-sm" id="accordion-room-search-general">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#room-search-accordeon-general" aria-expanded="true"
                                    aria-controls="room-search-accordeon-general" style="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-search me-3" viewBox="0 0 16 16">
                                        <path
                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                    </svg>
                                    Cari Ruangan Berdasarkan Ukuran
                                </button>
                            </h2>
                            <div id="room-search-accordeon-general" class="accordion-collapse collapse show"
                                data-bs-parent="#accordion-room-search-general">
                                <div class="accordion-body">
                                    {{--<form action="#" method="get">--}}
                                        <form action="#" method="get">
                                            <div class="row row-cols-1 row-cols-xl-3 g-3 mb-3">
                                                <div class="col">
                                                    <label for="search-tinggi-ruangan-terkecil-label"
                                                        class="form-label">
                                                        Tinggi Ruangan Terkecil <b class="opacity-50">Dalam Meter</b>
                                                    </label>
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control"
                                                            name="search-tinggi-terkecil-ruangan"
                                                            value="{{ $tinggi_ruangan_terkecil ?? ""}}"
                                                            id="search-tinggi-ruangan-terkecil-label"
                                                            placeholder="name@example.com">
                                                        <label for="search-tinggi-ruangan-terkecil-label">
                                                            Tinggi Ruangan Terkecil
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label for="search-tinggi-ruangan-terbesar-label"
                                                        class="form-label">
                                                        Tinggi Ruangan Terbesar <b class="opacity-50">Dalam Meter</b>
                                                    </label>
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control"
                                                            name="search-tinggi-terbesar-ruangan"
                                                            value="{{ $tinggi_ruangan_terbesar ?? "" }}"
                                                            id="search-tinggi-ruangan-terbesar-label"
                                                            placeholder="name@example.com">
                                                        <label for="search-tinggi-ruangan-terbesar-label">
                                                            Tinggi Ruangan Terbesar
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label for="search-luas-ruangan-terkecil-label" class="form-label">
                                                        Cari <b class="opacity-50">ke database.</b>
                                                    </label>
                                                    <button class="btn btn-primary btn-lg w-100 shadow-sm"
                                                        type="submit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            fill="currentColor" class="bi bi-search"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                                        </svg>
                                                        Cari Berdasarkan Tinggi Ruangan
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <form action="#" method="get">
                                            <div class="row row-cols-1 row-cols-xl-3 g-3 mb-3">
                                                <div class="col">
                                                    <label for="search-luas-ruangan-terkecil-label" class="form-label">
                                                        Luas Ruangan Terkecil <b class="opacity-50">Dalam Meter</b>
                                                    </label>
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control"
                                                            name="search-luas-terkecil-ruangan"
                                                            value="{{ $luas_ruangan_terkecil ?? ""}}"
                                                            id="search-luas-ruangan-terkecil-label"
                                                            placeholder="name@example.com">
                                                        <label for="search-luas-ruangan-terkecil-label">
                                                            Luas Ruangan Terkecil
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label for="search-luas-ruangan-terbesar-label" class="form-label">
                                                        Luas Ruangan Terbesar <b class="opacity-50">Dalam Meter</b>
                                                    </label>
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control"
                                                            name="search-luas-terbesar-ruangan"
                                                            value="{{ $luas_ruangan_terbesar ?? "" }}"
                                                            id="search-luas-ruangan-terbesar-label"
                                                            placeholder="name@example.com">
                                                        <label for="search-luas-ruangan-terbesar-label">
                                                            Luas Ruangan Terbesar
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label for="search-luas-ruangan-terkecil-label" class="form-label">
                                                        Cari <b class="opacity-50">ke database.</b>
                                                    </label>
                                                    <button class="btn btn-primary btn-lg w-100 shadow-sm"
                                                        type="submit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            fill="currentColor" class="bi bi-search"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                                        </svg>
                                                        Cari Berdasarkan Luas Ruangan
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        {{--
                                        <div class="d-flex justify-content-center mb-3 mb-lg-0">
                                            <div class="col">
                                                <button class="btn btn-primary btn-lg w-100 shadow-sm" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                                        <path
                                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                                    </svg>
                                                    Cari Berdasarkan Kriteria Tinggi dan Luas
                                                </button>
                                            </div>
                                        </div>
                                        --}}
                                    {{--</form>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End of Search accordion --}}

                {{-- Button section --}}
                <div class="col my-3">
                    <div class="d-flex justify-content-between">
                        {{-- Button --}}
                        <a href="{{ route('add-room') }}" class="text-decoration-none me-1">
                            <button type="button" class="btn btn-primary d-flex shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                    class="bi bi-plus-lg me-1" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                                </svg>
                                <div>
                                    Tambah Ruangan
                                </div>
                            </button>
                        </a>
                        {{-- End of Button --}}
                        {{-- Button --}}
                        {{--<a href="{{ route('list-of-room-session') }}" class="text-decoration-none">
                            <button type="button" class="btn btn-primary d-flex shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                    class="bi bi-stopwatch me-1" viewBox="0 0 16 16">
                                    <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5z" />
                                    <path
                                        d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64l.012-.013.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5M8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3" />
                                </svg>
                                <div>
                                    Halaman Session
                                </div>
                            </button>
                        </a>--}}
                        {{-- End of Button --}}
                    </div>
                </div>
                {{-- End of Button section --}}
                {{-- Some view logic --}}
                <div class="col my-3">
                    @if (isset($paginatedRooms) && is_iterable($paginatedRooms) && $paginatedRooms->total() >= 1)
                        {{-- Pagination Navigation --}}
                        <div class="mt-2">
                            {{ $paginatedRooms->links($default_pagination_view) }}
                        </div>
                        {{-- End of Pagination Navigation --}}
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3">
                            @foreach ($paginatedRooms as $room)
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
                                                    Tinggi: {{ (round($room->getRoomHeight(), 2) ?? "?") . " " . "meter." }}
                                                </div>
                                            </div>
                                            <div>
                                                <div class="opacity-75 fs-6 mb-1">
                                                    Luas Lantai: {{ (round($room->meter_squared_floor_wide, 2) ?? "?") }}
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
                    @else
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3">
                            @for ($i = 0; $i < 4; $i++)
                                <div class="col">
                                    {{-- card --}}
                                    <div class="card h-100 shadow-sm">
                                        {{-- Gray Placeholder --}}
                                        <svg aria-label="Placeholder: Image cap" class="bd-placeholder-img card-img-top"
                                            height="140" preserveAspectRatio="xMidYMid slice" role="img" width="100%"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <title>Placeholder</title>
                                            <rect width="100%" height="100%" fill="#868e96"></rect>
                                            <text x="45%" y="50%" fill="#dee2e6" dy=".3em">Image cap</text>
                                        </svg>
                                        {{-- end of Gray Placeholder --}}
                                        <div class="card-body">
                                            <h5 class="card-title text-primary">Ruangan tidak ketemu.</h5>
                                            <p class="card-text opacity-50">
                                                Coba untuk mengisi kriteria atau mengganti angka terbesar agar datanya ketemu.
                                            </p>
                                        </div>
                                    </div>
                                    {{-- end of card --}}
                                </div>
                            @endfor
                        </div>
                    @endif
                </div>
                {{-- end of some view logic --}}
            </div>
        </div>
    </div>
    {{-- <!-- end of item pagination --> --}}
</x-layout.main>