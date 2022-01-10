@if (isset($label))
<label>{{ $label }}</label>
@endif

<input type="{{ $type ?? 'text' }}" name="{{ $name }}" class="form-control @error($name) is-invalid @enderror" id="{{ $id ?? $name }}" value="{{ old($name, $value ?? null) }}">
</input>

@error($name)
<p class="invalid-feedback">
    {{ $message }}
</p>
@enderror