@php

    $default_name = "Pinjam Ruangan";
    $default_description = "Lorem ipsum dolor sit amet consectetur adipisicing elit.";
    $default_page_name = "Halaman Utama";

@endphp

<x-layout.main :title="$default_name">
    <style>
        .bs-max-card-height-20rem {
            max-height: 20rem;
        }
    </style>
    <x-navbar></x-navbar>
    {{-- --}}
    {{-- <!-- item pagination  --> --}}
    <div class="container my-5">
        <div class="">
            <div class="border rounded-3 p-4 g-4 shadow">
                {{-- --}}
                <h1 class="mb-4 text-center text-{{ $color_primary ?? "primary" }}">{{ $default_page_name . " " . $default_name}}<hr/></h1>
                {{-- --}}
                {{-- Some view logic --}}
                <div class="col mt-3">
                    @if (isset($paginated_rooms) && is_iterable($paginated_rooms) && $paginated_rooms->total() >= 1)
                        {{-- Pagination Navigation --}}
                        <div class="">
                            {{ $paginated_rooms->links() }}
                        </div>
                        {{-- End of Pagination Navigation --}}
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3">
                            @foreach ($paginated_rooms as $room)
                                <div class="col">
                                    {{-- Card --}}
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
                                            <a href="{{ route('detail-room', $room->getId()) }}">
                                                <button type="submit" class="btn btn-outline-primary w-100 shadow-sm">
                                                    Detail Ruangan
                                                </button>
                                            </a>
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