@php

    $title = "Dummy Input Page";

@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</head>

<body>
    <div class="mt-3">

        <div class="container-fluid container-md">
            <div class="col-auto col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">

                {{-- change username form with style --}}
                <div class="p-4 border rounded-3">

                    <form id="myForm" action="" method="post" novalidate>
                        @csrf
                        {{-- header form --}}
                        <h1 class="mb-4 text-center text-secondary">{{ $title }}</h1>
                        {{-- end header form --}}


                        
                        {{-- new room session start input --}}
                        <div class="form-floating mb-3">

                            <input class="form-control" name="room-session-start"
                                id="room-session-start" type="time" step="1"
                                placeholder="room-session-start" required />
                            <label for="room-session-start">Room Session Start</label>

                            {{-- room session start error message --}}
                            @isset($error_updated_session_start)
                                <div class="text-danger"> {{ $error_updated_session_start }} </div>
                            @endisset
                            {{-- end room session start error message --}}

                            <div class="form-text">Example: <b>07:00:00 AM</b> will be <b>07:00:00.</b> And <b>01:00:00 PM</b>
                                will be <b>13:00:00.</b></div>

                        </div>
                        {{-- end of new room session start input --}}



                        {{-- new room session end input --}}
                        <div class="form-floating mb-3">

                            <input class="form-control" name="room-session-end" id="room-session-end"
                                type="time" step="1" placeholder="room-session-end" required />
                            <label for="room-session-end">Room Session end</label>

                            {{-- room session end error message --}}
                            @isset($error_updated_session_end)
                                <div class="text-danger"> {{ $error_updated_session_end }} </div>
                            @endisset
                            {{-- end room session end error message --}}

                            <div class="form-text">Example: <b>07:49 AM</b> will be <b>07:49.</b> And <b>01:49 PM</b>
                                will be <b>13:49.</b></div>

                        </div>
                        {{-- end of new room session end input --}}



                        {{-- button submit input --}}
                        <div class="form-floating mb-2">
                            <button type="submit" class="btn btn-outline-secondary w-100">Submit Update</button>
                        </div>
                        {{-- end of button submit input --}}
                    </form>

                    {{-- back to room session page --}}
                    <a href="{{url()->route('list-of-room-session')}}">
                        <div class="form-floating mb-3 opacity-50">
                            <button type="reset" class="btn btn-outline-secondary w-100">Back to List of Room
                                Session</button>
                        </div>
                    </a>
                    {{-- end of back to room session page --}}
                </div>
                {{-- end of change username form with style --}}
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Ambil semua input dalam form
            let inputs = document.querySelectorAll("#myForm input");

            // Cek apakah ada data tersimpan, lalu isi kembali
            inputs.forEach(input => {
                let savedValue = localStorage.getItem(input.id);
                if (savedValue) {
                    input.value = savedValue;
                }

                // Simpan value setiap kali berubah
                input.addEventListener("input", function () {
                    localStorage.setItem(input.id, input.value);
                });
            });

            // Hapus data saat form dikirim
            document.getElementById("myForm").addEventListener("submit", function () {
                localStorage.clear();
            });
        });
    </script>
</body>

</html>