@php

    $default_pagination_view = "vendor.custom.bootstrap-5-custom";
    $title = "Akun aktif saat ini";

@endphp

<x-layout.main :title="$title">
    <x-navbar></x-navbar>
    <div class="container-fluid container-lg mt-3">
        <div class="col-auto col-md-8 offset-md-2 col-lg-6 offset-lg-3">
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
                                    <div class="fw-light fs-5">{{ "@".$user_model->getUsername() ??
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
                            <div class="list-group-item list-group-item-action shadow-sm">
                                <div class="d-flex justify-content-between">
                                    <div class="fw-light fs-5">{{ $user_model->getName() ?? "name_not_set" }}
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </div>
                    {{-- end of informasi nama --}}
                    {{-- informasi email --}}
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between mb-1">
                            <h5 class="mb-1">Email ter-registrasi</h5>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                                <a href="{{ route('add-email') }}" class="btn btn-outline-primary py-0 px-2">
                                    <i class="bi bi-envelope-plus fs-3"></i>
                                </a>
                            </div>
                        </div>
                        @if (isset($email_model) && is_iterable($email_model))
                            @if ($email_model->count() >= 1)
                                {{ $email_model->links($default_pagination_view) }}
                                <ul class="list-group mb-2">
                                    @foreach ($email_model as $email_record)
                                        <li class="list-group-item list-group-item-action shadow-sm">
                                            <a href="{{ route('edit-email') . "?id=" . $email_record->id }}"
                                                class="d-flex justify-content-between text-decoration-none">
                                                <div>
                                                    {{ $email_record->email }}
                                                </div>
                                                <div>
                                                    {{ Illuminate\Support\Carbon::parse($email_record->created_at)->translatedFormat('d F Y') }}
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <ul class="list-group mb-2">
                                    <li class="list-group-item list-group-item-action shadow-sm">
                                        Belum ada email teregistrasi.
                                    </li>
                                </ul>
                            @endif
                        @else
                            <ul class="list-group mb-2">
                                <li class="list-group-item list-group-item-action shadow-sm">
                                    Belum ada email teregistrasi.
                                </li>
                            </ul>
                        @endif
                    </div>
                    {{-- end of informasi email --}}
                    {{-- informasi nomor telepon --}}
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between mb-1">
                            <h5 class="mb-1">Nomor Telpon ter-registrasi</h5>
                            <a href="{{ route('add-phone-number') }}" class="btn btn-outline-primary py-0 px-2">
                                <i class="bi bi-telephone-plus fs-3"></i>
                            </a>
                        </div>
                        @if (isset($phone_number_model) && is_iterable($phone_number_model))
                            @if ($phone_number_model->count() >= 1)
                                <div>
                                    {{ $phone_number_model->links($default_pagination_view) }}
                                </div>
                                <ul class="list-group mb-2">
                                    @foreach ($phone_number_model as $phone_number_record)
                                        <li class="list-group-item list-group-item-action shadow-sm">
                                            <a href="{{ route('edit-phone-number') . "?id=" . $phone_number_record->getId() }}"
                                                class="d-flex justify-content-between text-decoration-none">
                                                <div>
                                                    {{ $phone_number_record->phone_number }}
                                                </div>
                                                <div>
                                                    {{ Illuminate\Support\Carbon::parse($phone_number_record->created_at)->translatedFormat('d F Y') }}
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <ul class="list-group mb-2">
                                    <li class="list-group-item list-group-item-action shadow-sm">
                                        Belum ada nomor telpon teregistrasi.
                                    </li>
                                </ul>
                            @endif
                        @else
                            <ul class="list-group mb-2">
                                <li class="list-group-item list-group-item-action shadow-sm">
                                    Belum ada nomor telpon teregistrasi.
                                </li>
                            </ul>
                        @endif
                    </div>
                    {{-- end of informasi nomor telepon --}}
                    {{-- informasi contoh role --}}
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">Role dimiliki</h5>
                            <small class="text-body-secondary">changed a long time ago.</small>
                        </div>
                        @if (isset($role_model) && is_iterable($role_model))
                            @if ($role_model->count() >= 1)
                                <div>
                                    {{ $role_model->links() }}
                                </div>
                                <ul class="list-group mb-2">
                                    @foreach ($role_model as $phone_number_record)
                                        <li class="list-group-item list-group-item-action shadow-sm">
                                            <a class="d-flex justify-content-between text-decoration-none">
                                                <div>
                                                    {{ $phone_number_record->role }}
                                                </div>
                                                <div>
                                                    {{ Illuminate\Support\Carbon::parse($phone_number_record->created_at)->translatedFormat('d F Y') }}
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <ul class="list-group mb-2">
                                    <li class="list-group-item list-group-item-action shadow-sm">
                                        Belum ada Role teregistrasi.
                                    </li>
                                </ul>
                            @endif
                        @else
                            <ul class="list-group mb-2">
                                <li class="list-group-item list-group-item-action shadow-sm">
                                    Belum ada Role teregistrasi.
                                </li>
                            </ul>
                        @endif
                    </div>
                    {{-- end of informasi contoh role --}}
                    <div class="list-group-item" aria-current="true">
                        <div class="d-flex w-100 justify-content-center">
                            <h5 class="mb-1">
                                Utilities
                            </h5>
                        </div>
                        <div class="input-group mb-3 justify-content-center">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary shadow"
                                type="button">Home</a>
                            <button class="btn btn-outline-primary shadow" onclick="toggleTheme()" type="button">Switch
                                Theme</button>
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