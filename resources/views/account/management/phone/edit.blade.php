@php

    $title = "Edit Existing Phone Number";

@endphp

<x-layout.main :title="$title">
    <div class="mt-3">
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
                            <input class="form-control shadow-sm opacity-50" name="oldPhoneNumber-display"
                                id="oldPhoneNumber-input" type="text" placeholder="oldPhoneNumber"
                                value="{{ $oldPhoneNumber ?? " @oldPhoneNumber_is_not_set"}}" disabled />
                            <label for="oldPhoneNumber-input">Old Phone Number</label>
                            <input type="hidden" name="oldPhoneNumber" value="{{ $oldPhoneNumber ?? null }}">
                            <div class="form-text">Currently your phone number registered on.</div>
                        </div>
                        {{-- end of disabled input --}}
                        {{-- new email input --}}
                        <div class="form-floating mb-3">
                            <input class="form-control shadow-sm" name="updated-phone-number" id="updated-phone-number-input"
                                type="text" value="" placeholder="updated-phone-number" required />
                            <label for="updated-phone-number-input">Updated Phone Number</label>
                            {{-- email error message --}}
                            @isset($errorUpdatedPhoneNumberInput)
                                <div class="text-danger"> {{ $errorUpdatedPhoneNumberInput }} </div>
                            @endisset
                            {{-- end email error message --}}
                            <div class="form-text">Example: +62-813-4567-8901</div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>
                        {{-- end of new email input --}}
                        {{-- button submit input --}}
                        <div class="form-floating mb-2">
                            <button type="submit" class="btn btn-outline-{{ $color_primary ?? "primary" }} w-100">Update Phone Number</button>
                        </div>
                        {{-- end of button submit input --}}
                    </form>
                    {{-- delete phone number --}}
                    <a
                        href="/account-management/dashboard/account/delete-phone-number?phone-number={{ urlencode($oldPhoneNumber) }}">
                        <div class="form-floating mb-2 opacity-75">
                            <button type="reset" class="btn btn-outline-danger w-100">Delete Phone Number</button>
                        </div>
                    </a>
                    {{-- end of delete phone number --}}
                    {{-- kembali ke halaman akun --}}
                    <x-redirect.account></x-redirect.account>
                    {{-- end of kembali ke halaman akun --}}
                </div>
                {{-- end of change username form with style --}}
            </div>
        </div>
    </div>
</x-layout.main>