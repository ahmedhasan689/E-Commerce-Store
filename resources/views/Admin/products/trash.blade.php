@extends('layouts.admin')

@section('title')
<div class="d-flex justify-content-between">
    <h2>Trash Products</h2>
</div>
@endsection

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="">Home</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('products.index') }}">products</a></li>
    <li class="breadcrumb-item active">Trash</li>
</ol>
@endsection



@section('content')

<!-- Blade Component -->
    <x-alert />

<!-- <x-message type="info">
        <x-slot name="title">info</x-slot>
        Welcome To Laravel
    </x-message>
  -->
    <div class="d-flex  m-3">
        <form action="{{ route('products.restore')}}" method="POST" class="mx-1">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-sm btn-warning">Restore All</button>
        </form>
        <form action="{{ route('products.force-delete')}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger">Empty Trash</button>
        </form>
    </div>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Img</th>
                <th>Name</th>
                <th>Category ID</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Status</th>
                <th>Deleted At</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>
                    <img class="rounded-circle" src="{{ asset('uploads/' . $product->image_path) }}" width="50" height="50" alt="">
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category_name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->status }}</td>
                <td>{{ $product->deleted_at }}</td>
                <td>
                    <form action="{{ route('products.restore', $product->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-warning">Restore</button>
                    </form>
                </td>
                <td>
                    <form action="{{ route('products.force-delete', $product->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex">
        {{ $products->links() }}
    </div>
    @endsection