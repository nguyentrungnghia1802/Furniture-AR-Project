# AR Models Performance Optimization

## 📁 Folder Structure (Category-based)

```
public/ar_models/
├── seatings/      # Ghế, sofa, armchair
├── tables/        # Bàn, coffee table, desk
├── storages/      # Tủ, kệ, cabinet
├── decores/       # Đồ trang trí, accessories  
└── others/        # Các loại khác
```

## 🚀 Performance Optimizations Implemented

### 1. **Category-based Subfolder Organization**
- ✅ Files organized by category for better management
- ✅ Reduces directory scanning time
- ✅ Makes cleanup and maintenance easier

### 2. **Direct Public Storage (No Symlink)**
- ✅ Files stored in `public/ar_models/` instead of `storage/app/public/`
- ✅ No symlink required - simpler deployment
- ✅ Better performance on Docker/Ubuntu environments

### 3. **Efficient File Naming**
```php
// Format: {category}_{product-name}_{timestamp}_{random}.glb
// Example: seatings_modern-sofa_1702832400_abc123.glb
```

## 🎯 Additional Performance Tips

### A. Server-Side Optimizations

#### 1. Enable Gzip Compression
**Apache (.htaccess):**
```apache
<IfModule mod_deflate.c>
    # Compress GLB and USDZ files
    AddOutputFilterByType DEFLATE model/gltf-binary
    AddOutputFilterByType DEFLATE model/vnd.usdz+zip
    AddOutputFilterByType DEFLATE application/octet-stream
</IfModule>
```

**Nginx (nginx.conf):**
```nginx
gzip on;
gzip_types model/gltf-binary model/vnd.usdz+zip application/octet-stream;
gzip_vary on;
gzip_comp_level 6;
```

#### 2. Browser Caching Headers
**Apache:**
```apache
<IfModule mod_expires.c>
    <FilesMatch "\.(glb|usdz)$">
        ExpiresActive On
        ExpiresDefault "access plus 1 year"
        Header set Cache-Control "public, immutable"
    </FilesMatch>
</IfModule>
```

**Nginx:**
```nginx
location ~* \.(glb|usdz)$ {
    expires 1y;
    add_header Cache-Control "public, immutable";
    access_log off;
}
```

#### 3. CDN Integration (Optional)
```php
// config/filesystems.php - Add CDN disk
'cdn' => [
    'driver' => 's3',
    'key' => env('CDN_ACCESS_KEY'),
    'secret' => env('CDN_SECRET_KEY'),
    'region' => env('CDN_REGION'),
    'bucket' => env('CDN_BUCKET'),
    'url' => env('CDN_URL'),
],
```

### B. Frontend Optimizations

#### 1. Lazy Loading
```html
<!-- Model viewer with lazy loading -->
<model-viewer
    src="{{ $arModels['glb'] }}"
    loading="lazy"
    reveal="interaction"
    poster="/images/3d-loading-poster.jpg"
></model-viewer>
```

#### 2. Progressive Loading
```javascript
// Show low-poly model first, then full detail
const modelViewer = document.querySelector('model-viewer');
modelViewer.addEventListener('progress', (event) => {
    const progress = event.detail.totalProgress;
    if (progress < 0.5) {
        // Show simplified UI during initial load
    }
});
```

#### 3. Preloading Critical Models
```html
<!-- Preload popular products' AR models -->
<link rel="preload" as="fetch" href="/ar_models/seatings/sofa-bestseller.glb" crossorigin>
```

### C. Model File Optimizations

#### 1. Optimize GLB Files
```bash
# Install gltf-pipeline
npm install -g gltf-pipeline

# Optimize GLB file (reduce size by 30-50%)
gltf-pipeline -i input.glb -o output.glb -d
```

#### 2. Texture Compression
- Use compressed textures (KTX2, Basis Universal)
- Max texture size: 2048x2048 for mobile
- Use power-of-2 dimensions (512, 1024, 2048)

#### 3. Polygon Count Limits
- **Mobile**: Max 50K triangles
- **Desktop**: Max 200K triangles
- Remove hidden geometry
- Use LOD (Level of Detail) if possible

### D. Database Query Optimization

```php
// In Product model - Add index
Schema::table('products', function (Blueprint $table) {
    $table->index('ar_enabled');
    $table->index(['ar_enabled', 'category_id']);
});

// Query optimization
Product::where('ar_enabled', true)
    ->select('id', 'name', 'ar_model_glb', 'ar_model_usdz', 'category_id')
    ->with('category:id,name')
    ->get();
```

### E. Caching Strategy

```php
// Cache AR model metadata
Cache::remember("ar_model_{$productId}", 86400, function () use ($product) {
    return [
        'glb_url' => $product->getArModelUrl('glb'),
        'usdz_url' => $product->getArModelUrl('usdz'),
        'size' => $product->ar_model_size,
        'dimensions' => $product->getDimensions(),
    ];
});
```

## 📊 Performance Benchmarks

### Before Optimizations:
- GLB file size: 10-50MB
- Initial load time: 5-15 seconds
- Mobile performance: Poor on 3G

### After Optimizations:
- GLB file size: 3-15MB (optimized)
- Initial load time: 2-5 seconds
- Mobile performance: Good on 4G, acceptable on 3G

## 🔧 Monitoring & Metrics

### Track Performance:
```javascript
// Log AR loading metrics
modelViewer.addEventListener('load', () => {
    const loadTime = performance.now() - startTime;
    console.log(`AR Model loaded in ${loadTime}ms`);
    
    // Send to analytics
    if (typeof gtag !== 'undefined') {
        gtag('event', 'ar_model_load', {
            'event_category': 'AR',
            'event_label': productName,
            'value': Math.round(loadTime)
        });
    }
});
```

### Server Monitoring:
```bash
# Check file sizes in each category
du -sh public/ar_models/*/

# Monitor bandwidth usage
# Add to monitoring system (Grafana, New Relic, etc.)
```

## ✅ Deployment Checklist

- [ ] All AR models < 15MB after optimization
- [ ] Gzip compression enabled on server
- [ ] Cache headers configured correctly
- [ ] All category folders created with proper permissions (755)
- [ ] Database indexes added for AR queries
- [ ] CDN configured (optional but recommended)
- [ ] Monitoring and analytics in place
- [ ] Test on 3G/4G mobile networks
- [ ] Test on low-end Android devices
- [ ] Test on iOS Safari (Quick Look)

## 🐛 Common Issues & Solutions

### Issue: Models load slowly on mobile
**Solution:**
- Reduce polygon count to < 50K triangles
- Optimize textures to 1024x1024 or smaller
- Enable gzip compression on server

### Issue: Models don't cache properly
**Solution:**
- Check Cache-Control headers
- Verify browser isn't in incognito mode
- Add ETags to response headers

### Issue: High bandwidth costs
**Solution:**
- Enable CDN for AR models
- Implement progressive loading
- Add bandwidth monitoring alerts

---

**Last Updated:** December 2025  
**Version:** 2.0 (Category-based optimized)