@extends('layouts.app')

@section('title', 'Create Product - Furniture AR Store')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                <li class="breadcrumb-item active">Create Product</li>
            </ol>
        </nav>

        <h1 class="mb-4">Create New Product</h1>

        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="mb-3">
                        <label for="price" class="form-label">Price ($) *</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                               id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control @error('category') is-invalid @enderror" 
                               id="category" name="category" value="{{ old('category') }}" 
                               placeholder="e.g., Chair, Table, Sofa">
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Product Image -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        <small class="form-text text-muted">Supported formats: JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <!-- AR Models Section -->
                    <h5 class="mb-3">📱 AR 3D Models (Optional)</h5>
                    <p class="text-muted">Upload 3D models to enable AR visualization</p>

                    <!-- GLB Model -->
                    <div class="mb-3">
                        <label for="glb_model" class="form-label">GLB Model (Web/Android)</label>
                        <input type="file" class="form-control @error('glb_model') is-invalid @enderror" 
                               id="glb_model" name="glb_model" accept=".glb">
                        <small class="form-text text-muted">For Android devices and web browsers (Max: 10MB)</small>
                        @error('glb_model')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- USDZ Model -->
                    <div class="mb-3">
                        <label for="usdz_model" class="form-label">USDZ Model (iOS)</label>
                        <input type="file" class="form-control @error('usdz_model') is-invalid @enderror" 
                               id="usdz_model" name="usdz_model" accept=".usdz">
                        <small class="form-text text-muted">For iOS devices using AR Quick Look (Max: 10MB)</small>
                        @error('usdz_model')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <strong>💡 Tip:</strong> Upload both GLB and USDZ files to support AR on all devices. 
                        GLB is used for Android and web browsers, while USDZ is required for iOS devices.
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Create Product</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
