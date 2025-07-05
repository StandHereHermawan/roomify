@php

    $default_name = "Pinjam Ruangan";
    $default_description = "Lorem ipsum dolor sit amet consectetur adipisicing elit.";
    $default_pagination_view = "vendor.custom.bootstrap-5-custom";

    $title = "Daftar Sesi"
@endphp

<x-layout.main :title="$title">
    <x-navbar></x-navbar>

    {{-- Main Content --}}
    <main class="container-fluid container-md my-5">

        <div class="border rounded-3 px-4 pt-4 shadow">

            {{-- Search accordion --}}
            <div class="accordion mb-3 shadow-sm" id="accordionExample1">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#room-session-search-accordeon" aria-expanded="true"
                            aria-controls="room-session-search-accordeon" style="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-search me-3" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                            </svg>
                            Cari Sesi
                        </button>
                    </h2>
                    <div id="room-session-search-accordeon" class="accordion-collapse collapse show"
                        data-bs-parent="#accordionExample1">
                        <div class="accordion-body">
                            <form action="#" method="get" class="d-flex justify-content-center mb-3 mb-lg-0">
                                <div class="col">
                                    <span disabled class="btn btn-outline-primary btn-lg mb-1 w-100">Room Session
                                        Start</span>
                                    <div class="input-group mb-3">
                                        <div class="input-group shadow-sm">
                                            <span class="input-group-text">Jam, Menit and Detik</span>
                                            <input type="number" min="0" max="23" value="00" aria-label=""
                                                class="form-control" name="start-hour">
                                            <input type="number" min="0" max="59" value="00" aria-label=""
                                                class="form-control" name="start-minutes">
                                            <input type="number" min="0" max="59" value="00" aria-label=""
                                                class="form-control" name="start-second">
                                        </div>

                                    </div>
                                    <span disabled class="btn btn-outline-primary btn-lg mb-1 w-100">Room Session
                                        End</span>
                                    <div class="input-group mb-3 shadow-sm">
                                        <span class="input-group-text">Jam, Menit and Detik</span>
                                        <input type="number" min="0" max="23" value="23" aria-label=""
                                            class="form-control" name="end-hour">
                                        <input type="number" min="0" max="59" value="59" aria-label=""
                                            class="form-control" name="end-minutes">
                                        <input type="number" min="0" max="59" value="59" aria-label=""
                                            class="form-control" name="end-second">
                                    </div>
                                    <button class="btn btn-primary btn-lg w-100 shadow-sm" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path
                                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                        </svg>
                                        Cari
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End of Search accordion --}}

            {{-- button section --}}
            <div class="d-flex justify-content-between mt-2 my-3">
                {{-- Button --}}
                <a href="{{ url()->route('add-room-session') }}" class="text-decoration-none me-1">
                    <button type="button" class="btn btn-primary d-flex shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-plus-lg me-1" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                        </svg>
                        <div>
                            Tambah Sesi
                        </div>
                    </button>
                </a>
                {{-- End of Button --}}

                {{-- Button --}}
                {{--<a href="{{ route('list-of-room') }}" class="text-decoration-none">
                    <button type="button" class="btn btn-primary d-flex shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-door-open me-1" viewBox="0 0 16 16">
                            <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1" />
                            <path
                                d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117M11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5M4 1.934V15h6V1.077z" />
                        </svg>
                        <div>
                            Halaman Ruangan
                        </div>
                    </button>
                </a>--}}
                {{-- End of Button --}}
            </div>
            {{-- end of button section --}}


            {{-- Bagian tabel --}}
            <div class="row">

                <table class="table">
                    {{-- table header --}}
                    <thead>
                        <tr>
                            <th scope="col">
                                <div class="h3 text-primary">
                                    #
                                </div>
                            </th>
                            <th scope="col">
                                <div class="h3 text-primary">
                                    Room Session Start
                                </div>
                            </th>
                            <th scope="col">
                                <div class="h3 text-primary">
                                    Room Session End
                                </div>
                            </th>
                            <th scope="col">
                                <div class="d-flex">
                                    <div class="h3 text-primary me-1">
                                        Option
                                    </div>
                                </div>
                            </th>
                            {{-- <th scope="col">Handle</th> --}}
                        </tr>
                    </thead>
                    {{-- end of table header --}}

                    {{-- table body --}}
                    <tbody class="table-group-divider text-primary">
                        @if (isset($listOfSession) && is_iterable($listOfSession))

                            {{-- Pagination Navigation --}}
                            <div class="mt-2">
                                {{ $listOfSession->links($default_pagination_view) }}
                            </div>
                            {{-- End of Pagination Navigation --}}

                            @foreach ($listOfSession as $oneSession)
                                {{-- Row --}}
                                <tr>
                                    <th scope="row">
                                        <div class="h3">
                                            {{ $oneSession->id }}
                                        </div>
                                    </th>
                                    <td scope="row">
                                        <div class="h3">
                                            {{ $oneSession->room_session_start }}
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <div class="h3">
                                            {{ $oneSession->room_session_end }}
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <div class="d-flex">
                                            <form action="{{ url()->route('edit-room-session') }}" method="get">
                                                <input type="hidden" name="room-session-id" value="{{ $oneSession->id }}">
                                                <button class="btn btn-primary me-1" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                        <path
                                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                        <path fill-rule="evenodd"
                                                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="{{ url()->route('delete-session') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="room-session-id" value="{{ $oneSession->id }}">
                                                <button class="btn btn-primary" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                {{-- End of Row --}}
                            @endforeach
                        @endif
                    </tbody>
                    {{-- end of table body --}}
                </table>
            </div>
            {{-- End of Bagian tabel --}}
        </div>
    </main>
    {{-- End of Main Content --}}
</x-layout.main>