@extends('layout')

@section('title', 'Create Product')

@section('content')
    <h1>Create New Product</h1>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div>
            <label for="name">Product Name:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea name="description"></textarea>
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" name="price" required>
        </div>
        <div>
            <label for="category_id">Category:</label>
            <select name="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <h3>Attributes</h3>
        @foreach ($attributes as $attribute)
            <div>
                <label>{{ $attribute->name }}</label>
                @switch($attribute->type)
                    @case('text')
                        <input type="text" name="attributes[{{ $attribute->id }}]">
                    @break

                    @case('select')
                        <select name="attributes[{{ $attribute->id }}]">
                            <option value="">Select...</option>
                            <option value="option1">Option 1</option>
                            <option value="option2">Option 2</option>
                        </select>
                    @break

                    @case('multiselect')
                        <select name="attributes[{{ $attribute->id }}][]" multiple>
                            <option value="option1">Option 1</option>
                            <option value="option2">Option 2</option>
                        </select>
                    @break

                    @case('date')
                        <input type="date" name="attributes[{{ $attribute->id }}]">
                    @break

                    @case('boolean')
                        <input type="checkbox" name="attributes[{{ $attribute->id }}]" value="1">
                    @break
                @endswitch
            </div>
        @endforeach

        <button type="submit">Create Product</button>
    </form>
@endsection
