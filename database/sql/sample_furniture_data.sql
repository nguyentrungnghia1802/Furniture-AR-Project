-- Xoá sạch dữ liệu cũ
DELETE FROM products;
DELETE FROM categories;
ALTER TABLE categories AUTO_INCREMENT = 1;
ALTER TABLE products AUTO_INCREMENT = 1;

-- Insert 4 categories
INSERT INTO categories (id, name, description, created_at, updated_at) VALUES
(1, 'Seatings', 'Ghế sofa, ghế đơn, ghế bành, ghế đôn...', NOW(), NOW()),
(2, 'Tables', 'Bàn ăn, bàn trà, bàn làm việc, bàn học...', NOW(), NOW()),
(3, 'Storages', 'Tủ quần áo, kệ sách, tủ giày, tủ trang trí...', NOW(), NOW()),
(4, 'Decores', 'Đèn, tranh, cây cảnh, phụ kiện trang trí...', NOW(), NOW());

-- Insert sample products (4 per category, có AR model giả lập)
INSERT INTO products (name, descriptions, price, discount_percent, stock_quantity, view_count, image_url, created_at, updated_at, category_id)
VALUES
-- Seatings
('Sofa Luna 3 chỗ', 'Sofa vải cao cấp, khung gỗ sồi, màu xám nhã nhặn.', 9500000, 10, 12, 120, 'images/sofa_luna.jpg', NOW(), NOW(), 1),
('Ghế bành Oslo', 'Ghế bành bọc nỉ, chân gỗ tự nhiên, phong cách Bắc Âu.', 4200000, 5, 8, 80, 'images/oslo_armchair.jpg', NOW(), NOW(), 1),
('Ghế đơn Velvet', 'Ghế đơn bọc vải nhung, màu xanh navy sang trọng.', 2100000, 0, 20, 60, 'images/velvet_chair.jpg', NOW(), NOW(), 1),
('Ghế đôn tròn', 'Ghế đôn tròn đa năng, dùng làm ghế phụ hoặc để chân.', 850000, 0, 30, 40, 'images/round_stool.jpg', NOW(), NOW(), 1),

-- Tables
('Bàn ăn 6 ghế Oak', 'Bàn ăn gỗ sồi tự nhiên, mặt bàn chống xước.', 7800000, 8, 10, 90, 'images/oak_dining_table.jpg', NOW(), NOW(), 2),
('Bàn trà kính', 'Bàn trà mặt kính cường lực, chân inox mạ vàng.', 3200000, 0, 15, 70, 'images/glass_coffee_table.jpg', NOW(), NOW(), 2),
('Bàn làm việc Minimal', 'Bàn làm việc phong cách tối giản, gỗ MDF chống ẩm.', 2500000, 0, 18, 55, 'images/minimal_desk.jpg', NOW(), NOW(), 2),
('Bàn học trẻ em', 'Bàn học cho bé, thiết kế an toàn, màu pastel.', 1800000, 0, 25, 30, 'images/kids_study_table.jpg', NOW(), NOW(), 2),

-- Storages
('Tủ quần áo 3 cánh', 'Tủ quần áo gỗ công nghiệp, 3 cánh mở, nhiều ngăn.', 5200000, 12, 7, 65, 'images/wardrobe_3door.jpg', NOW(), NOW(), 3),
('Kệ sách 5 tầng', 'Kệ sách gỗ thông, 5 tầng, phù hợp mọi không gian.', 1650000, 0, 22, 50, 'images/bookshelf_5tier.jpg', NOW(), NOW(), 3),
('Tủ giày thông minh', 'Tủ giày đa năng, tiết kiệm diện tích, màu trắng.', 1450000, 0, 16, 35, 'images/shoe_cabinet.jpg', NOW(), NOW(), 3),
('Tủ trang trí phòng khách', 'Tủ trang trí gỗ MDF, nhiều ngăn, màu walnut.', 2950000, 0, 12, 40, 'images/livingroom_cabinet.jpg', NOW(), NOW(), 3),

-- Decores
('Đèn cây phòng khách', 'Đèn cây đứng, ánh sáng vàng ấm, chân kim loại.', 1100000, 0, 20, 45, 'images/floor_lamp.jpg', NOW(), NOW(), 4),
('Tranh canvas nghệ thuật', 'Tranh canvas treo tường, chủ đề thiên nhiên.', 650000, 0, 30, 38, 'images/canvas_art.jpg', NOW(), NOW(), 4),
('Cây cảnh giả decor', 'Cây cảnh giả, chậu gốm, trang trí phòng khách.', 480000, 0, 25, 32, 'images/fake_plant.jpg', NOW(), NOW(), 4),
('Bộ phụ kiện decor bàn', 'Bộ phụ kiện decor bàn gồm lọ hoa, khay gỗ, nến.', 850000, 0, 18, 28, 'images/table_decor_set.jpg', NOW(), NOW(), 4);

-- Giả lập AR model cho các sản phẩm (nếu có cột ar_model_glb, ar_model_usdz, ar_enabled)
UPDATE products SET ar_enabled = 1, ar_model_glb = 'ar_models/sofa_luna.glb', ar_model_usdz = 'ar_models/sofa_luna.usdz' WHERE name = 'Sofa Luna 3 chỗ';
UPDATE products SET ar_enabled = 1, ar_model_glb = 'ar_models/oslo_armchair.glb', ar_model_usdz = 'ar_models/oslo_armchair.usdz' WHERE name = 'Ghế bành Oslo';
UPDATE products SET ar_enabled = 1, ar_model_glb = 'ar_models/oak_dining_table.glb', ar_model_usdz = 'ar_models/oak_dining_table.usdz' WHERE name = 'Bàn ăn 6 ghế Oak';
UPDATE products SET ar_enabled = 1, ar_model_glb = 'ar_models/wardrobe_3door.glb', ar_model_usdz = 'ar_models/wardrobe_3door.usdz' WHERE name = 'Tủ quần áo 3 cánh';
UPDATE products SET ar_enabled = 1, ar_model_glb = 'ar_models/floor_lamp.glb', ar_model_usdz = 'ar_models/floor_lamp.usdz' WHERE name = 'Đèn cây phòng khách';

-- Bạn có thể bổ sung thêm AR cho các sản phẩm khác nếu có model thật.