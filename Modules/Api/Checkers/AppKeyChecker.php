<?php

namespace Modules\Api\Checkers;

class AppKeyChecker extends AbstractHealthChecker
{
    public function check(): bool
    {
        return config('app.key') !== null;
    }
}
