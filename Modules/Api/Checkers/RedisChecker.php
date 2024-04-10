<?php

namespace Modules\Api\Checkers;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RedisChecker extends AbstractHealthChecker
{
    public function check(): bool
    {
        try {
            Cache::store('redis')->put('test_heath', 'test', 1);
        } catch (Exception $ex) {
            Log::error("Redis connection failed", ["ex" => $ex]);

            return false;
        }

        return true;
    }
}
