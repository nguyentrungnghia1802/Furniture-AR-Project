/**
 * AR Model Viewer Component
 * Handles AR/3D model viewing functionality for furniture products
 * Supports both WebXR (Android) and QuickLook (iOS) AR viewing
 */

class ArViewer {
    constructor(modelViewerElement) {
        this.modelViewer = modelViewerElement;
        this.isArSupported = false;
        this.isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
        this.isAndroid = /Android/.test(navigator.userAgent);
        
        this.init();
    }

    /**
     * Initialize AR viewer with capability detection
     */
    async init() {
        await this.checkArSupport();
        this.setupEventListeners();
        this.updateArButton();
    }

    /**
     * Check if AR is supported on current device
     */
    async checkArSupport() {
        if (this.modelViewer) {
            try {
                // Check WebXR support (Android)
                if ('xr' in navigator) {
                    const isSupported = await navigator.xr.isSessionSupported('immersive-ar');
                    this.isArSupported = isSupported;
                } 
                // Check QuickLook support (iOS)
                else if (this.isIOS) {
                    this.isArSupported = true; // iOS Safari supports QuickLook
                }
            } catch (error) {
                console.log('AR capability check failed:', error);
                this.isArSupported = false;
            }
        }
    }

    /**
     * Setup event listeners for AR interactions
     */
    setupEventListeners() {
        if (!this.modelViewer) return;

        // AR session events
        this.modelViewer.addEventListener('ar-status', (event) => {
            this.handleArStatusChange(event.detail.status);
        });

        // Model loading events
        this.modelViewer.addEventListener('load', () => {
            this.onModelLoaded();
        });

        this.modelViewer.addEventListener('error', (error) => {
            this.onModelError(error);
        });

        // Progress tracking
        this.modelViewer.addEventListener('progress', (event) => {
            this.updateLoadingProgress(event.detail.totalProgress);
        });
    }

    /**
     * Handle AR session status changes
     */
    handleArStatusChange(status) {
        const arButton = document.getElementById('ar-button');
        const statusIndicator = document.getElementById('ar-status');

        switch (status) {
            case 'not-presenting':
                this.updateArButtonText('View in AR');
                if (statusIndicator) statusIndicator.textContent = 'AR Ready';
                break;
            case 'session-started':
                this.updateArButtonText('Exit AR');
                if (statusIndicator) statusIndicator.textContent = 'AR Active';
                this.trackArUsage('ar_session_started');
                break;
            case 'object-placed':
                if (statusIndicator) statusIndicator.textContent = 'Object Placed';
                this.trackArUsage('ar_object_placed');
                break;
            case 'failed':
                this.updateArButtonText('AR Unavailable');
                if (statusIndicator) statusIndicator.textContent = 'AR Failed';
                break;
        }
    }

    /**
     * Update AR button text and state
     */
    updateArButtonText(text) {
        const arButton = document.getElementById('ar-button');
        if (arButton) {
            arButton.textContent = text;
        }
    }

    /**
     * Update AR button visibility based on support
     */
    updateArButton() {
        const arButton = document.getElementById('ar-button');
        const arContainer = document.getElementById('ar-container');

        if (arButton && arContainer) {
            if (this.isArSupported) {
                arContainer.style.display = 'block';
                arButton.disabled = false;
                arButton.classList.remove('opacity-50');
            } else {
                arContainer.style.display = 'none';
            }
        }
    }

    /**
     * Handle successful model loading
     */
    onModelLoaded() {
        const loadingIndicator = document.getElementById('model-loading');
        if (loadingIndicator) {
            loadingIndicator.style.display = 'none';
        }

        // Enable controls
        this.modelViewer.cameraControls = true;
        this.trackArUsage('model_loaded');
    }

    /**
     * Handle model loading errors
     */
    onModelError(error) {
        console.error('Model loading error:', error);
        const errorIndicator = document.getElementById('model-error');
        if (errorIndicator) {
            errorIndicator.style.display = 'block';
            errorIndicator.textContent = 'Failed to load 3D model';
        }
        this.trackArUsage('model_error');
    }

    /**
     * Update loading progress
     */
    updateLoadingProgress(progress) {
        const progressBar = document.getElementById('loading-progress');
        if (progressBar) {
            progressBar.style.width = `${progress * 100}%`;
        }
    }

    /**
     * Track AR usage for analytics
     */
    trackArUsage(action) {
        // Send usage data to server
        fetch('/api/track-ar-usage', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                action: action,
                product_id: this.modelViewer.dataset.productId,
                timestamp: new Date().toISOString()
            })
        }).catch(error => console.log('Analytics tracking failed:', error));
    }

    /**
     * Trigger AR mode manually
     */
    activateAr() {
        if (this.modelViewer && this.isArSupported) {
            this.modelViewer.activateAR();
        }
    }

    /**
     * Reset camera position
     */
    resetCamera() {
        if (this.modelViewer) {
            this.modelViewer.resetTurntableRotation();
            this.modelViewer.jumpCameraToGoal();
        }
    }

    /**
     * Take screenshot of current 3D view
     */
    async takeScreenshot() {
        if (this.modelViewer) {
            try {
                const screenshot = await this.modelViewer.toBlob({
                    idealAspect: true,
                    mimeType: 'image/png'
                });
                
                // Create download link
                const url = URL.createObjectURL(screenshot);
                const link = document.createElement('a');
                link.href = url;
                link.download = `${this.modelViewer.dataset.productName || 'product'}-3d-view.png`;
                link.click();
                
                URL.revokeObjectURL(url);
                this.trackArUsage('screenshot_taken');
            } catch (error) {
                console.error('Screenshot failed:', error);
            }
        }
    }
}

/**
 * Global AR functionality initialization
 */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AR viewers on page
    const modelViewers = document.querySelectorAll('model-viewer[ar]');
    const arViewers = [];

    modelViewers.forEach((viewer, index) => {
        const arViewer = new ArViewer(viewer);
        arViewers.push(arViewer);
        
        // Attach to global scope for easy access
        window[`arViewer${index}`] = arViewer;
    });

    // Global AR controls
    const arButton = document.getElementById('ar-button');
    if (arButton && arViewers.length > 0) {
        arButton.addEventListener('click', () => {
            arViewers[0].activateAr();
        });
    }

    const resetButton = document.getElementById('reset-camera');
    if (resetButton && arViewers.length > 0) {
        resetButton.addEventListener('click', () => {
            arViewers[0].resetCamera();
        });
    }

    const screenshotButton = document.getElementById('screenshot-button');
    if (screenshotButton && arViewers.length > 0) {
        screenshotButton.addEventListener('click', () => {
            arViewers[0].takeScreenshot();
        });
    }

    // Store first viewer globally for easy access
    if (arViewers.length > 0) {
        window.mainArViewer = arViewers[0];
    }
});

/**
 * AR Button Helper Functions
 */
window.ArHelpers = {
    /**
     * Show AR instructions modal
     */
    showArInstructions() {
        const modal = document.getElementById('ar-instructions-modal');
        if (modal) {
            modal.style.display = 'block';
        }
    },

    /**
     * Hide AR instructions modal
     */
    hideArInstructions() {
        const modal = document.getElementById('ar-instructions-modal');
        if (modal) {
            modal.style.display = 'none';
        }
    },

    /**
     * Check device compatibility and show appropriate message
     */
    checkCompatibility() {
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
        const isAndroid = /Android/.test(navigator.userAgent);
        
        if (isIOS) {
            return 'AR supported via QuickLook. Tap "View in AR" to place the furniture in your space.';
        } else if (isAndroid) {
            return 'AR supported via WebXR. Make sure you have ARCore installed for the best experience.';
        } else {
            return 'AR viewing requires a mobile device with AR support (iOS 12+ or Android with ARCore).';
        }
    }
};