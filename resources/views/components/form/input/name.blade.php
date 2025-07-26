{{-- He who is contented is rich. - Laozi --}}
{{-- Name input --}}
<div class="form-floating mb-3">
    <input class="form-control shadow-sm" name="name" id="Name-input" type="text" value="" placeholder="Name" />
    <label for="Name-input">Name</label>
    @isset($errorNameInput)
        @if (str_word_count($errorNameInput) > 2)
            {{-- username error message --}}
            <div class="btn btn-outline-danger mt-3 w-100">{{ $errorNameInput }}</div>
            {{-- end username error message --}}
        @endif
    @endisset
    <div class="d-flex w-100 justify-content-between">
        <div id="" class="form-text">Pick Your Name Here!</div>
        <div id="" class="form-text">Example: Saya Lorem Ipsum.</div>
    </div>
</div>
{{-- end Name input --}}