<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</head>

<body>
    <!-- navbar sticky top -->
    <nav class="navbar sticky-top navbar-expand-lg bg-secondary px-xl-2">
        <div class="container">
            <div class="col-2">
                <a href="/account-management/dashboard" class="list-group-item list-group-item-action">
                    <button type="button" class="btn btn-outline-light">
                        Home
                    </button>
                </a>
            </div>

            <div class="col-auto">
                <h1 class="d-flex justify-content-center text-light">Manajemen Akun</h1>
            </div>

            <div class="col-2 d-flex justify-content-end">
                <a href="/account-management/dashboard/logout" class="list-group-item list-group-item-action">
                    <button type="button" class="btn btn-outline-light">
                        Logout
                    </button>
                </a>
            </div>

        </div>
    </nav>
    <!-- end of navbar sticky top -->

    <!-- main content -->
    <div class="container-md mt-3">
        <div class="col-auto col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">

            <div class="border p-3 rounded-3">
                <h1 class="text-center text-secondary mb-4">Informasi Akun</h1>

                <div>
                    <!-- <img src="logo1.png" class="rounded mx-auto d-block border p-4 mb-3" alt="..."> -->
                </div>

                <div class="rounded-3 list-group">

                    <!-- informasi username -->
                    <div href="#" class="list-group-item list-group-item-action" aria-current="true">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                                Username
                            </h5>
                            <!-- <small class="text-body-secondary">Lorem_ipsum.</small> -->
                        </div>
                        @if (isset($username))
                            <ul class="list-group mb-2">
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <div class="">
                                            {{ "@" . $username }}
                                        </div>
                                        <a class="text-secondary"
                                            href="/account-management/dashboard/account/edit-username?username={{ $username }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                                fill="currentColor" class="bi bi-pencil-square opacity-25"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                            </svg>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        @else
                            <p class="mb-1">@username_not_set</p>
                        @endif
                    </div>
                    <!-- end of informasi username -->

                    <!-- informasi nama -->
                    <div href="#" class="list-group-item list-group-item-action" aria-current="true">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                                Name
                            </h5>
                            <!-- <small class="text-body-secondary">Lorem_ipsum.</small> -->
                        </div>
                        @if (isset($name))
                            <ul class="list-group mb-2">
                                <li class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <div class="">
                                            {{ $name }}
                                        </div>
                                        <a class="text-secondary"
                                            href="/account-management/dashboard/account/edit-name?name={{ $name }}&username={{ $username }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                                fill="currentColor" class="bi bi-pencil-square opacity-25"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                            </svg>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        @else
                            <p class="mb-1">@name_not_set</p>
                        @endif
                    </div>
                    <!-- end of informasi nama -->

                    <!-- informasi email -->
                    <!-- <div class="list-group-item list-group-item-action"> -->
                    <div class="list-group-item list-group-item-action">

                        <div>
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Email ter-registrasi</h5>
                                <!-- <small class="text-body-secondary">Lorem_ipsum.</small> -->
                            </div>

                            @if (isset($email))
                                @if (is_iterable($email))
                                    <ul class="list-group mb-2">
                                        @foreach ($email as $emailOne)
                                            <li class="list-group-item list-group-item-action">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        {{ $emailOne->email }}
                                                    </div>
                                                    <a class="text-secondary"
                                                        href="/account-management/dashboard/account/edit-email?oldEmail={{ $emailOne->email }}&username={{ $username }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                            fill="currentColor" class="bi bi-pencil-square opacity-25"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                            <path fill-rule="evenodd"
                                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>

                                @else

                                    <ul class="list-group mb-2">
                                        <li class="list-group-item list-group-item-action">
                                            {{ $email }}
                                        </li>
                                    </ul>

                                @endif

                            @else
                                <ul class="list-group mb-2">
                                    <li class="list-group-item list-group-item-action">
                                        email_not_set
                                    </li>
                                </ul>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link text-body-secondary"
                                            href="/account-management/dashboard/account?offsetTotalEmailPage={{ $offsetTotalEmailPage - $limitEmailPage }}"
                                            aria-label="Previous">
                                            <span aria-hidden="true">&laquo; Previous</span>
                                        </a>
                                    </li>
                                    <!-- <li class="page-item"><a class="page-link text-body-secondary" href="#">1</a></li> -->
                                    <li class="page-item">
                                        <a class="page-link text-body-secondary"
                                            href="/account-management/dashboard/account?offsetTotalEmailPage={{ $offsetTotalEmailPage + $limitEmailPage }}"
                                            aria-label="Next">
                                            <span aria-hidden="true">Next &raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link text-body-secondary"
                                            href="/account-management/dashboard/account/add-email?username={{ $username }}">
                                            &#x0002B;
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- end of informasi email -->

                    <!-- informasi password -->
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">Password</h5>
                            <!-- <small class="text-body-secondary">Lorem_ipsum.</small> -->
                        </div>
                        <p class="mb-1">Klik disini untuk ganti password</p>
                    </a>
                    <!-- end of informasi password -->

                    <!-- informasi nomor telepon -->
                    <div href="#" class="list-group-item list-group-item-action">

                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                                Nomor Telpon
                            </h5>
                            <!-- <small class="text-body-secondary">Lorem_ipsum.</small> -->
                        </div>

                        @if (isset($phoneNumber))
                            @if (is_iterable($phoneNumber))
                                <ul class="list-group mb-2">
                                    @foreach ($phoneNumber as $phoneNumberOne)
                                        <li class="list-group-item list-group-item-action">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    {{ $phoneNumberOne->phone_number }}
                                                </div>
                                                <a class="text-secondary"
                                                    href="/account-management/dashboard/account/edit-phone-number?oldPhoneNumber={{ urlencode($phoneNumberOne->phone_number) }}&username={{ $username }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                        fill="currentColor" class="bi bi-pencil-square opacity-25"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                        <path fill-rule="evenodd"
                                                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <ul class="list-group mb-2">
                                    <li class="list-group-item list-group-item-action">
                                        {{ $phoneNumber }}
                                    </li>
                                </ul>
                            @endif
                        @else
                            <ul class="list-group mb-2">
                                <li class="list-group-item list-group-item-action">
                                    phone_number_not_set
                                </li>
                            </ul>
                        @endif

                        <div class="d-flex justify-content-between">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link text-body-secondary"
                                            href="/account-management/dashboard/account?offsetTotalPhoneNumberPage={{ $offsetTotalPhoneNumberPage - $limitPhoneNumberPage }}"
                                            aria-label="Previous">
                                            <span aria-hidden="true">&laquo; Previous</span>
                                        </a>
                                    </li>
                                    <!-- <li class="page-item"><a class="page-link text-body-secondary" href="#">1</a></li> -->
                                    <li class="page-item">
                                        <a class="page-link text-body-secondary"
                                            href="/account-management/dashboard/account?offsetTotalPhoneNumberPage={{ $offsetTotalPhoneNumberPage + $limitPhoneNumberPage }}"
                                            aria-label="Next">
                                            <span aria-hidden="true">Next &raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link text-body-secondary"
                                            href="/account-management/dashboard/account/add-phone-number?username={{ $username }}">
                                            &#x0002B;
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <!-- end of informasi nomor telepon -->

                    <div class="form-floating text-center mt-3">
                        <p>
                            Sistem Informasi Peminjaman Ruangan
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of main content -->
</body>

</html>