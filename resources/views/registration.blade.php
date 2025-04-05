<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration SIPR</title>
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

                <form action="simpan-dengan-style-bootstrap.php" method="post" class="border rounded-3">
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
                        <h1 class="mb-4 text-center text-primary">Registrasi peminjaman ruangan</h1>
                        <!-- end header form -->

                        <!-- username input -->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="username" id="username-input" type="text" value=""
                                placeholder="username" required />
                            <label for="username-input">Username</label>

                            <div class="d-flex w-100 justify-content-between">
                                <div id="" class="form-text">Pick a unique username!</div>
                                <small id="" class="form-text">Example: I_am_guest.</small>
                            </div>
                        </div>
                        <!-- end username input  -->

                        <!-- Name input -->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="name" id="Name-input" type="text" value=""
                                placeholder="Name" />
                            <label for="Name-input">Name</label>
                            <div class="d-flex w-100 justify-content-between">
                                <div id="" class="form-text">Pick Your Name Here!</div>
                                <div id="" class="form-text">Example: Saya Lorem Ipsum.</div>
                            </div>
                        </div>
                        <!-- end Name input  -->

                        <!-- email input -->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="email" id="email-input" type="text" placeholder="email"
                                value="" required />
                            <label for="email-input">Email</label>
                            <div id="" class="form-text">Example: iamlucky@gmail.com</div>
                        </div>
                        <!-- end of email input  -->

                        <!-- password input  -->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="password" id="password-input" type="password" value=""
                                placeholder="password" required />
                            <label for="password-input">Password</label>
                            <div id="" class="form-text">Example: iamlucky@12345</div>
                        </div>
                        <!-- end of password input  -->

                        <!-- nomor telepon input  -->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="telephone" id="telephone-input" type="text" value=""
                                placeholder="telephone" required />
                            <label for="telephone-input">telephone</label>
                            <div id="" class="form-text">Example: +62-812-3456-7890</div>
                        </div>
                        <!-- end of nomor telepon input -->

                        <!-- role input  -->
                        <div class=" mb-3">
                            <select class="form-select" id="role" size="1" name="role" aria-placeholder="Role">
                                <option value="Mahasiswa">Mahasiswa</option>
                                <option value="Bukan Mahasiswa">Bukan Mahasiswa</option>
                            </select>
                            <div id="" class="form-text">Pick a role.</div>
                        </div>
                        <!-- end of role input -->

                        <!-- term of use input -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="agreedTermsOfUse" id="terms-of-use-check"
                                required />
                            <label for="terms-of-use-check" class="form-check-label">Terms of Use</label>
                        </div>
                        <!-- end of term of use input  -->

                        <!-- button submit input -->
                        <div class="form-floating">
                            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                        </div>
                        <!-- end of button submit input -->

                        <div class="form-floating text-center mt-3">
                            <p>
                                Sistem Informasi Peminjaman Ruangan
                            </p>
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>
</body>

</html>