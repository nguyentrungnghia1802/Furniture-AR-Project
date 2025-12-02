<?php
/**
 * Fix AR Model Paths in Database
 * 
 * This script fixes the AR model file paths in the database:
 * 1. Removes absolute Windows paths
 * 2. Removes "ar_models/" prefix (code already adds it)
 * 3. Updates with correct filenames only
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product\Product;

echo "=== FIXING AR MODEL PATHS IN DATABASE ===\n\n";

// Get all AR-enabled products
$products = Product::where('ar_enabled', true)->get();

echo "Found " . $products->count() . " AR-enabled products\n\n";

foreach ($products as $product) {
    echo "Product: {$product->name} (ID: {$product->id})\n";
    echo "  Current GLB: {$product->ar_model_glb}\n";
    
    $updated = false;
    $newGlb = $product->ar_model_glb;
    $newUsdz = $product->ar_model_usdz;
    
    // Fix GLB path
    if ($product->ar_model_glb) {
        // Remove absolute Windows path
        if (preg_match('/^"?[A-Z]:\\\\/', $product->ar_model_glb)) {
            echo "  ❌ ERROR: Absolute Windows path detected!\n";
            echo "  ℹ️  This product needs manual fixing - set proper GLB filename\n";
            $newGlb = null; // Clear invalid path
            $updated = true;
        }
        // Remove "ar_models/" prefix if exists
        elseif (strpos($product->ar_model_glb, 'ar_models/') === 0) {
            $newGlb = str_replace('ar_models/', '', $product->ar_model_glb);
            echo "  ✅ Removed prefix: {$newGlb}\n";
            $updated = true;
        }
    }
    
    // Fix USDZ path
    if ($product->ar_model_usdz) {
        if (strpos($product->ar_model_usdz, 'ar_models/') === 0) {
            $newUsdz = str_replace('ar_models/', '', $product->ar_model_usdz);
            echo "  ✅ Removed USDZ prefix: {$newUsdz}\n";
            $updated = true;
        }
    }
    
    // Update database
    if ($updated) {
        $product->update([
            'ar_model_glb' => $newGlb,
            'ar_model_usdz' => $newUsdz,
        ]);
        echo "  ✅ Updated in database\n";
    } else {
        echo "  ℹ️  No changes needed\n";
    }
    
    echo "\n";
}

echo "=== FIX COMPLETE ===\n";
echo "\nNext steps:\n";
echo "1. Run this script to fix database paths\n";
echo "2. Upload correct GLB/USDZ files to storage/app/public/ar_models/\n";
echo "3. Update Product ID 1 manually with correct filename\n";
echo "4. Test AR pages\n";
