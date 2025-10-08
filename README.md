# Furniture AR Project

A Laravel-based online furniture store with Augmented Reality (AR) features. This project allows customers to view and place 3D furniture models in their real space using AR technology on both iOS and Android devices.

## 🌟 Features

- **Product Management**: Full CRUD operations for furniture products
- **3D Model Support**: Upload and manage GLB (Web/Android) and USDZ (iOS) 3D models
- **AR Visualization**: View furniture in your space using:
  - Scene Viewer for Android
  - AR Quick Look for iOS
  - Interactive 3D viewer for web browsers
- **Responsive Design**: Works on desktop, tablet, and mobile devices
- **File Upload**: Support for product images and 3D model files
- **Database Integration**: MySQL database for storing product information

## 🛠️ Technology Stack

- **Backend**: Laravel 10.x
- **Frontend**: Blade Templates, Bootstrap 5
- **3D Viewer**: Google Model Viewer
- **Database**: MySQL
- **AR Support**: Scene Viewer (Android), Quick Look (iOS)

## 📋 Requirements

- PHP 8.1 or higher
- Composer
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Modern web browser with WebGL support

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/nguyentrungnghia1802/Furniture-AR-Project.git
   cd Furniture-AR-Project
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Update database configuration in `.env`**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=furniture_ar
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Create database**
   ```bash
   mysql -u your_username -p -e "CREATE DATABASE furniture_ar"
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Create upload directories**
   ```bash
   mkdir -p public/uploads/{images,models}
   chmod -R 755 public/uploads
   ```

8. **Start development server**
   ```bash
   php artisan serve
   ```

9. **Access the application**
   Open your browser and visit: `http://localhost:8000`

## 📱 Using AR Features

### For Android Users:
1. Click "View in Your Space" button on a product with 3D models
2. AR Scene Viewer will launch
3. Point your camera at a flat surface
4. Tap to place the furniture model
5. Move around to see it from different angles

### For iOS Users (Safari):
1. Click "View in Your Space" button on a product with 3D models
2. AR Quick Look will launch
3. Point your camera at a flat surface
4. Tap to place the furniture model
5. Use gestures to rotate and scale

### Desktop/Web:
1. Use mouse to drag and rotate the 3D model
2. Scroll to zoom in/out
3. Use two fingers to pan (on trackpad)

## 📂 Project Structure

```
Furniture-AR-Project/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── ProductController.php    # Product CRUD operations
│   └── Models/
│       └── Product.php                  # Product model with AR methods
├── database/
│   └── migrations/
│       └── 2024_01_01_000001_create_products_table.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php           # Main layout
│       └── products/
│           ├── index.blade.php         # Product listing
│           ├── show.blade.php          # Product detail with AR viewer
│           ├── create.blade.php        # Create product form
│           └── edit.blade.php          # Edit product form
├── routes/
│   └── web.php                         # Application routes
├── public/
│   ├── uploads/
│   │   ├── images/                     # Product images
│   │   └── models/                     # 3D models (GLB/USDZ)
│   └── index.php
└── composer.json
```

## 🗄️ Database Schema

### Products Table
| Column      | Type         | Description                    |
|-------------|--------------|--------------------------------|
| id          | bigint       | Primary key                    |
| name        | varchar(255) | Product name                   |
| description | text         | Product description            |
| price       | decimal(10,2)| Product price                  |
| category    | varchar(255) | Product category               |
| image       | varchar(255) | Product image filename         |
| glb_model   | varchar(255) | GLB model filename (Web/Android)|
| usdz_model  | varchar(255) | USDZ model filename (iOS)      |
| ar_enabled  | boolean      | AR availability flag           |
| created_at  | timestamp    | Creation timestamp             |
| updated_at  | timestamp    | Last update timestamp          |

## 🎯 Usage Examples

### Creating a Product with AR Models

1. Navigate to "Add Product" page
2. Fill in product details (name, description, price, category)
3. Upload a product image (optional)
4. Upload GLB model for Android/Web AR
5. Upload USDZ model for iOS AR
6. Click "Create Product"

### Viewing Product in AR

1. Browse to a product detail page
2. If AR models are available, you'll see the 3D viewer
3. Click "View in Your Space (AR)" button
4. Follow on-screen instructions to place the furniture

## 🔧 Configuration

### File Upload Limits

Modify in `app/Http/Controllers/ProductController.php`:
- Images: Max 2MB (change in validation rules)
- 3D Models: Max 10MB (change in validation rules)

### Supported File Formats

- **Images**: JPEG, PNG, JPG, GIF
- **3D Models**: GLB, USDZ

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Author

**Nguyen Trung Nghia**

## 🙏 Acknowledgments

- [Google Model Viewer](https://modelviewer.dev/) for 3D model visualization
- [Laravel Framework](https://laravel.com/) for the backend
- [Bootstrap](https://getbootstrap.com/) for the UI components

## 📞 Support

For issues, questions, or contributions, please open an issue on GitHub.
