<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Manajemen Akun</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous" />
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</head>

<body>
    <div class="mt-3">

        <div class="container-fluid container-md">

            <div class="col-auto col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">
                <form id="myForm" action="/account-management/registration" method="post" class="border rounded-3" novalidate>
                    <!-- Halaman registrasi dengan 6 field  -->
                    <!-- daftar field: -->
                    <!-- 1. Username -->
                    <!-- 2. Name -->
                    <!-- 3. Email -->
                    <!-- 4. Password -->
                    <!-- 5. Nomor telephone -->
                    <!-- 6. Role -->

                    <div class="p-4">
                        <!-- header form -->
                        <h1 class="mb-4 text-center text-secondary">Registrasi Manajemen Akun</h1>
                        <!-- end header form -->

                        <!-- username input -->
                        <div class="form-floating mb-3">
                            @csrf
                            <input class="form-control" name="username" id="username-input" type="text" value="{{ old("username") }}"
                                placeholder="username" autocomplete="true" required />
                            <label for="username-input">Username</label>

                            @isset($errorUsernameInput)
                            <!-- username error message -->
                            <div class="text-danger">{{ $errorUsernameInput }}</div>
                            <!-- end username error message -->
                            @endisset

                            <div class="d-flex w-100 justify-content-between">
                                <div id="" class="form-text">Pick a unique username!</div>
                                <small id="" class="form-text">Example: I_am_guest.</small>
                            </div>
                        </div>
                        <!-- end username input  -->

                        <!-- Name input -->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="name" id="Name-input" type="text" value="{{ old("name") }}"
                                placeholder="Name" autocomplete="true" required />
                            <label for="Name-input">Name</label>

                            @isset($errorNameInput)
                            <!-- username error message -->
                            <div class="text-danger">{{ $errorNameInput }}</div>
                            <!-- end username error message -->
                            @endisset

                            <div class="d-flex w-100 justify-content-between">
                                <div id="" class="form-text">Pick Your Name Here!</div>
                                <div id="" class="form-text">Example: Saya Lorem Ipsum.</div>
                            </div>
                        </div>
                        <!-- end Name input  -->

                        <!-- email input -->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="email" id="email-input" type="text" placeholder="email"
                                value="{{ old("email") }}" autocomplete="true" required />
                            <label for="email-input">Email</label>

                            @isset($errorEmailInput)
                            <!-- username error message -->
                            <div class="text-danger">{{ $errorEmailInput }}</div>
                            <!-- end username error message -->
                            @endisset

                            <div id="" class="form-text">Example: iamlucky@gmail.com</div>
                        </div>
                        <!-- end of email input  -->

                        <!-- password input  -->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="password" id="password-input" type="text" value="{{ old("password") }}"
                                placeholder="password" autocomplete="true" required />
                            <label for="password-input">Password</label>

                            @isset($errorPasswordInput)
                            <!-- username error message -->
                            <div class="text-danger">{{ $errorPasswordInput }}</div>
                            <!-- end username error message -->
                            @endisset

                            <div id="" class="form-text">Example: iamLucky@12345</div>
                        </div>
                        <!-- end of password input  -->

                        <!-- nomor telepon input  -->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="telephone" id="telephone-input" type="text" value="{{ old("telephone") }}"
                                placeholder="telephone" required />
                            <label for="telephone-input">telephone</label>

                            @isset($errorTelephoneInput)
                            <!-- username error message -->
                            <div class="text-danger">{{ $errorTelephoneInput }}</div>
                            <!-- end username error message -->
                            @endisset

                            <div id="" class="form-text">Example: +62-812-3456-7890</div>
                        </div>
                        <!-- end of nomor telepon input -->

                        <!-- term of use input -->
                        <div class="form-check">
                            <div class="mb-3">
                                <input class="form-check-input" type="checkbox" name="agreedTermsOfUse" id="terms-of-use-check"
                                    required />
                                <label for="terms-of-use-check" class="form-check-label">Terms of Use</label>
                                
                                @isset($errorTermsOfUseInput)
                                <!-- username error message -->
                                <div class="text-danger">{{ $errorTermsOfUseInput }}</div>
                                <!-- end username error message -->
                                @endisset
                            </div>
                        </div>
                        <!-- end of term of use input  -->

                        <!-- button submit input -->
                        <div class="form-floating mb-3">
                            <button type="submit" class="btn btn-secondary w-100">Sign Up</button>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>
                        <!-- end of button submit input -->
                        
                        <div class="form-floating text-center">
                            <p>
                                Sudah punya akun?
                                <a class="text-secondary link-underline link-underline-opacity-0" href="/account-management/login">Login disini.</a>
                            </p>
                        </div>

                        <div class="form-floating text-center">
                            <p>
                                Sistem Informasi Peminjaman Ruangan
                            </p>
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil semua input dalam form
            let inputs = document.querySelectorAll("#myForm input, #myForm password");

            // Cek apakah ada data tersimpan, lalu isi kembali
            inputs.forEach(input => {
                let savedValue = localStorage.getItem(input.id);
                if (savedValue) {
                    input.value = savedValue;
                }

                // Simpan value setiap kali berubah
                input.addEventListener("input", function() {
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