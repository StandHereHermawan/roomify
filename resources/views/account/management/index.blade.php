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
            {{-- Bagian produk tetap sama --}}
            <div class="row">
                <table class="table">
                    {{-- table header --}}
                    <thead>
                        <tr>
                            <th scope="col">
                                <div class="h3 text-primary">
                                    id
                                </div>
                            </th>
                            <th scope="col">
                                <div class="h3 text-primary">
                                    Username
                                </div>
                            </th>
                            <th scope="col">
                                <div class="h3 text-primary">
                                    Name
                                </div>
                            </th>
                            <th scope="col">
                                <div class="h3 text-primary">
                                    Created
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
                        @if (isset($listOfAccount) && is_iterable($listOfAccount))

                            {{-- Pagination Navigation --}}
                            <div class="mt-2">
                                {{ $listOfAccount->links($default_pagination_view) }}
                            </div>
                            {{-- End of Pagination Navigation --}}

                            @foreach ($listOfAccount as $account)
                                {{-- Row --}}
                                <tr>
                                    <th scope="row">
                                        <div class="h3">
                                            {{ $account->getId() }}
                                        </div>
                                    </th>
                                    <td scope="row">
                                        <div class="h3">
                                            {{ $account->getUsername() }}
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <div class="h3">
                                            {{ $account->getName() }}
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <div class="h3">
                                            {{ Illuminate\Support\Carbon::parse($account->created_at)->translatedFormat('d F Y, h:iA') }}
                                        </div>
                                    </td>
                                    <td scope="row">
                                        <div class="d-flex">
                                            <form action="{{ url()->route('edit-room-session') }}" method="get">
                                                <input type="hidden" name="room-session-id" value="{{ $account->id }}">
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
                                                <input type="hidden" name="room-session-id" value="{{ $account->id }}">
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
        </div>
    </main>
    {{-- End of Main Content --}}
</x-layout.main>