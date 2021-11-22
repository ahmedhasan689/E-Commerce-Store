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
        <span class="input-group-text">Product Name</span>
    </div>
    <input type="name" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Enter product Name" value="{{ old('name', $product->name) }}">

    @error('name')
    <p class="invalid-feedback">
        {{ $message }}
    </p>
    @enderror
</div>

<div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text">Select Category</span>
    </div>
    <select class="form-control @error('category_id') is-invalid @enderror" placeholder="Select product Name" name="category_id">
        <option value="0">No product</option>
        @foreach ($categories as $category)
        <option value="{{ $category->id }}" @if($category->id == old('category_id', $category->category_id)) selected @endif
            >{{ $category->name }}</option>
        @endforeach
    </select>

    @error('category_id')
    <p class="invalid-feedback">
        {{ $message }}
    </p>
    @enderror
</div>

<div class="input-group mb-3">
    <div class="input-group-prepend">
        <span class="input-group-text">Description</span>
    </div>
    <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $product->description) }}</textarea>

    @error('description')
    <p class="invalid-feedback">
        {{ $message }}
    </p>
    @enderror
</div>

<div class="input-group mb-3">
    <!-- <x-form-input type="number" name="price" span="price" :value="$product->price" /> -->
    <div class="input-group-prepend">
        <span class="input-group-text">price</span>
    </div>
    <input class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $product->price) }}"></input>

    @error('price')
    <p class="invalid-feedback">
        {{ $message }}
    </p>
    @enderror
</div>

<div class="input-group mb-3">
    <x-form-input type="number" name="quantity" span="quantity" :value="$product->quantity"/>
</div>

<div class="input-group mb-3">
    <x-form-input type="number" name="width" span="width" :value="$product->width"/> 
</div>

<div class="input-group mb-3">
    <x-form-input type="number" name="height" span="height" :value="$product->height"/> 
</div>

<div class="input-group mb-3">
    <x-form-input type="number" name="weight" span="weight" :value="$product->weight"/> 
</div>

<div class="input-group mb-3">
    <x-form-input type="number" name="length" span="Length" :value="$product->length"/>
</div>

<div class="input-group mb-3">
    <x-form-input type="file" name="image" span="Image" :value="$product->image_path"/> 
</div>

<div class="form-group">
    <label for="status">Status</label>
    <div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="status-active" value="active" @if ($product->status == 'active') checked @endif
            />
            <label class="form-check-label" for="status-active">
                Active
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" id="status-draft" value="draft" @if ($product->status == 'draft') checked @endif
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