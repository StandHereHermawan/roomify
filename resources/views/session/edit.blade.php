@php

    $title = "Edit Sesi Ruangan $room_session_id";

@endphp

{{-- --}}
<x-layout.main :title="$title">
    {{-- --}}
    <div class="mt-3">
        {{-- --}}
        <div class="container-fluid container-md">
            {{-- --}}
            <div class="col-auto col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">
                {{-- change username form with style --}}
                <div class="p-4 border rounded-3 shadow">
                    <form id="myForm" action="" method="post" novalidate>
                        {{-- --}}
                        @csrf
                        {{-- --}}
                        {{-- header form --}}
                        <h1 class="mb-4 text-center text-primary">{{ $title }}</h1>
                        {{-- end header form --}}
                        {{-- --}}
                        {{-- disabled input --}}
                        <div class="form-floating mb-3">
                            {{-- --}}
                            <input class="form-control shadow-sm" id="room-session-id" type="text"
                                value="{{ $room_session_id ?? " @old_room_session_start_is_not_set"}}" disabled />
                            <label for="room-session-id">Room Session Id</label>
                            {{-- --}}
                            {{-- --}}
                            <input type="hidden" name="room-session-id" value="{{ $room_session_id }}">
                            {{-- --}}
                            <div class="form-text">Currently room session id.</div>
                        </div>
                        {{-- end of disabled input --}}
                        {{-- --}}
                        {{-- disabled input --}}
                        <div class="form-floating mb-3">
                            {{-- --}}
                            <input class="form-control shadow-sm" id="old-room-session-start" type="text"
                                value="{{ $old_room_session_start ?? " @old_room_session_start_is_not_set"}}"
                                disabled />
                            <label for="old-room-session-start">Old Room Session Start</label>
                            {{-- --}}
                            {{-- --}}
                            <input type="hidden" name="old-room-session-start" value="{{ $old_room_session_start }}">
                            {{-- --}}
                            <div class="form-text">Currently old session start.</div>
                        </div>
                        {{-- end of disabled input --}}
                        {{-- --}}
                        {{-- disabled input --}}
                        <div class="form-floating mb-3">
                            {{-- --}}
                            <input class="form-control shadow-sm" id="old-room-session-end" type="text"
                                value="{{ $old_room_session_end ?? " @old_room_session_end_is_not_set"}}" disabled />
                            <label for="old-room-session-end">Old Room Session End</label>
                            {{-- --}}
                            {{-- --}}
                            <input type="hidden" name="old-room-session-end" value="{{ $old_room_session_end }}">
                            {{-- --}}
                            <div class="form-text">Currently old session end.</div>
                        </div>
                        {{-- end of disabled input --}}
                        {{-- --}}
                        {{-- new room session start input --}}
                        <div class="form-floating mb-3">
                            {{-- --}}
                            <input class="form-control shadow-sm updated-room-session-start"
                                id="updated-room-session-start" name="updated-room-session-start" type="time" step="1"
                                placeholder="updated-room-session-start" required />
                            <label for="updated-room-session-start">Updated Room Session Start</label>
                            {{-- --}}
                            {{-- --}}
                            @if ($errors->any())
                                @error('updated-room-session-start')
                                    <div class="btn btn-outline-danger my-2 w-100"> {{ $errors->first('updated-room-session-start') }} </div>
                                @enderror
                            @endif
                            @isset($error_updated_session_start)
                                <div class="text-danger"> {{ $error_updated_session_start }} </div>
                            @endisset
                            {{-- --}}
                            {{-- --}}
                            <div class="form-text">Example: <b>07:00:00 AM</b> will be <b>07:00:00.</b> And
                                <b>01:00:00 PM</b> will be <b>13:00:00.</b>
                            </div>
                            {{-- --}}
                        </div>
                        {{-- end of new room session start input --}}
                        {{-- --}}
                        {{-- new room session end input --}}
                        <div class="form-floating mb-3">
                            {{-- --}}
                            <input class="form-control shadow-sm updated-room-session-end" id="updated-room-session-end"
                                name="updated-room-session-end" type="time" step="1"
                                placeholder="updated-room-session-end" required />
                            <label for="updated-room-session-end">Updated Room Session end</label>
                            {{-- --}}
                            {{-- --}}
                            @if ($errors->any())
                                @error('updated-room-session-end')
                                    <div class="btn btn-outline-danger my-2 w-100"> {{ $errors->first('updated-room-session-end') }} </div>
                                @enderror
                            @endif
                            @isset($error_updated_session_end)
                                <div class="text-danger"> {{ $error_updated_session_end }} </div>
                            @endisset
                            {{-- --}}
                            {{-- --}}
                            <div class="form-text">Example: <b>07:49:59 AM</b> will be <b>07:49:59.</b> And
                                <b>01:49:59 PM</b> will be <b>13:49:59.</b>
                            </div>
                            {{-- --}}
                        </div>
                        {{-- end of new room session end input --}}
                        {{-- --}}
                        {{-- button submit input --}}
                        <div class="form-floating mb-2">
                            <button type="submit" class="btn btn-outline-primary w-100">Submit Update</button>
                        </div>
                        {{-- end of button submit input --}}
                    </form>
                    {{-- back to room session page --}}
                    <a href="{{url()->route('list-of-room-session')}}">
                        <div class="form-floating mb-3">
                            <button type="reset" class="btn btn-outline-primary w-100">
                                Back to List of Room Session
                            </button>
                        </div>
                    </a>
                    {{-- end of back to room session page --}}
                </div>
                {{-- end of change username form with style --}}
            </div>
            {{-- --}}
        </div>
        {{-- --}}
    </div>
    {{-- --}}
</x-layout.main>
{{-- --}}