{{-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger --}}
{{-- username input --}}
<div class="form-floating mb-3">
    <input class="form-control shadow-sm" name="username" id="username-input" type="text" value="{{ old("username") }}"
        placeholder="username" autocomplete="true" required />
    <label for="username-input">Username</label>
    @isset($errorUsernameInput)
        {{-- username error message --}}
        <div class="text-danger">{{ $errorUsernameInput }}</div>
        {{-- end username error message --}}
    @endisset
    <div class="d-flex w-100 justify-content-between">
        <div id="" class="form-text">{{ $sweetenMessage }}</div>
        <small id="" class="form-text">{{ $exampleMessage }}</small>
    </div>
</div>
{{-- end username input --}}