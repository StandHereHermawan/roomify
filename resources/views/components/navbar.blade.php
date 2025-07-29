@php

    $default_name = "Pinjam Ruangan";
    $default_description = "Lorem ipsum dolor sit amet consectetur adipisicing elit.";

@endphp

{{-- Simplicity is the essence of happiness. - Cedric Bledsoe --}}
{{-- --}}
{{-- upper navbar --}}
<header class="py-3 mb-4 border-bottom shadow-sm sticky-top bg-body">
    <div class="container-fluid container-md">
        <div class="d-flex flex-wrap justify-content-between">
            <div class="d-flex align-items-center mb-lg-0 me-lg-auto link-body-emphasis text-decoration-none">
                {{-- icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                    class="bi bi-door-open text-primary" viewBox="0 0 16 16">
                    <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1" />
                    <path
                        d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117M11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5M4 1.934V15h6V1.077z" />
                </svg>
                {{-- end of icon --}}
                {{-- navigation name --}}
                <span class="ms-2 fs-2 me-2 text-primary">{{ $topNavbarText ?? $default_name }}</span>
                {{-- end of navigation name --}}
            </div>
            <div class="col-auto">
                <div class="d-flex justify-content-center mb-lg-0">
                    <a href="" class="me-3">
                        <i class="bi bi-person-circle fs-1"></i>
                    </a>
                    {{-- button offcanva trigger --}}
                    <button class="btn btn-lg btn-outline-primary shadow-sm" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
                        <div class="d-flex">
                            {{--
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                class="bi bi-list" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                            </svg>
                            --}}
                            <i class="bi bi-list fs-4"></i>
                            <div class="ms-1">
                                <b class="fs-4">Menu</b>
                            </div>
                        </div>
                    </button>
                    {{-- end of button offcanva trigger --}}
                </div>
            </div>
        </div>
    </div>
</header>
{{-- end of upper navbar --}}
{{-- --}}
{{-- offcanvas baru muncul kalau klik tombol menut. --}}
<div class="offcanvas offcanvas-start shadow-lg" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
    id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel" aria-modal="true" role="dialog">
    {{-- --}}
    {{-- header inside offcanvas --}}
    <div class="offcanvas-header">
        <div class="container-fluid row">
            <div class="col">
                <h5 class="offcanvas-title " id="offcanvasScrollingLabel">
                    {{$offCanvaTitle ?? $default_name}}
                </h5>
            </div>
            <div class="col-1">
                <div class="pt-2">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    {{-- end of header inside offcanvas --}}
    {{-- --}}
    {{-- sidebar --}}
    <div class="offcanvas-body">
        <p>{{$offCanvaHeader ?? $default_description}}</p>
        {{-- first accordion --}}
        <div class="accordion mb-3 shadow-sm" id="accordion-in-offcanva" style="">
            {{-- --}}
            <div class="accordion-item">
                {{-- --}}
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse-room-accordion" aria-expanded="false"
                        aria-controls="collapse-room-accordion">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-door-open me-2" viewBox="0 0 16 16">
                            <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1" />
                            <path
                                d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117M11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5M4 1.934V15h6V1.077z" />
                        </svg>
                        <div>
                            Bagian Ruangan
                        </div>
                    </button>
                </h2>
                {{-- --}}
                {{-- --}}
                <div id="collapse-room-accordion" class="accordion-collapse collapse"
                    data-bs-parent="#accordion-in-offcanva">
                    <div class="accordion-body">
                        <div class="row row-cols-1 g-2">
                            <a href="{{ route('dashboard') }}"
                                class="d-flex justify-content-center text-decoration-none mb-lg-0">
                                <button class="btn btn-outline-primary w-100 text-start" type="submit"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                                    aria-controls="offcanvasScrolling">
                                    <i class="bi bi-house fs-5 me-1"></i>
                                    Dashboard
                                </button>
                            </a>
                            <a href="{{ route('list-of-room') }}"
                                class="d-flex justify-content-center text-decoration-none mb-lg-0">
                                <button class="btn btn-outline-primary w-100 text-start" type="submit"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                                    aria-controls="offcanvasScrolling">
                                    <i class="bi bi-list fs-5 me-1"></i>
                                    Daftar Ruangan
                                </button>
                            </a>
                            <a href="{{ route('list-of-room') }}"
                                class="d-flex justify-content-center text-decoration-none mb-lg-0">
                                <button class="btn btn-outline-primary w-100 text-start" type="submit"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                                    aria-controls="offcanvasScrolling">
                                    <i class="bi bi-list fs-5 me-1"></i>
                                    Daftar Ruangan Dipinjam
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- --}}
            </div>
            {{-- --}}
            {{-- --}}
            <div class="accordion-item">
                {{-- --}}
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse-room-reservation-accordion" aria-expanded="false"
                        aria-controls="collapse-room-reservation-accordion">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-door-open me-2" viewBox="0 0 16 16">
                            <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1" />
                            <path
                                d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117M11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5M4 1.934V15h6V1.077z" />
                        </svg>
                        <div>
                            Bagian Pinjam Ruangan
                        </div>
                    </button>
                </h2>
                {{-- --}}
                {{-- --}}
                <div id="collapse-room-reservation-accordion" class="accordion-collapse collapse"
                    data-bs-parent="#accordion-in-offcanva">
                    <div class="accordion-body">
                        <div class="row row-cols-1 g-2">
                            <a href="{{ route('room-reservation-request') }}"
                                class="d-flex justify-content-center text-decoration-none mb-lg-0">
                                <button class="btn btn-outline-primary w-100 text-start" type="submit"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                                    aria-controls="offcanvasScrolling">
                                    <i class="bi bi-send fs-5 me-1"></i>
                                    Pengajuan Peminjaman Ruangan
                                </button>
                            </a>
                            <a href="{{ route('list-of-room-reservation-request') }}"
                                class="d-flex justify-content-center text-decoration-none mb-lg-0">
                                <button class="btn btn-outline-primary w-100 text-start" type="submit"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                                    aria-controls="offcanvasScrolling">
                                    <i class="bi bi-list fs-5 me-1"></i>
                                    Semua Pengajuan Pinjam Ruangan (Harusnya ga semua orang bisa akses url ini)
                                </button>
                            </a>
                            <a href="{{ route('list-of-my-room-reservation-request') }}"
                                class="d-flex justify-content-center text-decoration-none mb-lg-0">
                                <button class="btn btn-outline-primary w-100 text-start" type="submit"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                                    aria-controls="offcanvasScrolling">
                                    <i class="bi bi-list fs-5 me-1"></i>
                                    Pengajuan Pinjam Ruangan oleh Saya
                                </button>
                            </a>
                            <a href="{{ route('manage-list-of-room-reservation-request') }}"
                                class="d-flex justify-content-center text-decoration-none mb-lg-0">
                                <button class="btn btn-outline-primary w-100 text-start" type="submit"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                                    aria-controls="offcanvasScrolling">
                                    <i class="bi bi-list fs-5 me-1"></i>
                                    Kelola Pengajuan Pinjam Ruangan (Harusnya hanya boleh admin)
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                {{-- --}}
            </div>
            {{-- --}}
            {{-- --}}
            <div class="accordion-item">
                {{-- --}}
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse-room-session-accordion" aria-expanded="false"
                        aria-controls="collapse-room-session-accordion">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-stopwatch me-2" viewBox="0 0 16 16">
                            <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5z" />
                            <path
                                d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64l.012-.013.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5M8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3" />
                        </svg>
                        <div>
                            Bagian Sesi Ruangan
                        </div>
                    </button>
                </h2>
                {{-- --}}
                {{-- --}}
                <div id="collapse-room-session-accordion" class="accordion-collapse collapse"
                    data-bs-parent="#accordion-in-offcanva">
                    <div class="accordion-body">
                        <div class="row row-cols-1 g-2">
                            <a href="{{ route('list-of-room-session') }}"
                                class="d-flex justify-content-center text-decoration-none mb-lg-0">
                                <button class="btn btn-outline-primary w-100 text-start" type="submit"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                                    aria-controls="offcanvasScrolling">
                                    <i class="bi bi-list fs-5 me-1"></i>
                                    Daftar Sesi Ruangan
                                </button>
                            </a>
                            {{--
                            <form action="{{ route('list-of-room-session') }}" method="get"
                                class="d-flex justify-content-center mb-lg-0">
                                <button class="btn btn-outline-primary w-100 text-start" type="submit"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                                    aria-controls="offcanvasScrolling">
                                    <i class="bi bi-list fs-5 me-1"></i>
                                    Daftar Sesi Ruangan
                                </button>
                            </form>
                            --}}
                            <a href="{{ route('add-room-session') }}"
                                class="d-flex justify-content-center text-decoration-none mb-lg-0">
                                <button class="btn btn-outline-primary w-100 text-start" type="submit"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                                    aria-controls="offcanvasScrolling">
                                    <i class="bi bi-list fs-5 me-1"></i>
                                    Tambah Sesi Ruangan
                                </button>
                            </a>
                            {{--
                            <form action="{{ route('add-room-session') }}" method="get"
                                class="d-flex justify-content-center mb-lg-0">
                                <button class="btn btn-outline-primary w-100 text-start" type="submit"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                                    aria-controls="offcanvasScrolling">
                                    <i class="bi bi-list fs-5 me-1"></i>
                                    Tambah Sesi Ruangan
                                </button>
                            </form>
                            --}}
                        </div>
                    </div>
                </div>
                {{-- --}}
            </div>
            {{-- --}}
            {{-- --}}
            <div class="accordion-item">
                {{-- --}}
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse-account-accordion" aria-expanded="false"
                        aria-controls="collapse-account-accordion">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-person me-2" viewBox="0 0 16 16">
                            <path
                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                        </svg>
                        <div>
                            Bagian Akun Pengguna
                        </div>
                    </button>
                </h2>
                {{-- --}}
                {{-- --}}
                <div id="collapse-account-accordion" class="accordion-collapse collapse"
                    data-bs-parent="#accordion-in-offcanva">
                    <div class="accordion-body">
                        <div class="row row-cols-1 g-2">
                            <a href="{{ route('account') }}"
                                class="d-flex justify-content-center text-decoration-none mb-lg-0">
                                <button class="btn btn-outline-primary w-100 text-start" type="submit"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                                    aria-controls="offcanvasScrolling">
                                    <i class="bi bi-gear-wide fs-5 me-1"></i>
                                    {{--
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-gear-wide" viewBox="0 0 16 16">
                                        <path
                                            d="M8.932.727c-.243-.97-1.62-.97-1.864 0l-.071.286a.96.96 0 0 1-1.622.434l-.205-.211c-.695-.719-1.888-.03-1.613.931l.08.284a.96.96 0 0 1-1.186 1.187l-.284-.081c-.96-.275-1.65.918-.931 1.613l.211.205a.96.96 0 0 1-.434 1.622l-.286.071c-.97.243-.97 1.62 0 1.864l.286.071a.96.96 0 0 1 .434 1.622l-.211.205c-.719.695-.03 1.888.931 1.613l.284-.08a.96.96 0 0 1 1.187 1.187l-.081.283c-.275.96.918 1.65 1.613.931l.205-.211a.96.96 0 0 1 1.622.434l.071.286c.243.97 1.62.97 1.864 0l.071-.286a.96.96 0 0 1 1.622-.434l.205.211c.695.719 1.888.03 1.613-.931l-.08-.284a.96.96 0 0 1 1.187-1.187l.283.081c.96.275 1.65-.918.931-1.613l-.211-.205a.96.96 0 0 1 .434-1.622l.286-.071c.97-.243.97-1.62 0-1.864l-.286-.071a.96.96 0 0 1-.434-1.622l.211-.205c.719-.695.03-1.888-.931-1.613l-.284.08a.96.96 0 0 1-1.187-1.186l.081-.284c.275-.96-.918-1.65-1.613-.931l-.205.211a.96.96 0 0 1-1.622-.434zM8 12.997a4.998 4.998 0 1 1 0-9.995 4.998 4.998 0 0 1 0 9.996z" />
                                    </svg>
                                    --}}
                                    Akun Saat Ini
                                </button>
                            </a>
                            {{--
                            <form action="{{ route('account') }}" method="get"
                                class="d-flex justify-content-center mb-lg-0">
                                <button class="btn btn-outline-primary w-100 text-start" type="submit"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                                    aria-controls="offcanvasScrolling">
                                    <i class="bi bi-gear-wide fs-5 me-1"></i>
                                    {{--
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                        class="bi bi-gear-wide" viewBox="0 0 16 16">
                                        <path
                                            d="M8.932.727c-.243-.97-1.62-.97-1.864 0l-.071.286a.96.96 0 0 1-1.622.434l-.205-.211c-.695-.719-1.888-.03-1.613.931l.08.284a.96.96 0 0 1-1.186 1.187l-.284-.081c-.96-.275-1.65.918-.931 1.613l.211.205a.96.96 0 0 1-.434 1.622l-.286.071c-.97.243-.97 1.62 0 1.864l.286.071a.96.96 0 0 1 .434 1.622l-.211.205c-.719.695-.03 1.888.931 1.613l.284-.08a.96.96 0 0 1 1.187 1.187l-.081.283c-.275.96.918 1.65 1.613.931l.205-.211a.96.96 0 0 1 1.622.434l.071.286c.243.97 1.62.97 1.864 0l.071-.286a.96.96 0 0 1 1.622-.434l.205.211c.695.719 1.888.03 1.613-.931l-.08-.284a.96.96 0 0 1 1.187-1.187l.283.081c.96.275 1.65-.918.931-1.613l-.211-.205a.96.96 0 0 1 .434-1.622l.286-.071c.97-.243.97-1.62 0-1.864l-.286-.071a.96.96 0 0 1-.434-1.622l.211-.205c.719-.695.03-1.888-.931-1.613l-.284.08a.96.96 0 0 1-1.187-1.186l.081-.284c.275-.96-.918-1.65-1.613-.931l-.205.211a.96.96 0 0 1-1.622-.434zM8 12.997a4.998 4.998 0 1 1 0-9.995 4.998 4.998 0 0 1 0 9.996z" />
                                    </svg>
                                    --/}}
                                    Akun Saat Ini
                                </button>
                            </form>
                            --}}
                            <a href="{{ route('list-of-account') }}"
                                class="d-flex justify-content-center text-decoration-none mb-lg-0">
                                <button class="btn btn-outline-primary w-100 text-start" type="submit"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                                    aria-controls="offcanvasScrolling">
                                    <i class="bi bi-list fs-5 me-1"></i>
                                    {{--
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                        class="bi bi-list-ol" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5" />
                                        <path
                                            d="M1.713 11.865v-.474H2c.217 0 .363-.137.363-.317 0-.185-.158-.31-.361-.31-.223 0-.367.152-.373.31h-.59c.016-.467.373-.787.986-.787.588-.002.954.291.957.703a.595.595 0 0 1-.492.594v.033a.615.615 0 0 1 .569.631c.003.533-.502.8-1.051.8-.656 0-1-.37-1.008-.794h.582c.008.178.186.306.422.309.254 0 .424-.145.422-.35-.002-.195-.155-.348-.414-.348h-.3zm-.004-4.699h-.604v-.035c0-.408.295-.844.958-.844.583 0 .96.326.96.756 0 .389-.257.617-.476.848l-.537.572v.03h1.054V9H1.143v-.395l.957-.99c.138-.142.293-.304.293-.508 0-.18-.147-.32-.342-.32a.33.33 0 0 0-.342.338zM2.564 5h-.635V2.924h-.031l-.598.42v-.567l.629-.443h.635z" />
                                    </svg>
                                    --}}
                                    Daftar Akun Teregistrasi (Harusnya hanya boleh admin)
                                </button>
                            </a>
                            {{--
                            <form action="{{ route('list-of-account') }}" method="get"
                                class="d-flex justify-content-center mb-lg-0">
                                <button class="btn btn-outline-primary w-100 text-start" type="submit"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                                    aria-controls="offcanvasScrolling">
                                    <i class="bi bi-list fs-5 me-1"></i>
                                    {{--
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                        class="bi bi-list-ol" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5" />
                                        <path
                                            d="M1.713 11.865v-.474H2c.217 0 .363-.137.363-.317 0-.185-.158-.31-.361-.31-.223 0-.367.152-.373.31h-.59c.016-.467.373-.787.986-.787.588-.002.954.291.957.703a.595.595 0 0 1-.492.594v.033a.615.615 0 0 1 .569.631c.003.533-.502.8-1.051.8-.656 0-1-.37-1.008-.794h.582c.008.178.186.306.422.309.254 0 .424-.145.422-.35-.002-.195-.155-.348-.414-.348h-.3zm-.004-4.699h-.604v-.035c0-.408.295-.844.958-.844.583 0 .96.326.96.756 0 .389-.257.617-.476.848l-.537.572v.03h1.054V9H1.143v-.395l.957-.99c.138-.142.293-.304.293-.508 0-.18-.147-.32-.342-.32a.33.33 0 0 0-.342.338zM2.564 5h-.635V2.924h-.031l-.598.42v-.567l.629-.443h.635z" />
                                    </svg>
                                    --/}}
                                    Daftar Akun Teregistrasi (Harusnya hanya boleh admin)
                                </button>
                            </form>
                            --}}
                            <form action="{{ route('logout') }}" method="post"
                                class="d-flex justify-content-center mb-lg-0">
                                @csrf
                                <button class="btn btn-outline-danger w-100 text-start" type="submit"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling"
                                    aria-controls="offcanvasScrolling">
                                    <i class="bi bi-box-arrow-in-left fs-5 me-1"></i>
                                    {{--
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                        class="bi bi-box-arrow-in-left" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0z" />
                                        <path fill-rule="evenodd"
                                            d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                                    </svg>
                                    --}}
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- --}}
            </div>
            {{-- --}}
        </div>
        {{-- end of first accordion --}}
    </div>
    {{-- end of sidebar --}}
</div>
{{-- end of offcanvas baru muncul kalau klik tombol menu. --}}