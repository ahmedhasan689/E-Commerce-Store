@extends('layouts.admin')

@section('title')
        <div class="d-flex justify-content-between">
            <h2>Products List</h2>
            <div class="">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('products.create') }}">Create product</a>
                <a class="btn btn-sm btn-outline-warning" href="{{ route('products.trash') }}">Trash product</a>
            </div>
        </div>
@endsection

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Home</a></li>
    <li class="breadcrumb-item active">Products</li>
</ol>
@endsection



@section('content')

    <!-- Blade Component -->
    <x-alert  />

    <!-- <x-message type="info">
        <x-slot name="title">info</x-slot>
        Welcome To Laravel
    </x-message>
  -->
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Img</th>
                <th>Name</th>
                <th>Category ID</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>
                    <img src="{{ $product->image }}" width="50" height="50" alt="">
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category_name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->status }}</td>
                <td>{{ $product->created_at }}</td>
                <td>
                    <a href="{{ route('products.edit', ['id' => $product->id]) }}">
                        <button type="submit" class="btn btn-sm btn-success">Edit</button>
                    </a>                    
                </td>
                <td>
                    <form action="{{ route('products.destroy', $product->id)}}" method="POST">
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
