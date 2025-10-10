<?php
/**
 * Update Product with Sample AR Data
 * Cập nhật sản phẩm với dữ liệu AR mẫu để test
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== UPDATING PRODUCT WITH SAMPLE AR DATA ===\n\n";

try {
    // Lấy sản phẩm đầu tiên để test
    $product = App\Models\Product\Product::first();
    
    if (!$product) {
        echo "Không tìm thấy sản phẩm nào trong database!\n";
        exit(1);
    }
    
    echo "Đang cập nhật sản phẩm: {$product->name} (ID: {$product->id})\n";
    
    // Cập nhật thông tin AR
    $product->update([
        'ar_enabled' => true,
        'ar_model_glb' => 'sample_chair_ar_2025_10_10_12_00_00_abc123.glb',
        'ar_model_usdz' => 'sample_chair_ar_2025_10_10_12_00_00_xyz789.usdz',
        'ar_model_size' => '60x80x45 cm',
        'ar_placement_instructions' => 'Đặt trên sàn nhà trong không gian rộng rãi. Đảm bảo có đủ ánh sáng.',
        'width_cm' => 60,
        'height_cm' => 80,
        'depth_cm' => 45
    ]);
    
    echo "✅ Đã cập nhật thông tin AR cho sản phẩm!\n\n";
    
    // Tạo file AR mẫu
    $arModelsPath = storage_path('app/public/ar_models');
    if (!is_dir($arModelsPath)) {
        mkdir($arModelsPath, 0755, true);
        echo "✅ Đã tạo thư mục ar_models\n";
    }
    
    // Tạo file GLB mẫu
    $glbContent = "// Sample GLB file for testing AR functionality\n// This is a placeholder file\n";
    file_put_contents($arModelsPath . '/sample_chair_ar_2025_10_10_12_00_00_abc123.glb', $glbContent);
    echo "✅ Đã tạo file GLB mẫu\n";
    
    // Tạo file USDZ mẫu
    $usdzContent = "// Sample USDZ file for testing AR functionality\n// This is a placeholder file\n";
    file_put_contents($arModelsPath . '/sample_chair_ar_2025_10_10_12_00_00_xyz789.usdz', $usdzContent);
    echo "✅ Đã tạo file USDZ mẫu\n";
    
    echo "\n=== THÔNG TIN AR CỦA SẢN PHẨM ===\n";
    echo "ID: {$product->id}\n";
    echo "Name: {$product->name}\n";
    echo "AR Enabled: " . ($product->ar_enabled ? 'YES' : 'NO') . "\n";
    echo "GLB File: {$product->ar_model_glb}\n";
    echo "USDZ File: {$product->ar_model_usdz}\n";
    echo "Dimensions: {$product->width_cm}×{$product->height_cm}×{$product->depth_cm} cm\n";
    echo "Instructions: {$product->ar_placement_instructions}\n";
    
    echo "\n=== AR URLs ===\n";
    echo "GLB URL: " . $product->getArModelUrl('glb') . "\n";
    echo "USDZ URL: " . $product->getArModelUrl('usdz') . "\n";
    
    echo "\n=== TESTING AR PAGE ===\n";
    echo "Product Detail: http://127.0.0.1:8000/products/{$product->id}\n";
    echo "AR Page: http://127.0.0.1:8000/products/{$product->id}/ar\n";
    
    echo "\n✅ Hoàn thành! Bạn có thể test AR tại các URL trên.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}