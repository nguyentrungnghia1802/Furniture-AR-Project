<?php
/**
 * AR Debug Script
 * Kiểm tra các vấn đề liên quan đến AR trong ứng dụng
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== AR DEBUG SCRIPT ===\n\n";

// 1. Kiểm tra thư mục AR models
echo "1. Kiểm tra thư mục AR models:\n";
$arPath = storage_path('app/public/ar_models');
echo "   Path: $arPath\n";
echo "   Exists: " . (is_dir($arPath) ? "YES" : "NO") . "\n";
echo "   Writable: " . (is_writable($arPath) ? "YES" : "NO") . "\n";

if (is_dir($arPath)) {
    $files = scandir($arPath);
    $arFiles = array_filter($files, fn($f) => !in_array($f, ['.', '..']));
    echo "   Files count: " . count($arFiles) . "\n";
    if (count($arFiles) > 0) {
        echo "   Files: " . implode(', ', $arFiles) . "\n";
    }
}
echo "\n";

// 2. Kiểm tra symbolic link
echo "2. Kiểm tra symbolic link:\n";
$publicStoragePath = public_path('storage');
echo "   Public storage path: $publicStoragePath\n";
echo "   Exists: " . (file_exists($publicStoragePath) ? "YES" : "NO") . "\n";
echo "   Is link: " . (is_link($publicStoragePath) ? "YES" : "NO") . "\n";
if (is_link($publicStoragePath)) {
    echo "   Target: " . readlink($publicStoragePath) . "\n";
}
echo "\n";

// 3. Kiểm tra sản phẩm có AR
echo "3. Kiểm tra sản phẩm có AR:\n";
try {
    $products = App\Models\Product\Product::where('ar_enabled', true)->get();
    echo "   Sản phẩm có AR enabled: " . $products->count() . "\n";
    
    foreach ($products as $product) {
        echo "   - ID: {$product->id}, Name: {$product->name}\n";
        echo "     GLB: " . ($product->ar_model_glb ?: 'NULL') . "\n";
        echo "     USDZ: " . ($product->ar_model_usdz ?: 'NULL') . "\n";
        
        // Kiểm tra URL AR
        if ($product->ar_model_glb) {
            $glbUrl = $product->getArModelUrl('glb');
            echo "     GLB URL: $glbUrl\n";
            $filePath = str_replace(url('/'), public_path(), $glbUrl);
            echo "     GLB File exists: " . (file_exists($filePath) ? "YES" : "NO") . "\n";
        }
        
        if ($product->ar_model_usdz) {
            $usdzUrl = $product->getArModelUrl('usdz');
            echo "     USDZ URL: $usdzUrl\n";
            $filePath = str_replace(url('/'), public_path(), $usdzUrl);
            echo "     USDZ File exists: " . (file_exists($filePath) ? "YES" : "NO") . "\n";
        }
        echo "\n";
    }
} catch (Exception $e) {
    echo "   Error: " . $e->getMessage() . "\n";
}

// 4. Kiểm tra route AR
echo "4. Kiểm tra route AR:\n";
try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    foreach ($routes as $route) {
        if (str_contains($route->uri(), '/ar') || str_contains($route->uri(), 'products')) {
            echo "   - " . implode('|', $route->methods()) . " " . $route->uri() . " -> " . $route->getActionName() . "\n";
        }
    }
} catch (Exception $e) {
    echo "   Error: " . $e->getMessage() . "\n";
}

echo "\n=== DEBUG COMPLETE ===\n";