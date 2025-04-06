<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Nomor Telepon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</head>

<body>

    <!-- navbar sticky top -->
    <nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary px-xl-2">
        <div class="container">
            <div class="col-2">
                <button type="button" class="btn btn-outline-primary">
                    <a href="" class="list-group-item list-group-item-action">
                        Home
                    </a>
                </button>
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

    <div class="mt-3">

        <div class="container-fluid container-md">

            <div class="col-auto col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">

                <form action="#" method="post" class="border rounded-3">

                    <div class="p-4">
                        <!-- header form -->
                        <h1 class="mb-4 text-center text-primary">Tambah nomor telepon</h1>
                        <!-- end header form -->

                        <!-- masukkan nomor telepon input  -->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="nomor-telpon-baru" id="nomor-telpon-baru-input"
                                type="text" value="" placeholder="nomor-telpon-baru" required />
                            <label for="nomor-telpon-baru-input">nomor telepon yang baru</label>

                            <div class="d-flex w-100 justify-content-between">
                                <div id="" class="form-text">Masukkan nomor telepon yang baru.</div>
                                <div id="" class="form-text">Example: +62-812-3456-7890</div>
                            </div>
                        </div>
                        <!-- end of masukkan nomor telepon input  -->

                        <div style="height: 2rem;">
                            @csrf
                        </div>
                        <!-- button submit input -->
                        <div class="form-floating mb-3">
                            <button type="submit" class="btn btn-primary w-100">Tambah nomor Telepon</button>
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