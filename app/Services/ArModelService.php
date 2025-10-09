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
     * Upload AR Model File
     *
     * Handles the upload process for AR model files with validation,
     * secure storage, and proper naming conventions.
     *
     * @param UploadedFile $file The uploaded AR model file
     * @param string $type File type ('glb' or 'usdz')
     * @param string|null $productName Optional product name for file naming
     * @return array Result array with success status, filename, and any errors
     */
    public function uploadArModel(UploadedFile $file, string $type, string $productName = null): array
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

            // Store file in the public disk under ar_models directory
            $path = $file->storeAs(
                self::STORAGE_PATH,
                $filename,
                'public'
            );

            if (!$path) {
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
                'size' => $file->getSize(),
                'product_name' => $productName
            ]);

            return [
                'success' => true,
                'filename' => $filename,
                'path' => $path,
                'url' => asset('storage/' . $path)
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
     *
     * @param string $filename The filename to delete
     * @return bool True if deletion was successful, false otherwise
     */
    public function deleteArModel(string $filename): bool
    {
        try {
            if (!$filename) {
                return true; // Nothing to delete
            }

            $path = self::STORAGE_PATH . '/' . $filename;
            
            if (!Storage::disk('public')->exists($path)) {
                Log::warning('AR model file not found for deletion', ['filename' => $filename]);
                return true; // File doesn't exist, consider it "deleted"
            }

            $deleted = Storage::disk('public')->delete($path);

            if ($deleted) {
                Log::info('AR model deleted successfully', ['filename' => $filename]);
            } else {
                Log::error('Failed to delete AR model', ['filename' => $filename]);
            }

            return $deleted;

        } catch (\Exception $e) {
            Log::error('AR model deletion failed', [
                'filename' => $filename,
                'error' => $e->getMessage()
            ]);
            return false;
        }
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

        $path = self::STORAGE_PATH . '/' . $filename;
        
        if (!Storage::disk('public')->exists($path)) {
            return null;
        }

        try {
            return [
                'filename' => $filename,
                'size' => Storage::disk('public')->size($path),
                'url' => asset('storage/' . $path),
                'last_modified' => Storage::disk('public')->lastModified($path)
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

        $path = self::STORAGE_PATH . '/' . $filename;
        return Storage::disk('public')->exists($path);
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
            // Get all AR model files from storage
            $allFiles = Storage::disk('public')->files(self::STORAGE_PATH);
            
            // Get all referenced AR model filenames from database
            $referencedFiles = \App\Models\Product\Product::whereNotNull('ar_model_glb')
                ->orWhereNotNull('ar_model_usdz')
                ->get(['ar_model_glb', 'ar_model_usdz'])
                ->flatMap(function ($product) {
                    return array_filter([$product->ar_model_glb, $product->ar_model_usdz]);
                })
                ->map(function ($filename) {
                    return self::STORAGE_PATH . '/' . $filename;
                })
                ->toArray();

            // Find orphaned files
            $orphanedFiles = array_diff($allFiles, $referencedFiles);
            $deletedCount = 0;

            foreach ($orphanedFiles as $file) {
                if (Storage::disk('public')->delete($file)) {
                    $deletedCount++;
                    Log::info('Deleted orphaned AR model', ['file' => $file]);
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