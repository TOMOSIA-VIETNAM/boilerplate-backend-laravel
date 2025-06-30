<?php

namespace App\Core\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class FileUploadService
{
    /**
     * Upload file to storage
     */
    public function upload(UploadedFile $file, string $path = 'uploads', string $disk = 'public'): string
    {
        $fileName = $this->generateFileName($file);
        $fullPath = $path . '/' . $fileName;
        
        // Ensure directory exists
        $this->ensureDirectoryExists($path, $disk);
        
        // Upload file
        $uploaded = Storage::disk($disk)->putFileAs($path, $file, $fileName);
        
        if (!$uploaded) {
            throw new \Exception('Failed to upload file to storage');
        }
        
        return $fullPath;
    }

    /**
     * Upload avatar specifically
     */
    public function uploadAvatar(UploadedFile $file, string $userId = null): string
    {
        $path = 'avatars';
        if ($userId) {
            $path .= '/' . $userId;
        }
        
        return $this->upload($file, $path);
    }

    /**
     * Delete file from storage with better error handling
     */
    public function delete(string $path, string $disk = 'public'): bool
    {
        try {
            if (Storage::disk($disk)->exists($path)) {
                $deleted = Storage::disk($disk)->delete($path);
                
                if (!$deleted) {
                    Log::warning("Failed to delete file: {$path} from disk: {$disk}");
                    return false;
                }
                
                Log::info("Successfully deleted file: {$path} from disk: {$disk}");
                return true;
            }
            
            Log::info("File does not exist, skipping deletion: {$path} from disk: {$disk}");
            return true;
            
        } catch (\Exception $e) {
            Log::error("Error deleting file {$path} from disk {$disk}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get full URL for file
     */
    public function getUrl(string $path, string $disk = 'public'): string
    {
        return Storage::disk($disk)->url($path);
    }

    /**
     * Generate unique filename
     */
    private function generateFileName(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $name = Str::slug($name);
        
        return $name . '_' . time() . '_' . Str::random(10) . '.' . $extension;
    }

    /**
     * Ensure directory exists
     */
    private function ensureDirectoryExists(string $path, string $disk = 'public'): void
    {
        try {
            if (!Storage::disk($disk)->exists($path)) {
                $created = Storage::disk($disk)->makeDirectory($path);
                
                if (!$created) {
                    throw new \Exception("Failed to create directory: {$path}");
                }
                
                Log::info("Created directory: {$path} on disk: {$disk}");
            }
        } catch (\Exception $e) {
            Log::error("Error creating directory {$path} on disk {$disk}: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Validate image file
     */
    public function validateImage(UploadedFile $file, int $maxSize = 2048): bool
    {
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSizeInBytes = $maxSize * 1024; // Convert KB to bytes
        
        return in_array($file->getMimeType(), $allowedMimes) && 
               $file->getSize() <= $maxSizeInBytes;
    }

    /**
     * Get validation rules for image upload
     */
    public function getImageValidationRules(int $maxSize = 2048): array
    {
        return [
            'image',
            'mimes:jpeg,png,gif,webp',
            'max:' . $maxSize
        ];
    }

    /**
     * Clean up old files in a directory
     */
    public function cleanupOldFiles(string $directory, string $disk = 'public', int $maxAge = 86400): int
    {
        try {
            $files = Storage::disk($disk)->files($directory);
            $deletedCount = 0;
            $cutoffTime = time() - $maxAge;
            
            foreach ($files as $file) {
                $lastModified = Storage::disk($disk)->lastModified($file);
                
                if ($lastModified < $cutoffTime) {
                    if ($this->delete($file, $disk)) {
                        $deletedCount++;
                    }
                }
            }
            
            Log::info("Cleaned up {$deletedCount} old files from {$directory}");
            return $deletedCount;
            
        } catch (\Exception $e) {
            Log::error("Error cleaning up old files in {$directory}: " . $e->getMessage());
            return 0;
        }
    }
} 