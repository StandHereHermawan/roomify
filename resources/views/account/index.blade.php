@php

    $default_pagination_view = "vendor.custom.bootstrap-5-custom";
    $title = "Daftar Sesi";

@endphp

<x-layout.main :title="$title">
    <x-navbar></x-navbar>
    <div class="container-md mt-3">
        <div class="col-auto col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">
            <div class="border p-3 rounded-3 shadow">
                <h1 class="text-center text-primary mb-4">Informasi Akun</h1>
                <div class="list-group rounded-3 shadow-sm">
                    {{-- informasi username --}}
                    <div class="list-group-item" aria-current="true">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                                Username
                            </h5>
                            <small class="text-body-secondary">Created at
                                {{ Illuminate\Support\Carbon::parse($user_model->created_at)->translatedFormat('d F Y') }}
                            </small>
                        </div>
                        <ul class="list-group mb-2">
                            <li class="list-group-item list-group-item-action shadow-sm">
                                <div class="d-flex justify-content-between">
                                    <div class="fw-bold fs-5 opacity-50">{{ "@".$user_model->getUsername() ??
                                        "@username_not_set" }}</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    {{-- end of informasi username --}}
                    {{-- informasi nama --}}
                    <div class="list-group-item" aria-current="true">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                                Name
                            </h5>
                            <small class="text-body-secondary">Created at
                                {{ Illuminate\Support\Carbon::parse($user_model->created_at)->translatedFormat('d F Y') }}</small>
                        </div>
                        <ul class="list-group mb-2">
                            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action shadow-sm">
                                <div class="d-flex justify-content-between">
                                    <div class="fw-bold fs-5 opacity-50">{{ $user_model->getName() ?? "name_not_set" }}
                                    </div>
                                </div>
                            </a>
                        </ul>
                    </div>
                    {{-- end of informasi nama --}}
                    {{-- informasi email --}}
                    @if (isset($email_model) && is_iterable($email_model))
                        <div class="list-group-item">
                            <div>
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">Email ter-registrasi</h5>
                                    <small class="text-body-secondary"></small>
                                </div>
                                @if ($email_model->count() >= 1)
                                    {{ $email_model->links($default_pagination_view) }}
                                    <ul class="list-group mb-2">
                                        @foreach ($email_model as $email_record)
                                            <li class="list-group-item list-group-item-action shadow-sm">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        {{ $email_record->email }}
                                                    </div>
                                                    <div>
                                                        {{ Illuminate\Support\Carbon::parse($email_record->created_at)->translatedFormat('d F Y') }}
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <ul class="list-group mb-2">
                                        Belum ada email teregistrasi.

                                    </ul>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Email ter-registrasi</h5>
                                <small class="text-body-secondary"></small>
                            </div>
                            <ul class="list-group mb-2">
                                <li class="list-group-item list-group-item-action">
                                    Belum ada email teregistrasi.
                                </li>
                            </ul>
                        </div>
                    @endif
                    {{-- end of informasi email --}}
                    {{-- informasi nomor telepon --}}
                    @if (isset($phone_number_model) && is_iterable($phone_number_model))
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Nomor Telpon ter-registrasi</h5>
                                <small class="text-body-secondary"></small>
                            </div>
                            @if ($phone_number_model->count() >= 1)
                                <div>
                                    {{ $phone_number_model->links($default_pagination_view) }}
                                </div>
                                <ul class="list-group mb-2">
                                    @foreach ($phone_number_model as $phone_number_record)
                                        <li class="list-group-item list-group-item-action shadow-sm">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    {{ $phone_number_record->phone_number }}
                                                </div>
                                                <div>
                                                    {{ Illuminate\Support\Carbon::parse($phone_number_record->created_at)->translatedFormat('d F Y') }}
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <ul class="list-group mb-2">
                                    Belum ada nomor telpon teregistrasi.
                                </ul>
                            @endif
                        </div>
                    @else
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Nomor Telpon</h5>
                                <small class="text-body-secondary"></small>
                            </div>
                            <ul class="list-group mb-2">
                                <li class="list-group-item list-group-item-action">
                                    Belum ada nomor telpon teregistrasi.
                                </li>
                            </ul>
                        </div>
                    @endif
                    {{-- end of informasi nomor telepon --}}
                    {{-- informasi contoh role -->
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">Role dimiliki</h5>
                            <small class="text-body-secondary">changed a long time ago.</small>
                        </div>
                        <ul class="list-group mb-2">
                            <li class="list-group-item list-group-item-action">
                                Mahasiswa
                            </li>
                        </ul>
                    </div>
                    <!-- end of informasi contoh role -->
                    --}}
                    <div class="list-group-item" aria-current="true">
                        <div class="d-flex w-100 justify-content-center">
                            <h5 class="mb-1">
                                Utilities
                            </h5>
                        </div>
                        <div class="input-group mb-3 justify-content-center">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary" type="button">Home</a>
                            <button class="btn btn-outline-secondary" type="button">Button</button>
                            <button class="btn btn-outline-secondary" type="button">Button</button>
                            <button class="btn btn-outline-secondary" type="button">Button</button>
                        </div>
                        <ul class="list-group mb-2">
                        </ul>
                    </div>
                </div>
                <div class="form-floating text-center mt-3">
                    <p>
                        Sistem Informasi Peminjaman Ruangan
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layout.main>