@php

    $title = "Edit Existing Email";

@endphp

<x-layout.main :title="$title">
    <div class="my-3">
        <div class="container-fluid container-md">
            <div class="col-auto col-sm-8 offset-sm-2 col-lg-6 offset-lg-3">
                {{-- change username form with style --}}
                <div class="p-4 border rounded-3 shadow">
                    <form id="myForm" action="#" method="post" novalidate>
                        @csrf
                        {{-- header form --}}
                        <h1 class="mb-4 text-center text-{{ $color_primary ?? "primary" }}">{{ $title }}</h1>
                        {{-- end header form --}}
                        {{-- disabled input --}}
                        <div class="form-floating mb-3">
                            <input class="form-control shadow-sm opacity-50" name="username-display" id="username-input"
                                type="text" placeholder="username" value="{{ $username ?? " @username_is_not_set"}}"
                                disabled />
                            <label for="username-input">Username</label>
                            <input type="hidden" name="username" value="{{ $username ?? null }}">
                            <div class="form-text">Currently your username registered on.</div>
                        </div>
                        {{-- end of disabled input --}}
                        {{-- disabled input --}}
                        <div class="form-floating mb-3">
                            <input class="form-control shadow-sm opacity-50" name="oldEmail-display" id="oldEmail-input"
                                type="text" placeholder="oldEmail" value="{{ $oldEmail ?? " @oldEmail_is_not_set"}}"
                                disabled />
                            <label for="oldEmail-input">Old Email</label>
                            <input type="hidden" name="oldEmail" value="{{ $oldEmail ?? null }}">
                            <div class="form-text">Currently your email registered on.</div>
                        </div>
                        {{-- end of disabled input --}}
                        {{-- new email input --}}
                        <div class="form-floating mb-3">
                            <input class="form-control shadow-sm" name="updated-email" id="updated-email-input" type="text"
                                value="" placeholder="updated-email" required />
                            <label for="updated-email-input">Updated Email</label>
                            {{-- email error message --}}
                            @isset($errorUpdatedEmailInput)
                                <div class="text-danger"> {{ $errorUpdatedEmailInput }} </div>
                            @endisset
                            {{-- end email error message --}}
                            <div class="form-text">Example: example@gmail.com</div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>
                        {{-- end of new email input --}}
                        {{-- button submit input --}}
                        <div class="form-floating mb-2">
                            <button type="submit" class="btn btn-outline-{{ $color_primary ?? "primary" }} w-100">Update Email</button>
                        </div>
                        {{-- end of button submit input --}}
                    </form>
                    {{-- delete email --}}
                    <a href="/account-management/dashboard/account/delete-email?email={{ $oldEmail }}">
                        <div class="form-floating mb-2 opacity-75">
                            <button type="reset" class="btn btn-outline-danger w-100">Delete Email</button>
                        </div>
                    </a>
                    {{-- end of delete email --}}
                    {{-- kembali ke halaman akun --}}
                    <x-redirect.account></x-redirect.account>
                    {{-- end of kembali ke halaman akun --}}
                </div>
                {{-- end of change username form with style --}}
            </div>
        </div>
    </div>
</x-layout.main>