@extends('layouts.admin')

@section('title')
        {{ $title }}
        <a href="{{ route('categories.create') }}">Create Category</a>
@endsection

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="">Home</a></li>
    <li class="breadcrumb-item active">Categories</li>
</ol>
@endsection



@section('content')

    @if ($success)
    <div class="alert alert-danger">
        {{ $success }}
    </div>
    @endif
 
    <table class="table table-hover">
        <thead>
            <tr>
                <th>NO. Loop</th>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Parent ID</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $loop->first? 'First' : ($loop->last? 'Last' : $loop->iteration) }}</td>
                <td>{{ $category->id }}</td>
                <td>{{ $category->original_name }}</td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->parent_name }}</td>
                <td>{{ $category->status }}</td>
                <td>{{ $category->created_at }}</td>
                <td>
                    <a href="{{ route('categories.edit', ['id' => $category->id]) }}">
                        <button type="submit" class="btn btn-sm btn-success">Edit</button>
                    </a>                    
                </td>
                <td>
                    <form action="{{ route('categories.destroy', $category->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection