@extends('layouts.app')

@section('title', 'Edit ' . $product->name . ' - Furniture AR Store')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>

        <h1 class="mb-4">Edit Product</h1>

        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="mb-3">
                        <label for="price" class="form-label">Price ($) *</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                               id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control @error('category') is-invalid @enderror" 
                               id="category" name="category" value="{{ old('category', $product->category) }}" 
                               placeholder="e.g., Chair, Table, Sofa">
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Current Product Image -->
                    @if($product->image)
                        <div class="mb-3">
                            <label class="form-label">Current Product Image</label>
                            <div>
                                <img src="{{ asset('uploads/images/' . $product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     style="max-width: 200px; height: auto; border-radius: 4px;">
                            </div>
                        </div>
                    @endif

                    <!-- Product Image -->
                    <div class="mb-3">
                        <label for="image" class="form-label">{{ $product->image ? 'Replace' : 'Upload' }} Product Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        <small class="form-text text-muted">Supported formats: JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <!-- AR Models Section -->
                    <h5 class="mb-3">📱 AR 3D Models</h5>
                    
                    <!-- Current Models -->
                    @if($product->glb_model || $product->usdz_model)
                        <div class="alert alert-success">
                            <strong>Current AR Models:</strong>
                            <ul class="mb-0 mt-2">
                                @if($product->glb_model)
                                    <li>GLB Model: {{ $product->glb_model }} ✓</li>
                                @endif
                                @if($product->usdz_model)
                                    <li>USDZ Model: {{ $product->usdz_model }} ✓</li>
                                @endif
                            </ul>
                        </div>
                    @endif

                    <!-- GLB Model -->
                    <div class="mb-3">
                        <label for="glb_model" class="form-label">{{ $product->glb_model ? 'Replace' : 'Upload' }} GLB Model (Web/Android)</label>
                        <input type="file" class="form-control @error('glb_model') is-invalid @enderror" 
                               id="glb_model" name="glb_model" accept=".glb">
                        <small class="form-text text-muted">For Android devices and web browsers (Max: 10MB)</small>
                        @error('glb_model')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- USDZ Model -->
                    <div class="mb-3">
                        <label for="usdz_model" class="form-label">{{ $product->usdz_model ? 'Replace' : 'Upload' }} USDZ Model (iOS)</label>
                        <input type="file" class="form-control @error('usdz_model') is-invalid @enderror" 
                               id="usdz_model" name="usdz_model" accept=".usdz">
                        <small class="form-text text-muted">For iOS devices using AR Quick Look (Max: 10MB)</small>
                        @error('usdz_model')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <strong>💡 Tip:</strong> Upload both GLB and USDZ files to support AR on all devices. 
                        Leave fields empty to keep existing models.
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update Product</button>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
