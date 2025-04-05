<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Page</title>
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
    <!-- navbar sticky top -->
    <nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary px-xl-2">
        <div class="container">
            <div class="col-2">
                <button type="button" class="btn btn-outline-primary"><a href="" class="list-group-item list-group-item-action">Home</a></button>
            </div>

            <div class="col-auto">
                <h1 class="d-flex justify-content-center text-primary">Pinjam Ruangan</h1>
            </div>

            <div class="col-2 d-flex justify-content-end">
                <button type="button" class="btn btn-outline-secondary">Logout</button>
            </div>

        </div>
    </nav>
    <!-- end of navbar sticky top -->

    <div class="container-md mt-3">
        <div class="col-auto col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">

            <div class="border p-3 rounded-3">
                <h1 class="text-center text-primary mb-4">Informasi Akun</h1>

                <div>
                    <!-- <img src="logo1.png" class="rounded mx-auto d-block border p-4 mb-3" alt="..."> -->
                </div>

                <div class="list-group">

                    <!-- informasi username -->
                    <a href="#" class="list-group-item list-group-item-action" aria-current="true">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                                Username
                            </h5>
                            <small class="text-body-secondary">changed a long time ago.</small>
                        </div>
                        <p class="mb-1">@lorem_ipsum</p>
                    </a>
                    <!-- end of informasi username -->

                    <!-- informasi nama -->
                    <a href="#" class="list-group-item list-group-item-action" aria-current="true">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                                Name
                            </h5>
                            <small class="text-body-secondary">changed a long time ago.</small>
                        </div>
                        <p class="mb-1">Lorem Ipsum</p>
                    </a>
                    <!-- end of informasi nama -->

                    <!-- informasi email -->
                    <a class="list-group-item list-group-item-action">
                        <div>
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Email Utama</h5>
                                <small class="text-body-secondary">changed a long time ago.</small>
                            </div>
                            <ul class="list-group mb-2">
                                <li class="list-group-item list-group-item-action">
                                    ContohEmail@localhost.com
                                </li>
                            </ul>
                        </div>
                        <div>
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Email Lain ter-registrasi</h5>
                                <small class="text-body-secondary">changed a long time ago.</small>
                            </div>
                            <ul class="list-group mb-2">
                                <li class="list-group-item list-group-item-action">
                                    ContohEmail2@localhost.com
                                </li>
                                <li class="list-group-item list-group-item-action">
                                    ContohEmail3@localhost.com
                                </li>
                            </ul>
                        </div>
                    </a>
                    <!-- end of informasi email -->

                    <!-- informasi email -->
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">Password</h5>
                            <small class="text-body-secondary">changed a long time ago.</small>
                        </div>
                        <p class="mb-1">Klik disini untuk ganti password</p>
                    </a>
                    <!-- end of informasi email -->


                    <!-- informasi nomor telepon -->
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                                Nomor Telpon
                            </h5>
                            <small class="text-body-secondary">changed a long time ago.</small>
                        </div>
                        <p class="mb-1">+62-812-3456-7890</p>
                    </a>
                    <!-- end of informasi nomor telepon -->

                    <!-- informasi contoh role -->
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">Role dimiliki</h5>
                            <small class="text-body-secondary">changed a long time ago.</small>
                        </div>
                        <ul class="list-group mb-2">
                            <li class="list-group-item list-group-item-action">
                                Mahasiswa
                            </li>
                        </ul>
                    </div>
                    <!-- end of informasi contoh role -->

                    <div class="form-floating text-center mt-3">
                        <p>
                            Sistem Informasi Peminjaman Ruangan
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</body>

</html>