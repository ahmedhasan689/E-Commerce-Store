@extends('layouts.admin')

@section('title', 'Edit New product')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('products.index') }}">products</a></li>
    <li class="breadcrumb-item active">Create</li>
</ol>
@endsection

@section('content')
<form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    @include('admin.products._form', [
        'button' => 'Update',    
    ])

</form>

@endsection