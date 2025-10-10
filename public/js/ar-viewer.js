/**
 * AR Viewer JavaScript
 * Handles AR functionality for the Luna Shop furniture AR system
 */

// AR Helper functions
const ArHelpers = {
    // Check device compatibility
    checkCompatibility: function() {
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
        const isAndroid = /Android/.test(navigator.userAgent);
        const isMobile = isIOS || isAndroid;
        
        if (isIOS) {
            return "iOS device detected. AR works best with iOS 12+ and ARKit support.";
        } else if (isAndroid) {
            return "Android device detected. Please ensure ARCore is installed for the best AR experience.";
        } else {
            return "Desktop detected. AR works best on mobile devices (iOS/Android).";
        }
    },

    // Show AR instructions modal
    showArInstructions: function() {
        document.getElementById('ar-instructions-modal').style.display = 'block';
    },

    // Hide AR instructions modal
    hideArInstructions: function() {
        document.getElementById('ar-instructions-modal').style.display = 'none';
    },

    // Update AR status
    updateArStatus: function(message) {
        const statusElement = document.getElementById('ar-status');
        if (statusElement) {
            statusElement.textContent = message;
        }
    },

    // Handle screenshot
    takeScreenshot: function() {
        const modelViewer = document.getElementById('ar-model-viewer');
        if (modelViewer) {
            const screenshot = modelViewer.toDataURL('image/png');
            const link = document.createElement('a');
            link.download = 'ar-furniture-screenshot.png';
            link.href = screenshot;
            link.click();
        }
    },

    // Reset camera position
    resetCamera: function() {
        const modelViewer = document.getElementById('ar-model-viewer');
        if (modelViewer) {
            modelViewer.resetTurntableRotation();
            modelViewer.jumpCameraToGoal();
        }
    }
};

// Initialize AR viewer when page loads
document.addEventListener('DOMContentLoaded', function() {
    const modelViewer = document.getElementById('ar-model-viewer');
    const loadingOverlay = document.getElementById('model-loading');
    const errorOverlay = document.getElementById('model-error');
    const errorMessage = document.getElementById('error-message');
    const progressBar = document.getElementById('loading-progress');
    const arButton = document.getElementById('ar-button');
    const resetButton = document.getElementById('reset-camera');
    const screenshotButton = document.getElementById('screenshot-button');

    if (!modelViewer) {
        console.error('Model viewer not found');
        return;
    }

    // Update initial status
    ArHelpers.updateArStatus('Initializing AR...');

    // Handle model loading progress
    modelViewer.addEventListener('progress', function(event) {
        const progress = event.detail.totalProgress * 100;
        if (progressBar) {
            progressBar.style.width = progress + '%';
        }
        ArHelpers.updateArStatus(`Loading: ${Math.round(progress)}%`);
    });

    // Handle model load success
    modelViewer.addEventListener('load', function() {
        console.log('3D model loaded successfully');
        if (loadingOverlay) {
            loadingOverlay.style.display = 'none';
        }
        ArHelpers.updateArStatus('Model loaded - Ready for AR');
        
        // Enable AR button
        if (arButton) {
            arButton.disabled = false;
        }
    });

    // Handle model load error
    modelViewer.addEventListener('error', function(event) {
        console.error('Model loading error:', event);
        if (loadingOverlay) {
            loadingOverlay.style.display = 'none';
        }
        if (errorOverlay) {
            errorOverlay.style.display = 'block';
        }
        if (errorMessage) {
            errorMessage.textContent = 'Failed to load 3D model. Please check your internet connection.';
        }
        ArHelpers.updateArStatus('Error loading model');
    });

    // Handle AR session start
    modelViewer.addEventListener('ar-status', function(event) {
        if (event.detail.status === 'session-started') {
            ArHelpers.updateArStatus('AR session active');
        } else if (event.detail.status === 'not-presenting') {
            ArHelpers.updateArStatus('AR ready');
        }
    });

    // AR Button click handler
    if (arButton) {
        arButton.addEventListener('click', function() {
            console.log('AR button clicked');
            console.log('Model viewer:', modelViewer);
            console.log('Model src:', modelViewer.src);
            console.log('Can activate AR:', modelViewer.canActivateAR);
            
            // Check if AR is supported
            if (!modelViewer.canActivateAR) {
                console.error('AR not supported. Reason:', modelViewer.arStatus);
                alert('AR is not supported on this device. Please use a compatible mobile device.');
                return;
            }

            try {
                // Show instructions first time
                const hasSeenInstructions = localStorage.getItem('ar-instructions-seen');
                if (!hasSeenInstructions) {
                    console.log('Showing AR instructions for first time');
                    ArHelpers.showArInstructions();
                    localStorage.setItem('ar-instructions-seen', 'true');
                } else {
                    // Directly activate AR
                    console.log('Activating AR...');
                    modelViewer.activateAR();
                }
            } catch (error) {
                console.error('Error activating AR:', error);
                alert('Error starting AR: ' + error.message);
            }
        });
    }

    // Reset camera button
    if (resetButton) {
        resetButton.addEventListener('click', function() {
            ArHelpers.resetCamera();
        });
    }

    // Screenshot button
    if (screenshotButton) {
        screenshotButton.addEventListener('click', function() {
            ArHelpers.takeScreenshot();
        });
    }

    // Handle camera-change events
    modelViewer.addEventListener('camera-change', function(event) {
        // Optional: Track camera movements for analytics
        console.log('Camera changed:', event.detail);
    });

    // Check AR availability
    modelViewer.addEventListener('ar-tracking', function(event) {
        if (event.detail.status === 'tracking') {
            ArHelpers.updateArStatus('AR tracking active');
        } else if (event.detail.status === 'not-tracking') {
            ArHelpers.updateArStatus('AR tracking lost');
        }
    });

    // Handle model-viewer ready state
    modelViewer.addEventListener('model-visibility', function(event) {
        if (event.detail.visible) {
            console.log('Model is now visible');
        }
    });

    // Add touch/interaction handlers for mobile
    let isDragging = false;
    
    modelViewer.addEventListener('touchstart', function() {
        isDragging = true;
    });
    
    modelViewer.addEventListener('touchend', function() {
        isDragging = false;
    });

    // Auto-hide loading after timeout (fallback)
    setTimeout(function() {
        if (loadingOverlay && loadingOverlay.style.display !== 'none') {
            console.warn('Model loading timeout - hiding loading overlay');
            loadingOverlay.style.display = 'none';
            ArHelpers.updateArStatus('Ready (timeout)');
        }
    }, 10000); // 10 second timeout
});

// Global functions for template usage
window.ArHelpers = ArHelpers;

// Additional AR features
document.addEventListener('DOMContentLoaded', function() {
    // Check for WebXR support
    if ('xr' in navigator) {
        navigator.xr.isSessionSupported('immersive-ar').then(function(supported) {
            if (supported) {
                console.log('WebXR AR is supported');
            } else {
                console.log('WebXR AR is not supported');
            }
        }).catch(function(err) {
            console.log('Error checking WebXR support:', err);
        });
    }

    // Add device orientation handling
    if (window.DeviceOrientationEvent) {
        window.addEventListener('deviceorientation', function(event) {
            // Optional: Handle device orientation for better AR experience
            // This could be used to adjust model rotation or camera angle
        });
    }
});