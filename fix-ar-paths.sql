-- =====================================================
-- Quick Fix for AR Model Paths
-- Run this in your MySQL database
-- =====================================================

USE furniture_shop_ar;

-- 1. Fix Product 1 - Sofa Luna (use existing sofa file)
UPDATE products 
SET ar_model_glb = 'sofa_luna_3_cho_ar_2025_10_09_19_23_11_sjk8he.glb',
    ar_model_usdz = NULL
WHERE id = 1;

-- 2. Fix Product 2 - Ghế bành Oslo (use existing chair file)
UPDATE products 
SET ar_model_glb = 'ghe_ar_2025_10_09_12_08_52_8B04w4.glb',
    ar_model_usdz = NULL
WHERE id = 2;

-- 3. Option A: Use sample files for other products (for testing)
UPDATE products 
SET ar_model_glb = 'sample_chair_2025_10_09_21_15_55.glb',
    ar_model_usdz = 'sample_chair_ar_2025_10_10_12_00_00_xyz789.usdz'
WHERE id IN (5, 9, 13);

-- 3. Option B: Disable AR for products without proper models
-- UPDATE products 
-- SET ar_enabled = 0 
-- WHERE id IN (5, 9, 13);

-- Verify the changes
SELECT id, name, ar_enabled, ar_model_glb, ar_model_usdz 
FROM products 
WHERE ar_enabled = 1;
