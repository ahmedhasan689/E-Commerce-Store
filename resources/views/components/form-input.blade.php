

<div class="input-group-prepend">
    @if (isset($span))
    <span class="input-group-text">{{ $span }}</span>
    @endif
</div>
<input type="{{ $type ?? 'text' }}"
       class="form-control @error($name) is-invalid @enderror"
       id = "{{ $id ?? $name }}"
       value="{{ old($name, $value ?? null) }}" > 
</input>

@error($name)
<p class="invalid-feedback">
    {{ $message }}
</p>
@enderror