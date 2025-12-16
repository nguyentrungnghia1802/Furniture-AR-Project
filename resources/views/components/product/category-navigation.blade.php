@props(['selectedCategory' => null])

<div class="bg-white rounded-lg shadow-lg p-6 mb-8">
    <h3 class="text-xl font-semibold text-gray-800 mb-4 text-center">{{ __('product.choose_product_category') }}</h3>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <!-- All Products -->
        <a href="{{ route('product.index') }}" 
           class="category-item group relative overflow-hidden rounded-lg border-2 transition-all duration-300 hover:shadow-lg {{ !$selectedCategory ? 'border-gray-500 bg-gray-50' : 'border-gray-200 hover:border-gray-300' }}">
            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-3 rounded-full flex items-center justify-center {{ !$selectedCategory ? 'bg-gray-500' : 'bg-gray-100 group-hover:bg-gray-100' }}">
                    <svg class="w-8 h-8 {{ !$selectedCategory ? 'text-white' : 'text-gray-600 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-4H9m4 8H7m6 4v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h6a2 2 0 002-2z"></path>
                    </svg>
                </div>
                <h4 class="font-semibold {{ !$selectedCategory ? 'text-gray-700' : 'text-gray-700 group-hover:text-gray-600' }}">
                    {{ __('product.all_products') }}
                </h4>
                <p class="text-sm text-gray-500 mt-1">{{ __('product.view_all') }}</p>
            </div>
        </a>

        <!-- Seating -->
        <a href="{{ route('product.index', ['category_name' => 'soap-flower']) }}" 
           class="category-item group relative overflow-hidden rounded-lg border-2 transition-all duration-300 hover:shadow-lg {{ $selectedCategory === 'soap-flower' ? 'border-gray-500 bg-gray-50' : 'border-gray-200 hover:border-gray-300' }}">
            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-3 rounded-full flex items-center justify-center {{ $selectedCategory === 'soap-flower' ? 'bg-gray-500' : 'bg-gray-100 group-hover:bg-gray-100' }}">
                    <svg class="w-8 h-8 {{ $selectedCategory === 'soap-flower' ? 'text-white' : 'text-gray-600 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <h4 class="font-semibold {{ $selectedCategory === 'soap-flower' ? 'text-gray-700' : 'text-gray-700 group-hover:text-gray-600' }}">
                    Seatingjhgjhkgyjkhg
                </h4>
                <p class="text-sm text-gray-500 mt-1">{{ __('product.soap_flowers') }}</p>
            </div>
        </a>

        <!-- Storage -->
        <a href="{{ route('product.index', ['category_name' => 'special-flower']) }}" 
           class="category-item group relative overflow-hidden rounded-lg border-2 transition-all duration-300 hover:shadow-lg {{ $selectedCategory === 'special-flower' ? 'border-gray-500 bg-gray-50' : 'border-gray-200 hover:border-gray-300' }}">
            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-3 rounded-full flex items-center justify-center {{ $selectedCategory === 'special-flower' ? 'bg-gray-500' : 'bg-gray-100 group-hover:bg-gray-100' }}">
                    <svg class="w-8 h-8 {{ $selectedCategory === 'special-flower' ? 'text-white' : 'text-gray-600 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h4 class="font-semibold {{ $selectedCategory === 'special-flower' ? 'text-gray-700' : 'text-gray-700 group-hover:text-gray-600' }}">
                    Storage
                </h4>
                <p class="text-sm text-gray-500 mt-1">{{ __('product.special_flowers') }}</p>
            </div>
        </a>

        <!-- Tables -->
        <a href="{{ route('product.index', ['category_name' => 'fresh-flowers']) }}" 
           class="category-item group relative overflow-hidden rounded-lg border-2 transition-all duration-300 hover:shadow-lg {{ $selectedCategory === 'fresh-flowers' ? 'border-gray-500 bg-gray-50' : 'border-gray-200 hover:border-gray-300' }}">
            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-3 rounded-full flex items-center justify-center {{ $selectedCategory === 'fresh-flowers' ? 'bg-gray-500' : 'bg-gray-100 group-hover:bg-gray-100' }}">
                    <svg class="w-8 h-8 {{ $selectedCategory === 'fresh-flowers' ? 'text-white' : 'text-gray-600 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </div>
                <h4 class="font-semibold {{ $selectedCategory === 'fresh-flowers' ? 'text-gray-700' : 'text-gray-700 group-hover:text-gray-600' }}">
                    Tables
                </h4>
                <p class="text-sm text-gray-500 mt-1">{{ __('product.fresh_flowers') }}</p>
            </div>
        </a>

        <!-- Decor (span 2 columns on mobile, span 4 on larger screens to center it) -->
        <a href="{{ route('product.index', ['category_name' => 'souvenir']) }}" 
           class="category-item group relative overflow-hidden rounded-lg border-2 transition-all duration-300 hover:shadow-lg col-span-2 md:col-span-4 max-w-xs mx-auto {{ $selectedCategory === 'souvenir' ? 'border-gray-500 bg-gray-50' : 'border-gray-200 hover:border-gray-300' }}">
            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-3 rounded-full flex items-center justify-center {{ $selectedCategory === 'souvenir' ? 'bg-gray-500' : 'bg-gray-100 group-hover:bg-gray-100' }}">
                    <svg class="w-8 h-8 {{ $selectedCategory === 'souvenir' ? 'text-white' : 'text-gray-600 group-hover:text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                    </svg>
                </div>
                <h4 class="font-semibold {{ $selectedCategory === 'souvenir' ? 'text-gray-700' : 'text-gray-700 group-hover:text-gray-600' }}">
                    Decor
                </h4>
                <p class="text-sm text-gray-500 mt-1">{{ __('product.souvenirs') }}</p>
            </div>
        </a>
    </div>
</div>
