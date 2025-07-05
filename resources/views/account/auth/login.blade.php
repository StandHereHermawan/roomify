@php
    $errorUsernameInput = isset($errorUsernameInput) ? $errorUsernameInput : "";
    $errorPasswordInput = isset($errorPasswordInput) ? $errorPasswordInput : "";
    $exampleMessageUsername = "";
    $sweetenMessageUsername = "Insert your registered username.";
    $exampleMessagePassword = "";
    $sweetenMessagePassword = "Insert your valid password.";

    $title = "Login";
    $name = "Login";
@endphp

<x-layout.main :title="$title">
    <div class="mt-3">
        <div class="container-fluid container-md">
            <div class="col-auto col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">
                <div class="shadow-sm border rounded-3">
                    <form id="myForm" action="#" method="post" novalidate>
                        @csrf
                        <div class="p-4">
                            {{-- header form --}}
                            <h1 class="mb-4 text-center text-primary">Login peminjaman ruangan</h1>
                            {{-- end header form --}}

                            <x-form.input.username :errorUsernameInput="$errorUsernameInput"
                                :exampleMessage="$exampleMessageUsername" :sweetenMessage="$sweetenMessageUsername">
                            </x-form.input.username>
                            <x-form.input.password :errorPasswordInput="$errorPasswordInput"
                                :exampleMessage="$exampleMessagePassword" :sweetenMessage="$sweetenMessagePassword">
                            </x-form.input.password>

                            <div class="pt-4">
                                <x-form.submit.button :name="$name"></x-form.submit.button>
                            </div>

                            <div class="form-floating text-center mt-3">
                                <p>
                                    Belum punya akun?
                                    <a href="{{ route('registration') }}">Registrasi disini.</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout.main>