<?php

/**
 * AR Model Service
 *
 * This service handles all AR (Augmented Reality) model related operations
 * for the Luna Shop e-commerce application. It provides functionality for
 * uploading, validating, storing, and managing 3D model files in GLB and USDZ formats.
 *
 * Key Features:
 * - Upload and validation of AR model files (.glb, .usdz)
 * - File size and format validation
 * - Secure file storage with proper naming conventions
 * - File deletion and cleanup operations
 * - Model metadata extraction and validation
 * - Error handling and logging for AR operations
 *
 * Supported Formats:
 * - GLB (GL Transmission Format Binary) - For Android/WebXR
 * - USDZ (Universal Scene Description ZIP) - For iOS Quick Look
 *
 * @author Luna Shop Development Team
 * @version 1.0
 */

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * AR Model Service Class
 *
 * Handles AR model file operations including upload, validation, and storage.
 */
class ArModelService
{
    /**
     * Maximum file size for AR models (in bytes)
     * 50MB limit to balance quality with loading performance
     */
    const MAX_FILE_SIZE = 50 * 1024 * 1024; // 50MB

    /**
     * Allowed AR model file extensions
     */
    const ALLOWED_EXTENSIONS = ['glb', 'usdz'];

    /**
     * Storage directory for AR models
     */
    const STORAGE_PATH = 'ar_models';

    /**
     * Category to Subfolder Mapping
     * Maps category names/slugs to their corresponding storage subfolders
     */
    const CATEGORY_FOLDERS = [
        'seatings' => 'seatings',
        'tables' => 'tables',
        'storages' => 'storages',
        'decores' => 'decores',
        // Default fallback
        'default' => 'others'
    ];

    /**
     * Get Category Subfolder
     *
     * Determines the appropriate subfolder based on category name.
     * Supports flexible matching for various category naming formats.
     *
     * @param string|null $categoryName The category name or slug
     * @return string The subfolder name
     */
    private function getCategorySubfolder(?string $categoryName): string
    {
        if (!$categoryName) {
            return self::CATEGORY_FOLDERS['default'];
        }

        // Normalize category name (lowercase, remove special chars)
        $normalized = strtolower(trim($categoryName));
        $normalized = preg_replace('/[^a-z0-9]/', '', $normalized);

        // Check for exact match or partial match
        foreach (self::CATEGORY_FOLDERS as $key => $folder) {
            if ($key === 'default') continue;
            
            if (str_contains($normalized, $key) || str_contains($key, $normalized)) {
                return $folder;
            }
        }

        return self::CATEGORY_FOLDERS['default'];
    }

    /**
     * Upload AR Model File
     *
     * Handles the upload process for AR model files with validation,
     * secure storage, and proper naming conventions.
     * Files are organized into category-based subfolders for better management.
     *
     * @param UploadedFile $file The uploaded AR model file
     * @param string $type File type ('glb' or 'usdz')
     * @param string|null $productName Optional product name for file naming
     * @param string|null $categoryName Optional category name for subfolder organization
     * @return array Result array with success status, filename, and any errors
     */
    public function uploadArModel(UploadedFile $file, string $type, string $productName = null, string $categoryName = null): array
    {
        try {
            // Validate file
            $validation = $this->validateArModelFile($file, $type);
            if (!$validation['valid']) {
                return [
                    'success' => false,
                    'error' => $validation['error'],
                    'filename' => null
                ];
            }

            // Generate unique filename
            $filename = $this->generateArModelFilename($file, $type, $productName);

            // Determine category subfolder
            $subfolder = $this->getCategorySubfolder($categoryName);
            $relativePath = self::STORAGE_PATH . '/' . $subfolder;

            // Store file directly in public/ar_models/{category}/ directory
            // This avoids symlink issues on deployment
            $destinationPath = public_path($relativePath);
            
            // Ensure directory exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Move the file
            $file->move($destinationPath, $filename);
            $fullPath = $relativePath . '/' . $filename;

            // Verify file was moved successfully
            if (!file_exists(public_path($fullPath))) {
                return [
                    'success' => false,
                    'error' => 'Failed to store AR model file',
                    'filename' => null
                ];
            }

            // Log successful upload
            Log::info('AR model uploaded successfully', [
                'filename' => $filename,
                'type' => $type,
                'size' => filesize(public_path($fullPath)),
                'product_name' => $productName,
                'category' => $categoryName,
                'subfolder' => $subfolder
            ]);

            return [
                'success' => true,
                'filename' => $filename,
                'subfolder' => $subfolder,
                'full_path' => $fullPath,
                'url' => asset($fullPath)
            ];

        } catch (\Exception $e) {
            Log::error('AR model upload failed', [
                'error' => $e->getMessage(),
                'type' => $type,
                'product_name' => $productName
            ]);

            return [
                'success' => false,
                'error' => 'Upload failed: ' . $e->getMessage(),
                'filename' => null
            ];
        }
    }

    /**
     * Validate AR Model File
     *
     * Performs comprehensive validation on uploaded AR model files
     * including size, extension, and format checks.
     *
     * @param UploadedFile $file The file to validate
     * @param string $type Expected file type ('glb' or 'usdz')
     * @return array Validation result with status and error message
     */
    public function validateArModelFile(UploadedFile $file, string $type): array
    {
        // Check if file is valid
        if (!$file->isValid()) {
            return [
                'valid' => false,
                'error' => 'Invalid file upload'
            ];
        }

        // Check file size
        if ($file->getSize() > self::MAX_FILE_SIZE) {
            $maxSizeMB = self::MAX_FILE_SIZE / (1024 * 1024);
            return [
                'valid' => false,
                'error' => "File size exceeds maximum limit of {$maxSizeMB}MB"
            ];
        }

        // Check file extension
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, self::ALLOWED_EXTENSIONS)) {
            return [
                'valid' => false,
                'error' => 'Invalid file type. Only .glb and .usdz files are allowed'
            ];
        }

        // Check if extension matches expected type
        if ($extension !== strtolower($type)) {
            return [
                'valid' => false,
                'error' => "File extension '{$extension}' does not match expected type '{$type}'"
            ];
        }

        // Additional MIME type validation
        $mimeType = $file->getMimeType();
        $validMimeTypes = [
            'glb' => ['model/gltf-binary', 'application/octet-stream'],
            'usdz' => ['model/vnd.usdz+zip', 'application/zip', 'application/octet-stream']
        ];

        if (isset($validMimeTypes[$type]) && !in_array($mimeType, $validMimeTypes[$type])) {
            Log::warning('AR model MIME type validation failed', [
                'expected_type' => $type,
                'actual_mime' => $mimeType,
                'allowed_mimes' => $validMimeTypes[$type]
            ]);
            // Note: We log this as a warning but don't fail validation
            // as MIME type detection can be unreliable for these formats
        }

        return [
            'valid' => true,
            'error' => null
        ];
    }

    /**
     * Generate AR Model Filename
     *
     * Creates a unique, descriptive filename for AR model files
     * with proper sanitization and timestamp.
     *
     * @param UploadedFile $file The uploaded file
     * @param string $type File type ('glb' or 'usdz')
     * @param string|null $productName Optional product name
     * @return string Generated filename
     */
    private function generateArModelFilename(UploadedFile $file, string $type, string $productName = null): string
    {
        // Sanitize product name if provided
        $prefix = 'ar_model';
        if ($productName) {
            $sanitized = Str::slug($productName, '_');
            $prefix = $sanitized . '_ar';
        }

        // Generate unique timestamp-based suffix
        $timestamp = now()->format('Y_m_d_H_i_s');
        $random = Str::random(6);

        return "{$prefix}_{$timestamp}_{$random}.{$type}";
    }

    /**
     * Delete AR Model File
     *
     * Safely removes AR model files from storage with error handling.
     * Supports both legacy flat structure and category-based subfolder structure.
     *
     * @param string $filePathOrName Full path (e.g., "seatings/file.glb") or just filename
     * @return bool True if deletion was successful, false otherwise
     */
    public function deleteArModel(string $filePathOrName): bool
    {
        try {
            if (!$filePathOrName) {
                return true; // Nothing to delete
            }

            // Check if it's a full path or just filename
            if (str_contains($filePathOrName, '/')) {
                // Full path provided (e.g., "seatings/file.glb")
                $filePath = public_path(self::STORAGE_PATH . '/' . $filePathOrName);
            } else {
                // Just filename - search in all subfolders
                $filePath = $this->findArModelFile($filePathOrName);
            }

            if (!$filePath || !file_exists($filePath)) {
                Log::warning('AR model file not found for deletion', ['file' => $filePathOrName]);
                return true; // File doesn't exist, consider it "deleted"
            }

            $deleted = unlink($filePath);

            if ($deleted) {
                Log::info('AR model deleted successfully', ['file' => $filePathOrName]);
            } else {
                Log::error('Failed to delete AR model', ['file' => $filePathOrName]);
            }

            return $deleted;

        } catch (\Exception $e) {
            Log::error('AR model deletion failed', [
                'file' => $filePathOrName,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Find AR Model File
     *
     * Searches for an AR model file across all category subfolders.
     * Useful for backwards compatibility and when exact path is unknown.
     *
     * @param string $filename The filename to search for
     * @return string|null Full file path if found, null otherwise
     */
    private function findArModelFile(string $filename): ?string
    {
        $basePath = public_path(self::STORAGE_PATH);
        
        // Check root directory first (legacy files)
        $rootPath = $basePath . '/' . $filename;
        if (file_exists($rootPath)) {
            return $rootPath;
        }

        // Search in category subfolders
        foreach (self::CATEGORY_FOLDERS as $folder) {
            $subfolderPath = $basePath . '/' . $folder . '/' . $filename;
            if (file_exists($subfolderPath)) {
                return $subfolderPath;
            }
        }

        return null;
    }

    /**
     * Get AR Model File Info
     *
     * Retrieves information about an AR model file including size and URL.
     *
     * @param string $filename The filename to get info for
     * @return array|null File information or null if file doesn't exist
     */
    public function getArModelInfo(string $filename): ?array
    {
        if (!$filename) {
            return null;
        }

        $filePath = public_path(self::STORAGE_PATH . '/' . $filename);
        
        if (!file_exists($filePath)) {
            return null;
        }

        try {
            return [
                'filename' => $filename,
                'size' => filesize($filePath),
                'url' => asset(self::STORAGE_PATH . '/' . $filename),
                'last_modified' => filemtime($filePath)
            ];
        } catch (\Exception $e) {
            Log::error('Failed to get AR model info', [
                'filename' => $filename,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Check AR Model File Exists
     *
     * Verifies if an AR model file exists in storage.
     *
     * @param string $filename The filename to check
     * @return bool True if file exists, false otherwise
     */
    public function arModelExists(string $filename): bool
    {
        if (!$filename) {
            return false;
        }

        $filePath = public_path(self::STORAGE_PATH . '/' . $filename);
        return file_exists($filePath);
    }

    /**
     * Get Formatted File Size
     *
     * Returns a human-readable file size string.
     *
     * @param int $bytes File size in bytes
     * @return string Formatted size (e.g., "2.5 MB")
     */
    public function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.1f %s", $bytes / pow(1024, $factor), $units[$factor]);
    }

    /**
     * Clean Up Orphaned AR Models
     *
     * Removes AR model files that are not referenced by any products.
     * Should be run periodically as maintenance.
     *
     * @return array Cleanup results with deleted files count
     */
    public function cleanupOrphanedModels(): array
    {
        try {
            // Get all AR model files from public directory
            $publicPath = public_path(self::STORAGE_PATH);
            $allFiles = [];
            
            if (file_exists($publicPath)) {
                $files = glob($publicPath . '/*');
                $allFiles = array_map('basename', $files);
            }
            
            // Get all referenced AR model filenames from database
            $referencedFiles = \App\Models\Product\Product::whereNotNull('ar_model_glb')
                ->orWhereNotNull('ar_model_usdz')
                ->get(['ar_model_glb', 'ar_model_usdz'])
                ->flatMap(function ($product) {
                    return array_filter([$product->ar_model_glb, $product->ar_model_usdz]);
                })
                ->toArray();

            // Find orphaned files
            $orphanedFiles = array_diff($allFiles, $referencedFiles);
            $deletedCount = 0;

            foreach ($orphanedFiles as $filename) {
                $filePath = public_path(self::STORAGE_PATH . '/' . $filename);
                if (file_exists($filePath) && unlink($filePath)) {
                    $deletedCount++;
                    Log::info('Deleted orphaned AR model', ['file' => $filename]);
                }
            }

            return [
                'success' => true,
                'total_files' => count($allFiles),
                'orphaned_files' => count($orphanedFiles),
                'deleted_files' => $deletedCount
            ];

        } catch (\Exception $e) {
            Log::error('AR model cleanup failed', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}