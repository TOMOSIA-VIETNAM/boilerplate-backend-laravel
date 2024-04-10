<?php

namespace Modules\Api\Checkers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseChecker extends AbstractHealthChecker
{
    public function check(): bool
    {
        try {
            DB::connection()->getPdo();
        } catch (Exception $ex) {
            Log::error("Database connection failed", ["ex" => $ex]);
            return false;
        }
        return true;
    }
}
