@php
    $errorUsernameInput = isset($errorUsernameInput) ? $errorUsernameInput : "";
    $errorNameInput = isset($errorNameInput) ? $errorNameInput : "";
    // $errorEmailInput = isset($errorEmailInput) ? $errorEmailInput : "";
    // $errorTelephoneInput = isset($errorTelephoneInput) ? $errorTelephoneInput : "";
    $errorPasswordInput = isset($errorPasswordInput) ? $errorPasswordInput : "";

    $title = "Registrasi peminjaman ruangan";
    $name = "Sign Up";
@endphp

<x-layout.main :title="$title">
    <div class="mt-3">
        <div class="container-fluid container-md">
            <div class="col-auto col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">
                <div class="shadow border rounded-3">
                    <form id="myForm" action="#" method="post" novalidate>
                        @csrf
                        <div class="p-4">
                            {{-- header form --}}
                            <h1 class="mb-4 text-center text-primary">{{ $title }}</h1>
                            {{-- end header form --}}

                            <x-form.input.username :errorUsernameInput="$errorUsernameInput">
                            </x-form.input.username>
                            <x-form.input.name :errorNameInput="$errorUsernameInput">
                            </x-form.input.name>
                            <x-form.input.password :errorPasswordInput="$errorPasswordInput">
                            </x-form.input.password>
                            {{-- <x-form.input.email :errorEmailInput="$errorEmailInput">
                            </x-form.input.email>
                            <x-form.input.telephone :errorTelephoneInput="$errorTelephoneInput">
                            </x-form.input.telephone> --}}

                            {{-- term of use input --}}
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="agreedTermsOfUse"
                                    id="terms-of-use-check" required />
                                <label for="terms-of-use-check" class="form-check-label">Terms of Use</label>
                                @isset($errorTermsOfUseInput)
                                <!-- username error message -->
                                <div class="text-danger">{{ $errorTermsOfUseInput }}</div>
                                <!-- end username error message -->
                                @endisset
                            </div>
                            {{-- end of term of use input --}}

                            <x-form.submit.button :name="$name"></x-form.submit.button>

                            <div class="form-floating text-center mt-3">
                                <div class="h5">
                                    Sistem Informasi Peminjaman Ruangan
                                </div>
                                <p>
                                    Sudah punya akun?
                                    <a href="#">Login disini.</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout.main>

{{--
<!-- role input  -->
<div class=" mb-3">
    <select class="form-select" id="role" size="1" name="role" aria-placeholder="Role">
        <option value="Mahasiswa">Mahasiswa</option>
        <option value="Bukan Mahasiswa">Bukan Mahasiswa</option>
    </select>
    <div id="" class="form-text">Pick a role.</div>
</div>
<!-- end of role input -->
--}}