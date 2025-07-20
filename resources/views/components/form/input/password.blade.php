{{-- Smile, breathe, and go slowly. - Thich Nhat Hanh --}}
{{-- password input --}}
<div class="form-floating mb-3">
    <input class="form-control shadow-sm" name="password" id="password-input" type="password" value=""
        placeholder="password" required />
    <label for="password-input">Password</label>
    @isset($errorPasswordInput)
        @if (str_word_count($errorPasswordInput) > 2)
            {{-- username error message --}}
            <div class="btn btn-outline-danger mt-3 w-100">{{ $errorPasswordInput }}</div>
            {{-- end username error message --}}
        @endif
    @endisset
    <div class="d-flex w-100 justify-content-between">
        <div id="" class="form-text">{{ $sweetenMessage }}</div>
        <small id="" class="form-text">{{ $exampleMessage }}</small>
    </div>
</div>
{{-- end of password input --}}