# AR Models Storage Guide

## ✅ Giải pháp hiện tại
AR models được lưu trực tiếp trong `public/ar_models/` với tổ chức theo category:

```
public/ar_models/
├── seatings/      # Ghế, sofa, armchair
├── tables/        # Bàn, coffee table, desk
├── storages/      # Tủ, kệ, cabinet
├── decores/       # Đồ trang trí, accessories
└── others/        # Các loại khác
```

**Ưu điểm:**
- ✅ Không cần symlink - đơn giản hơn
- ✅ Deploy dễ dàng trên Ubuntu/Docker
- ✅ Không cần chạy `php artisan storage:link`
- ✅ Truy cập trực tiếp: `/ar_models/{category}/file.glb`
- ✅ Ít lỗi permission hơn
- ✅ Dễ quản lý theo từng loại sản phẩm

## Các thay đổi đã thực hiện

### 1. ArModelService.php
- Lưu file trực tiếp vào `public/ar_models/{category}/` với category subfolder
- Upload tự động phân loại theo category name
- Hỗ trợ tìm kiếm file qua các subfolder
- Method: `uploadArModel()`, `deleteArModel()`, `getCategorySubfolder()`, `findArModelFile()`

### 2. Product.php
- `getArModelUrl()` trả về URL: `/ar_models/{category}/file.glb`

### 3. ProductsController.php
- Truyền category name khi upload AR models
- Lưu full path (bao gồm subfolder) vào database

### 4. Cấu trúc hiện tại
```
public/ar_models/
├── .htaccess           # Caching & compression
├── .gitkeep           # README
├── seatings/
├── tables/
├── storages/
├── decores/
└── others/
```

## URL Structure

```
/ar_models/{category}/{filename}.glb
     ↓
public/ar_models/seatings/sofa-modern-123.glb
```

**Ví dụ:**
- Sofa: `/ar_models/seatings/sofa-modern-123.glb`
- Desk: `/ar_models/tables/desk-wooden-456.glb`
- Cabinet: `/ar_models/storages/cabinet-white-789.glb`


## Testing

### 1. Test Upload
- Vào Admin Panel → Products → Create/Edit Product
- Enable AR support
- Upload GLB và USDZ file
- Kiểm tra file xuất hiện trong `public/ar_models/{category}/`

### 2. Test View
- Vào trang product detail
- Click nút "View in AR"
- Model viewer phải load được file .glb

### 3. Test URL
```bash
# URL phải hoạt động:
curl -I https://your-domain.com/ar_models/seatings/your-file.glb
# Response: 200 OK
```

## Deployment Guide

### Ubuntu/Apache:
```bash
# Set permissions
sudo chown -R www-data:www-data public/ar_models/
sudo chmod -R 755 public/ar_models/

# Không cần chạy storage:link nữa!
```

### Ubuntu/Nginx:
```bash
sudo chown -R nginx:nginx public/ar_models/
sudo chmod -R 755 public/ar_models/
```

### Docker:
```dockerfile
# Trong Dockerfile
RUN mkdir -p /var/www/html/public/ar_models/{seatings,tables,storages,decores,others} && \
    chown -R www-data:www-data /var/www/html/public/ar_models && \
    chmod -R 755 /var/www/html/public/ar_models
```

## Permissions cho Production

```bash
# Ubuntu/Apache hoặc Nginx
sudo chown -R www-data:www-data public/ar_models/
sudo chmod -R 755 public/ar_models/

# Verify
ls -la public/ar_models/
```

## Troubleshooting

### Lỗi: "Failed to store AR model file"
- Kiểm tra permission: `chmod -R 755 public/ar_models/`
- Kiểm tra owner: `chown -R www-data:www-data public/ar_models/`

### Lỗi: "File not found" khi view AR
- Kiểm tra file: `ls public/ar_models/{category}/`
- Kiểm tra URL: `https://domain.com/ar_models/{category}/file.glb`
- Xem log: `tail -f storage/logs/laravel.log`

### Model không load trên iOS
- Đảm bảo có file `.usdz` cho iOS
- Kiểm tra MIME type: `model/vnd.usdz+zip`

---

**Lưu ý quan trọng:**
- Không còn cần symlink `public/storage`
- Không còn cần folder `storage/app/public/ar_models/`
- Files AR models giờ hoàn toàn độc lập và public-access ready
