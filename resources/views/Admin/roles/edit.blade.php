@extends('layouts.admin')

@section('title', 'Edit New role')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('roles.index') }}">roles</a></li>
    <li class="breadcrumb-item active">Create</li>
</ol>
@endsection

@section('content')
<form action="{{ route('roles.update', ['role' => $role->id]) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    @include('admin.roles._form', [
        'button' => 'Update',    
    ])

</form>

@endsection