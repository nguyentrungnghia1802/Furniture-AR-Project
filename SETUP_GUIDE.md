# Setup Guide - Furniture AR Project

This guide will help you get started with the Furniture AR Project.

## Quick Start

### 1. Install Dependencies

```bash
composer install
```

### 2. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Database Configuration

Edit your `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=furniture_ar
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create the database:

```bash
mysql -u root -p -e "CREATE DATABASE furniture_ar CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 4. Run Migrations

```bash
php artisan migrate
```

### 5. Set Permissions

```bash
# Make sure upload directories are writable
chmod -R 755 public/uploads
chmod -R 755 storage
```

### 6. Start the Server

```bash
php artisan serve
```

Visit: `http://localhost:8000`

## Creating Your First Product with AR

### Step 1: Access Create Product Page

Navigate to `http://localhost:8000/products/create`

### Step 2: Fill Product Details

- **Name**: Modern Armchair
- **Description**: A comfortable and stylish modern armchair perfect for any living room
- **Price**: 499.99
- **Category**: Chair

### Step 3: Upload Files

**Product Image**: Upload a JPEG/PNG image of the furniture

**3D Models** (Required for AR):
- **GLB Model**: For Android and Web browsers
- **USDZ Model**: For iOS devices

### Step 4: View Product

After creating, you'll be redirected to the product detail page where you can:
- View the product information
- See the 3D model in the interactive viewer
- Click "View in Your Space (AR)" to launch AR mode

## Getting 3D Models

### Free 3D Model Resources

1. **Sketchfab** (https://sketchfab.com/)
   - Download models in GLB format
   - Many free furniture models available

2. **Poly Pizza** (https://poly.pizza/)
   - Free 3D models
   - Download as GLB

3. **TurboSquid** (https://www.turbosquid.com/)
   - Free and paid models
   - Various formats available

### Converting Models

If you have models in other formats (OBJ, FBX, etc.):

**GLB Conversion**:
- Use Blender (free): Import model → Export as GLB
- Online tools: https://www.vectary.com/ or https://products.aspose.app/3d/conversion

**USDZ Conversion** (for iOS):
- Use Apple's Reality Converter (macOS): https://developer.apple.com/augmented-reality/tools/
- Online tools: https://www.vectary.com/

## Testing AR Features

### On Android:
1. Open the product page on Chrome/Firefox
2. Tap "View in Your Space"
3. Grant camera permissions
4. Point at a flat surface
5. Tap to place the model

### On iOS (iPhone/iPad):
1. Open the product page in Safari
2. Tap "View in Your Space"
3. Grant camera permissions
4. Point at a flat surface
5. Tap to place the model

### On Desktop:
1. Open product page in Chrome/Firefox/Edge
2. Use mouse to rotate the 3D model
3. Scroll to zoom
4. View from all angles

## Database Schema

The `products` table includes these AR-specific fields:

```sql
glb_model    VARCHAR(255)  -- Filename for GLB model (Web/Android)
usdz_model   VARCHAR(255)  -- Filename for USDZ model (iOS)
ar_enabled   BOOLEAN       -- Automatically set when models exist
```

## File Upload Specifications

### Images
- **Supported formats**: JPEG, PNG, JPG, GIF
- **Maximum size**: 2MB
- **Storage**: `public/uploads/images/`

### 3D Models
- **GLB format**: For Android and web browsers
- **USDZ format**: For iOS devices
- **Maximum size**: 10MB each
- **Storage**: `public/uploads/models/`

## API Reference

### Routes

| Method | URL | Description |
|--------|-----|-------------|
| GET | `/products` | List all products |
| GET | `/products/create` | Show create form |
| POST | `/products` | Store new product |
| GET | `/products/{id}` | Show product detail with AR viewer |
| GET | `/products/{id}/edit` | Show edit form |
| PUT | `/products/{id}` | Update product |
| DELETE | `/products/{id}` | Delete product |

### Product Model Methods

```php
// Check if product has AR models
$product->hasArModels(); // Returns boolean

// Get full URLs for models
$product->getGlbModelUrl();  // Returns URL or null
$product->getUsdzModelUrl(); // Returns URL or null
```

## Troubleshooting

### AR Not Working?

1. **Check file formats**: GLB for Android/Web, USDZ for iOS
2. **Check file size**: Models should be under 10MB
3. **Check browser**: Use Chrome/Firefox on Android, Safari on iOS
4. **Check permissions**: Allow camera access
5. **Check surface**: AR needs a flat, well-lit surface

### Upload Errors?

1. **Check file permissions**: `chmod -R 755 public/uploads`
2. **Check PHP upload limits**: Edit `php.ini`:
   ```ini
   upload_max_filesize = 20M
   post_max_size = 20M
   ```
3. **Check storage space**: Ensure enough disk space

### Database Issues?

1. **Check credentials**: Verify `.env` database settings
2. **Run migrations**: `php artisan migrate`
3. **Check MySQL version**: Requires 5.7+

## Advanced Configuration

### Custom Upload Limits

Edit `app/Http/Controllers/ProductController.php`:

```php
// Change validation rules
'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',  // 5MB
'glb_model' => 'nullable|file|mimes:glb|max:20480',  // 20MB
```

### Custom Model Viewer Settings

Edit `resources/views/products/show.blade.php`:

```html
<model-viewer
    src="{{ $product->getGlbModelUrl() }}"
    camera-orbit="0deg 75deg 105%"  <!-- Custom camera position -->
    auto-rotate-delay="3000"        <!-- Delay before auto-rotate -->
    rotation-per-second="30deg"     <!-- Rotation speed -->
    ...
>
```

## Production Deployment

### Before Deploying:

1. **Set environment to production**:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Optimize configuration**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. **Set proper permissions**:
   ```bash
   chmod -R 755 storage
   chmod -R 755 public/uploads
   ```

4. **Use HTTPS**: AR features require secure context (HTTPS)

5. **Configure web server**: Set up Apache/Nginx to serve Laravel

## Support

For issues or questions:
1. Check the main README.md
2. Review error logs in `storage/logs/`
3. Open an issue on GitHub

## Next Steps

- Add user authentication
- Implement product categories with filtering
- Add shopping cart functionality
- Create admin panel for product management
- Add product ratings and reviews
- Implement search functionality
