
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
        <span class="input-group-text">Category Name</span>
    </div>
    <input type="name" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter Category Name" value="{{ old('name', $category->name) }}">

    @error('name')
        <p class="invalid-feedback">
            {{ $message }}
        </p>
    @enderror
</div>

<div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text">Parent Name</span>
    </div>
    <select class="form-control @error('parent_id') is-invalid @enderror" id="Parent" placeholder="Select Parent Name" name="parent_id">
        <option>No Parent</option>
        @foreach ($parents as $parent)
        <option value="{{ $parent->id }}" @if($parent->id == old('parent_id', $category->parent_id)) selected @endif
            >{{ $parent->name }}</option>
        @endforeach
    </select>

    @error('parent_id')
        <p class="invalid-feedback">
            {{ $message }}
        </p>
    @enderror
</div>

<div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text">Description</span>
    </div>
    <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $category->description) }}</textarea>

    @error('description')
        <p class="invalid-feedback">
            {{ $message }}
        </p>
    @enderror
</div>

<div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text">Image</span>
    </div>
    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">

    @error('image')
        <p class="invalid-feedback">
            {{ $message }}
        </p>
    @enderror
</div>

<div class="form-group">
    <label for="status">Status</label>
    <div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="status-active" value="active" @if ($category->status == 'active') checked @endif
            />
            <label class="form-check-label" for="status-active">
                Active
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="status-draft" value="draft" @if ($category->status == 'draft') checked @endif
            />
            <label class="form-check-label" for="status-draft">
                Draft
            </label>
        </div>
    </div>
    
    @error('status')
        <p class="text-danger">
            {{ $message }}
        </p>
    @enderror
</div>

<button type="submit" class="btn btn-primary">
    {{ $button }}
</button>

