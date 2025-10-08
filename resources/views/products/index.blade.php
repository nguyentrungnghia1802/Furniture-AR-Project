@extends('layouts.app')

@section('title', 'Products - Furniture AR Store')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h1>Furniture Products</h1>
        <p class="text-muted">Browse our collection of furniture with AR visualization</p>
    </div>
    <div class="col-auto">
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Product
        </a>
    </div>
</div>

@if($products->isEmpty())
    <div class="alert alert-info">
        <h4>No products yet!</h4>
        <p>Start by <a href="{{ route('products.create') }}">creating your first product</a>.</p>
    </div>
@else
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach($products as $product)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    @if($product->image)
                        <img src="{{ asset('uploads/images/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <span class="text-muted">No Image</span>
                        </div>
                    @endif
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        
                        @if($product->ar_enabled)
                            <span class="ar-badge mb-2 d-inline-block">AR Available</span>
                        @endif
                        
                        <p class="card-text text-muted small">{{ Str::limit($product->description, 100) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="h5 mb-0 text-success">${{ number_format($product->price, 2) }}</span>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $products->links() }}
    </div>
@endif
@endsection
