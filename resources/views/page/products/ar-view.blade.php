{{-- resources/views/page/products/ar-view.blade.php --}}
<x-app-layout>
    @section('head')
        <!-- Model Viewer for AR functionality -->
        <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
        <script nomodule src="https://unpkg.com/@google/model-viewer/dist/model-viewer-legacy.js"></script>
        
        <!-- AR Viewer Scripts -->
        <script src="{{ asset('js/ar-viewer.js') }}" defer></script>
        
        <!-- Debug Script for AR Model Loading -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modelViewer = document.querySelector('model-viewer');
                
                if (modelViewer) {
                    console.log('Model Viewer found');
                    console.log('Model URL:', modelViewer.getAttribute('src'));
                    console.log('iOS Source:', modelViewer.getAttribute('ios-src'));
                    
                    modelViewer.addEventListener('load', () => {
                        console.log('✅ Model loaded successfully');
                        document.getElementById('loading-indicator')?.style.display = 'none';
                    });
                    
                    modelViewer.addEventListener('error', (event) => {
                        console.error('❌ Model failed to load:', event.detail);
                        document.getElementById('loading-indicator')?.innerHTML = 
                            '<div class="text-red-500">❌ Failed to load model</div>';
                    });
                    
                    modelViewer.addEventListener('progress', (event) => {
                        const progress = event.detail.totalProgress;
                        console.log('Loading progress:', Math.round(progress * 100) + '%');
                    });
                    
                    // Test if model file exists
                    const modelUrl = modelViewer.getAttribute('src');
                    if (modelUrl) {
                        fetch(modelUrl, { method: 'HEAD' })
                            .then(response => {
                                if (response.ok) {
                                    console.log('✅ Model file exists and accessible');
                                } else {
                                    console.error('❌ Model file not accessible:', response.status);
                                }
                            })
                            .catch(error => {
                                console.error('❌ Error checking model file:', error);
                            });
                    }
                } else {
                    console.error('❌ Model Viewer not found');
                }
            });
        </script>
        
        <!-- Meta tags for AR -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        
        <style>
            model-viewer {
                width: 100%;
                height: 500px;
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                border-radius: 12px;
                box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            }
            
            .ar-controls {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                border-radius: 12px;
                padding: 1rem;
                box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            }
            
            .ar-button {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border: none;
                padding: 12px 24px;
                border-radius: 8px;
                font-weight: 600;
                transition: all 0.3s ease;
                box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
            }
            
            .ar-button:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            }
            
            .ar-button:disabled {
                background: #ccc;
                box-shadow: none;
                transform: none;
            }
            
            .dimension-badge {
                background: rgba(102, 126, 234, 0.1);
                color: #667eea;
                padding: 6px 12px;
                border-radius: 20px;
                font-size: 0.875rem;
                font-weight: 500;
            }
            
            .loading-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(255, 255, 255, 0.9);
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
                z-index: 10;
            }
            
            .progress-bar {
                width: 200px;
                height: 4px;
                background: #e0e0e0;
                border-radius: 2px;
                overflow: hidden;
            }
            
            .progress-fill {
                height: 100%;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                width: 0%;
                transition: width 0.3s ease;
            }
            
            .ar-instructions {
                background: #f8f9fa;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                padding: 1rem;
                margin: 1rem 0;
            }
            
            .related-product-card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                border-radius: 12px;
                overflow: hidden;
            }
            
            .related-product-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            }
        </style>
    @endsection

    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600">Home</a></li>
                <li class="flex items-center"><span class="mx-2">/</span></li>
                <li><a href="{{ route('user.products.index') }}" class="hover:text-blue-600">Products</a></li>
                <li class="flex items-center"><span class="mx-2">/</span></li>
                @if($product->category)
                <li><a href="{{ route('user.products.index', ['category' => $product->category->id]) }}" class="hover:text-blue-600">{{ $product->category->name }}</a></li>
                <li class="flex items-center"><span class="mx-2">/</span></li>
                @endif
                <li class="text-gray-900 font-medium">{{ $product->name }} (AR View)</li>
            </ol>
        </nav>

        <div class="grid lg:grid-cols-2 gap-12">
            <!-- AR Model Viewer Section -->
            <div class="space-y-6">
                <div class="relative">
                    <!-- Loading Overlay -->
                    <div id="model-loading" class="loading-overlay">
                        <div class="text-center">
                            <div class="mb-4">
                                <svg class="animate-spin h-8 w-8 mx-auto text-blue-600" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600 mb-2">Loading 3D Model...</p>
                            <div class="progress-bar">
                                <div id="loading-progress" class="progress-fill"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Error Display -->
                    <div id="model-error" class="loading-overlay" style="display: none;">
                        <div class="text-center text-red-600">
                            <svg class="h-12 w-12 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 19.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                            <p id="error-message">Failed to load 3D model</p>
                        </div>
                    </div>

                    <!-- 3D Model Viewer -->
                    <model-viewer
                        id="ar-model-viewer"
                        src="{{ $arModels['glb'] }}"
                        @if($arModels['usdz'])
                        ios-src="{{ $arModels['usdz'] }}"
                        @endif
                        alt="{{ $product->name }} 3D Model"
                        ar
                        ar-modes="webxr scene-viewer quick-look"
                        camera-controls
                        touch-action="pan-y"
                        auto-rotate
                        data-product-id="{{ $product->id }}"
                        data-product-name="{{ $product->name }}"
                        @if($dimensions)
                        ar-scale="{{ $dimensions['scale'] ?? 'auto' }}"
                        @endif
                    >
                        <!-- Loading Indicator -->
                        <div id="loading-indicator" slot="poster" class="flex items-center justify-center h-full">
                            <div class="text-center">
                                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                                <p class="text-gray-600">Loading 3D Model...</p>
                                <p class="text-sm text-gray-500 mt-2">Model URL: {{ basename($arModels['glb']) }}</p>
                            </div>
                        </div>
                        
                        <!-- AR Instructions -->
                        <div slot="ar-button" style="display: none;"></div>
                    </model-viewer>
                </div>

                <!-- AR Controls -->
                <div class="ar-controls">
                    <div class="flex flex-wrap gap-3 items-center justify-between">
                        <div class="flex gap-3">
                            <button id="ar-button" class="ar-button">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9 3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                    </svg>
                                    View in AR
                                </span>
                            </button>
                            
                            <button id="reset-camera" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>

                            <button id="screenshot-button" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>

                        <div id="ar-status" class="text-sm text-gray-600 font-medium">
                            Loading AR...
                        </div>
                    </div>

                    @if($dimensions)
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="dimension-badge">W: {{ $dimensions['width'] }}cm</span>
                        <span class="dimension-badge">H: {{ $dimensions['height'] }}cm</span>
                        <span class="dimension-badge">D: {{ $dimensions['depth'] }}cm</span>
                    </div>
                    @endif
                </div>

                <!-- AR Instructions -->
                <div class="ar-instructions">
                    <h3 class="font-semibold mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        How to use AR
                    </h3>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• <strong>Mobile required:</strong> AR works best on smartphones and tablets</li>
                        <li>• <strong>iOS users:</strong> Tap "View in AR" to open QuickLook</li>
                        <li>• <strong>Android users:</strong> Ensure ARCore is installed for best experience</li>
                        <li>• <strong>Placement:</strong> Point your camera at a flat surface to place the furniture</li>
                        <li>• <strong>Scale:</strong> Walk around to see the furniture from different angles</li>
                    </ul>
                </div>
            </div>

            <!-- Product Information Section -->
            <div class="space-y-8">
                <!-- Product Header -->
                <div>
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                            <p class="text-gray-600">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-blue-600">${{ number_format($product->price, 2) }}</div>
                            @if($product->discount_percent && $product->discount_percent > 0)
                                <div class="text-sm text-gray-500 line-through">${{ number_format($product->price / (1 - $product->discount_percent / 100), 2) }}</div>
                                <div class="text-sm text-green-600 font-medium">{{ $product->discount_percent }}% OFF</div>
                            @endif
                        </div>
                    </div>

                    <!-- AR Badge -->
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-gradient-to-r from-purple-100 to-blue-100 text-purple-700 rounded-full text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9 3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                        AR Enabled
                    </div>
                </div>

                <!-- Product Description -->
                @if($product->descriptions)
                <div>
                    <h3 class="text-xl font-semibold mb-4">Description</h3>
                    <div class="prose text-gray-700">
                        {!! nl2br(e($product->descriptions)) !!}
                    </div>
                </div>
                @endif

                <!-- AR Placement Instructions -->
                @if($product->ar_placement_instructions)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="font-semibold text-blue-900 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        AR Placement Tips
                    </h3>
                    <p class="text-blue-800 text-sm">{{ $product->ar_placement_instructions }}</p>
                </div>
                @endif

                <!-- Product Specifications -->
                @if($dimensions)
                <div>
                    <h3 class="text-xl font-semibold mb-4">Specifications</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ $dimensions['width'] }}</div>
                                <div class="text-sm text-gray-600">Width (cm)</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ $dimensions['height'] }}</div>
                                <div class="text-sm text-gray-600">Height (cm)</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-gray-900">{{ $dimensions['depth'] }}</div>
                                <div class="text-sm text-gray-600">Depth (cm)</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Purchase Actions -->
                <div class="space-y-4">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="flex items-center gap-4">
                            <label for="quantity" class="text-sm font-medium">Quantity:</label>
                            <select name="quantity" id="quantity" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                                Add to Cart
                            </button>
                            
                            <button type="button" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </div>
                    </form>

                    <!-- Regular Product View Link -->
                    <div class="text-center pt-4 border-t">
                        <a href="{{ route('user.products.show', $product->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            ← View regular product page
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related AR Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold mb-8">More AR-Enabled Furniture</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <div class="related-product-card bg-white border border-gray-200">
                        <div class="aspect-square bg-gray-100 relative overflow-hidden">
                            <img src="{{ $related->image_url ? asset('images/products/' . $related->image_url) : asset('images/no-image.png') }}" 
                                 alt="{{ $related->name }}" class="w-full h-full object-cover">
                            
                            <!-- AR Badge -->
                            <div class="absolute top-3 right-3 bg-purple-600 text-white px-2 py-1 rounded-full text-xs font-medium">
                                AR
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-1">{{ $related->name }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ $related->category->name ?? 'Uncategorized' }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-bold text-blue-600">${{ number_format($related->price, 2) }}</span>
                                <a href="{{ route('products.ar', $related->id) }}" class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium hover:bg-purple-200 transition-colors">
                                    View AR
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- AR Instructions Modal -->
    <div id="ar-instructions-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50" style="display: none;">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">AR Instructions</h3>
                    <button onclick="document.getElementById('ar-instructions-modal').style.display = 'none'" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4 text-sm text-gray-600">
                    <p id="compatibility-message"></p>
                    
                    <div class="space-y-2">
                        <p><strong>Step 1:</strong> Point your device at a flat surface (floor, table, etc.)</p>
                        <p><strong>Step 2:</strong> Wait for AR to detect the surface</p>
                        <p><strong>Step 3:</strong> Tap to place the furniture model</p>
                        <p><strong>Step 4:</strong> Walk around to view from different angles</p>
                    </div>
                </div>
                
                <button onclick="document.getElementById('ar-instructions-modal').style.display = 'none'" class="w-full mt-6 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Got it!
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Update compatibility message when page loads
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('compatibility-message').textContent = 'AR compatibility: Most modern smartphones and tablets support AR. For best experience, use Chrome (Android) or Safari (iOS).';
            });
        </script>
    @endpush
</x-app-layout>