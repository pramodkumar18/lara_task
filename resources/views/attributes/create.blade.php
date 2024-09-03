@extends('layout')

@section('title', 'Create Attribute')

@section('content')
    <h1>Create Attribute</h1>

    <form action="{{ route('attributes.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Attribute Name:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label for="type">Attribute Type:</label>
            <select name="type" required>
                <option value="text">Text</option>
                <option value="select">Select</option>
                <option value="multiselect">Multi-Select</option>
                <option value="date">Date</option>
                <option value="boolean">Boolean</option>
            </select>
        </div>
        <button type="submit">Create Attribute</button>
    </form>
@endsection
