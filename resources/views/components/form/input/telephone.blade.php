{{-- The best way to take care of the future is to take care of the present moment. - Thich Nhat Hanh --}}
{{-- nomor telepon input --}}
<div class="form-floating mb-3">
    <input class="form-control shadow-sm" name="telephone" id="telephone-input" type="text" value="" placeholder="telephone"
        required />
    <label for="telephone-input">Telephone</label>
    @isset($errorTelephoneInput)
        {{-- username error message --}}
        <div class="text-danger">{{ $errorTelephoneInput }}</div>
        {{-- end username error message --}}
    @endisset
    <div class="d-flex w-100 justify-content-between">
        <div id="" class="form-text">Please insert your valid phone number.</div>
        <div id="" class="form-text">Example: +62-812-3456-7890</div>
    </div>
</div>
{{-- end of nomor telepon input --}}