{{-- He who is contented is rich. - Laozi --}}
{{-- Name input --}}
<div class="form-floating mb-3">
    <input class="form-control shadow-sm" name="name" id="Name-input" type="text" value="" placeholder="Name" />
    <label for="Name-input">Name</label>
    @isset($errorNameInput)
        {{-- username error message --}}
        <div class="text-danger">{{ $errorNameInput }}</div>
        {{-- end username error message --}}
    @endisset
    <div class="d-flex w-100 justify-content-between">
        <div id="" class="form-text">Pick Your Name Here!</div>
        <div id="" class="form-text">Example: Saya Lorem Ipsum.</div>
    </div>
</div>
{{-- end Name input --}}