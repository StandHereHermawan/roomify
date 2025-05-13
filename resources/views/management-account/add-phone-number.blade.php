<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Phone Number</title>
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

                <!-- change username form with style -->
                <div class="p-4 border rounded-3">
                    <form id="myForm" action="/account-management/dashboard/account/add-phone-number" method="post"
                        novalidate>
                        @csrf
                        <!-- header form -->
                        <h1 class="mb-4 text-center text-secondary">Add Phone Number</h1>
                        <!-- end header form -->

                        <!-- disabled input -->
                        <div class="form-floating mb-3">

                            <input class="form-control opacity-50" name="username-display" id="username-input"
                                type="text" placeholder="username" value="{{ $username ?? " @username_is_not_set"}}"
                                disabled />
                            <label for="username-input">Username</label>
                            <input type="hidden" name="username" value="{{ $username ?? null }}">

                            <div class="form-text">Currently your username registered on.</div>
                        </div>
                        <!-- end of disabled input  -->

                        <!-- new username input  -->
                        <div class="form-floating mb-3">

                            <input class="form-control" name="new-phone-number" id="new-phone-number-input" type="text" value=""
                                placeholder="new-phone-number" required />
                            <label for="new-phone-number-input">New Phone Number</label>

                            <!-- username error message -->
                            @isset($errorNewPhoneNumberInput)
                                <div class="text-danger"> {{ $errorNewPhoneNumberInput }} </div>
                            @endisset
                            <!-- end username error message -->

                            <div class="form-text">Example: +62-812-3456-7890</div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        </div>
                        <!-- end of new username input  -->

                        <!-- button submit input -->
                        <div class="form-floating mb-2">
                            <button type="submit" class="btn btn-outline-secondary w-100">Add Phone Number</button>
                        </div>
                        <!-- end of button submit input -->
                    </form>

                    <!-- kembali ke halaman akun -->
                    <a href="/account-management/dashboard/account">
                        <div class="form-floating mb-3 opacity-50">
                            <button type="reset" class="btn btn-outline-secondary w-100">Back to Account</button>
                        </div>
                    </a>
                    <!-- end of kembali ke halaman akun -->
                </div>
                <!-- end of change username form with style -->
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Ambil semua input dalam form
            let inputs = document.querySelectorAll("#myForm input, #myForm password");

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
            // document.getElementById("myForm").addEventListener("submit", function () {
            //     localStorage.clear();
            // });
        });
    </script>
</body>

</html>