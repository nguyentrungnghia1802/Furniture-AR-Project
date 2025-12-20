# Quick Deployment Guide - Furniture AR

## ✅ Docker Image Published

Docker image đã được build và push lên Docker Hub:
- **Repository**: https://hub.docker.com/r/assassincreed2k1/furniture-ar
- **Tag latest**: `assassincreed2k1/furniture-ar:latest`
- **Tag v1.0.0**: `assassincreed2k1/furniture-ar:v1.0.0`
- **Image size**: 2.7GB

## 🚀 Cách Deploy Trên Ubuntu Server

### Phương Án 1: Sử Dụng Script Tự Động (Khuyến Nghị)

```bash
# Bước 1: Tải script setup
wget https://raw.githubusercontent.com/nguyentrungnghia1802/Furniture-AR-Project/main/deployment/setup-ubuntu.sh

# Bước 2: Cấp quyền thực thi
chmod +x setup-ubuntu.sh

# Bước 3: Chạy script với quyền root
sudo ./setup-ubuntu.sh
```

Script sẽ hỏi:
1. Domain hoặc IP của server (vd: 192.168.1.100)
2. Mật khẩu MySQL root
3. Tên database (mặc định: furniture_shop_ar)
4. Username MySQL (mặc định: furniture_user)
5. Mật khẩu MySQL user
6. Laravel APP_KEY (để trống để tự động tạo)

Sau khi setup xong:
```bash
cd /opt/furniture-ar
./start.sh
```

### Phương Án 2: Deploy Thủ Công

#### 1. Cài Đặt Docker
```bash
sudo apt update
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
sudo systemctl enable docker
sudo systemctl start docker
```

#### 2. Tạo Thư Mục Dự Án
```bash
sudo mkdir -p /opt/furniture-ar/{logs/app,backups/db,sql,public/images}
cd /opt/furniture-ar
```

#### 3. Tạo docker-compose.yml
```bash
sudo nano docker-compose.yml
```

Paste nội dung sau:
```yaml
services:
  app:
    image: assassincreed2k1/furniture-ar:latest
    container_name: furniture_ar_app
    restart: unless-stopped
    ports:
      - "80:80"
    environment:
      APP_NAME: "Furniture AR Shop"
      APP_ENV: production
      APP_KEY: "base64:YOUR_APP_KEY_HERE"
      APP_DEBUG: "false"
      APP_URL: "http://YOUR_SERVER_IP"
      
      DB_CONNECTION: mysql
      DB_HOST: db
      DB_PORT: 3306
      DB_DATABASE: furniture_shop_ar
      DB_USERNAME: furniture_user
      DB_PASSWORD: your_password
      
      CACHE_DRIVER: redis
      QUEUE_CONNECTION: database
      SESSION_DRIVER: redis
      
      REDIS_HOST: redis
      REDIS_PORT: 6379
    volumes:
      - app_storage:/var/www/html/storage
      - ./logs/app:/var/www/html/storage/logs
      - ./public/images:/var/www/html/public/images
    depends_on:
      - db
      - redis
    networks:
      - furniture_network

  db:
    image: mysql:8.0
    container_name: furniture_ar_db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: furniture_shop_ar
      MYSQL_USER: furniture_user
      MYSQL_PASSWORD: your_password
      MYSQL_ROOT_PASSWORD: your_root_password
    volumes:
      - db_data:/var/lib/mysql
      - ./backups/db:/backups
      - ./sql:/docker-entrypoint-initdb.d
    networks:
      - furniture_network

  redis:
    image: redis:7-alpine
    container_name: furniture_ar_redis
    restart: unless-stopped
    volumes:
      - redis_data:/data
    networks:
      - furniture_network

networks:
  furniture_network:
    driver: bridge

volumes:
  app_storage:
  db_data:
  redis_data:
```

#### 4. Khởi Động
```bash
sudo docker compose up -d
```

#### 5. Kiểm Tra
```bash
sudo docker compose ps
sudo docker compose logs -f app
```

#### 6. Truy Cập
Mở trình duyệt: `http://YOUR_SERVER_IP`

## 📋 Các Lệnh Quản Lý

### Xem Logs
```bash
# Tất cả logs
docker compose logs -f

# Chỉ app
docker compose logs -f app
```

### Restart
```bash
docker compose restart
```

### Stop/Start
```bash
docker compose down
docker compose up -d
```

### Update Lên Phiên Bản Mới
```bash
docker compose pull
docker compose down
docker compose up -d
```

### Chạy Lệnh Artisan
```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan cache:clear
```

### Backup Database
```bash
docker compose exec -T db mysqldump -u root -pYOUR_ROOT_PASSWORD furniture_shop_ar > backup.sql
```

### Restore Database
```bash
docker compose exec -T db mysql -u root -pYOUR_ROOT_PASSWORD furniture_shop_ar < backup.sql
```

## 🔧 Troubleshooting

### Port 80 đã được sử dụng
Thay đổi port trong docker-compose.yml:
```yaml
ports:
  - "8080:80"  # Dùng port 8080 thay vì 80
```

### Container không khởi động
```bash
# Xem logs để biết lỗi
docker compose logs

# Xóa và tạo lại
docker compose down -v
docker compose up -d
```

### Database connection failed
Kiểm tra:
1. DB_HOST phải là `db` (tên service trong docker-compose)
2. Database credentials đúng
3. Database container đã chạy: `docker compose ps db`

## 📁 Files Đã Tạo

- `deployment/setup-ubuntu.sh` - Script tự động setup Ubuntu
- `deployment/UBUNTU_DEPLOYMENT.md` - Hướng dẫn chi tiết
- `deployment/QUICK_START.md` - File này

## 📞 Hỗ Trợ

Nếu gặp vấn đề, hãy:
1. Kiểm tra logs: `docker compose logs`
2. Xem tài liệu chi tiết: `deployment/UBUNTU_DEPLOYMENT.md`
3. Tạo issue trên GitHub với thông tin logs

## 🎯 Các Bước Tiếp Theo

Sau khi deploy thành công:
1. ✅ Đổi APP_KEY và mật khẩu mặc định
2. ✅ Cấu hình email trong docker-compose.yml
3. ✅ Upload database backup vào thư mục sql/
4. ✅ Chạy migration: `docker compose exec app php artisan migrate`
5. ✅ Setup SSL certificate cho HTTPS (khuyến nghị)
6. ✅ Cấu hình backup tự động

## ⚡ Performance Tips

- Dùng `assassincreed2k1/furniture-ar:v1.0.0` thay vì `:latest` cho production
- Enable Redis cache cho session và cache
- Setup CDN cho static assets
- Monitor logs thường xuyên

---

**Furniture AR Project** - Laravel 12 + AR Features
