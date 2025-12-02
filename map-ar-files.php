<?php
/**
 * Map AR Model Files to Products
 * 
 * This script helps map existing AR model files to products
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product\Product;

echo "=== MAPPING AR MODEL FILES ===\n\n";

// List existing files
$arPath = storage_path('app/public/ar_models');
$files = scandir($arPath);
$glbFiles = array_filter($files, function($file) {
    return pathinfo($file, PATHINFO_EXTENSION) === 'glb';
});
$usdzFiles = array_filter($files, function($file) {
    return pathinfo($file, PATHINFO_EXTENSION) === 'usdz';
});

echo "Available GLB files:\n";
foreach ($glbFiles as $file) {
    echo "  - $file\n";
}
echo "\nAvailable USDZ files:\n";
foreach ($usdzFiles as $file) {
    echo "  - $file\n";
}

echo "\n--- SUGGESTED MAPPINGS ---\n\n";

// Product 1: Sofa Luna 3 chỗ
echo "Product 1: Sofa Luna 3 chỗ\n";
echo "  Suggested GLB: sofa_luna_3_cho_ar_2025_10_09_19_23_11_sjk8he.glb\n";
echo "  Command:\n";
echo "  UPDATE products SET ar_model_glb = 'sofa_luna_3_cho_ar_2025_10_09_19_23_11_sjk8he.glb' WHERE id = 1;\n\n";

// Product 2: Ghế bành Oslo
echo "Product 2: Ghế bành Oslo\n";
echo "  Suggested GLB: ghe_ar_2025_10_09_12_08_52_8B04w4.glb\n";
echo "  Command:\n";
echo "  UPDATE products SET ar_model_glb = 'ghe_ar_2025_10_09_12_08_52_8B04w4.glb' WHERE id = 2;\n\n";

// For other products - they need new files
echo "Products 5, 9, 13: Need GLB/USDZ files uploaded\n";
echo "  Current files don't exist. Options:\n";
echo "  1. Upload actual 3D model files\n";
echo "  2. Use sample files temporarily\n";
echo "  3. Disable AR for these products\n\n";

echo "=== AUTO-FIX OPTION ===\n";
echo "Run the following SQL commands:\n\n";

echo "-- Fix Product 1 (Sofa)\n";
echo "UPDATE products SET ar_model_glb = 'sofa_luna_3_cho_ar_2025_10_09_19_23_11_sjk8he.glb', ar_model_usdz = NULL WHERE id = 1;\n\n";

echo "-- Fix Product 2 (Chair)\n";
echo "UPDATE products SET ar_model_glb = 'ghe_ar_2025_10_09_12_08_52_8B04w4.glb', ar_model_usdz = NULL WHERE id = 2;\n\n";

echo "-- Disable AR for products without models\n";
echo "UPDATE products SET ar_enabled = 0 WHERE id IN (5, 9, 13);\n\n";

echo "Or use sample files for testing:\n";
echo "UPDATE products SET ar_model_glb = 'sample_chair_2025_10_09_21_15_55.glb', ar_model_usdz = 'sample_chair_ar_2025_10_10_12_00_00_xyz789.usdz' WHERE id IN (5, 9, 13);\n";
