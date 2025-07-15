@php

    $default_name = "Pinjam Ruangan";
    $default_description = "Lorem ipsum dolor sit amet consectetur adipisicing elit.";
    $default_pagination_view = "vendor.custom.bootstrap-5-custom";

    $title = "Kelola Pengajuan Pinjam Ruangan"
@endphp

<x-layout.main :title="$title">
    <x-navbar></x-navbar>
    {{-- Main Content --}}
    <main class="container-fluid container-md my-3">
        <div class="border rounded-3 px-4 pt-4 shadow">
            <div class="text-center text-primary h1">
                {{ $title }}
                <hr />
            </div>
            {{-- Bagian produk tetap sama --}}
            <div class="row">
                <table class="table">
                    {{-- table header --}}
                    <thead>
                        <tr>
                            <th scope="col">
                                <div class="fs-4 text-primary">
                                    id
                                </div>
                            </th>
                            <th scope="col">
                                <div class="fs-4 text-primary">
                                    Kode Ruangan
                                </div>
                            </th>
                            <th scope="col">
                                <div class="fs-4 text-primary">
                                    Pemohon
                                </div>
                            </th>
                            <th scope="col">
                                <div class="fs-4 text-primary">
                                    Status
                                </div>
                            </th>
                            <th scope="col">
                                <div class="fs-4 text-primary">
                                    Tanggal Ruangan Dipinjam
                                </div>
                            </th>
                            <th scope="col">
                                <div class="fs-4 text-primary">
                                    Tanggal Pengajuan
                                </div>
                            </th>
                            <th scope="col">
                                <div class="fs-4 text-primary">
                                    Sesi Ruangan Dipinjam
                                </div>
                            </th>
                            {{----}}
                            <th scope="col">
                                <div class="d-flex">
                                    <div class="h3 text-primary">
                                        Option
                                    </div>
                                </div>
                            </th>
                            {{----}}
                            {{--
                            <th scope="col">Handle</th>
                            --}}
                        </tr>
                    </thead>
                    {{-- end of table header --}}
                    {{-- table body --}}
                    <tbody class="table-group-divider text-primary">
                        @if (isset($list_of_room_reservation_request) && is_iterable($list_of_room_reservation_request))
                            {{-- Pagination Navigation --}}
                            <div class="mt-2">
                                {{ $list_of_room_reservation_request->links($default_pagination_view) }}
                            </div>
                            {{-- End of Pagination Navigation --}}
                            @foreach ($list_of_room_reservation_request as $reservation_request)
                                {{-- Row --}}
                                <tr>
                                    <th scope="row">
                                        <div class="fs-5">
                                            {{ $reservation_request->getId() }}
                                        </div>
                                    </th>
                                    <td scope="row">
                                        <div class="fs-5">
                                            {{ $reservation_request->roomReserved->room_code }}
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <div class="fs-5">
                                            {{ $reservation_request->userRequest->name }}
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <div class="fs-5">
                                            <button class="btn btn-warning">{{ $reservation_request->status }}</button>
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <div class="fs-5">
                                            {{ Illuminate\Support\Carbon::parse($reservation_request->reservation_date)->translatedFormat('d F Y') }}
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <div class="fs-5 row">
                                            {{ Illuminate\Support\Carbon::parse($reservation_request->created_at)->translatedFormat('d F Y') }}
                                        </div>
                                        <div class="fs-5 row">
                                            Pukul
                                            {{ Illuminate\Support\Carbon::parse($reservation_request->created_at)->translatedFormat('H:i') }}
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <div class="fs-5">
                                            <div>
                                                @php
                                                    $counter = 1;
                                                @endphp
                                                @foreach ($reservation_request->sessionBorrowed as $session)
                                                    <div class="row">
                                                        {{ "Sesi ke {$counter}: " . $session->room_session_start }}
                                                    </div>
                                                    @php
                                                        $counter++;
                                                    @endphp
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <div class="row row-cols-1 row-cols-xl-2 g-2">
                                            {{-- terima Pengajuan --}}
                                            <div class="col-auto">
                                                <form action="{{ route('accept-room-reservation-request') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="room_reservation_id"
                                                        value="{{ $reservation_request->getId() }}">
                                                    <button type="submit" class="btn btn-sm btn-success w-100">
                                                        Terima
                                                    </button>
                                                </form>
                                            </div>
                                            {{-- end of terima Pengajuan --}}
                                            {{-- tolak pengajuan --}}
                                            <div class="col-auto">
                                                <form action="{{ route('reject-room-reservation-request') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="room_reservation_id"
                                                        value="{{ $reservation_request->getId() }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                            {{-- end of tolak pengajuan --}}
                                            {{-- sembunyikan pengajuan --}}
                                            <div class="col-auto">
                                                <form action="{{ route('soft-delete-room-reservation-request') }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="room_reservation_id"
                                                        value="{{ $reservation_request->getId() }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary w-100">
                                                        Sembunyikan dari User
                                                    </button>
                                                </form>
                                            </div>
                                            {{-- end of sembunyikan pengajuan --}}
                                            {{-- hapus pengajuan --}}
                                            <div class="col-auto">
                                                <form action="{{ route('delete-room-reservation-request-from-database') }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="room_reservation_id"
                                                        value="{{ $reservation_request->getId() }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary w-100">
                                                        Hapus Dari Database.
                                                    </button>
                                                </form>
                                            </div>
                                            {{-- end of hapus pengajuan --}}
                                        </div>
                                    </td>
                                    {{--
                                    <td scope="row">
                                        <div class="d-flex">
                                            <form action="{{ url()->route('edit-room-session') }}" method="get">
                                                <input type="hidden" name="room-session-id"
                                                    value="{{ $reservation_request->id }}">
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
                                                <input type="hidden" name="room-session-id"
                                                    value="{{ $reservation_request->id }}">
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
                                    --}}
                                </tr>
                                {{-- End of Row --}}
                            @endforeach
                        @endif
                    </tbody>
                    {{-- end of table body --}}
                </table>
            </div>
        </div>
    </main>
    {{-- End of Main Content --}}
</x-layout.main>