<?php

/**
 * Main Web Routes Configuration
 *
 * This file serves as the central routing hub for the Luna Shop e-commerce application.
 * It orchestrates the inclusion of specialized route files and defines global application routes.
 * The modular approach separates concerns between user, admin, and authentication routes.
 *
 * Route Organization:
 * - User routes: Customer-facing functionality (products, cart, orders)
 * - Admin routes: Administrative panel and management features
 * - Auth routes: Authentication and authorization functionality
 * - Global routes: Application-wide features like chatbot
 *
 * Architecture Benefits:
 * - Separation of concerns for maintainability
 * - Clear responsibility boundaries
 * - Easier debugging and development
 * - Scalable route organization
 *
 * @author Luna Shop Development Team
 *
 * @version 1.0
 */

use App\Http\Controllers\LocaleController;       // Laravel routing facade
use Illuminate\Http\Request;                   // Request facade
use Illuminate\Support\Facades\Auth;          // Auth facade
use Illuminate\Support\Facades\Log;           // Logging facade
// Chatbot functionality controller
use Illuminate\Support\Facades\Route;  // Locale switching functionality controller

/**
 * Modular Route Inclusion
 *
 * Includes specialized route files for different application areas.
 * This modular approach keeps routes organized and maintainable.
 * Each file handles specific functionality domains.
 */

// User Routes - Customer-facing functionality
/**
 * User Route Module - Customer Interface Routes
 * Includes: Product browsing, cart management, checkout, orders, reviews
 * Handles both guest and authenticated user experiences
 * File: routes/user.php
 */
require __DIR__.'/user.php';

// Admin Routes - Administrative functionality
/**
 * Admin Route Module - Administrative Panel Routes
 * Includes: Dashboard, product management, user management, order management
 * Protected by admin middleware for security
 * File: routes/admin.php
 */
require __DIR__.'/admin.php';

// Authentication Routes - Login/registration functionality
/**
 * Authentication Route Module - User Authentication Routes
 * Includes: Login, registration, password reset, email verification
 * Handles user account management and security
 * File: routes/auth.php
 */
require __DIR__.'/auth.php';

/**
 * Global Application Routes
 *
 * Routes that don't fit into specific modules or are used across the entire application.
 * These routes provide global functionality accessible from various parts of the system.
 */

// Chatbot Communication Route
/**
 * Chatbot Integration - AI-powered customer support
 *
 * Provides intelligent customer assistance through AI chatbot integration.
 * Handles customer inquiries, product recommendations, and support requests.
 * POST method ensures secure data transmission for chat interactions.
 *
 * Features:
 * - Real-time customer support
 * - Product information assistance
 * - Order status inquiries
 * - General shopping guidance
 *
 * Security: CSRF protection via POST method
 * Accessibility: Available to both guests and authenticated users
 */
Route::post('/chatbot', [App\Http\Controllers\ChatbotController::class, 'chat'])
    ->name('chatbot.chat');

/**
 * AR Analytics Route - Track AR usage for analytics
 *
 * Tracks AR model viewing and interaction analytics.
 * Helps understand user engagement with AR features.
 * Used for business intelligence and feature optimization.
 */
Route::post('/api/track-ar-usage', function (Request $request) {
    // Validate incoming data
    $validated = $request->validate([
        'action' => 'required|string|in:model_loaded,ar_session_started,ar_object_placed,screenshot_taken,model_error',
        'product_id' => 'required|integer|exists:products,id',
        'timestamp' => 'required|date_format:Y-m-d\TH:i:s.v\Z'
    ]);

    // Log AR usage for analytics (could be stored in database or analytics service)
    Log::info('AR Usage Tracked', [
        'action' => $validated['action'],
        'product_id' => $validated['product_id'],
        'timestamp' => $validated['timestamp'],
        'user_agent' => $request->userAgent(),
        'ip' => $request->ip(),
        'user_id' => Auth::check() ? Auth::id() : null
    ]);

    return response()->json(['status' => 'tracked']);
})->name('ar.track');

/**
 * Locale Switching Route - Multi-language Support
 *
 * Handles switching between available application languages.
 * Supports English, Vietnamese, and Japanese languages.
 * Stores selected locale in session for persistence across requests.
 *
 * Languages:
 * - en: English
 * - vi: Tiếng Việt
 * - ja: 日本語
 *
 * Security: Validates locale parameter against configured available locales
 * Persistence: Selected locale stored in user session
 */
Route::get('/locale/{locale}', [LocaleController::class, 'setLocale'])
    ->name('locale.set')
    ->where('locale', '[a-z]{2}');

/**
 * Application Health Check Endpoint
 *
 * Provides basic application health status for monitoring and deployment verification.
 * Used by load balancers, monitoring systems, and deployment automation.
 */
Route::get('/health', function () {
    return response('ok', 200)->header('Content-Type', 'text/plain');
});

/**
 * Application Version & Deployment Information API
 *
 * Critical endpoint for smart deployment change detection.
 * Returns current application version, build info, and deployment metadata.
 * Used by CI/CD pipeline to determine if deployment is necessary.
 */
Route::get('/api/version', function () {
    try {
        $gitSha = env('GIT_SHA', 'unknown');
        $buildDate = env('BUILD_DATE', 'unknown');
        $appVersion = config('app.version', '1.0.0');

        // Try to get Git SHA from various sources
        if ($gitSha === 'unknown') {
            // Try to read from deployment info file
            $deploymentFile = base_path('.deployment_info');
            if (file_exists($deploymentFile)) {
                $deploymentInfo = json_decode(file_get_contents($deploymentFile), true);
                $gitSha = $deploymentInfo['git_sha'] ?? 'unknown';
                $buildDate = $deploymentInfo['build_date'] ?? 'unknown';
            }
        }

        return response()->json([
            'status' => 'healthy',
            'git_sha' => $gitSha,
            'build_date' => $buildDate,
            'app_version' => $appVersion,
            'environment' => app()->environment(),
            'laravel_version' => app()->version(),
            'php_version' => PHP_VERSION,
            'timestamp' => now()->toISOString(),
            'uptime' => null, // Could add server uptime if needed
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Version endpoint error',
            'git_sha' => 'unknown',
            'timestamp' => now()->toISOString(),
        ], 500);
    }
});
