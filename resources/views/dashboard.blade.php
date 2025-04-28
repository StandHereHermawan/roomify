<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Page</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous" />
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <style>
        .bd-example {
            max-height: 25rem;
            overflow: auto;
        }

        .offcanvas-custom-size {
            --bs-offcanvas-width: 5rem;
        }
    </style>
</head>

<body>
    <!-- navbar sticky top -->
    <nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary px-xl-2">
        <div class="container">
            <div class="col-2">
                <button class="btn btn-outline-primary" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                        class="bi bi-three-dots" viewBox="0 0 16 16">
                        <path
                            d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3" />
                    </svg>
                </button>
            </div>

            <div class="col-auto">
                <h1 class="d-flex justify-content-center text-primary">Pinjam Ruangan</h1>
            </div>

            <div class="col-2 d-flex justify-content-end">
                <button type="button" class="btn btn-outline-secondary">Log Out</button>
            </div>

        </div>
    </nav>
    <!-- end of navbar sticky top -->

    <!-- offcanvas baru muncul kalau klik tombol navigation. -->
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
        id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">

        <div class="offcanvas-header">

            <div class="container-fluid row">
                <div class="col">
                    <h5 class="offcanvas-title text-primary" id="offcanvasScrollingLabel">Aplikasi Pinjam Ruangan</h5>
                </div>

                <div class="col-1">
                    <div class="pt-2">
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="offcanvas-body">
            <p>Try scrolling the rest of the page to see this option in action.</p>
            <!-- first accordion -->
            <div class="accordion mb-3" id="accordionExample1">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne1" aria-expanded="false" aria-controls="collapseOne1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person me-2" viewBox="0 0 16 16">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                            </svg>
                            Account Management
                        </button>
                    </h2>
                    <div id="collapseOne1" class="accordion-collapse collapse" data-bs-parent="#accordionExample1">
                        <div class="accordion-body">
                            <button type="button" class="btn btn-outline-secondary w-100">
                                <a href="/dashboard/account" class="list-group-item list-group-item-action">Account Section</a>
                            </button>
                            <!-- <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow. -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of first accordion -->

            <!-- second accordion -->
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Accordion Item #1
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Accordion Item #2
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Accordion Item #3
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of second accordion -->
        </div>
    </div>
    <!-- offcanvas baru muncul kalau klik tombol navigation. -->

    <div class="container mt-3">
        <div class="row">

            <div class="col-lg-6 mb-3 mb-md-3">

                <div class="card border-success">
                    <div class="card-header bg-transparent border-success">
                        Header
                    </div>
                    <div class="card-body text-success">
                        <h5 class="card-title">Success card title</h5>
                        <p class="card-text">
                            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Assumenda perspiciatis non praesentium expedita! Delectus, voluptas neque natus error sit dolore magnam iusto cupiditate impedit voluptatibus recusandae quo libero rerum fuga.
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-success">
                        Footer
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-3 mb-md-3">
                <div class="card border-success">
                    <div class="card-header bg-transparent border-success">
                        Header
                    </div>
                    <div class="card-body text-success">
                        <h5 class="card-title">Success card title</h5>
                        <p class="card-text">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio vero modi quam odio! Molestias odit dicta voluptatibus, molestiae maxime velit pariatur exercitationem obcaecati tenetur autem minima corrupti ipsa est cum!
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-success">
                        Footer
                    </div>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-lg-6 mb-3 mb-md-3">

                <div class="card border-primary">

                    <div class="card-header bg-transparent border-primary">
                        Header
                    </div>

                    <div class="card-body text-primary">
                        <h5 class="card-title">info card title</h5>
                        <p class="card-text">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio vero modi quam odio! Molestias odit dicta voluptatibus, molestiae maxime velit pariatur exercitationem obcaecati tenetur autem minima corrupti ipsa est cum!
                        </p>
                    </div>

                    <div class="card-footer bg-transparent border-primary">
                        Footer
                    </div>

                </div>
            </div>

            <div class="col-lg-6 mb-3 mb-md-3">
                <div class="card border-primary">
                    <div class="card-header bg-transparent border-primary">
                        Header
                    </div>
                    <div class="card-body text-primary">
                        <h5 class="card-title">info card title</h5>
                        <p class="card-text">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus quia debitis odit sit repellat porro cupiditate fugiat eos culpa autem laborum dolores magnam maiores facilis numquam, enim minima in veniam.
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-primary">
                        Footer
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-6 mb-3 mb-md-3">

                <div class="card border-success">
                    <div class="card-header bg-transparent border-success">
                        Header
                    </div>
                    <div class="card-body text-success">
                        <h5 class="card-title">Success card title</h5>
                        <div>
                            <div class="row">
                                <div class="col-4 bd-example">
                                    <nav id="navbar-example3"
                                        class="h-100 flex-column align-items-stretch pe-4 border-end bd-example">
                                        <nav class="nav nav-pills flex-column">
                                            <a class="nav-link" href="#item-1-1">Item 1</a>
                                            <nav class="nav nav-pills flex-column">
                                                <a class="nav-link ms-3 my-1" href="#item-1-1-1">Item 1-1</a>
                                                <a class="nav-link ms-3 my-1" href="#item-1-1-2">Item 1-2</a>
                                            </nav>
                                            <a class="nav-link" href="#item-2-1">Item 2</a>
                                            <a class="nav-link" href="#item-3-1">Item 3</a>
                                            <nav class="nav nav-pills flex-column">
                                                <a class="nav-link ms-3 my-1" href="#item-3-1-1">Item 3-1</a>
                                                <a class="nav-link ms-3 my-1" href="#item-3-1-2">Item 3-2</a>
                                            </nav>
                                        </nav>
                                    </nav>
                                </div>

                                <div class="col-8 bd-example">
                                    <div data-bs-spy="scroll" data-bs-target="#navbar-example3"
                                        data-bs-smooth-scroll="true" class="scrollspy-example-2 bd-example"
                                        tabindex="0">
                                        <div id="item-1-1">
                                            <h4>Item 1</h4>
                                            <p>
                                                Lorem ipsum dolor sit amet
                                                consectetur adipisicing
                                                elit. Minima, ad? Incidunt
                                                ipsam dolores et aperiam
                                                inventore fuga laboriosam,
                                                officia sint veniam quia
                                                expedita? Consequuntur, enim
                                                dolor! Laboriosam qui est
                                                nisi. Lorem ipsum dolor sit
                                                amet consectetur adipisicing
                                                elit. Veniam architecto
                                                consequatur dicta accusamus
                                                illum voluptas repellendus
                                                explicabo eius iste,
                                                nesciunt minus fugiat
                                                nostrum mollitia natus quia
                                                vitae odit officia quisquam.
                                            </p>
                                        </div>
                                        <div id="item-1-1-1">
                                            <h5>Item 1-1</h5>
                                            <p>
                                                Lorem ipsum dolor sit amet
                                                consectetur adipisicing
                                                elit. Minima, ad? Incidunt
                                                ipsam dolores et aperiam
                                                inventore fuga laboriosam,
                                                officia sint veniam quia
                                                expedita? Consequuntur, enim
                                                dolor! Laboriosam qui est
                                                nisi. Lorem ipsum dolor sit
                                                amet consectetur adipisicing
                                                elit. Veniam architecto
                                                consequatur dicta accusamus
                                                illum voluptas repellendus
                                                explicabo eius iste,
                                                nesciunt minus fugiat
                                                nostrum mollitia natus quia
                                                vitae odit officia quisquam.
                                            </p>
                                        </div>
                                        <div id="item-1-1-2">
                                            <h5>Item 1-2</h5>
                                            <p>
                                                Lorem ipsum dolor sit amet
                                                consectetur adipisicing
                                                elit. Minima, ad? Incidunt
                                                ipsam dolores et aperiam
                                                inventore fuga laboriosam,
                                                officia sint veniam quia
                                                expedita? Consequuntur, enim
                                                dolor! Laboriosam qui est
                                                nisi. Lorem ipsum dolor sit
                                                amet consectetur adipisicing
                                                elit. Veniam architecto
                                                consequatur dicta accusamus
                                                illum voluptas repellendus
                                                explicabo eius iste,
                                                nesciunt minus fugiat
                                                nostrum mollitia natus quia
                                                vitae odit officia quisquam.
                                            </p>
                                        </div>
                                        <div id="item-2-1">
                                            <h4>Item 2</h4>
                                            <p>
                                                Lorem ipsum dolor sit amet
                                                consectetur adipisicing
                                                elit. Minima, ad? Incidunt
                                                ipsam dolores et aperiam
                                                inventore fuga laboriosam,
                                                officia sint veniam quia
                                                expedita? Consequuntur, enim
                                                dolor! Laboriosam qui est
                                                nisi. Lorem ipsum dolor sit
                                                amet consectetur adipisicing
                                                elit. Veniam architecto
                                                consequatur dicta accusamus
                                                illum voluptas repellendus
                                                explicabo eius iste,
                                                nesciunt minus fugiat
                                                nostrum mollitia natus quia
                                                vitae odit officia quisquam.
                                            </p>
                                        </div>
                                        <div id="item-3-1">
                                            <h4>Item 3</h4>
                                            <p>
                                                Lorem ipsum dolor sit amet
                                                consectetur adipisicing
                                                elit. Minima, ad? Incidunt
                                                ipsam dolores et aperiam
                                                inventore fuga laboriosam,
                                                officia sint veniam quia
                                                expedita? Consequuntur, enim
                                                dolor! Laboriosam qui est
                                                nisi. Lorem ipsum dolor sit
                                                amet consectetur adipisicing
                                                elit. Veniam architecto
                                                consequatur dicta accusamus
                                                illum voluptas repellendus
                                                explicabo eius iste,
                                                nesciunt minus fugiat
                                                nostrum mollitia natus quia
                                                vitae odit officia quisquam.
                                            </p>
                                        </div>
                                        <div id="item-3-1-1">
                                            <h5>Item 3-1</h5>
                                            <p>
                                                Lorem ipsum dolor sit amet
                                                consectetur adipisicing
                                                elit. Minima, ad? Incidunt
                                                ipsam dolores et aperiam
                                                inventore fuga laboriosam,
                                                officia sint veniam quia
                                                expedita? Consequuntur, enim
                                                dolor! Laboriosam qui est
                                                nisi. Lorem ipsum dolor sit
                                                amet consectetur adipisicing
                                                elit. Veniam architecto
                                                consequatur dicta accusamus
                                                illum voluptas repellendus
                                                explicabo eius iste,
                                                nesciunt minus fugiat
                                                nostrum mollitia natus quia
                                                vitae odit officia quisquam.
                                            </p>
                                        </div>
                                        <div id="item-3-1-2">
                                            <h5>Item 3-2</h5>
                                            <p>
                                                Lorem ipsum dolor sit amet
                                                consectetur adipisicing
                                                elit. Minima, ad? Incidunt
                                                ipsam dolores et aperiam
                                                inventore fuga laboriosam,
                                                officia sint veniam quia
                                                expedita? Consequuntur, enim
                                                dolor! Laboriosam qui est
                                                nisi. Lorem ipsum dolor sit
                                                amet consectetur adipisicing
                                                elit. Veniam architecto
                                                consequatur dicta accusamus
                                                illum voluptas repellendus
                                                explicabo eius iste,
                                                nesciunt minus fugiat
                                                nostrum mollitia natus quia
                                                vitae odit officia quisquam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="card-text"></p>
                    </div>
                    <div class="card-footer bg-transparent border-success">
                        Footer
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-3 mb-md-3">
                <div class="card border-success">
                    <div class="card-header bg-transparent border-success">
                        Header
                    </div>
                    <div class="card-body text-success">
                        <h5 class="card-title">Success card title</h5>
                        <div>
                            <div class="row">

                                <div class="col-4">
                                    <nav id="navbar-example4"
                                        class="h-100 flex-column align-items-stretch pe-4 border-end bd-example">
                                        <nav class="nav nav-pills flex-column">
                                            <a class="nav-link" href="#item-1-2">Item 1</a>
                                            <nav class="nav nav-pills flex-column">
                                                <a class="nav-link ms-3 my-1" href="#item-1-2-1">Item 1-1</a>
                                                <a class="nav-link ms-3 my-1" href="#item-1-2-2">Item 1-2</a>
                                            </nav>
                                            <a class="nav-link" href="#item-2-2">Item 2</a>
                                            <a class="nav-link" href="#item-3-2">Item 3</a>
                                            <nav class="nav nav-pills flex-column">
                                                <a class="nav-link ms-3 my-1" href="#item-3-2-1">Item 3-1</a>
                                                <a class="nav-link ms-3 my-1" href="#item-3-2-2">Item 3-2</a>
                                            </nav>
                                        </nav>
                                    </nav>
                                </div>

                                <div class="col-8">
                                    <div data-bs-spy="scroll" data-bs-target="#navbar-example4"
                                        data-bs-smooth-scroll="true" class="scrollspy-example-2 bd-example"
                                        tabindex="0">
                                        <div id="item-1-2">
                                            <h4>Item 1</h4>
                                            <p>
                                                Lorem ipsum dolor sit amet
                                                consectetur adipisicing
                                                elit. Minima, ad? Incidunt
                                                ipsam dolores et aperiam
                                                inventore fuga laboriosam,
                                                officia sint veniam quia
                                                expedita? Consequuntur, enim
                                                dolor! Laboriosam qui est
                                                nisi. Lorem ipsum dolor sit
                                                amet consectetur adipisicing
                                                elit. Veniam architecto
                                                consequatur dicta accusamus
                                                illum voluptas repellendus
                                                explicabo eius iste,
                                                nesciunt minus fugiat
                                                nostrum mollitia natus quia
                                                vitae odit officia quisquam.
                                            </p>
                                        </div>
                                        <div id="item-1-2-1">
                                            <h5>Item 1-1</h5>
                                            <p>
                                                Lorem ipsum dolor sit amet
                                                consectetur adipisicing
                                                elit. Minima, ad? Incidunt
                                                ipsam dolores et aperiam
                                                inventore fuga laboriosam,
                                                officia sint veniam quia
                                                expedita? Consequuntur, enim
                                                dolor! Laboriosam qui est
                                                nisi. Lorem ipsum dolor sit
                                                amet consectetur adipisicing
                                                elit. Veniam architecto
                                                consequatur dicta accusamus
                                                illum voluptas repellendus
                                                explicabo eius iste,
                                                nesciunt minus fugiat
                                                nostrum mollitia natus quia
                                                vitae odit officia quisquam.
                                            </p>
                                        </div>
                                        <div id="item-1-2-2">
                                            <h5>Item 1-2</h5>
                                            <p>
                                                Lorem ipsum dolor sit amet
                                                consectetur adipisicing
                                                elit. Minima, ad? Incidunt
                                                ipsam dolores et aperiam
                                                inventore fuga laboriosam,
                                                officia sint veniam quia
                                                expedita? Consequuntur, enim
                                                dolor! Laboriosam qui est
                                                nisi. Lorem ipsum dolor sit
                                                amet consectetur adipisicing
                                                elit. Veniam architecto
                                                consequatur dicta accusamus
                                                illum voluptas repellendus
                                                explicabo eius iste,
                                                nesciunt minus fugiat
                                                nostrum mollitia natus quia
                                                vitae odit officia quisquam.
                                            </p>
                                        </div>
                                        <div id="item-2-2">
                                            <h4>Item 2</h4>
                                            <p>
                                                Lorem ipsum dolor sit amet
                                                consectetur adipisicing
                                                elit. Minima, ad? Incidunt
                                                ipsam dolores et aperiam
                                                inventore fuga laboriosam,
                                                officia sint veniam quia
                                                expedita? Consequuntur, enim
                                                dolor! Laboriosam qui est
                                                nisi. Lorem ipsum dolor sit
                                                amet consectetur adipisicing
                                                elit. Veniam architecto
                                                consequatur dicta accusamus
                                                illum voluptas repellendus
                                                explicabo eius iste,
                                                nesciunt minus fugiat
                                                nostrum mollitia natus quia
                                                vitae odit officia quisquam.
                                            </p>
                                        </div>
                                        <div id="item-3-2">
                                            <h4>Item 3</h4>
                                            <p>
                                                Lorem ipsum dolor sit amet
                                                consectetur adipisicing
                                                elit. Minima, ad? Incidunt
                                                ipsam dolores et aperiam
                                                inventore fuga laboriosam,
                                                officia sint veniam quia
                                                expedita? Consequuntur, enim
                                                dolor! Laboriosam qui est
                                                nisi. Lorem ipsum dolor sit
                                                amet consectetur adipisicing
                                                elit. Veniam architecto
                                                consequatur dicta accusamus
                                                illum voluptas repellendus
                                                explicabo eius iste,
                                                nesciunt minus fugiat
                                                nostrum mollitia natus quia
                                                vitae odit officia quisquam.
                                            </p>
                                        </div>
                                        <div id="item-3-2-1">
                                            <h5>Item 3-1</h5>
                                            <p>
                                                Lorem ipsum dolor sit amet
                                                consectetur adipisicing
                                                elit. Minima, ad? Incidunt
                                                ipsam dolores et aperiam
                                                inventore fuga laboriosam,
                                                officia sint veniam quia
                                                expedita? Consequuntur, enim
                                                dolor! Laboriosam qui est
                                                nisi. Lorem ipsum dolor sit
                                                amet consectetur adipisicing
                                                elit. Veniam architecto
                                                consequatur dicta accusamus
                                                illum voluptas repellendus
                                                explicabo eius iste,
                                                nesciunt minus fugiat
                                                nostrum mollitia natus quia
                                                vitae odit officia quisquam.
                                            </p>
                                        </div>
                                        <div id="item-3-2-2">
                                            <h5>Item 3-2</h5>
                                            <p>
                                                Lorem ipsum dolor sit amet
                                                consectetur adipisicing
                                                elit. Minima, ad? Incidunt
                                                ipsam dolores et aperiam
                                                inventore fuga laboriosam,
                                                officia sint veniam quia
                                                expedita? Consequuntur, enim
                                                dolor! Laboriosam qui est
                                                nisi. Lorem ipsum dolor sit
                                                amet consectetur adipisicing
                                                elit. Veniam architecto
                                                consequatur dicta accusamus
                                                illum voluptas repellendus
                                                explicabo eius iste,
                                                nesciunt minus fugiat
                                                nostrum mollitia natus quia
                                                vitae odit officia quisquam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="card-text"></p>
                    </div>
                    <div class="card-footer bg-transparent border-success">
                        Footer
                    </div>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-lg-6 mb-3 mb-md-3">

                <div class="card border-primary">

                    <div class="card-header bg-transparent border-primary">
                        Header
                    </div>

                    <div class="card-body text-primary">
                        <h5 class="card-title">info card title</h5>

                        <div class="row">
                            <div class="col-4">
                                <nav id="navbar-example6"
                                    class="h-100 flex-column align-items-stretch pe-4 border-end bd-example">
                                    <nav class="nav nav-pills flex-column">
                                        <a class="nav-link" href="#item-1-6">Item 1</a>
                                        <nav class="nav nav-pills flex-column">
                                            <a class="nav-link ms-3 my-1" href="#item-1-6-1">Item 1-1</a>
                                            <a class="nav-link ms-3 my-1" href="#item-1-6-2">Item 1-2</a>
                                        </nav>
                                        <a class="nav-link" href="#item-2-6">Item 2</a>
                                        <a class="nav-link" href="#item-3-6">Item 3</a>
                                        <nav class="nav nav-pills flex-column">
                                            <a class="nav-link ms-3 my-1" href="#item-3-6-1">Item 3-1</a>
                                            <a class="nav-link ms-3 my-1" href="#item-3-6-2">Item 3-2</a>
                                        </nav>
                                    </nav>
                                </nav>
                            </div>

                            <div class="col-8">
                                <div data-bs-spy="scroll" data-bs-target="#navbar-example6" data-bs-smooth-scroll="true"
                                    class="scrollspy-example-2 bd-example" tabindex="0">
                                    <div id="item-1-6">
                                        <h4>Item 1</h4>
                                        <p>
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Quasi eaque sed, placeat iure
                                            possimus odit sequi vel ratione
                                            modi consectetur numquam
                                            blanditiis, dignissimos id
                                            commodi, omnis quisquam eos
                                            vitae debitis? Lorem ipsum dolor
                                            sit amet consectetur adipisicing
                                            elit. Magni commodi laudantium
                                            quo itaque tempore porro autem
                                            libero repellendus, recusandae
                                            nemo ipsum officiis temporibus,
                                            suscipit, ratione rerum
                                            doloremque vero modi beatae.
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Itaque, unde deserunt id omnis
                                            ipsa odio dolor pariatur
                                            inventore dolore blanditiis ex
                                            architecto expedita repudiandae
                                            et dolores illo distinctio a
                                            corrupti! Lorem ipsum dolor sit,
                                            amet consectetur adipisicing
                                            elit. Nulla consequatur
                                            distinctio illo voluptatem
                                            expedita veniam possimus
                                            accusantium id! Quibusdam
                                            expedita ratione magni dolores,
                                            non officia possimus! Provident
                                            et ipsam mollitia. Lorem ipsum
                                            dolor sit amet consectetur
                                            adipisicing elit. Ullam quia
                                            accusamus voluptates, doloremque
                                            qui pariatur iure eligendi
                                            fugiat enim inventore, dolorem
                                            dolore mollitia cupiditate omnis
                                            tempore necessitatibus rem
                                            quibusdam blanditiis.
                                        </p>
                                    </div>
                                    <div id="item-1-6-1">
                                        <h5>Item 1-1</h5>
                                        <p>
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Quasi eaque sed, placeat iure
                                            possimus odit sequi vel ratione
                                            modi consectetur numquam
                                            blanditiis, dignissimos id
                                            commodi, omnis quisquam eos
                                            vitae debitis? Lorem ipsum dolor
                                            sit amet consectetur adipisicing
                                            elit. Magni commodi laudantium
                                            quo itaque tempore porro autem
                                            libero repellendus, recusandae
                                            nemo ipsum officiis temporibus,
                                            suscipit, ratione rerum
                                            doloremque vero modi beatae.
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Itaque, unde deserunt id omnis
                                            ipsa odio dolor pariatur
                                            inventore dolore blanditiis ex
                                            architecto expedita repudiandae
                                            et dolores illo distinctio a
                                            corrupti! Lorem ipsum dolor sit,
                                            amet consectetur adipisicing
                                            elit. Nulla consequatur
                                            distinctio illo voluptatem
                                            expedita veniam possimus
                                            accusantium id! Quibusdam
                                            expedita ratione magni dolores,
                                            non officia possimus! Provident
                                            et ipsam mollitia. Lorem ipsum
                                            dolor sit amet consectetur
                                            adipisicing elit. Ullam quia
                                            accusamus voluptates, doloremque
                                            qui pariatur iure eligendi
                                            fugiat enim inventore, dolorem
                                            dolore mollitia cupiditate omnis
                                            tempore necessitatibus rem
                                            quibusdam blanditiis.
                                        </p>
                                    </div>
                                    <div id="item-1-6-2">
                                        <h5>Item 1-2</h5>
                                        <p>
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Quasi eaque sed, placeat iure
                                            possimus odit sequi vel ratione
                                            modi consectetur numquam
                                            blanditiis, dignissimos id
                                            commodi, omnis quisquam eos
                                            vitae debitis? Lorem ipsum dolor
                                            sit amet consectetur adipisicing
                                            elit. Magni commodi laudantium
                                            quo itaque tempore porro autem
                                            libero repellendus, recusandae
                                            nemo ipsum officiis temporibus,
                                            suscipit, ratione rerum
                                            doloremque vero modi beatae.
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Itaque, unde deserunt id omnis
                                            ipsa odio dolor pariatur
                                            inventore dolore blanditiis ex
                                            architecto expedita repudiandae
                                            et dolores illo distinctio a
                                            corrupti! Lorem ipsum dolor sit,
                                            amet consectetur adipisicing
                                            elit. Nulla consequatur
                                            distinctio illo voluptatem
                                            expedita veniam possimus
                                            accusantium id! Quibusdam
                                            expedita ratione magni dolores,
                                            non officia possimus! Provident
                                            et ipsam mollitia. Lorem ipsum
                                            dolor sit amet consectetur
                                            adipisicing elit. Ullam quia
                                            accusamus voluptates, doloremque
                                            qui pariatur iure eligendi
                                            fugiat enim inventore, dolorem
                                            dolore mollitia cupiditate omnis
                                            tempore necessitatibus rem
                                            quibusdam blanditiis.
                                        </p>
                                    </div>
                                    <div id="item-2-6">
                                        <h4>Item 2</h4>
                                        <p>
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Quasi eaque sed, placeat iure
                                            possimus odit sequi vel ratione
                                            modi consectetur numquam
                                            blanditiis, dignissimos id
                                            commodi, omnis quisquam eos
                                            vitae debitis? Lorem ipsum dolor
                                            sit amet consectetur adipisicing
                                            elit. Magni commodi laudantium
                                            quo itaque tempore porro autem
                                            libero repellendus, recusandae
                                            nemo ipsum officiis temporibus,
                                            suscipit, ratione rerum
                                            doloremque vero modi beatae.
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Itaque, unde deserunt id omnis
                                            ipsa odio dolor pariatur
                                            inventore dolore blanditiis ex
                                            architecto expedita repudiandae
                                            et dolores illo distinctio a
                                            corrupti! Lorem ipsum dolor sit,
                                            amet consectetur adipisicing
                                            elit. Nulla consequatur
                                            distinctio illo voluptatem
                                            expedita veniam possimus
                                            accusantium id! Quibusdam
                                            expedita ratione magni dolores,
                                            non officia possimus! Provident
                                            et ipsam mollitia. Lorem ipsum
                                            dolor sit amet consectetur
                                            adipisicing elit. Ullam quia
                                            accusamus voluptates, doloremque
                                            qui pariatur iure eligendi
                                            fugiat enim inventore, dolorem
                                            dolore mollitia cupiditate omnis
                                            tempore necessitatibus rem
                                            quibusdam blanditiis.
                                        </p>
                                    </div>
                                    <div id="item-3-6">
                                        <h4>Item 3</h4>
                                        <p>
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Quasi eaque sed, placeat iure
                                            possimus odit sequi vel ratione
                                            modi consectetur numquam
                                            blanditiis, dignissimos id
                                            commodi, omnis quisquam eos
                                            vitae debitis? Lorem ipsum dolor
                                            sit amet consectetur adipisicing
                                            elit. Magni commodi laudantium
                                            quo itaque tempore porro autem
                                            libero repellendus, recusandae
                                            nemo ipsum officiis temporibus,
                                            suscipit, ratione rerum
                                            doloremque vero modi beatae.
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Itaque, unde deserunt id omnis
                                            ipsa odio dolor pariatur
                                            inventore dolore blanditiis ex
                                            architecto expedita repudiandae
                                            et dolores illo distinctio a
                                            corrupti! Lorem ipsum dolor sit,
                                            amet consectetur adipisicing
                                            elit. Nulla consequatur
                                            distinctio illo voluptatem
                                            expedita veniam possimus
                                            accusantium id! Quibusdam
                                            expedita ratione magni dolores,
                                            non officia possimus! Provident
                                            et ipsam mollitia. Lorem ipsum
                                            dolor sit amet consectetur
                                            adipisicing elit. Ullam quia
                                            accusamus voluptates, doloremque
                                            qui pariatur iure eligendi
                                            fugiat enim inventore, dolorem
                                            dolore mollitia cupiditate omnis
                                            tempore necessitatibus rem
                                            quibusdam blanditiis.
                                        </p>
                                    </div>
                                    <div id="item-3-6-1">
                                        <h5>Item 3-1</h5>
                                        <p>
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Quasi eaque sed, placeat iure
                                            possimus odit sequi vel ratione
                                            modi consectetur numquam
                                            blanditiis, dignissimos id
                                            commodi, omnis quisquam eos
                                            vitae debitis? Lorem ipsum dolor
                                            sit amet consectetur adipisicing
                                            elit. Magni commodi laudantium
                                            quo itaque tempore porro autem
                                            libero repellendus, recusandae
                                            nemo ipsum officiis temporibus,
                                            suscipit, ratione rerum
                                            doloremque vero modi beatae.
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Itaque, unde deserunt id omnis
                                            ipsa odio dolor pariatur
                                            inventore dolore blanditiis ex
                                            architecto expedita repudiandae
                                            et dolores illo distinctio a
                                            corrupti! Lorem ipsum dolor sit,
                                            amet consectetur adipisicing
                                            elit. Nulla consequatur
                                            distinctio illo voluptatem
                                            expedita veniam possimus
                                            accusantium id! Quibusdam
                                            expedita ratione magni dolores,
                                            non officia possimus! Provident
                                            et ipsam mollitia. Lorem ipsum
                                            dolor sit amet consectetur
                                            adipisicing elit. Ullam quia
                                            accusamus voluptates, doloremque
                                            qui pariatur iure eligendi
                                            fugiat enim inventore, dolorem
                                            dolore mollitia cupiditate omnis
                                            tempore necessitatibus rem
                                            quibusdam blanditiis.
                                        </p>
                                    </div>
                                    <div id="item-3-6-2">
                                        <h5>Item 3-2</h5>
                                        <p>
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Quasi eaque sed, placeat iure
                                            possimus odit sequi vel ratione
                                            modi consectetur numquam
                                            blanditiis, dignissimos id
                                            commodi, omnis quisquam eos
                                            vitae debitis? Lorem ipsum dolor
                                            sit amet consectetur adipisicing
                                            elit. Magni commodi laudantium
                                            quo itaque tempore porro autem
                                            libero repellendus, recusandae
                                            nemo ipsum officiis temporibus,
                                            suscipit, ratione rerum
                                            doloremque vero modi beatae.
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Itaque, unde deserunt id omnis
                                            ipsa odio dolor pariatur
                                            inventore dolore blanditiis ex
                                            architecto expedita repudiandae
                                            et dolores illo distinctio a
                                            corrupti! Lorem ipsum dolor sit,
                                            amet consectetur adipisicing
                                            elit. Nulla consequatur
                                            distinctio illo voluptatem
                                            expedita veniam possimus
                                            accusantium id! Quibusdam
                                            expedita ratione magni dolores,
                                            non officia possimus! Provident
                                            et ipsam mollitia. Lorem ipsum
                                            dolor sit amet consectetur
                                            adipisicing elit. Ullam quia
                                            accusamus voluptates, doloremque
                                            qui pariatur iure eligendi
                                            fugiat enim inventore, dolorem
                                            dolore mollitia cupiditate omnis
                                            tempore necessitatibus rem
                                            quibusdam blanditiis.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-transparent border-primary">
                        Footer
                    </div>

                </div>
            </div>

            <div class="col-lg-6 mb-3 mb-md-3">
                <div class="card border-primary">
                    <div class="card-header bg-transparent border-primary">
                        Header
                    </div>
                    <div class="card-body text-primary">
                        <h5 class="card-title">info card title</h5>

                        <div class="row">
                            <div class="col-4">
                                <nav id="navbar-example5"
                                    class="h-100 flex-column align-items-stretch pe-4 border-end bd-example">
                                    <nav class="nav nav-pills flex-column">
                                        <a class="nav-link" href="#item-1-4">Item 1</a>
                                        <nav class="nav nav-pills flex-column">
                                            <a class="nav-link ms-3 my-1" href="#item-1-4-1">Item 1-1</a>
                                            <a class="nav-link ms-3 my-1" href="#item-1-4-2">Item 1-2</a>
                                        </nav>
                                        <a class="nav-link" href="#item-2-4">Item 2</a>
                                        <a class="nav-link" href="#item-3-4">Item 3</a>
                                        <nav class="nav nav-pills flex-column">
                                            <a class="nav-link ms-3 my-1" href="#item-3-4-1">Item 3-1</a>
                                            <a class="nav-link ms-3 my-1" href="#item-3-4-2">Item 3-2</a>
                                        </nav>
                                    </nav>
                                </nav>
                            </div>

                            <div class="col-8">
                                <div data-bs-spy="scroll" data-bs-target="#navbar-example5" data-bs-smooth-scroll="true"
                                    class="scrollspy-example-2 bd-example" tabindex="0">
                                    <div id="item-1-4">
                                        <h4>Item 1</h4>
                                        <p>
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Nulla quos nesciunt repudiandae.
                                            Doloribus modi, repellat
                                            reiciendis cumque quasi ab. Eum,
                                            fugit natus! Earum sit ad
                                            doloribus temporibus magnam
                                            atque alias? Lorem ipsum dolor
                                            sit, amet consectetur
                                            adipisicing elit. Officia
                                            numquam eius eligendi illo
                                            corrupti esse est facere
                                            pariatur quo inventore totam,
                                            aut sed magni, omnis blanditiis
                                            vitae velit repellat alias?
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Dolor assumenda esse eligendi
                                            sapiente officia inventore
                                            minima recusandae odit rerum
                                            possimus aspernatur molestiae
                                            natus id, fugit nostrum.
                                            Corporis magnam perspiciatis
                                            optio? Lorem, ipsum dolor sit
                                            amet consectetur adipisicing
                                            elit. Veritatis sit illum
                                            corporis iusto repellendus
                                            doloribus repellat ipsa modi!
                                            Eum magni molestias soluta,
                                            ipsam quasi tempore rerum
                                            voluptas fuga iste blanditiis?
                                        </p>
                                    </div>
                                    <div id="item-1-4-1">
                                        <h5>Item 1-1</h5>
                                        <p>
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Nulla quos nesciunt repudiandae.
                                            Doloribus modi, repellat
                                            reiciendis cumque quasi ab. Eum,
                                            fugit natus! Earum sit ad
                                            doloribus temporibus magnam
                                            atque alias? Lorem ipsum dolor
                                            sit, amet consectetur
                                            adipisicing elit. Officia
                                            numquam eius eligendi illo
                                            corrupti esse est facere
                                            pariatur quo inventore totam,
                                            aut sed magni, omnis blanditiis
                                            vitae velit repellat alias?
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Dolor assumenda esse eligendi
                                            sapiente officia inventore
                                            minima recusandae odit rerum
                                            possimus aspernatur molestiae
                                            natus id, fugit nostrum.
                                            Corporis magnam perspiciatis
                                            optio? Lorem, ipsum dolor sit
                                            amet consectetur adipisicing
                                            elit. Veritatis sit illum
                                            corporis iusto repellendus
                                            doloribus repellat ipsa modi!
                                            Eum magni molestias soluta,
                                            ipsam quasi tempore rerum
                                            voluptas fuga iste blanditiis?
                                        </p>
                                    </div>
                                    <div id="item-1-4-2">
                                        <h5>Item 1-2</h5>
                                        <p>
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Nulla quos nesciunt repudiandae.
                                            Doloribus modi, repellat
                                            reiciendis cumque quasi ab. Eum,
                                            fugit natus! Earum sit ad
                                            doloribus temporibus magnam
                                            atque alias? Lorem ipsum dolor
                                            sit, amet consectetur
                                            adipisicing elit. Officia
                                            numquam eius eligendi illo
                                            corrupti esse est facere
                                            pariatur quo inventore totam,
                                            aut sed magni, omnis blanditiis
                                            vitae velit repellat alias?
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Dolor assumenda esse eligendi
                                            sapiente officia inventore
                                            minima recusandae odit rerum
                                            possimus aspernatur molestiae
                                            natus id, fugit nostrum.
                                            Corporis magnam perspiciatis
                                            optio? Lorem, ipsum dolor sit
                                            amet consectetur adipisicing
                                            elit. Veritatis sit illum
                                            corporis iusto repellendus
                                            doloribus repellat ipsa modi!
                                            Eum magni molestias soluta,
                                            ipsam quasi tempore rerum
                                            voluptas fuga iste blanditiis?
                                        </p>
                                    </div>
                                    <div id="item-2-4">
                                        <h4>Item 2</h4>
                                        <p>
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Nulla quos nesciunt repudiandae.
                                            Doloribus modi, repellat
                                            reiciendis cumque quasi ab. Eum,
                                            fugit natus! Earum sit ad
                                            doloribus temporibus magnam
                                            atque alias? Lorem ipsum dolor
                                            sit, amet consectetur
                                            adipisicing elit. Officia
                                            numquam eius eligendi illo
                                            corrupti esse est facere
                                            pariatur quo inventore totam,
                                            aut sed magni, omnis blanditiis
                                            vitae velit repellat alias?
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Dolor assumenda esse eligendi
                                            sapiente officia inventore
                                            minima recusandae odit rerum
                                            possimus aspernatur molestiae
                                            natus id, fugit nostrum.
                                            Corporis magnam perspiciatis
                                            optio? Lorem, ipsum dolor sit
                                            amet consectetur adipisicing
                                            elit. Veritatis sit illum
                                            corporis iusto repellendus
                                            doloribus repellat ipsa modi!
                                            Eum magni molestias soluta,
                                            ipsam quasi tempore rerum
                                            voluptas fuga iste blanditiis?
                                        </p>
                                    </div>
                                    <div id="item-3-4">
                                        <h4>Item 3</h4>
                                        <p>
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Nulla quos nesciunt repudiandae.
                                            Doloribus modi, repellat
                                            reiciendis cumque quasi ab. Eum,
                                            fugit natus! Earum sit ad
                                            doloribus temporibus magnam
                                            atque alias? Lorem ipsum dolor
                                            sit, amet consectetur
                                            adipisicing elit. Officia
                                            numquam eius eligendi illo
                                            corrupti esse est facere
                                            pariatur quo inventore totam,
                                            aut sed magni, omnis blanditiis
                                            vitae velit repellat alias?
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Dolor assumenda esse eligendi
                                            sapiente officia inventore
                                            minima recusandae odit rerum
                                            possimus aspernatur molestiae
                                            natus id, fugit nostrum.
                                            Corporis magnam perspiciatis
                                            optio? Lorem, ipsum dolor sit
                                            amet consectetur adipisicing
                                            elit. Veritatis sit illum
                                            corporis iusto repellendus
                                            doloribus repellat ipsa modi!
                                            Eum magni molestias soluta,
                                            ipsam quasi tempore rerum
                                            voluptas fuga iste blanditiis?
                                        </p>
                                    </div>
                                    <div id="item-3-4-1">
                                        <h5>Item 3-1</h5>
                                        <p>
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Nulla quos nesciunt repudiandae.
                                            Doloribus modi, repellat
                                            reiciendis cumque quasi ab. Eum,
                                            fugit natus! Earum sit ad
                                            doloribus temporibus magnam
                                            atque alias? Lorem ipsum dolor
                                            sit, amet consectetur
                                            adipisicing elit. Officia
                                            numquam eius eligendi illo
                                            corrupti esse est facere
                                            pariatur quo inventore totam,
                                            aut sed magni, omnis blanditiis
                                            vitae velit repellat alias?
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Dolor assumenda esse eligendi
                                            sapiente officia inventore
                                            minima recusandae odit rerum
                                            possimus aspernatur molestiae
                                            natus id, fugit nostrum.
                                            Corporis magnam perspiciatis
                                            optio? Lorem, ipsum dolor sit
                                            amet consectetur adipisicing
                                            elit. Veritatis sit illum
                                            corporis iusto repellendus
                                            doloribus repellat ipsa modi!
                                            Eum magni molestias soluta,
                                            ipsam quasi tempore rerum
                                            voluptas fuga iste blanditiis?
                                        </p>
                                    </div>
                                    <div id="item-3-4-2">
                                        <h5>Item 3-2</h5>
                                        <p>
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Nulla quos nesciunt repudiandae.
                                            Doloribus modi, repellat
                                            reiciendis cumque quasi ab. Eum,
                                            fugit natus! Earum sit ad
                                            doloribus temporibus magnam
                                            atque alias? Lorem ipsum dolor
                                            sit, amet consectetur
                                            adipisicing elit. Officia
                                            numquam eius eligendi illo
                                            corrupti esse est facere
                                            pariatur quo inventore totam,
                                            aut sed magni, omnis blanditiis
                                            vitae velit repellat alias?
                                            Lorem ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Dolor assumenda esse eligendi
                                            sapiente officia inventore
                                            minima recusandae odit rerum
                                            possimus aspernatur molestiae
                                            natus id, fugit nostrum.
                                            Corporis magnam perspiciatis
                                            optio? Lorem, ipsum dolor sit
                                            amet consectetur adipisicing
                                            elit. Veritatis sit illum
                                            corporis iusto repellendus
                                            doloribus repellat ipsa modi!
                                            Eum magni molestias soluta,
                                            ipsam quasi tempore rerum
                                            voluptas fuga iste blanditiis?
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-primary">
                        Footer
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>