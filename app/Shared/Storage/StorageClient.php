<?php

namespace App\Shared\Storage;

use App\Enums\FileSystemEnum;
use App\Traits\MediaManager;
use Exception;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;

class StorageClient
{
    use MediaManager;

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
            $this->initLocalStorage();
        }
    }

    /**
     * Init local storage
     *
     * @return void
     * @throws Exception
     */
    public function initLocalStorage(): void
    {
        $this->storageClient = $this->getLocalStorage();
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

            if ($hasThumbnail) {
                $pathThumbnail = $this->getUploadPath($folder . '/thumbnail', $fileName);
                $dataInfo = $this->getFileInfo($file);
                $widthResize = $heightResize = min($dataInfo['height'], $dataInfo['width'], config('image.image_thumb_size'));

                $manager = new ImageManager(Driver::class);
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
                'name'         => $fileName,
                'path'         => $path,
                'storage_path' => $path,
                'public_url'   => !$isPrivate ? $this->getPublicUrl($path) : null,
                'thumbnail_path' => $hasThumbnail ? $pathThumbnail : null,
                'public_thumbnail_url' => !$isPrivate ? $this->getPublicUrl($pathThumbnail) : null,
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
     * Delete file.
     *
     * @param string $path
     *
     * @return bool|null
     */
    public function deleteFile(string $path): ?bool
    {
        try {
            return $this->storageClient->delete($path);
        } catch (Exception $e) {
            Log::error(
                logErrorMessage(
                    message: '[ERROR_DELETE_FILE]',
                    file: $e->getFile(),
                    line: $e->getLine()
                )
            );

            return false;
        } //end try
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
