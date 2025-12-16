# 🎄 Christmas Tree 3D Module

Interactive 3D Christmas Tree experience built with Three.js for Luna Furniture AR Project.

## 🌟 Features

- ✨ **Fully Interactive 3D Christmas Tree** with realistic ornaments and lights
- 🎨 **Beautiful Animations**: Auto-rotation, pulsing lights, falling snow
- 🎮 **Intuitive Controls**: Drag to rotate, scroll to zoom, right-click to pan
- 📸 **Screenshot Capability**: Capture your favorite angle
- 🎄 **Festive Atmosphere**: Decorations, presents, star on top
- 📱 **Fully Responsive**: Works on desktop, tablet, and mobile
- ⚡ **Optimized Performance**: Smooth 60fps animations

## 📂 Structure

```
christmas-tree/
├── index.html           # Main HTML file (standalone viewer)
├── README.md           # This file
├── js/
│   └── christmas-tree-3d.js  # Core Three.js implementation
├── css/
│   └── (custom styles if needed)
├── models/
│   └── (3D model files - GLB/GLTF format)
├── textures/
│   └── (texture images for materials)
└── photos/
    ├── backgrounds/    # Background images
    ├── decorations/    # Ornament textures
    ├── effects/        # Visual effects
    └── ui/            # UI elements
```

## 🚀 Usage

### As Standalone Page

Access directly via browser:
```
http://your-domain.com/christmas-tree/index.html
```

### Embedded in Laravel Blade

```blade
<x-christmas-tree-icon />
```

The component will show a small icon in the bottom-left corner. Click to open the full 3D experience.

## 🎮 Controls

| Action | Desktop | Mobile |
|--------|---------|---------|
| **Rotate** | Left Click + Drag | One Finger Drag |
| **Zoom** | Mouse Wheel | Pinch |
| **Pan** | Right Click + Drag | Two Finger Drag |
| **Reset** | Click Reset Button | Click Reset Button |
| **Auto-Rotate** | Click Rotate Button | Click Rotate Button |
| **Screenshot** | Click Camera Button | Click Camera Button |

## 🔧 Technical Details

### Dependencies

- **Three.js v0.169.0** - 3D graphics library
- **OrbitControls** - Camera controls
- **No external frameworks** - Pure JavaScript (ES6+)

### Browser Support

- ✅ Chrome 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+

### Performance

- **Target FPS**: 60fps
- **Polygon Count**: ~5,000 triangles
- **Texture Memory**: ~10MB
- **Load Time**: < 2 seconds

## 🎨 Customization

### Adding Custom Ornaments

Edit `christmas-tree-3d.js`:

```javascript
createOrnaments(treeGroup) {
    const ornamentPositions = [
        { x: 1.5, y: 3, z: 0, color: 0xff0000 },
        // Add more positions here
    ];
}
```

### Changing Colors

```javascript
// Tree color
const treeMaterial = new THREE.MeshStandardMaterial({ 
    color: 0x0d5c0d  // Change this hex color
});
```

### Adding Custom Textures

Place images in `/textures/` and load:

```javascript
const textureLoader = new THREE.TextureLoader();
const texture = textureLoader.load('/christmas-tree/textures/your-texture.png');
```

## 📸 Adding Photos

Place your Christmas photos in the appropriate folder:

```
photos/
├── backgrounds/     # Winter scenes, snow landscapes
├── decorations/     # Ornament textures, ribbon patterns
├── effects/         # Sparkle effects, light flares
└── ui/             # Button icons, logos
```

## 🐛 Troubleshooting

### Issue: Black screen or not loading

**Solution**: Check browser console for errors. Ensure Three.js CDN is accessible.

### Issue: Low performance

**Solution**: 
- Reduce `snowCount` in `createSnowEffect()`
- Disable shadows: `renderer.shadowMap.enabled = false`
- Lower `pixelRatio`: `renderer.setPixelRatio(1)`

### Issue: Controls not working

**Solution**: Check if `OrbitControls` is loaded correctly from CDN.

## 📝 Credits

- **Built with**: Three.js
- **Part of**: Luna Furniture AR Project
- **Christmas 2025 Special Feature**
- **Developer**: Luna Development Team

## 📄 License

Part of Luna Furniture AR Project - Internal Use Only

---

**Merry Christmas! 🎄🎅✨**

For support, contact the development team.
