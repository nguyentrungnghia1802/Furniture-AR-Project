/**
 * Christmas Tree 3D Interactive Experience
 * Built with Three.js - Pure JavaScript Implementation
 * Optimized for Luna Furniture AR Project
 */

import * as THREE from 'three';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';

class ChristmasTree3D {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.scene = null;
        this.camera = null;
        this.renderer = null;
        this.controls = null;
        this.christmasTree = null;
        this.ornaments = [];
        this.lights = [];
        this.snowflakes = [];
        this.isPlaying = true;
        
        this.init();
        this.createLights();
        this.createChristmasTree();
        this.createSnowEffect();
        this.createAmbience();
        this.animate();
        this.setupEventListeners();
    }

    init() {
        // Scene
        this.scene = new THREE.Scene();
        this.scene.background = new THREE.Color(0x0a1628);
        this.scene.fog = new THREE.Fog(0x0a1628, 10, 50);

        // Camera
        this.camera = new THREE.PerspectiveCamera(
            75,
            this.container.clientWidth / this.container.clientHeight,
            0.1,
            1000
        );
        this.camera.position.set(0, 5, 15);

        // Renderer
        this.renderer = new THREE.WebGLRenderer({ 
            antialias: true,
            alpha: true 
        });
        this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
        this.renderer.setPixelRatio(window.devicePixelRatio);
        this.renderer.shadowMap.enabled = true;
        this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        this.renderer.toneMapping = THREE.ACESFilmicToneMapping;
        this.renderer.toneMappingExposure = 1.2;
        this.container.appendChild(this.renderer.domElement);

        // Controls
        this.controls = new OrbitControls(this.camera, this.renderer.domElement);
        this.controls.enableDamping = true;
        this.controls.dampingFactor = 0.05;
        this.controls.minDistance = 5;
        this.controls.maxDistance = 30;
        this.controls.maxPolarAngle = Math.PI / 2;
        this.controls.autoRotate = true;
        this.controls.autoRotateSpeed = 0.5;

        // Ground
        const groundGeometry = new THREE.CircleGeometry(20, 32);
        const groundMaterial = new THREE.MeshStandardMaterial({ 
            color: 0xffffff,
            roughness: 0.8,
            metalness: 0.2
        });
        const ground = new THREE.Mesh(groundGeometry, groundMaterial);
        ground.rotation.x = -Math.PI / 2;
        ground.receiveShadow = true;
        this.scene.add(ground);
    }

    createLights() {
        // Ambient Light
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.4);
        this.scene.add(ambientLight);

        // Main Directional Light
        const mainLight = new THREE.DirectionalLight(0xffffff, 1);
        mainLight.position.set(5, 10, 5);
        mainLight.castShadow = true;
        mainLight.shadow.mapSize.width = 2048;
        mainLight.shadow.mapSize.height = 2048;
        mainLight.shadow.camera.near = 0.5;
        mainLight.shadow.camera.far = 50;
        this.scene.add(mainLight);

        // Colored spot lights for festive mood
        const colors = [0xff0000, 0x00ff00, 0x0000ff, 0xffff00];
        colors.forEach((color, i) => {
            const spotLight = new THREE.SpotLight(color, 0.5);
            const angle = (i / colors.length) * Math.PI * 2;
            spotLight.position.set(
                Math.cos(angle) * 10,
                8,
                Math.sin(angle) * 10
            );
            spotLight.angle = Math.PI / 6;
            spotLight.penumbra = 0.3;
            this.scene.add(spotLight);
            this.lights.push(spotLight);
        });
    }

    createChristmasTree() {
        const treeGroup = new THREE.Group();

        // Tree trunk
        const trunkGeometry = new THREE.CylinderGeometry(0.3, 0.4, 2, 8);
        const trunkMaterial = new THREE.MeshStandardMaterial({ 
            color: 0x4a2511,
            roughness: 0.9
        });
        const trunk = new THREE.Mesh(trunkGeometry, trunkMaterial);
        trunk.position.y = 1;
        trunk.castShadow = true;
        treeGroup.add(trunk);

        // Tree layers (cones)
        const layers = [
            { radius: 2.5, height: 3, y: 3.5 },
            { radius: 2, height: 2.5, y: 5.5 },
            { radius: 1.5, height: 2, y: 7 },
            { radius: 1, height: 1.5, y: 8.5 }
        ];

        layers.forEach(layer => {
            const geometry = new THREE.ConeGeometry(layer.radius, layer.height, 8);
            const material = new THREE.MeshStandardMaterial({ 
                color: 0x0d5c0d,
                roughness: 0.7,
                metalness: 0.1
            });
            const cone = new THREE.Mesh(geometry, material);
            cone.position.y = layer.y;
            cone.castShadow = true;
            cone.receiveShadow = true;
            treeGroup.add(cone);
        });

        // Star on top
        const starGeometry = new THREE.SphereGeometry(0.3, 5, 5);
        const starMaterial = new THREE.MeshStandardMaterial({ 
            color: 0xffd700,
            emissive: 0xffd700,
            emissiveIntensity: 0.8,
            roughness: 0.3,
            metalness: 0.7
        });
        const star = new THREE.Mesh(starGeometry, starMaterial);
        star.position.y = 10;
        treeGroup.add(star);

        // Add glow to star
        const starLight = new THREE.PointLight(0xffd700, 2, 5);
        starLight.position.copy(star.position);
        treeGroup.add(starLight);

        // Ornaments
        this.createOrnaments(treeGroup);

        // Lights on tree
        this.createTreeLights(treeGroup);

        this.christmasTree = treeGroup;
        this.scene.add(treeGroup);
    }

    createOrnaments(treeGroup) {
        const ornamentPositions = [
            { x: 1.5, y: 3, z: 0, color: 0xff0000 },
            { x: -1.5, y: 3, z: 0, color: 0x0000ff },
            { x: 0, y: 3.5, z: 1.5, color: 0xffd700 },
            { x: 1, y: 5, z: 1, color: 0xff00ff },
            { x: -1, y: 5, z: -1, color: 0x00ffff },
            { x: 0.8, y: 6.5, z: 0, color: 0xff0000 },
            { x: -0.8, y: 6.5, z: 0, color: 0x0000ff },
            { x: 0, y: 7.5, z: 0.5, color: 0xffd700 }
        ];

        ornamentPositions.forEach(pos => {
            const geometry = new THREE.SphereGeometry(0.15, 16, 16);
            const material = new THREE.MeshStandardMaterial({ 
                color: pos.color,
                roughness: 0.2,
                metalness: 0.8,
                emissive: pos.color,
                emissiveIntensity: 0.3
            });
            const ornament = new THREE.Mesh(geometry, material);
            ornament.position.set(pos.x, pos.y, pos.z);
            ornament.castShadow = true;
            treeGroup.add(ornament);
            this.ornaments.push(ornament);
        });
    }

    createTreeLights(treeGroup) {
        const lightPositions = [
            { x: 1, y: 4, z: 1 },
            { x: -1, y: 4, z: -1 },
            { x: 0.5, y: 5.5, z: -0.5 },
            { x: -0.5, y: 5.5, z: 0.5 },
            { x: 0.7, y: 7, z: 0 },
            { x: -0.7, y: 7, z: 0 }
        ];

        const colors = [0xff0000, 0x00ff00, 0x0000ff, 0xffff00, 0xff00ff, 0x00ffff];

        lightPositions.forEach((pos, i) => {
            const light = new THREE.PointLight(colors[i % colors.length], 1, 3);
            light.position.set(pos.x, pos.y, pos.z);
            treeGroup.add(light);
            this.lights.push(light);
        });
    }

    createSnowEffect() {
        const snowGeometry = new THREE.BufferGeometry();
        const snowCount = 1000;
        const positions = new Float32Array(snowCount * 3);

        for (let i = 0; i < snowCount * 3; i += 3) {
            positions[i] = (Math.random() - 0.5) * 40;
            positions[i + 1] = Math.random() * 20;
            positions[i + 2] = (Math.random() - 0.5) * 40;
        }

        snowGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));

        const snowMaterial = new THREE.PointsMaterial({
            color: 0xffffff,
            size: 0.1,
            transparent: true,
            opacity: 0.8
        });

        this.snowflakes = new THREE.Points(snowGeometry, snowMaterial);
        this.scene.add(this.snowflakes);
    }

    createAmbience() {
        // Add some presents under the tree
        const presentColors = [0xff0000, 0x00ff00, 0x0000ff, 0xffd700];
        const presentPositions = [
            { x: 2, z: 2 },
            { x: -2, z: 2 },
            { x: 2, z: -2 },
            { x: -2, z: -2 }
        ];

        presentPositions.forEach((pos, i) => {
            const size = 0.5 + Math.random() * 0.5;
            const geometry = new THREE.BoxGeometry(size, size, size);
            const material = new THREE.MeshStandardMaterial({ 
                color: presentColors[i],
                roughness: 0.6,
                metalness: 0.2
            });
            const present = new THREE.Mesh(geometry, material);
            present.position.set(pos.x, size / 2, pos.z);
            present.castShadow = true;
            present.receiveShadow = true;
            this.scene.add(present);
        });
    }

    animate() {
        if (!this.isPlaying) return;

        requestAnimationFrame(() => this.animate());

        const time = Date.now() * 0.001;

        // Rotate tree slowly
        if (this.christmasTree) {
            this.christmasTree.rotation.y += 0.002;
        }

        // Animate ornaments (slight bobbing)
        this.ornaments.forEach((ornament, i) => {
            ornament.position.y += Math.sin(time * 2 + i) * 0.001;
        });

        // Animate lights (pulsing)
        this.lights.forEach((light, i) => {
            light.intensity = 0.5 + Math.sin(time * 3 + i) * 0.3;
        });

        // Animate snow falling
        if (this.snowflakes) {
            const positions = this.snowflakes.geometry.attributes.position.array;
            for (let i = 1; i < positions.length; i += 3) {
                positions[i] -= 0.02;
                if (positions[i] < 0) {
                    positions[i] = 20;
                }
            }
            this.snowflakes.geometry.attributes.position.needsUpdate = true;
        }

        this.controls.update();
        this.renderer.render(this.scene, this.camera);
    }

    setupEventListeners() {
        // Handle window resize
        window.addEventListener('resize', () => {
            if (!this.container) return;
            
            this.camera.aspect = this.container.clientWidth / this.container.clientHeight;
            this.camera.updateProjectionMatrix();
            this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
        });
    }

    dispose() {
        this.isPlaying = false;
        
        // Clean up
        if (this.renderer) {
            this.renderer.dispose();
        }
        
        if (this.controls) {
            this.controls.dispose();
        }

        // Remove all objects from scene
        while(this.scene.children.length > 0) { 
            this.scene.remove(this.scene.children[0]); 
        }

        console.log('🎄 Christmas Tree 3D disposed');
    }
}

// Export for use
export { ChristmasTree3D };

console.log('🎄 Christmas Tree 3D module loaded successfully!');
