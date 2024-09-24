<?php

namespace App\Shared\Storage;

use App\Enums\FileSystemEnum;
use Exception;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Illuminate\Support\Facades\Storage;

class StorageClient
{
    /**
     * @var Filesystem
     */
    private Filesystem $storageClient;

    /**
     * @var string
     */
    private string $disk;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->disk = $this->getDisk();
        if (in_array($this->disk, FileSystemEnum::LOCAL_DISKS)) {
            $this->storageClient = Storage::disk($this->getDisk());
        }
    }

    /**
     * Get storage disk
     * @throws Exception
     */
    public function getDisk(): string
    {
        $config = config('filesystems.disks');
        $disk = config('filesystems.default');

        if (empty($config[$disk])) {
            throw new ServiceUnavailableHttpException(
                message: __('Disk is unavailable!')
            );
        }

        return $disk;
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
            return !empty($path) && $this->storageClient->exists($path)
                ? $this->storageClient->url($path)
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
            return !empty($path) && $this->storageClient->exists($path)
                ? $this->storageClient->path($path)
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
            return !empty($path) && $this->storageClient->exists($path)
                ? $this->storageClient->temporaryUrl($path, Carbon::now()->addMinutes(30))
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
            if (!empty($path) && $this->storageClient->exists($path)) {
                return $this->storageClient->delete($path);
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

    /**
     * Handle upload
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param bool $private
     * @return array|null
     * @throws Exception
     */
    public function upload(UploadedFile $file, string $folder = '', bool $isPrivate = false, bool $hasThumbnail = false): ?array
    {
        try {
            $fileName = $this->getFileName($file);
            $path = $this->getUploadPath($folder, $fileName);
            $source = file_get_contents($file);

            // Create thumbnail image if flag hasThumbnail is true
            if ($hasThumbnail) {
                $pathThumbnail = $this->getUploadPath($folder . '/thumbnail', $fileName);
                $dataInfo = $this->getFileInfo($file);
                $widthResize = $heightResize = min($dataInfo['height'], $dataInfo['width'], config('image.image_thumb_size'));

                $manager = new ImageManager(Driver::class);

                // Resize image by width and height of original image
                $newFile = $manager->read($file)->resize($widthResize, $heightResize)->encode(new JpegEncoder(config('image.quality_image')));

                $this->storageClient->put($pathThumbnail,  $newFile, [
                    'visibility'   => $isPrivate ? FileSystemEnum::ACL_PRIVATE : FileSystemEnum::ACL_PUBLIC,
                ]);
            }

            $this->storageClient
                ->put($path, $source, [
                    'visibility'   => $isPrivate ? FileSystemEnum::ACL_PRIVATE : FileSystemEnum::ACL_PUBLIC,
                ]);

            return [
                'name' => $fileName,
                'path' => $path,
                'thumbnail_path' => $hasThumbnail ? $pathThumbnail : null
            ];
        } catch (Exception $e) {
            Log::error(
                logErrorMessage(
                    message: '[ERROR_UPLOAD_FILE]',
                    file: $e->getFile(),
                    line: $e->getLine()
                )
            );
            return null;
        }
    }

    /**
     * Get upload path.
     *
     * @param string $folder
     * @param string $name name.
     *
     * @return string
     */
    private function getUploadPath(string $folder, string $name): string
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
    private function formatFileName(string $name, string $ext): string
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
    private function getFileName(UploadedFile $file, bool $isRename = true): string
    {
        $ext = $file->getClientOriginalExtension();
        $fileName = $isRename
            ? randomString()
            : pathinfo(normalizeStr($file->getClientOriginalName()), PATHINFO_FILENAME);

        return $this->formatFileName(pathinfo($fileName, PATHINFO_FILENAME), $ext);
    }

    /**
     * @param object $file File object.
     * @return array
     */
    private function getFileInfo(object $file): array
    {
        $imageSize = getimagesize((string)$file);
        $size = null;

        if ($imageSize) {
            $size = $imageSize[0] . 'x' . $imageSize[1];
            return [
                'size'   => $size,
                'width'  => $imageSize[0],
                'height' => $imageSize[1],
                'type'   => $file->getClientOriginalExtension()
            ];
        }

        return [
            'size' => $size,
            'type' => $file->getClientOriginalExtension()
        ];
    }
}
