# Christmas Tree 3D - Asset Storage

This folder contains all assets for the Christmas Tree 3D experience.

## 📁 Structure

```
photos/
├── backgrounds/      # Background images
├── decorations/      # Ornament and decoration textures
├── effects/          # Visual effects (snow, sparkles)
└── ui/              # UI elements and icons
```

## 📷 Recommended Image Formats

- **Photos**: JPG, PNG (1920x1080 or higher)
- **Textures**: PNG with transparency
- **Icons**: SVG (preferred) or PNG

## 💾 File Naming Convention

Use descriptive names with lowercase and hyphens:
- ✅ `christmas-ornament-red.png`
- ✅ `snow-texture-seamless.jpg`
- ✅ `tree-background-winter.jpg`
- ❌ `IMG_1234.jpg`
- ❌ `photo 1.PNG`

## 🎨 Usage in Code

Images can be referenced in the Christmas Tree 3D code:

```javascript
const texture = new THREE.TextureLoader().load('/christmas-tree/photos/decorations/ornament.png');
```

## 📝 Notes

- Keep file sizes optimized (< 2MB per image)
- Use WebP format for better compression when possible
- Include both @1x and @2x versions for high-DPI displays

---

**Last Updated**: December 16, 2025
**Part of**: Luna Furniture AR Project - Christmas 2025 Special Feature
