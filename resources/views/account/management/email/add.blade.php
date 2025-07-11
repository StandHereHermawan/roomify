@php
    $title = "Tambah Email";
@endphp

<x-layout.main :title="$title">
    <div class="my-3">
        <div class="container-fluid container-md">
            <div class="col-auto col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">
                {{-- change form with style --}}
                <div class="p-4 border rounded-3 shadow">
                    <form id="myForm" action="#" method="post" novalidate>
                        @csrf
                        {{-- header form --}}
                        <h1 class="mb-4 text-center text-{{ $color_main ?? "primary" }}">{{ $title }}</h1>
                        {{-- end header form --}}
                        {{-- disabled input --}}
                        <div class="form-floating mb-3">
                            <input class="form-control shadow-sm" name="username-display" id="username-input"
                                type="text" placeholder="username" value="{{ $username ?? " @username_is_not_set"}}"
                                disabled />
                            <label for="username-input">Username</label>
                            <div class="form-text">Currently your username registered on.</div>
                        </div>
                        {{-- end of disabled input --}}
                        {{-- new username input --}}
                        <div class="form-floating mb-3">
                            <input class="form-control shadow-sm" name="new-email" id="new-email-input" type="text" value=""
                                placeholder="new-email" required />
                            <label for="new-email-input">New Email</label>
                            {{-- username error message --}}
                            @isset($error_new_email_input)
                                <div class="text-danger"> {{ $error_new_email_input }} </div>
                            @endisset
                            {{-- end username error message --}}
                            <div class="form-text">Example: example@gmail.com</div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>
                        {{-- end of new username input --}}
                        {{-- button submit input --}}
                        <div class="form-floating mb-2">
                            <x-form.submit.button :name="$title"></x-form.submit.button>
                        </div>
                        {{-- end of button submit input --}}
                    </form>
                    {{-- kembali ke halaman akun --}}
                    <x-redirect.account></x-redirect.account>
                    {{-- end of kembali ke halaman akun --}}
                </div>
                {{-- end of change form with style --}}
            </div>
        </div>
    </div>
</x-layout.main>