<!-- Christmas Tree Icon Component - Fixed Bottom Left -->
<div class="christmas-tree-icon-container">
    <!-- Small Christmas Tree Icon -->
    <button 
        onclick="openChristmasTree()" 
        class="christmas-tree-btn group"
        title="🎄 Click to view Christmas Tree in 3D!"
    >
        <!-- Simple Christmas Tree SVG -->
        <div class="tree-icon">
            <svg viewBox="0 0 100 120" class="w-full h-full">
                <!-- Tree -->
                <polygon points="50,10 30,40 70,40" fill="#2d5016" />
                <polygon points="50,25 25,55 75,55" fill="#3d6b1f" />
                <polygon points="50,40 20,70 80,70" fill="#4a7c2a" />
                <polygon points="50,55 15,85 85,85" fill="#568f35" />
                
                <!-- Trunk -->
                <rect x="45" y="85" width="10" height="15" fill="#654321" />
                
                <!-- Star on top -->
                <polygon points="50,5 52,12 59,12 53,16 55,23 50,19 45,23 47,16 41,12 48,12" fill="#ffd700" class="star-twinkle" />
                
                <!-- Decorations (animated) -->
                <circle cx="50" cy="30" r="2" fill="#ff0000" class="ornament-pulse" />
                <circle cx="40" cy="45" r="2" fill="#0000ff" class="ornament-pulse" style="animation-delay: 0.3s" />
                <circle cx="60" cy="45" r="2" fill="#ff0000" class="ornament-pulse" style="animation-delay: 0.6s" />
                <circle cx="35" cy="60" r="2" fill="#ffd700" class="ornament-pulse" style="animation-delay: 0.9s" />
                <circle cx="65" cy="60" r="2" fill="#0000ff" class="ornament-pulse" style="animation-delay: 1.2s" />
                <circle cx="30" cy="75" r="2" fill="#ff0000" class="ornament-pulse" style="animation-delay: 1.5s" />
                <circle cx="70" cy="75" r="2" fill="#ffd700" class="ornament-pulse" style="animation-delay: 1.8s" />
            </svg>
        </div>
        
        <!-- Text overlay on hover -->
        <div class="tree-text">
            <span class="text-xs font-bold text-white drop-shadow-lg">🎄 Giáng Sinh</span>
        </div>
        
        <!-- Snow effect -->
        <div class="snow-container">
            <div class="snowflake">❄</div>
            <div class="snowflake">❄</div>
            <div class="snowflake">❄</div>
        </div>
    </button>
</div>

<!-- Christmas Tree 3D Modal -->
<div id="christmas-tree-modal" class="christmas-modal" style="display: none;">
    <div class="modal-overlay" onclick="closeChristmasTree()"></div>
    <div class="modal-content">
        <!-- Close button -->
        <button onclick="closeChristmasTree()" class="modal-close">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        
        <!-- Title -->
        <div class="modal-header">
            <h2 class="text-3xl font-bold text-white mb-2">🎄 Merry Christmas! 🎅</h2>
            <p class="text-white opacity-90">Interactive 3D Christmas Tree</p>
        </div>
        
        <!-- iframe to embed Local Christmas Tree -->
        <div class="modal-body">
            <iframe 
                id="christmas-tree-iframe"
                src="{{ asset('christmas-tree-react/dist/index.html') }}"
                frameborder="0"
                allowfullscreen
                class="w-full h-full rounded-lg"
            ></iframe>
        </div>
        
        {{-- <!-- Loading indicator -->
        <div id="tree-loading" class="tree-loading">
            <div class="spinner"></div>
            <p class="text-white mt-4">Loading Christmas Magic... 🎄✨</p>
        </div> --}}
    </div>
</div>

<style>
/* Christmas Tree Icon - Fixed Bottom Left */
.christmas-tree-icon-container {
    position: fixed;
    bottom: 20px;
    left: 20px;
    z-index: 999;
    pointer-events: none;
}

.christmas-tree-btn {
    pointer-events: auto;
    width: 80px;
    height: 90px;
    background: linear-gradient(135deg, #1a472a 0%, #2d5016 100%);
    border: 3px solid #ffd700;
    border-radius: 16px;
    cursor: pointer;
    position: relative;
    transition: all 0.3s ease;
    box-shadow: 0 8px 24px rgba(255, 215, 0, 0.3),
                0 0 20px rgba(255, 215, 0, 0.2);
    overflow: hidden;
}

.christmas-tree-btn:hover {
    transform: scale(1.1) translateY(-5px);
    box-shadow: 0 12px 32px rgba(255, 215, 0, 0.5),
                0 0 30px rgba(255, 215, 0, 0.4);
    border-color: #fff;
}

.tree-icon {
    width: 100%;
    height: 100%;
    padding: 8px;
}

.tree-text {
    position: absolute;
    bottom: 2px;
    left: 0;
    right: 0;
    text-align: center;
    opacity: 0;
    transition: opacity 0.3s;
    pointer-events: none;
}

.christmas-tree-btn:hover .tree-text {
    opacity: 1;
}

/* Animations */
@keyframes twinkle {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.2); }
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}

@keyframes snowfall {
    0% { transform: translateY(-10px) translateX(0); opacity: 0; }
    50% { opacity: 1; }
    100% { transform: translateY(60px) translateX(10px); opacity: 0; }
}

.star-twinkle {
    animation: twinkle 1.5s ease-in-out infinite;
}

.ornament-pulse {
    animation: pulse 2s ease-in-out infinite;
}

/* Snow effect */
.snow-container {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
    overflow: hidden;
}

.snowflake {
    position: absolute;
    top: -10px;
    color: white;
    font-size: 12px;
    animation: snowfall 3s linear infinite;
    opacity: 0.8;
}

.snowflake:nth-child(1) {
    left: 20%;
    animation-delay: 0s;
}

.snowflake:nth-child(2) {
    left: 50%;
    animation-delay: 1s;
}

.snowflake:nth-child(3) {
    left: 80%;
    animation-delay: 2s;
}

/* Modal Styles */
.christmas-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(5px);
}

.modal-content {
    position: relative;
    width: 90vw;
    height: 90vh;
    max-width: 1400px;
    background: linear-gradient(135deg, #1a472a 0%, #0f2616 100%);
    border-radius: 24px;
    padding: 24px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    border: 2px solid #ffd700;
    display: flex;
    flex-direction: column;
    animation: slideUp 0.4s ease;
}

@keyframes slideUp {
    from { transform: translateY(50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.modal-close {
    position: absolute;
    top: 16px;
    right: 16px;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    z-index: 10;
}

.modal-close:hover {
    background: rgba(255, 59, 48, 0.8);
    border-color: #ff3b30;
    transform: rotate(90deg);
}

.modal-header {
    text-align: center;
    margin-bottom: 20px;
}

.modal-body {
    flex: 1;
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    background: #000;
}

/* Loading indicator */
.tree-loading {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    z-index: 1;
}

.spinner {
    width: 60px;
    height: 60px;
    border: 4px solid rgba(255, 255, 255, 0.1);
    border-top-color: #ffd700;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 768px) {
    .christmas-tree-btn {
        width: 60px;
        height: 70px;
    }
    
    .christmas-tree-icon-container {
        bottom: 80px; /* Avoid footer on mobile */
    }
    
    .modal-content {
        width: 95vw;
        height: 85vh;
        padding: 16px;
    }
}
</style>

<script>
function openChristmasTree() {
    const modal = document.getElementById('christmas-tree-modal');
    const loading = document.getElementById('tree-loading');
    const iframe = document.getElementById('christmas-tree-iframe');
    
    if (!modal) return;
    
    // Show modal
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    // Show loading
    if (loading) loading.style.display = 'block';
    
    // Hide loading when iframe loads
    if (iframe) {
        iframe.onload = function() {
            if (loading) {
                setTimeout(() => {
                    loading.style.display = 'none';
                }, 500);
            }
        };
    }
    
    // Track event (optional)
    console.log('🎄 Christmas Tree opened!');
}

function closeChristmasTree() {
    const modal = document.getElementById('christmas-tree-modal');
    if (!modal) return;
    
    modal.style.display = 'none';
    document.body.style.overflow = '';
    
    console.log('🎄 Christmas Tree closed!');
}

// Close on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeChristmasTree();
    }
});

// Log when component loads
console.log('🎄 Christmas Tree component loaded! Click the tree icon to view in 3D!');
</script>
