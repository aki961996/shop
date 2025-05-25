@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">Product Listing</h2>
        <a href="{{ route('products.create') }}" class="btn btn-success">+ Add Product</a>
    </div>

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" style="height:200px; object-fit:cover;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="text-muted mb-1">₹{{ number_format($product->price, 2) }}</p>
                    <p class="text-muted mb-1">Shop: {{ $product->shop->name ?? 'N/A' }}</p>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm mt-2">Edit</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection