# Examples and Screenshots

This file provides visual examples and descriptions of the Furniture AR Project features.

## Page Examples

### 1. Product Listing Page (index)

**URL**: `http://localhost:8000/products`

**Features**:
- Grid layout with product cards
- Product images and prices
- "AR Available" badge for products with 3D models
- Pagination for multiple products
- "Add New Product" button

**Sample View**:
```
┌─────────────────────────────────────────────────────────────┐
│  🪑 Furniture AR Store                      Products | Add   │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  Furniture Products                                           │
│  Browse our collection of furniture with AR visualization    │
│                                                               │
│  ┌─────────┐  ┌─────────┐  ┌─────────┐  ┌─────────┐       │
│  │ [Image] │  │ [Image] │  │ [Image] │  │ [Image] │       │
│  │ Sofa    │  │ Chair   │  │ Table   │  │ Shelf   │       │
│  │ $1299   │  │ $349    │  │ $899    │  │ $199    │       │
│  │ [View]  │  │ [View]  │  │ [View]  │  │ [View]  │       │
│  └─────────┘  └─────────┘  └─────────┘  └─────────┘       │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

### 2. Product Detail Page with AR Viewer (show)

**URL**: `http://localhost:8000/products/{id}`

**Features**:
- Product information (name, price, description, category)
- Interactive 3D model viewer
- AR button ("View in Your Space")
- Camera controls (rotate, zoom, pan)
- Auto-rotate feature
- Product image display
- Edit and Delete buttons

**Sample View**:
```
┌────────────────────────────────────────────────────────────────────┐
│  Products > Modern Armchair                                         │
├────────────────────────────────────────────────────────────────────┤
│                                                                      │
│  ┌──────────────────────────┐  ┌──────────────────────────────┐   │
│  │  Modern Armchair          │  │                               │   │
│  │  ✨ AR Available          │  │      ╔═══════════════╗       │   │
│  │                           │  │      ║   3D MODEL    ║       │   │
│  │  Category: Chair          │  │      ║   [ROTATING   ║       │   │
│  │  $499.99                  │  │      ║    CHAIR]     ║       │   │
│  │                           │  │      ║               ║       │   │
│  │  Description:             │  │      ╚═══════════════╝       │   │
│  │  A comfortable and        │  │                               │   │
│  │  stylish modern armchair  │  │  [ 📱 View in Your Space ]   │   │
│  │  perfect for any living   │  │                               │   │
│  │  room                     │  │  🎯 How to use AR:           │   │
│  │                           │  │  • Android: Scene Viewer     │   │
│  │  [Product Image]          │  │  • iOS: Quick Look           │   │
│  │                           │  │  • Desktop: 3D Viewer        │   │
│  │  [Edit] [Delete]          │  │                               │   │
│  └──────────────────────────┘  └──────────────────────────────┘   │
│                                                                      │
└────────────────────────────────────────────────────────────────────┘
```

### 3. Create Product Page (create)

**URL**: `http://localhost:8000/products/create`

**Features**:
- Form for product details
- Image upload
- GLB model upload (Web/Android)
- USDZ model upload (iOS)
- File format validation
- Helpful tips and instructions

**Sample View**:
```
┌─────────────────────────────────────────────────────────────┐
│  Create New Product                                          │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  Product Name *:                                             │
│  [_____________________]                                     │
│                                                               │
│  Description:                                                │
│  [_____________________]                                     │
│  [_____________________]                                     │
│                                                               │
│  Price ($) *:                                                │
│  [_____________________]                                     │
│                                                               │
│  Category:                                                   │
│  [_____________________]                                     │
│                                                               │
│  Product Image:                                              │
│  [Choose File] No file chosen                                │
│                                                               │
│  ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━   │
│  📱 AR 3D Models (Optional)                                  │
│                                                               │
│  GLB Model (Web/Android):                                    │
│  [Choose File] No file chosen                                │
│                                                               │
│  USDZ Model (iOS):                                           │
│  [Choose File] No file chosen                                │
│                                                               │
│  💡 Tip: Upload both GLB and USDZ files to support AR       │
│  on all devices.                                             │
│                                                               │
│  [Create Product] [Cancel]                                   │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

### 4. Edit Product Page (edit)

Similar to create page but shows:
- Current product values pre-filled
- Current images/models displayed
- Option to replace files
- "Update Product" button instead of "Create"

## AR Experience Flow

### On Android Devices:

```
1. User opens product page on Chrome/Firefox
   ↓
2. Sees 3D model viewer with furniture
   ↓
3. Taps "View in Your Space" button
   ↓
4. Scene Viewer launches with camera view
   ↓
5. User points camera at floor/surface
   ↓
6. White dots appear when surface detected
   ↓
7. User taps to place furniture model
   ↓
8. Model appears in real space at actual size
   ↓
9. User can rotate, move, scale the model
   ↓
10. User can take photos/screenshots
```

### On iOS Devices (Safari):

```
1. User opens product page in Safari
   ↓
2. Sees 3D model viewer with furniture
   ↓
3. Taps "View in Your Space" button
   ↓
4. AR Quick Look launches with camera view
   ↓
5. User points camera at floor/surface
   ↓
6. AR coaching overlay appears
   ↓
7. User taps to place furniture model
   ↓
8. Model appears in real space at actual size
   ↓
9. User can rotate, move the model
   ↓
10. User can take photos and share
```

### On Desktop:

```
1. User opens product page in browser
   ↓
2. Sees interactive 3D model viewer
   ↓
3. Can drag to rotate the model
   ↓
4. Scroll to zoom in/out
   ↓
5. Two-finger drag to pan
   ↓
6. Model auto-rotates when idle
   ↓
7. Can view from any angle
```

## Code Examples

### 1. Creating a Product (Controller)

```php
// ProductController.php - store method
public function store(Request $request)
{
    // Validate inputs
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'glb_model' => 'nullable|file|mimes:glb|max:10240',
        'usdz_model' => 'nullable|file|mimes:usdz|max:10240',
    ]);

    // Handle file uploads
    if ($request->hasFile('glb_model')) {
        $glbName = time() . '_' . $request->file('glb_model')->getClientOriginalName();
        $request->file('glb_model')->move(public_path('uploads/models'), $glbName);
        $productData['glb_model'] = $glbName;
    }

    // Create product
    $product = Product::create($productData);
    
    return redirect()->route('products.show', $product->id);
}
```

### 2. Displaying AR Viewer (Blade)

```html
<!-- show.blade.php -->
@if($product->hasArModels())
    <model-viewer
        src="{{ $product->getGlbModelUrl() }}"
        ios-src="{{ $product->getUsdzModelUrl() }}"
        alt="{{ $product->name }}"
        ar
        ar-modes="scene-viewer webxr quick-look"
        camera-controls
        auto-rotate
        shadow-intensity="1"
    >
        <button slot="ar-button" class="btn btn-primary">
            📱 View in Your Space (AR)
        </button>
    </model-viewer>
@endif
```

### 3. Product Model Helper

```php
// Product.php model
public function hasArModels(): bool
{
    return !empty($this->glb_model) || !empty($this->usdz_model);
}

public function getGlbModelUrl(): ?string
{
    return $this->glb_model ? asset('uploads/models/' . $this->glb_model) : null;
}
```

## Sample Data

### Example Products in Database:

| ID | Name | Price | Category | AR Models |
|----|------|-------|----------|-----------|
| 1 | Modern Leather Sofa | $1,299.99 | Sofa | ❌ |
| 2 | Ergonomic Office Chair | $349.99 | Chair | ✅ |
| 3 | Rustic Dining Table | $899.99 | Table | ✅ |
| 4 | Minimalist Bookshelf | $199.99 | Storage | ❌ |

To populate with sample data:
```bash
php artisan db:seed --class=ProductSeeder
```

## API Endpoints

| Method | Endpoint | Description | Response |
|--------|----------|-------------|----------|
| GET | `/products` | List all products | Product listing page |
| GET | `/products/create` | Show create form | Create product form |
| POST | `/products` | Store new product | Redirect to product detail |
| GET | `/products/{id}` | Show product detail | Product detail with AR |
| GET | `/products/{id}/edit` | Show edit form | Edit product form |
| PUT | `/products/{id}` | Update product | Redirect to product detail |
| DELETE | `/products/{id}` | Delete product | Redirect to product list |

## File Structure Example

```
public/uploads/
├── images/
│   ├── 1704123456_sofa.jpg
│   ├── 1704123789_chair.jpg
│   └── 1704124012_table.png
└── models/
    ├── 1704123456_sofa.glb
    ├── 1704123456_sofa.usdz
    ├── 1704123789_chair.glb
    ├── 1704123789_chair.usdz
    ├── 1704124012_table.glb
    └── 1704124012_table.usdz
```

## Testing Checklist

- [x] Create product without AR models
- [x] Create product with only GLB model
- [x] Create product with only USDZ model
- [x] Create product with both models
- [x] View product list page
- [x] View product detail page
- [x] Test 3D viewer controls (desktop)
- [x] Test AR on Android device
- [x] Test AR on iOS device
- [x] Edit product
- [x] Delete product
- [x] Upload large files (test limits)
- [x] Upload invalid file types (test validation)

## Performance Tips

1. **Optimize 3D Models**:
   - Keep under 5MB for best performance
   - Use compressed textures
   - Reduce polygon count

2. **Image Optimization**:
   - Compress images before upload
   - Use WebP format when possible
   - Consider lazy loading

3. **Caching**:
   - Enable browser caching for static assets
   - Use CDN for model-viewer library
   - Cache database queries

## Common Use Cases

### Use Case 1: Interior Designer
- Browse furniture catalog
- View items in 3D before purchasing
- Place in client's space using AR
- Take screenshots to share

### Use Case 2: Homeowner Shopping
- Compare furniture sizes in real space
- Check color/style match with room
- Visualize before buying
- Share AR views with family

### Use Case 3: Furniture Store Owner
- Add new products with 3D models
- Provide AR experience to customers
- Reduce returns by showing accurate size
- Differentiate from competitors

This comprehensive example documentation helps users understand the complete functionality and features of the Furniture AR Project.
