<?php

namespace Modules\Api\Checkers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Log;

class WritablePathsChecker extends AbstractHealthChecker
{
    /** @var Filesystem */
    private $filesystem;

    private const WRITABLE_PATHS = [
        'bootstrap/cache',
        'storage',
    ];

    /**
     * WritablePathsChecker constructor.
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function check(): bool
    {
        foreach (self::WRITABLE_PATHS as $path) {
            if (!$this->filesystem->isWritable(base_path($path))) {
                Log::error("Path is not writeable", ["path" => $path]);
                return false;
            }
        }
        return true;
    }
}
