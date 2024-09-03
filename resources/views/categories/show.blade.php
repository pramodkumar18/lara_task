@extends('layout')

@section('title', 'Category Details')

@section('content')
    <h2>{{ $category->name }}</h2>
    <a href="{{ route('categories.index') }}" class="btn btn-primary">Back to Categories</a>
@endsection
