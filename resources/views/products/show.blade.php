@extends('layouts.app')

@section('title', $product->name . ' - Furniture AR Store')

@section('styles')
<style>
    model-viewer {
        width: 100%;
        height: 500px;
        background-color: #f0f0f0;
        border-radius: 8px;
    }
    .ar-instructions {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px;
        border-radius: 8px;
        margin-top: 15px;
    }
    .product-image {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <!-- Product Info Column -->
    <div class="col-lg-6">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>

        <h1>{{ $product->name }}</h1>
        
        @if($product->ar_enabled)
            <span class="ar-badge mb-3 d-inline-block">✨ AR Available</span>
        @endif

        @if($product->category)
            <p class="text-muted mb-2"><strong>Category:</strong> {{ $product->category }}</p>
        @endif

        <h2 class="text-success mb-4">${{ number_format($product->price, 2) }}</h2>

        <div class="mb-4">
            <h5>Description</h5>
            <p>{{ $product->description ?? 'No description available.' }}</p>
        </div>

        @if($product->image)
            <div class="mb-4">
                <h5>Product Image</h5>
                <img src="{{ asset('uploads/images/' . $product->image) }}" alt="{{ $product->name }}" class="product-image shadow">
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit Product</a>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Product</button>
            </form>
        </div>
    </div>

    <!-- AR Viewer Column -->
    <div class="col-lg-6">
        @if($product->hasArModels())
            <h4 class="mb-3">3D Model Viewer with AR</h4>
            
            <!-- Model Viewer -->
            <model-viewer
                src="{{ $product->getGlbModelUrl() }}"
                @if($product->getUsdzModelUrl())
                ios-src="{{ $product->getUsdzModelUrl() }}"
                @endif
                alt="{{ $product->name }}"
                ar
                ar-modes="scene-viewer webxr quick-look"
                camera-controls
                auto-rotate
                shadow-intensity="1"
                environment-image="neutral"
                poster="{{ $product->image ? asset('uploads/images/' . $product->image) : '' }}"
            >
                <button slot="ar-button" class="btn btn-primary btn-lg w-100" style="position: absolute; bottom: 16px; left: 16px; right: 16px;">
                    📱 View in Your Space (AR)
                </button>
                
                <div id="ar-prompt" style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); white-space: nowrap; display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </model-viewer>

            <div class="ar-instructions">
                <h5>🎯 How to use AR:</h5>
                <ul class="mb-0">
                    <li><strong>Desktop/Android:</strong> Click "View in Your Space" to launch AR with Scene Viewer</li>
                    <li><strong>iOS (Safari):</strong> Click "View in Your Space" to launch AR Quick Look</li>
                    <li><strong>3D Viewer:</strong> Drag to rotate, scroll to zoom, use two fingers to pan</li>
                </ul>
            </div>

            <div class="alert alert-info mt-3">
                <strong>AR Features:</strong>
                <ul class="mb-0">
                    <li>Place furniture in your real space</li>
                    <li>See actual size and scale</li>
                    <li>Rotate and position the model</li>
                    <li>Take photos to share</li>
                </ul>
            </div>
        @else
            <div class="alert alert-warning">
                <h5>3D AR Models Not Available</h5>
                <p>This product doesn't have 3D models uploaded yet. Upload GLB (for Android/Web) and USDZ (for iOS) files to enable AR visualization.</p>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Upload AR Models</a>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<!-- Google Model Viewer -->
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.3.0/model-viewer.min.js"></script>

<script>
    // Handle AR loading states
    const modelViewer = document.querySelector('model-viewer');
    
    if (modelViewer) {
        modelViewer.addEventListener('load', () => {
            console.log('3D Model loaded successfully');
        });

        modelViewer.addEventListener('error', (event) => {
            console.error('Error loading 3D model:', event);
            alert('Failed to load 3D model. Please check the file format.');
        });

        modelViewer.addEventListener('ar-status', (event) => {
            if (event.detail.status === 'session-started') {
                console.log('AR session started');
            }
        });
    }
</script>
@endsection
