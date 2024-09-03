@extends('layout')

@section('title', 'Attributes')

@section('content')
    <h1>Attributes List</h1>

    <a href="{{ route('attributes.create') }}" class="btn btn-primary">Add New Attribute</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attributes as $attribute)
                <tr>
                    <td>{{ $attribute->id }}</td>
                    <td>{{ $attribute->name }}</td>
                    <td>{{ $attribute->type }}</td>
                    <td>
                        <a href="{{ route('attributes.edit', $attribute->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('attributes.destroy', $attribute->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
