@php

    $default_name = "Pinjam Ruangan";
    $default_description = "Lorem ipsum dolor sit amet consectetur adipisicing elit.";
    $default_value = "?";
    $default_this_page_name = "Detail Ruangan";

@endphp

<x-layout.main :title="$default_this_page_name">
    <x-navbar></x-navbar>

    {{-- <!-- detail item  --> --}}
    <div class="container">
        @if (isset($room))
            <div class="card p-4 shadow">
                <h2 class="pb-2 border-bottom">{{ $default_this_page_name }}</h2>
                <div class="row row-cols-1 row-cols-md-2 align-items-md-center g-5 py-5">
                    <div class="col d-flex flex-column align-items-start gap-2">
                        <h2 class="fw-bold text-body-emphasis">Aplikasi pinjam ruangan detail ruangan</h2>
                        <p class="text-body-secondary">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore delectus, optio voluptatem
                            vitae odio molestiae maiores mollitia architecto deleniti magni autem officiis similique
                            blanditiis maxime, veritatis debitis ipsam expedita nemo?
                        </p>
                        <div class="shadow">
                            <a href="{{ route('list-of-room') }}" class="btn btn-primary btn-lg">Ke Halaman Ruangan</a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row row-cols-1 row-cols-sm-2 g-4">
                            <div class="col d-flex flex-column gap-2">
                                <h4 class="fw-semibold mb-0 text-body-emphasis">{{ $room->name }}</h4>
                                <p class="text-body-secondary">Nama ruangan yang tertera.
                                </p>
                            </div>
                            <div class="col d-flex flex-column gap-2">
                                <h4 class="fw-semibold mb-0 text-body-emphasis">{{ $room->room_code }}</h4>
                                <p class="text-body-secondary">Kode ruangan yang tertera.
                                </p>
                            </div>
                            <div class="col d-flex flex-column gap-2">
                                <h4 class="fw-semibold mb-0 text-body-emphasis">
                                    {{ round($room->meter_room_height, 2) . " " . "meter" }}
                                </h4>
                                <p class="text-body-secondary">Tinggi ruangan tertera.
                                </p>
                            </div>
                            <div class="col d-flex flex-column gap-2">
                                @if (isset($room->meter_squared_floor_wide))
                                    <h4 class="fw-semibold mb-0 text-body-emphasis">
                                        {{ round($room->meter_squared_floor_wide, 2) . " " }}
                                        <sup>2</sup>
                                        meter square
                                    </h4>
                                @else
                                    <h4 class="fw-semibold mb-0 text-body-emphasis">{{ $default_value }}
                                    </h4>
                                @endif
                                <p class="text-body-secondary">Luas lantai ruangan tertera.
                                </p>
                            </div>
                            <div class="col d-flex flex-column gap-2">
                                <h4 class="fw-semibold mb-0 text-body-emphasis">Diregistrasi Pada</h4>
                                <p class="text-body-secondary">
                                    {{ Illuminate\Support\Carbon::parse($room->created_at)->translatedFormat('d F Y, l, h:iA') }}
                                </p>
                            </div>
                            <div class="col d-flex flex-column gap-2">
                                <h4 class="fw-semibold mb-0 text-body-emphasis">Diubah pada</h4>
                                <p class="text-body-secondary">
                                    {{ Illuminate\Support\Carbon::parse($room->updated_at)->translatedFormat('d F Y, l, h:iA') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    {{-- <!-- end of detail item --> --}}
</x-layout.main>