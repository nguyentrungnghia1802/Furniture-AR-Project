@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Products') }}
    </h2>
@endsection

@section('content')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Display form validation errors --}}
                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Display error message stored in session --}}
                    @if (session('error'))
                        <div class="mb-4 text-red-600">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Display success message stored in session --}}
                    @if (session('success'))
                        <div class="mb-4 text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Form to create a new product --}}
                    <form id="productForm" class="mb-20 max-w-md mx-auto bg-white p-6 rounded-lg shadow-md space-y-4"
                        action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">

                        {{-- CSRF token to prevent cross-site request forgery --}}
                        @csrf

                        {{-- Form title --}}
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('admin.add_new_product') }}</h2>

                        {{-- Product name input --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.product_name') }}</label>
                            <input type="text" name="name" id="name" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none"
                                value="{{ old('name') }}">

                            {{-- Shown only when product name is duplicated (client-side) --}}
                            <p id="errorMsg" class="hidden text-red-500 text-sm mt-1">{{ __('admin.product_already_exists') }}</p>
                        </div>

                        {{-- Product description input --}}
                        <div>
                            <label for="descriptions" class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.product_description') }}</label>
                            <input type="text" name="descriptions" id="descriptions"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
                        </div>

                        {{-- Product price input --}}
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.price') }}</label>
                            <div class="flex items-center">
                                <input type="number" name="price" id="price" min="0" step="0.01"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
                                <span class="ml-2">USD</span>
                            </div>
                        </div>

                        {{-- Stock quantity input --}}
                        <div>
                            <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.stock_quantity') }}</label>
                            <input type="number" name="stock_quantity" id="stock_quantity" required min="0"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
                        </div>

                        {{-- Discount Percent --}}
                        <div>
                            <label for="discount_percent" class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.discount_percent') }} (%)</label>
                            <input type="number" name="discount_percent" id="discount_percent" min="0" max="100" step="0.01" value="0"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
                        </div>

                        {{-- Product category selection --}}
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.product_category') }}</label>
                            <select name="category_id" id="category_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
                                <option value="">-- {{ __('admin.select_category') }} --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Product image input --}}
                        <div>
                            <label for="image_url" class="block text-sm font-medium text-gray-700 mb-1">{{ __('admin.product_image') }}</label>
                            <input type="file" name="image_url" id="image_url" accept="image/*"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
                        </div>

                        {{-- Preview selected image --}}
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">{{ __('admin.current_image') }}</p>
                            <img id="create-image" src="{{ asset('images/base.jpg') }}" alt="Product Image" width="150"
                                class="mt-1 rounded border">
                        </div>

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
                                    <input type="checkbox" name="ar_enabled" id="ar_enabled" value="1" 
                                        class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                                    <span class="text-sm font-medium text-gray-700">Enable AR for this product</span>
                                </label>
                            </div>

                            {{-- AR Model Files Section (hidden by default) --}}
                            <div id="ar-models-section" class="space-y-4 hidden">
                                {{-- GLB Model (Android/WebXR) --}}
                                <div>
                                    <label for="ar_model_glb" class="block text-sm font-medium text-gray-700 mb-1">
                                        AR Model (GLB) - Android/WebXR
                                        <span class="text-gray-500 text-xs">(.glb format, max 50MB)</span>
                                    </label>
                                    <input type="file" name="ar_model_glb" id="ar_model_glb" accept=".glb"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-purple-200 focus:outline-none">
                                </div>

                                {{-- USDZ Model (iOS) --}}
                                <div>
                                    <label for="ar_model_usdz" class="block text-sm font-medium text-gray-700 mb-1">
                                        AR Model (USDZ) - iOS QuickLook
                                        <span class="text-gray-500 text-xs">(.usdz format, max 50MB)</span>
                                    </label>
                                    <input type="file" name="ar_model_usdz" id="ar_model_usdz" accept=".usdz"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-purple-200 focus:outline-none">
                                </div>

                                {{-- Physical Dimensions --}}
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label for="width_cm" class="block text-sm font-medium text-gray-700 mb-1">Width (cm)</label>
                                        <input type="number" name="width_cm" id="width_cm" min="0" step="0.1"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-purple-200 focus:outline-none">
                                    </div>
                                    <div>
                                        <label for="height_cm" class="block text-sm font-medium text-gray-700 mb-1">Height (cm)</label>
                                        <input type="number" name="height_cm" id="height_cm" min="0" step="0.1"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-purple-200 focus:outline-none">
                                    </div>
                                    <div>
                                        <label for="depth_cm" class="block text-sm font-medium text-gray-700 mb-1">Depth (cm)</label>
                                        <input type="number" name="depth_cm" id="depth_cm" min="0" step="0.1"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-purple-200 focus:outline-none">
                                    </div>
                                </div>

                                {{-- AR Placement Instructions --}}
                                <div>
                                    <label for="ar_placement_instructions" class="block text-sm font-medium text-gray-700 mb-1">
                                        AR Placement Instructions
                                        <span class="text-gray-500 text-xs">(Optional tips for users)</span>
                                    </label>
                                    <textarea name="ar_placement_instructions" id="ar_placement_instructions" rows="3"
                                        placeholder="e.g., Best placed on flat surfaces like floors or tables..."
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-purple-200 focus:outline-none"></textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Submit form button --}}
                        <button type="submit"
                            class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-200">
                            {{ __('admin.save') }}
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript to preview image before submitting and handle AR toggles --}}
    <script>
        // Image preview functionality
        document.getElementById('image_url').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                document.getElementById('create-image').src = URL.createObjectURL(file);
            }
        });

        // AR section toggle functionality
        document.getElementById('ar_enabled').addEventListener('change', function() {
            const arSection = document.getElementById('ar-models-section');
            if (this.checked) {
                arSection.classList.remove('hidden');
            } else {
                arSection.classList.add('hidden');
                // Clear AR form fields when disabled
                document.getElementById('ar_model_glb').value = '';
                document.getElementById('ar_model_usdz').value = '';
                document.getElementById('width_cm').value = '';
                document.getElementById('height_cm').value = '';
                document.getElementById('depth_cm').value = '';
                document.getElementById('ar_placement_instructions').value = '';
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
        document.getElementById('ar_model_glb').addEventListener('change', function() {
            validateFileSize(this);
        });

        document.getElementById('ar_model_usdz').addEventListener('change', function() {
            validateFileSize(this);
        });
    </script>
@endsection
