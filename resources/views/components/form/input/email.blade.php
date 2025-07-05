{{-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie --}}
{{-- email input --}}
<div class="form-floating mb-3">
    <input class="form-control shadow-sm" name="email" id="email-input" type="text" placeholder="email" value="" required />
    <label for="email-input">Email</label>
    @isset($errorEmailInput)
        {{-- username error message --}}
        <div class="text-danger">{{ $errorEmailInput }}</div>
        {{-- end username error message --}}
    @endisset
    <div class="d-flex w-100 justify-content-between">
        <div id="" class="form-text">Please insert your valid email.</div>
        <div id="" class="form-text">Example: iamlucky@gmail.com</div>
    </div>
</div>
{{-- end of email input --}}