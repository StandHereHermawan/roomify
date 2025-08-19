@php

    $title = "Tambah Ruangan";

@endphp

<x-layout.main :title="$title">
    {{-- --}}
    <div class="mt-3">
        {{-- --}}
        <div class="container-fluid container-md">
            {{-- --}}
            <div class="col-auto col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">
                {{-- --}}
                <div class="p-4 border rounded-3 shadow">
                    {{-- --}}
                    <form id="myForm" action="" method="post" novalidate>
                        {{-- --}}
                        @csrf
                        {{-- --}}
                        {{-- header form --}}
                        <h1 class="mb-4 text-center text-primary">{{ $title }}</h1>
                        {{-- end header form --}}
                        {{-- --}}
                        {{-- new room name input --}}
                        <div class="form-floating mb-3">
                            {{-- --}}
                            <input name="nama-ruangan" type="text" class="form-control shadow-sm"
                                id="nama-ruangan-label" placeholder="nama-ruangan-input">
                            <label for="nama-ruangan-label">Nama Ruangan</label>
                            {{-- --}}
                            {{-- room name error message --}}
                            @if ($errors->any())
                                @error('nama-ruangan')
                                    <div class="btn btn-outline-danger my-2 w-100">
                                        {{ $errors->first('nama-ruangan') }}
                                    </div>
                                @enderror
                            @endif
                            @isset($error_add_room_name)
                                @if (strlen($error_add_room_name) > 2)
                                    <div class="btn btn-outline-danger w-100 mt-2">{{ $error_add_room_name }}</div>
                                @endif
                            @endisset
                            {{-- end room name error message --}}
                            {{-- --}}
                            <div class="form-text">
                                Example: <b>Ruang Kelas</b>, Ruang Biasa, <b>Lab</b>.
                            </div>
                            {{-- --}}
                        </div>
                        {{-- end of new room name input --}}
                        {{-- --}}
                        {{-- new room code input --}}
                        <div class="form-floating mb-3">
                            <input name="kode-ruangan" type="text" class="form-control shadow-sm"
                                id="kode-ruangan-label" placeholder="kode-ruangan-input">
                            <label for="kode-ruangan-label">Kode Ruangan</label>
                            {{-- --}}
                            {{-- room code error message --}}
                            @if ($errors->any())
                                @error('kode-ruangan')
                                    <div class="btn btn-outline-danger my-2 w-100">
                                        {{ $errors->first('kode-ruangan') }}
                                    </div>
                                @enderror
                            @endif
                            @isset($error_add_room_code)
                                @if (strlen($error_add_room_code) > 2)
                                    <div class="btn btn-outline-danger w-100 mt-2"> {{ $error_add_room_code }} </div>
                                @endif
                            @endisset
                            {{-- end room code error message --}}
                            {{-- --}}
                            <div class="form-text">
                                Example: <b>B-308</b>, A-104, <b>C-201</b>.
                            </div>
                            {{-- --}}
                        </div>
                        {{-- end of new room code input --}}
                        {{-- --}}
                        {{-- new input --}}
                        <div class="form-floating mb-3">
                            <input name="tinggi-ruangan" type="text" class="form-control shadow-sm"
                                id="tinggi-ruangan-label" placeholder="tinggi-ruangan-input">
                            <label for="tinggi-ruangan-label">Tinggi Ruangan</label>
                            {{-- --}}
                            {{-- error message --}}
                            @if ($errors->any())
                                @error('tinggi-ruangan')
                                    <div class="btn btn-outline-danger my-2 w-100">
                                        {{ $errors->first('tinggi-ruangan') }}
                                    </div>
                                @enderror
                            @endif
                            @isset($error_add_room_height)
                                @if (strlen($error_add_room_height) > 2)
                                    <div class="btn btn-outline-danger w-100 mt-2"> {{ $error_add_room_height }} </div>
                                @endif
                            @endisset
                            {{-- end error message --}}
                            {{-- --}}
                            <div class="form-text">
                                Example: <b>2</b> Meter, <b>2.5</b> Meter.
                            </div>
                            {{-- --}}
                        </div>
                        {{-- end of new input --}}
                        {{-- --}}
                        {{-- new input --}}
                        <div class="form-floating mb-3">
                            <input name="luas-ruangan" type="text" class="form-control shadow-sm"
                                id="luas-ruangan-label" placeholder="luas-ruangan-input">
                            <label for="luas-ruangan-label">Luas Ruangan</label>
                            {{-- --}}
                            {{-- error message --}}
                            @if ($errors->any())
                                @error('luas-ruangan')
                                    <div class="btn btn-outline-danger my-2 w-100">
                                        {{ $errors->first('luas-ruangan') }}
                                    </div>
                                @enderror
                            @endif
                            @isset($error_add_room_wide)
                                @if (strlen($error_add_room_wide) > 2)
                                    <div class="btn btn-outline-danger w-100 mt-2"> {{ $error_add_room_wide }} </div>
                                @endif
                            @endisset
                            {{-- end error message --}}
                            {{-- --}}
                            <div class="form-text">
                                Example: <b>2</b> Meter, <b>2.5</b> Meter.
                            </div>
                            {{-- --}}
                        </div>
                        {{-- end of new input --}}
                        {{-- --}}
                        <div>
                            <x-form.submit.button :name="$title"></x-form.submit.button>
                        </div>
                        {{-- --}}
                    </form>
                    {{-- --}}
                    {{-- back to room session page --}}
                    <a href="{{ route('list-of-room') }}">
                        <div class="form-floating my-2">
                            <button type="reset" class="btn btn-outline-secondary w-100 shadow-sm">
                                Back to List of Room
                            </button>
                        </div>
                    </a>
                    {{-- end of back to room session page --}}
                    {{-- --}}
                </div>
                {{-- --}}
            </div>
            {{-- --}}
        </div>
        {{-- --}}
    </div>
</x-layout.main>