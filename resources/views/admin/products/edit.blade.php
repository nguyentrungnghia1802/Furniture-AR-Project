@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Product') }} {{-- Page header --}}
    </h2>
@endsection

@section('content')

{{-- Product Edit Form --}}
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl max-h-[90vh] overflow-y-auto">
        <form id="productForm-edit"
              class="p-6 space-y-4"
              action="{{ route('admin.product.update', $product->id) }}"
              method="POST"
              enctype="multipart/form-data">

    @csrf {{-- CSRF protection --}}
    @method('PUT') {{-- Use PUT method for resource update --}}

    {{-- Product Name --}}
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.product_name') }}</label>
        <input type="text" name="name" id="name-edit" value="{{ old('name', $product->name) }}" required
               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
    </div>

    {{-- Product Description --}}
    <div>
        <label for="descriptions" class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.description') }}</label>
        <textarea name="descriptions" id="descriptions-edit" cols="30" rows="4"
                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none">{{ old('descriptions', $product->descriptions) }}</textarea>
    </div>

    {{-- Product Price --}}
    <div>
        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.price') }}</label>
        <div class="flex items-center">
            <input type="number" name="price" id="price-edit" value="{{ old('price', $product->price) }}" required min="0" step="0.01"
               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
            <span class="ml-2">USD</span>
        </div>
    </div>

    {{-- Stock Quantity --}}
    <div>
        <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.stock_quantity') }}</label>
        <input type="number" name="stock_quantity" id="stock_quantity-edit" value="{{ old('stock_quantity', $product->stock_quantity) }}" required min="0"
               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
    </div>

    {{-- Discount Percent --}}
    <div>
        <label for="discount_percent" class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.discount_percent') }} (%)</label>
        <input type="number" name="discount_percent" id="discount_percent-edit" value="{{ old('discount_percent', $product->discount_percent) }}" min="0" max="100" step="0.01"
               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
    </div>

    {{-- Product Category Selection --}}
    <div>
        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.product_category') }}</label>
        <select name="category_id" id="category_id-edit" required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
            <option value="">-- {{ __('admin.select_category') }} --</option>
            @foreach ($categories as $category)
                {{-- Preserve selected category after form submission --}}
                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Product Image Upload --}}
    <div>
        <label for="image_url" class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.product_image') }}</label>
        <input type="file" name="image_url" id="imageInput" accept="image/*"
               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
    </div>

    {{-- Display current image (if exists) --}}
    @if($product->image_url)
        <p class="text-sm text-gray-600">{{ __('admin.current_image') }}</p>
        <img id="previewImage" src="{{ asset('images/products/' . $product->image_url) }}" alt="Product Image" width="150"
             class="mt-1 rounded border">
    @endif

    {{-- AR Section --}}
    <div class="border-t pt-4 mt-6">
        <h3 class="text-lg font-medium text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9 3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
            </svg>
            Augmented Reality Settings
        </h3>

        {{-- AR Enable Checkbox --}}
        <div class="mb-4">
            <label class="flex items-center space-x-2">
                <input type="checkbox" name="ar_enabled" id="ar_enabled-edit" value="1" 
                    {{ old('ar_enabled', $product->ar_enabled ?? false) ? 'checked' : '' }}
                    class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                <span class="text-sm font-medium text-gray-700">Enable AR for this product</span>
            </label>
        </div>

        {{-- AR Model Files Section --}}
        <div id="ar-models-section-edit" class="space-y-4 {{ old('ar_enabled', $product->ar_enabled ?? false) ? '' : 'hidden' }}">
            {{-- Current AR Models Display --}}
            @if($product->ar_model_glb || $product->ar_model_usdz)
                <div class="bg-gray-50 p-3 rounded-md">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Current AR Models:</h4>
                    @if($product->ar_model_glb)
                        <p class="text-sm text-green-600">✓ GLB Model: {{ basename($product->ar_model_glb) }}</p>
                    @endif
                    @if($product->ar_model_usdz)
                        <p class="text-sm text-green-600">✓ USDZ Model: {{ basename($product->ar_model_usdz) }}</p>
                    @endif
                </div>
            @endif

            {{-- GLB Model (Android/WebXR) --}}
            <div>
                <label for="ar_model_glb" class="block text-sm font-medium text-gray-700 mb-1">
                    AR Model (GLB) - Android/WebXR
                    <span class="text-gray-500 text-xs">(.glb format, max 50MB)</span>
                </label>
                <input type="file" name="ar_model_glb" id="ar_model_glb-edit" accept=".glb"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-purple-200 focus:outline-none">
                <p class="text-xs text-gray-500 mt-1">Leave empty to keep current model</p>
            </div>

            {{-- USDZ Model (iOS) --}}
            <div>
                <label for="ar_model_usdz" class="block text-sm font-medium text-gray-700 mb-1">
                    AR Model (USDZ) - iOS QuickLook
                    <span class="text-gray-500 text-xs">(.usdz format, max 50MB)</span>
                </label>
                <input type="file" name="ar_model_usdz" id="ar_model_usdz-edit" accept=".usdz"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-purple-200 focus:outline-none">
                <p class="text-xs text-gray-500 mt-1">Leave empty to keep current model</p>
            </div>

            {{-- Physical Dimensions --}}
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="width_cm" class="block text-sm font-medium text-gray-700 mb-1">Width (cm)</label>
                    <input type="number" name="width_cm" id="width_cm-edit" min="0" step="0.1"
                        value="{{ old('width_cm', $product->width_cm ?? '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-purple-200 focus:outline-none">
                </div>
                <div>
                    <label for="height_cm" class="block text-sm font-medium text-gray-700 mb-1">Height (cm)</label>
                    <input type="number" name="height_cm" id="height_cm-edit" min="0" step="0.1"
                        value="{{ old('height_cm', $product->height_cm ?? '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-purple-200 focus:outline-none">
                </div>
                <div>
                    <label for="depth_cm" class="block text-sm font-medium text-gray-700 mb-1">Depth (cm)</label>
                    <input type="number" name="depth_cm" id="depth_cm-edit" min="0" step="0.1"
                        value="{{ old('depth_cm', $product->depth_cm ?? '') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-purple-200 focus:outline-none">
                </div>
            </div>

            {{-- AR Placement Instructions --}}
            <div>
                <label for="ar_placement_instructions" class="block text-sm font-medium text-gray-700 mb-1">
                    AR Placement Instructions
                    <span class="text-gray-500 text-xs">(Optional tips for users)</span>
                </label>
                <textarea name="ar_placement_instructions" id="ar_placement_instructions-edit" rows="3"
                    placeholder="e.g., Best placed on flat surfaces like floors or tables..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-purple-200 focus:outline-none">{{ old('ar_placement_instructions', $product->ar_placement_instructions ?? '') }}</textarea>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex justify-end gap-2">
        {{-- Cancel button: Go back to product listing --}}
        <a href="{{ route('admin.product') }}"
           class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
            {{ __('admin.cancel') }}
        </a>
        {{-- Submit button: Save changes --}}
        <button type="submit"
                class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">
            {{ __('admin.save') }}
        </button>
    </div>
        </form>
    </div>
</div>

@endsection

{{-- Preview uploaded image before submitting and handle AR toggles --}}
<script>
    // Image preview functionality
    document.getElementById('imageInput')?.addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            document.getElementById('previewImage').src = URL.createObjectURL(file);
        }
    });

    // AR section toggle functionality
    document.getElementById('ar_enabled-edit')?.addEventListener('change', function() {
        const arSection = document.getElementById('ar-models-section-edit');
        if (this.checked) {
            arSection.classList.remove('hidden');
        } else {
            arSection.classList.add('hidden');
        }
    });

    // File size validation for AR models
    function validateFileSize(input, maxSizeMB = 50) {
        if (input.files.length > 0) {
            const file = input.files[0];
            const maxSizeBytes = maxSizeMB * 1024 * 1024;
            
            if (file.size > maxSizeBytes) {
                alert(`File size must be less than ${maxSizeMB}MB. Selected file is ${(file.size / 1024 / 1024).toFixed(2)}MB.`);
                input.value = '';
                return false;
            }
        }
        return true;
    }

    // Add file size validation to AR model inputs
    document.getElementById('ar_model_glb-edit')?.addEventListener('change', function() {
        validateFileSize(this);
    });

    document.getElementById('ar_model_usdz-edit')?.addEventListener('change', function() {
        validateFileSize(this);
    });
</script>
