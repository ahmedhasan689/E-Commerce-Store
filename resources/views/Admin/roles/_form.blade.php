<!-- Where Come From Validate If There Any Error -->
@if ($errors->any())

<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $message)
        <li>
            {{ $message }}
        </li>
        @endforeach
    </ul>
</div>

@endif



<!-- Form -->
<div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text">role Name</span>
    </div>
    <input type="name" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter role Name" value="{{ old('name', $role->name) }}">

    @error('name')
    <p class="invalid-feedback">
        {{ $message }}
    </p>
    @enderror
</div>

<div class="form-group">
    @foreach(config('abilities') as $key =>$value)
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="{{ $key }}" name="abilities[]">
        <label class="form-check-label">
            {{ $value }}
        </label>
    </div>
    @endforeach
</div>

<button type="submit" class="btn btn-primary">
    {{ $button }}
</button>