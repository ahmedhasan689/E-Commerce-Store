@extends('layouts.admin')

@section('title', 'Edit New Category')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('categories.index') }}">Categories</a></li>
    <li class="breadcrumb-item active">Create</li>
</ol>
@endsection

@section('content')
<form action="{{ route('categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    @include('admin.categories._form', [
        'button' => 'Update',    
    ])

</form>

@endsection