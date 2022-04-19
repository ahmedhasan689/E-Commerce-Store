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

    {{ trans_choice('app.categories_count', $categories->count(), ['number' => $categories->count()]) }}

    <table class="table table-hover">
        <thead>
            <tr>
                <th>NO. Loop</th>
                <th>{{ __('ID') }}</th>
                <th>{{ trans('Name') }}</th>
                <th>{{ Lang::get('Slug') }}</th>
                <th>@lang('Parent ID')</th>
                <th>{{ __('Products Count') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Created At') }}</th>
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
                <td>{{ $category->products_count }}</td>
                <td>{{ $category->status }}</td>
                <td>{{ $category->created_at }}</td>
                <td>
                    <a href="{{ route('categories.edit', ['id' => $category->id]) }}">
                        <button type="submit" class="btn btn-sm btn-success">{{ __('app.Edit')}}</button>
                    </a>
                </td>
                <td>
                    <form action="{{ route('categories.destroy', $category->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">{{ __('app.Delete')}}</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $categories->links() }}
@endsection
