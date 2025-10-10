<?php
/**
 * Download Sample AR Model for Testing
 * Script này sẽ download model AR mẫu từ Khronos Group
 */

echo "=== DOWNLOADING SAMPLE AR MODEL ===\n\n";

// URLs của sample models từ Khronos Group
$sampleModels = [
    'chair' => 'https://raw.githubusercontent.com/KhronosGroup/glTF-Sample-Models/master/2.0/WaterBottle/glTF-Binary/WaterBottle.glb',
    'chair2' => 'https://raw.githubusercontent.com/KhronosGroup/glTF-Sample-Models/master/2.0/Avocado/glTF-Binary/Avocado.glb',
    'furniture' => 'https://raw.githubusercontent.com/KhronosGroup/glTF-Sample-Models/master/2.0/Duck/glTF-Binary/Duck.glb'
];

$arModelsPath = __DIR__ . '/storage/app/public/ar_models/';

// Đảm bảo thư mục tồn tại
if (!is_dir($arModelsPath)) {
    mkdir($arModelsPath, 0755, true);
    echo "✅ Created ar_models directory\n";
}

foreach ($sampleModels as $name => $url) {
    echo "Downloading $name model...\n";
    
    $filename = "sample_{$name}_" . date('Y_m_d_H_i_s') . '.glb';
    $filepath = $arModelsPath . $filename;
    // Download file
    $content = file_get_contents($url);
    if ($content !== false) {
        file_put_contents($filepath, $content);
        echo "✅ Downloaded: $filename (" . round(filesize($filepath)/1024, 2) . " KB)\n";
        // Update product với model này
        require_once __DIR__ . '/vendor/autoload.php';
        $app = require_once __DIR__ . '/bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();
        $product = App\Models\Product\Product::first();
        if ($product) {
            $product->update([
                'ar_enabled' => true,
                'ar_model_glb' => 'storage/ar_models/' . $filename,
                'width_cm' => 30,
                'height_cm' => 40,
                'depth_cm' => 30
            ]);
            echo "✅ Updated product {$product->id} with new model\n";
            echo "   Test URL: http://127.0.0.1:8000/products/{$product->id}/ar\n";
        }
        break; // Chỉ cần 1 model để test
    } else {
        echo "❌ Failed to download: $name\n";
    }
}

echo "\n=== DOWNLOAD COMPLETE ===\n";
echo "Now test the AR page to see if the model loads!\n";