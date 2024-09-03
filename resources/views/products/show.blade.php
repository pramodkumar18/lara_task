@extends('layout')

@section('title', 'Product Details')

@section('content')
    <h2>{{ $product->name }}</h2>
    <p><strong>Category:</strong> {{ $product->category->name ?? 'No Category' }}</p>
    <p><strong>Price:</strong> {{ $product->price }}</p>
    <p><strong>Description:</strong> {{ $product->description }}</p>

    <h4>Attributes</h4>

    @foreach ($product->attributes as $attribute)
        <p><strong>{{ $attribute->name }}:</strong> {{ $attribute->pivot->value }}</p>
    @endforeach


    <a href="{{ route('products.index') }}" class="btn btn-primary">Back to Products</a>
@endsection
