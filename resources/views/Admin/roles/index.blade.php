@extends('layouts.admin')

@section('title')
        <div class="d-flex justify-content-between">
            <h2>roles List</h2>
            <div class="">
                <a class="btn btn-sm btn-outline-primary" href="{{ route('roles.create') }}">Create role</a>
                
            </div>
        </div>
@endsection

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Home</a></li>
    <li class="breadcrumb-item active">roles</li>
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

                <th>Name</th>
                <th>Created At</th>                
                <th>Options</th>                
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td>{{ $role->created_at }}</td>

                <td class="d-flex">
                    <a href="{{ route('roles.edit', ['role' => $role->id]) }}" class="mr-2">
                        <button type="submit" class="btn btn-sm btn-success">Edit</button>
                    </a> 
                                      
                    <form action="{{ route('roles.destroy', $role->id)}}" method="POST">
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
        {{ $roles->links() }}
    </div>
@endsection
