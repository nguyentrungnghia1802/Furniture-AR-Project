# AR Implementation Guide

This document explains how AR features are implemented in the Furniture AR Project.

## Overview

The project uses **Google's Model Viewer** web component to display 3D models and enable AR experiences across different platforms:

- **Android**: Scene Viewer
- **iOS**: AR Quick Look
- **Desktop**: Interactive 3D viewer

## Key Components

### 1. Database Structure

AR-specific fields in the `products` table:

```sql
glb_model VARCHAR(255) NULL     -- GLB file for Web/Android
usdz_model VARCHAR(255) NULL    -- USDZ file for iOS
ar_enabled BOOLEAN DEFAULT 0    -- Indicates AR availability
```

### 2. Product Model (app/Models/Product.php)

Helper methods for AR functionality:

```php
// Check if AR models are available
public function hasArModels(): bool
{
    return !empty($this->glb_model) || !empty($this->usdz_model);
}

// Get full URL for GLB model
public function getGlbModelUrl(): ?string
{
    return $this->glb_model ? asset('uploads/models/' . $this->glb_model) : null;
}

// Get full URL for USDZ model
public function getUsdzModelUrl(): ?string
{
    return $this->usdz_model ? asset('uploads/models/' . $this->usdz_model) : null;
}
```

### 3. File Upload (ProductController.php)

Handling 3D model uploads:

```php
// Upload GLB model
if ($request->hasFile('glb_model')) {
    $glbName = time() . '_' . $request->file('glb_model')->getClientOriginalName();
    $request->file('glb_model')->move(public_path('uploads/models'), $glbName);
    $productData['glb_model'] = $glbName;
}

// Upload USDZ model
if ($request->hasFile('usdz_model')) {
    $usdzName = time() . '_' . $request->file('usdz_model')->getClientOriginalName();
    $request->file('usdz_model')->move(public_path('uploads/models'), $usdzName);
    $productData['usdz_model'] = $usdzName;
}

// Set AR enabled if models exist
$productData['ar_enabled'] = !empty($productData['glb_model']) || !empty($productData['usdz_model']);
```

### 4. AR Viewer (show.blade.php)

The core AR implementation using Model Viewer:

```html
<!-- Load Model Viewer Library -->
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.3.0/model-viewer.min.js"></script>

<!-- Model Viewer Component -->
<model-viewer
    src="{{ $product->getGlbModelUrl() }}"              <!-- GLB for Android/Web -->
    @if($product->getUsdzModelUrl())
    ios-src="{{ $product->getUsdzModelUrl() }}"         <!-- USDZ for iOS -->
    @endif
    alt="{{ $product->name }}"
    ar                                                   <!-- Enable AR -->
    ar-modes="scene-viewer webxr quick-look"            <!-- AR platforms -->
    camera-controls                                      <!-- Enable camera controls -->
    auto-rotate                                          <!-- Auto-rotate model -->
    shadow-intensity="1"                                 <!-- Add shadow -->
    environment-image="neutral"                          <!-- Lighting -->
    poster="{{ $product->image ? asset('uploads/images/' . $product->image) : '' }}"
>
    <!-- AR Button -->
    <button slot="ar-button" class="btn btn-primary btn-lg w-100">
        📱 View in Your Space (AR)
    </button>
</model-viewer>
```

## AR Modes Explained

### Scene Viewer (Android)
- Launched automatically on Android devices
- Requires GLB model format
- Uses ARCore for surface detection
- Allows object placement, rotation, and scaling

### Quick Look (iOS)
- Launched automatically on iOS devices (Safari)
- Requires USDZ model format
- Uses ARKit for surface detection
- Supports object placement and interaction

### WebXR (Future)
- Experimental web-based AR
- Works in compatible browsers
- Uses GLB models

## Model Viewer Attributes

| Attribute | Description |
|-----------|-------------|
| `src` | URL to GLB model (required) |
| `ios-src` | URL to USDZ model for iOS |
| `ar` | Enables AR functionality |
| `ar-modes` | Specifies AR platforms: "scene-viewer" (Android), "quick-look" (iOS), "webxr" |
| `camera-controls` | Enables mouse/touch controls for 3D viewer |
| `auto-rotate` | Automatically rotates the model |
| `shadow-intensity` | Shadow strength (0-1) |
| `environment-image` | Lighting environment |
| `poster` | Image shown while model loads |

## File Format Requirements

### GLB (GL Transmission Format Binary)
- **Use for**: Android and web browsers
- **Supported by**: Scene Viewer, WebXR
- **Benefits**: 
  - Single file format (geometry + textures)
  - Widely supported
  - Optimized for web
- **Creation**: Export from Blender, 3ds Max, or online converters

### USDZ (Universal Scene Description)
- **Use for**: iOS devices
- **Supported by**: AR Quick Look
- **Benefits**:
  - Native iOS format
  - Optimized for Apple devices
  - High quality rendering
- **Creation**: Reality Converter (macOS), online converters

## Best Practices

### 1. Model Optimization
```
- Keep file size under 5MB for better performance
- Use compressed textures (1024x1024 or smaller)
- Reduce polygon count (aim for <50k triangons)
- Remove unnecessary materials and objects
```

### 2. Model Scale
```
- Use real-world dimensions
- Center the model at origin (0,0,0)
- Align to ground plane
- Test scale on actual devices
```

### 3. Textures
```
- Use PBR (Physically Based Rendering) materials
- Include: Base Color, Normal, Metallic, Roughness
- Compress textures appropriately
- Embed textures in GLB file
```

### 4. Testing
```
- Test on actual Android device (ARCore support required)
- Test on actual iOS device (iPhone 6s+ with iOS 12+)
- Verify model loads correctly in desktop viewer
- Check file sizes and load times
```

## JavaScript Events

Monitor AR status with JavaScript:

```javascript
const modelViewer = document.querySelector('model-viewer');

// Model loaded
modelViewer.addEventListener('load', () => {
    console.log('3D Model loaded successfully');
});

// Error loading
modelViewer.addEventListener('error', (event) => {
    console.error('Error loading 3D model:', event);
    alert('Failed to load 3D model');
});

// AR session started
modelViewer.addEventListener('ar-status', (event) => {
    if (event.detail.status === 'session-started') {
        console.log('AR session started');
    }
});
```

## Browser Compatibility

| Feature | Chrome | Safari | Firefox | Edge |
|---------|--------|--------|---------|------|
| 3D Viewer | ✅ | ✅ | ✅ | ✅ |
| Scene Viewer (Android) | ✅ | ❌ | ✅ | ✅ |
| Quick Look (iOS) | ❌ | ✅ | ❌ | ❌ |
| WebXR | 🔶 Experimental | ❌ | 🔶 Experimental | 🔶 Experimental |

## Device Requirements

### Android
- **OS**: Android 7.0+
- **ARCore**: Must be supported and installed
- **Browser**: Chrome, Firefox, Samsung Internet
- **Camera**: Required for AR

### iOS
- **Device**: iPhone 6s or newer, iPad Pro, iPad (5th gen+)
- **OS**: iOS 12+
- **Browser**: Safari (required)
- **Camera**: Required for AR

## Troubleshooting

### AR Button Not Showing?
1. Check if both GLB and USDZ models are uploaded
2. Verify `ar` attribute is present on model-viewer
3. Ensure HTTPS (AR requires secure context in production)

### Model Not Loading?
1. Check file format (GLB/USDZ)
2. Verify file path is correct
3. Check browser console for errors
4. Ensure file size is reasonable (<10MB)

### AR Not Launching?
1. Verify device supports AR (ARCore/ARKit)
2. Check browser compatibility
3. Grant camera permissions
4. Ensure good lighting conditions

## Advanced Customization

### Custom Camera Position
```html
<model-viewer
    camera-orbit="0deg 75deg 105%"
    camera-target="0m 0m 0m"
    field-of-view="30deg"
    min-camera-orbit="auto auto 2m"
    max-camera-orbit="auto auto 10m"
>
```

### Animation Support
```html
<model-viewer
    src="model.glb"
    animation-name="Walk"
    autoplay
>
```

### Custom AR Placement
```html
<model-viewer
    ar-placement="floor"  <!-- or "wall" -->
    ar-scale="auto"       <!-- or "fixed" -->
>
```

## Resources

- **Model Viewer Documentation**: https://modelviewer.dev/
- **Sketchfab (Free Models)**: https://sketchfab.com/
- **GLB Optimization**: https://gltf.report/
- **Reality Converter (USDZ)**: https://developer.apple.com/augmented-reality/tools/
- **ARCore Supported Devices**: https://developers.google.com/ar/devices
- **ARKit Requirements**: https://developer.apple.com/arkit/

## Example Implementation Flow

```
1. User creates product
   ↓
2. Uploads GLB + USDZ models
   ↓
3. Files saved to public/uploads/models/
   ↓
4. Database updated with filenames
   ↓
5. Product page displays model-viewer
   ↓
6. User clicks "View in Your Space"
   ↓
7. Platform detected (Android/iOS)
   ↓
8. Appropriate AR mode launched
   ↓
9. User places furniture in real space
```

## Security Considerations

1. **File Validation**: Validate file types and sizes
2. **File Names**: Sanitize uploaded file names
3. **Storage**: Store files outside web root when possible
4. **MIME Types**: Verify MIME types on upload
5. **User Permissions**: Implement proper access controls

## Performance Optimization

1. **Lazy Loading**: Load models only when needed
2. **Compression**: Compress 3D models (Draco compression)
3. **CDN**: Use CDN for model-viewer library
4. **Caching**: Enable browser caching for models
5. **Progressive Loading**: Show low-res version first

This implementation provides a complete AR furniture visualization solution compatible with both Android and iOS devices, with fallback to interactive 3D viewing on desktop browsers.
