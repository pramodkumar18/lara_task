@extends('layout')

@section('title', 'Edit Product')

@section('content')
    <h1>Edit Product: {{ $product->name }}</h1>

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Product Name:</label>
            <input type="text" name="name" value="{{ $product->name }}" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea name="description">{{ $product->description }}</textarea>
        </div>
        <div>
            <label for="price">Price:</label>
            <input type="number" name="price" value="{{ $product->price }}" required>
        </div>
        <div>
            <label for="category_id">Category:</label>
            <select name="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <h3>Attributes</h3>
        @foreach ($attributes as $attribute)
            <div>
                <label>{{ $attribute->name }}</label>
                @switch($attribute->type)
                    @case('text')
                        <input type="text" name="attributes[{{ $attribute->id }}]"
                            value="{{ optional($product->attributes->find($attribute->id))->pivot->value ?? '' }}">
                    @break

                    @case('select')
                        <select name="attributes[{{ $attribute->id }}]">
                            <option value="">Select...</option>
                            <option value="option1"
                                {{ optional($product->attributes->find($attribute->id))->pivot->value == 'option1' ? 'selected' : '' }}>
                                Option 1</option>
                            <option value="option2"
                                {{ optional($product->attributes->find($attribute->id))->pivot->value == 'option2' ? 'selected' : '' }}>
                                Option 2</option>
                        </select>
                    @break

                    @case('multiselect')
                        <select name="attributes[{{ $attribute->id }}][]" multiple>
                            <option value="option1"
                                {{ optional($product->attributes->find($attribute->id))->pivot->value && in_array('option1', explode(',', optional($product->attributes->find($attribute->id))->pivot->value)) ? 'selected' : '' }}>
                                Option 1</option>
                            <option value="option2"
                                {{ optional($product->attributes->find($attribute->id))->pivot->value && in_array('option2', explode(',', optional($product->attributes->find($attribute->id))->pivot->value)) ? 'selected' : '' }}>
                                Option 2</option>
                        </select>
                    @break

                    @case('date')
                        <input type="date" name="attributes[{{ $attribute->id }}]"
                            value="{{ optional($product->attributes->find($attribute->id))->pivot->value ?? '' }}">
                    @break

                    @case('boolean')
                        <input type="checkbox" name="attributes[{{ $attribute->id }}]" value="1"
                            {{ optional($product->attributes->find($attribute->id))->pivot->value == 1 ? 'checked' : '' }}>
                    @break
                @endswitch
            </div>
        @endforeach

        <button type="submit">Update Product</button>
    </form>
@endsection
