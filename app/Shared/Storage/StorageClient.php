<?php

namespace App\Shared\Storage;

use App\Enums\FileSystemEnum;
use App\Traits\MediaManager;
use Exception;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

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
    public function upload(UploadedFile $file, string $folder = '', bool $private = false): ?array
    {
        try {
            $fileName = $this->getFileName($file);
            $path = $this->getUploadPath($folder, $fileName);
            $source = file_get_contents($file);

            $this->storageClient
                ->put($path, $source, [
                    'visibility'   => $private ? FileSystemEnum::ACL_PRIVATE : FileSystemEnum::ACL_PUBLIC,
                ]);

            return [
                'name'         => $fileName,
                'path'         => $path,
                'storage_path' => $path,
                'public_url'   => $this->getPublicUrl($path)
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
        }//end try
    }
}
