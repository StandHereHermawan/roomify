{{-- Smile, breathe, and go slowly. - Thich Nhat Hanh --}}
{{-- password input --}}
<div class="form-floating mb-3">
    <input class="form-control shadow-sm" name="password" id="password-input" type="password" value=""
        placeholder="password" required />
    <label for="password-input">Password</label>
    @isset($errorPasswordInput)
        {{-- username error message --}}
        <div class="text-danger">{{ $errorPasswordInput }}</div>
        {{-- end username error message --}}
    @endisset
    <div class="d-flex w-100 justify-content-between">
        <div id="" class="form-text">{{ $sweetenMessage }}</div>
        <small id="" class="form-text">{{ $exampleMessage }}</small>
    </div>
</div>
{{-- end of password input --}}