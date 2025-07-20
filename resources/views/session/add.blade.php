@php

    $title = "Tambah Sesi Pinjam Baru";

@endphp

<x-layout.main :title="$title">
    <div class="mt-3">
        <div class="container-fluid container-md">
            <div class="col-auto col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">
                {{-- --}}
                <div class="p-4 border rounded-3 shadow">
                    {{-- --}}
                    <form id="myForm" action="" method="post" novalidate>
                        {{-- --}}
                        @csrf
                        {{-- header form --}}
                        <h1 class="mb-4 text-center text-{{$color_primary ?? "primary"}}">{{ $title }}</h1>
                        {{-- end header form --}}
                        {{-- new room session start input --}}
                        <div class="form-floating mb-3">
                            <input class="form-control shadow-sm" name="room-session-start" id="room-session-start"
                                type="time" step="1" placeholder="room-session-start" required />
                            <label for="room-session-start">Room Session Start</label>
                            {{-- room session start error message --}}
                            @isset($error_updated_session_start)
                                <div class="text-danger"> {{ $error_updated_session_start }} </div>
                            @endisset
                            {{-- end room session start error message --}}
                            <div class="form-text">Example: <b>07:00:00 AM</b> will be <b>07:00:00.</b> And <b>01:00:00
                                    PM</b>
                                will be <b>13:00:00.</b>
                            </div>
                        </div>
                        {{-- end of new room session start input --}}
                        {{-- new room session end input --}}
                        <div class="form-floating mb-3">
                            <input class="form-control shadow-sm" name="room-session-end" id="room-session-end"
                                type="time" step="1" placeholder="room-session-end" required />
                            <label for="room-session-end">Room Session end</label>
                            {{-- room session end error message --}}
                            @isset($error_updated_session_end)
                                <div class="text-danger"> {{ $error_updated_session_end }} </div>
                            @endisset
                            {{-- end room session end error message --}}
                            <div class="form-text">Example: <b>07:49:59 AM</b> will be <b>07:49:59.</b> And <b>01:49:59
                                    PM</b>
                                will be <b>13:49:59.</b>
                            </div>
                        </div>
                        {{-- end of new room session end input --}}
                        {{-- button submit input --}}
                        <div class="form-floating mb-2">
                            <button type="submit" class="btn btn-outline-{{$color_primary ?? "primary"}} w-100">
                                Submit Update
                            </button>
                        </div>
                        {{-- end of button submit input --}}
                    </form>
                    {{-- back to room session page --}}
                    <a href="{{url()->route('list-of-room-session')}}">
                        <div class="form-floating mb-3">
                            <button type="reset" class="btn btn-outline-{{$color_primary ?? "primary"}} w-100">
                                Back to List of Room Session
                            </button>
                        </div>
                    </a>
                    {{-- end of back to room session page --}}
                </div>
                {{-- --}}
            </div>
        </div>
    </div>
</x-layout.main>