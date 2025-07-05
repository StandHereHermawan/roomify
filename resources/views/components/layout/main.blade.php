<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet"
            crossorigin="anonymous">
    </head>
    <body>
        {{ $slot }}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                {{-- Ambil semua input dalam form --}}
                let inputs = document.querySelectorAll("#myForm input, #myForm password");

                {{-- Cek apakah ada data tersimpan, lalu isi kembali  --}} 
                inputs.forEach(input => {
                    let savedValue = localStorage.getItem(input.id);
                    if (savedValue) {
                        input.value = savedValue;
                    }

                    {{-- Simpan value setiap kali berubah  --}} 
                    input.addEventListener("input", function () {
                        localStorage.setItem(input.id, input.value);
                    });
                });

                {{--  Hapus data saat form dikirim
                document.getElementById("myForm").addEventListener("submit", function () {
                    localStorage.clear();
                });
                --}}
            });
        </script>
    </body>
</html>