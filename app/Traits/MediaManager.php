<?php

namespace App\Traits;

use Carbon\Carbon;
use Exception;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

trait MediaManager
{
    /**
     * Get storage disk
     * @throws Exception
     */
    public function getDisk(): string
    {
        $config = $this->getConfigDisks();
        $disk = config('filesystems.default');

        if (empty($config[$disk])) {
            throw new ServiceUnavailableHttpException(
                message: __('Disk is unavailable!')
            );
        }

        return $disk;
    }

    /**
     * Get filesystem disks config
     *
     * @return Repository|Application|\Illuminate\Foundation\Application|mixed
     */
    public function getConfigDisks(): mixed
    {
        return config('filesystems.disks');
    }

    /**
     * Get local storage
     *
     * @return Filesystem
     * @throws Exception
     */
    public function getLocalStorage(): Filesystem
    {
        return Storage::disk($this->getDisk());
    }

    /**
     * Get upload path.
     *
     * @param string $folder
     * @param string $name name.
     *
     * @return string
     */
    public function getUploadPath(string $folder, string $name): string
    {
        return sprintf('%s/%s', $folder, $name);
    }

    /**
     * Format file name.
     *
     * @param string $name Filename
     * @param string $ext ext
     *
     * @return string
     */
    public function formatFileName(string $name, string $ext): string
    {
        return sprintf('%s_%s.%s', $name, time(), $ext);
    }

    /**
     * Get file name.
     *
     * @param UploadedFile $file
     * @param boolean $isRename
     * @return string
     */
    public function getFileName(UploadedFile $file, bool $isRename = true): string
    {
        $ext = $file->getClientOriginalExtension();
        $fileName = $isRename
            ? randomString()
            : pathinfo(normalizeStr($file->getClientOriginalName()), PATHINFO_FILENAME);

        return $this->formatFileName(pathinfo($fileName, PATHINFO_FILENAME), $ext);
    }

    /**
     * Get public url.
     *
     * @param string|null $path
     *
     * @return null|string
     */
    public function getPublicUrl(?string $path): ?string
    {
        try {
            $storage = $this->getLocalStorage();

            return !empty($path) && $storage->exists($path)
                ? $storage->url($path)
                : null;
        } catch (Exception $e) {
            Log::error(
                logErrorMessage(
                    message: "[ERROR_GET_FILE_PUBLIC_URL]",
                    file: $e->getFile(),
                    line: $e->getLine()
                )
            );
            return null;
        }
    }

    /**
     * Get storage path.
     *
     * @param string $path
     *
     * @return null|string
     */
    public function getStoragePath(string $path): ?string
    {
        try {
            $storage = $this->getLocalStorage();

            return !empty($path) && $storage->exists($path)
                ? $storage->path($path)
                : null;
        } catch (Exception $e) {
            Log::error(
                logErrorMessage(
                    message: '[ERROR_GET_STORAGE_PATH]',
                    file: $e->getFile(),
                    line: $e->getLine()
                )
            );
            return null;
        }
    }

    /**
     * Get temporary url
     *
     * @param string $path
     * @return string|null
     */
    public function getTemporaryUrl(string $path): ?string
    {
        try {
            $storage = $this->getLocalStorage();

            return !empty($path) && $storage->exists($path)
                ? $storage->temporaryUrl($path, Carbon::now()->addMinutes(30))
                : null;
        } catch (Exception $e) {
            Log::error(
                logErrorMessage(
                    message: '[ERROR_GET_TEMPORARY_PATH]',
                    file: $e->getFile(),
                    line: $e->getLine()
                )
            );
            return null;
        }
    }

    /**
     * @param string $path
     * @return bool
     */
    public function deleteImage(string $path): bool
    {
        try {
            $storage = $this->getLocalStorage();

            if (!empty($path) && $storage->exists($path)) {
                return $storage->delete($path);
            }
            return false;
        } catch (Exception $e) {
            Log::error(
                logErrorMessage(
                    message: '[ERROR_DELETE_STORAGE_PATH]',
                    file: $e->getFile(),
                    line: $e->getLine()
                )
            );
            return false;
        }
    }
}
