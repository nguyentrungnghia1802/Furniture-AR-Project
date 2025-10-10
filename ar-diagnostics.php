<?php
/**
 * AR Model Checker & Simple Model Creator
 * Kiểm tra model hiện tại và tạo model test đơn giản
 */

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== AR MODEL DIAGNOSTICS ===\n\n";

// 1. Kiểm tra product hiện tại
$product = App\Models\Product\Product::where('ar_enabled', true)->first();
if (!$product) {
    echo "❌ No AR-enabled products found\n";
    exit(1);
}

echo "📦 Product: {$product->name} (ID: {$product->id})\n";
echo "🔗 GLB File: {$product->ar_model_glb}\n";
echo "🔗 USDZ File: {$product->ar_model_usdz}\n\n";

// 2. Kiểm tra file paths
$arPath = storage_path('app/public/ar_models/');
$glbPath = $arPath . $product->ar_model_glb;
$publicPath = public_path('storage/ar_models/' . $product->ar_model_glb);

echo "📁 Storage path: $arPath\n";
echo "📁 GLB file path: $glbPath\n";
echo "📁 Public path: $publicPath\n";
echo "✅ GLB exists in storage: " . (file_exists($glbPath) ? "YES" : "NO") . "\n";
echo "✅ GLB accessible via public: " . (file_exists($publicPath) ? "YES" : "NO") . "\n";

if (file_exists($glbPath)) {
    echo "📊 GLB file size: " . round(filesize($glbPath)/1024/1024, 2) . " MB\n";
}

// 3. Test URLs
$glbUrl = $product->getArModelUrl('glb');
$usdzUrl = $product->getArModelUrl('usdz');

echo "\n🌐 AR URLs:\n";
echo "   GLB: $glbUrl\n";
if ($usdzUrl) {
    echo "   USDZ: $usdzUrl\n";
}

// 4. Test HTTP accessibility
echo "\n🌍 HTTP Accessibility Test:\n";
$context = stream_context_create(['http' => ['timeout' => 10]]);

// Test GLB URL
$headers = @get_headers($glbUrl, 1, $context);
if ($headers && strpos($headers[0], '200') !== false) {
    echo "✅ GLB URL accessible via HTTP\n";
} else {
    echo "❌ GLB URL not accessible via HTTP\n";
    echo "   Response: " . ($headers[0] ?? 'No response') . "\n";
}

// 5. Tạo một model cube đơn giản để test
echo "\n🎲 Creating simple test model...\n";

// Tạo một GLB cube đơn giản (base64 encoded)
$simpleCubeGLB = base64_decode('Z2xURgIAAABEAQAAaAAAAABCJPeBGAAAAAGQhAAEAAAABWkGAiEiABAQGAQGgAACAACAzYAAhDgABYEARAQOgAEARAQMCAkKCwANgAwgAqAAsgAAEAAgAKgAAwAAgM2AAwAQAKIABYgAApAABQQAAARhKAEhAQAABQAAAAMAAAABAAAIAAAAAAAACAAAAAcAAAAGAAAABQAAAAgAAAAFAAAABAAAAAMAAAA7gAAAAAAA7/8AAAAAwAAAAK/rAAAAAA==');

$testFilename = 'test_cube_' . date('Y_m_d_H_i_s') . '.glb';
$testFilepath = $arPath . $testFilename;

file_put_contents($testFilepath, $simpleCubeGLB);

// Update product với test model
$product->update([
    'ar_model_glb' => $testFilename,
    'ar_model_usdz' => null, // Remove USDZ for now
    'width_cm' => 10,
    'height_cm' => 10,
    'depth_cm' => 10
]);

echo "✅ Created simple test cube: $testFilename\n";
echo "📊 Test cube size: " . round(filesize($testFilepath)/1024, 2) . " KB\n";

// 6. Final test URLs
echo "\n🎯 FINAL TEST URLS:\n";
echo "Product Page: http://127.0.0.1:8000/products/{$product->id}\n";
echo "AR Page: http://127.0.0.1:8000/products/{$product->id}/ar\n";
echo "Direct GLB: " . $product->getArModelUrl('glb') . "\n";

echo "\n💡 DEBUGGING TIPS:\n";
echo "1. Open AR page and check browser console for errors\n";
echo "2. Check Network tab to see if GLB file loads\n";
echo "3. Try direct GLB URL in browser\n";
echo "4. Test on HTTPS for full AR features\n";

echo "\n=== DIAGNOSTICS COMPLETE ===\n";