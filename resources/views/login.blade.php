<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SIPR</title>
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

                <form action="#" method="post" class="border rounded-3">

                    <div class="p-4">
                        <!-- header form -->
                        <h1 class="mb-4 text-center text-primary">Login peminjaman ruangan</h1>
                        <!-- end header form -->

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
                            <input class="form-control" name="password" id="password-input" type="text" value=""
                                placeholder="password" required />
                            <label for="password-input">Password</label>
                            <div id="" class="form-text">Example: rahasia@12345</div>
                        </div>
                        <!-- end of password input  -->

                        <!-- button submit input -->
                        <div class="form-floating mb-3">
                            <button type="submit" class="btn btn-primary w-100">Log In</button>
                        </div>
                        <!-- end of button submit input -->

                        <div class="form-floating text-center">
                            <p>
                                Belum punya akun?
                                <a href="#">Registrasi disini.</a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</body>

</html>