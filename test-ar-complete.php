<?php
/**
 * Complete AR System Test
 * Tests all aspects of AR functionality
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product\Product;

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║          COMPLETE AR SYSTEM TEST - Luna Shop                   ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// 1. Database Check
echo "┌─ 1. DATABASE CHECK ─────────────────────────────────────────────┐\n";
$arProducts = Product::where('ar_enabled', true)->get();
echo "   AR-Enabled Products: " . $arProducts->count() . "\n\n";

foreach ($arProducts as $product) {
    echo "   📦 {$product->name} (ID: {$product->id})\n";
    echo "      GLB: " . ($product->ar_model_glb ?: '❌ Not set') . "\n";
    echo "      USDZ: " . ($product->ar_model_usdz ?: '⚠️ Not set') . "\n";
    echo "      Dimensions: {$product->width_cm}x{$product->height_cm}x{$product->depth_cm} cm\n";
    echo "      Has AR Support: " . ($product->hasArSupport() ? '✅ Yes' : '❌ No') . "\n\n";
}
echo "└─────────────────────────────────────────────────────────────────┘\n\n";

// 2. File System Check
echo "┌─ 2. FILE SYSTEM CHECK ──────────────────────────────────────────┐\n";
$storagePath = storage_path('app/public/ar_models');
$publicPath = public_path('storage/ar_models');

echo "   Storage Path: $storagePath\n";
echo "   Public Path: $publicPath\n\n";

echo "   Storage Directory:\n";
if (is_dir($storagePath)) {
    $storageFiles = scandir($storagePath);
    $glbFiles = array_filter($storageFiles, fn($f) => pathinfo($f, PATHINFO_EXTENSION) === 'glb');
    $usdzFiles = array_filter($storageFiles, fn($f) => pathinfo($f, PATHINFO_EXTENSION) === 'usdz');
    
    echo "      GLB files: " . count($glbFiles) . "\n";
    foreach ($glbFiles as $file) {
        $size = filesize($storagePath . '/' . $file);
        echo "         - $file (" . number_format($size / 1024, 2) . " KB)\n";
    }
    
    echo "      USDZ files: " . count($usdzFiles) . "\n";
    foreach ($usdzFiles as $file) {
        $size = filesize($storagePath . '/' . $file);
        echo "         - $file (" . number_format($size / 1024, 2) . " KB)\n";
    }
} else {
    echo "      ❌ Directory not found!\n";
}

echo "\n   Public Symlink:\n";
if (is_link($publicPath)) {
    echo "      ✅ Symlink exists\n";
    echo "      Target: " . readlink($publicPath) . "\n";
} else {
    echo "      ❌ Symlink not found! Run: php artisan storage:link\n";
}
echo "└─────────────────────────────────────────────────────────────────┘\n\n";

// 3. URL Generation Check
echo "┌─ 3. URL GENERATION CHECK ───────────────────────────────────────┐\n";
foreach ($arProducts->take(3) as $product) {
    echo "   Product: {$product->name}\n";
    $glbUrl = $product->getArModelUrl('glb');
    $usdzUrl = $product->getArModelUrl('usdz');
    
    echo "      GLB URL: " . ($glbUrl ?: '❌ Not available') . "\n";
    if ($glbUrl) {
        $filename = basename($glbUrl);
        $filePath = $storagePath . '/' . $filename;
        echo "      File exists: " . (file_exists($filePath) ? '✅' : '❌') . "\n";
    }
    
    if ($usdzUrl) {
        echo "      USDZ URL: $usdzUrl\n";
    }
    echo "\n";
}
echo "└─────────────────────────────────────────────────────────────────┘\n\n";

// 4. Route Check
echo "┌─ 4. ROUTE CHECK ────────────────────────────────────────────────┐\n";
try {
    $arRoute = route('products.ar', ['id' => 1]);
    echo "   ✅ AR Route: $arRoute\n";
} catch (Exception $e) {
    echo "   ❌ AR Route Error: " . $e->getMessage() . "\n";
}
echo "└─────────────────────────────────────────────────────────────────┘\n\n";

// 5. Summary
echo "┌─ 5. SUMMARY ────────────────────────────────────────────────────┐\n";
$issues = [];

if ($arProducts->count() === 0) {
    $issues[] = "No AR-enabled products found";
}

foreach ($arProducts as $product) {
    if (!$product->hasArSupport()) {
        $issues[] = "Product '{$product->name}' has AR enabled but no model files";
    }
    
    if ($product->ar_model_glb) {
        $filename = $product->ar_model_glb;
        if (!file_exists($storagePath . '/' . $filename)) {
            $issues[] = "GLB file missing for '{$product->name}': $filename";
        }
    }
}

if (!is_link($publicPath)) {
    $issues[] = "Public storage symlink missing";
}

if (empty($issues)) {
    echo "   ✅ ALL CHECKS PASSED!\n";
    echo "   🎉 AR system is working correctly!\n\n";
    echo "   Test your AR pages:\n";
    foreach ($arProducts->take(3) as $product) {
        $url = route('products.ar', ['id' => $product->id]);
        echo "      - {$product->name}: $url\n";
    }
} else {
    echo "   ⚠️  ISSUES FOUND:\n";
    foreach ($issues as $issue) {
        echo "      - $issue\n";
    }
}
echo "└─────────────────────────────────────────────────────────────────┘\n\n";

echo "Test complete at " . date('Y-m-d H:i:s') . "\n";
