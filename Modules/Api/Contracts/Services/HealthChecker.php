<?php

namespace Modules\Api\Contracts\Services;

interface HealthChecker
{
    /**
     * Return name of checker
     *
     * @return string
     */
    public function name(): string;

    /**
     * This method should return true if the check pass and false if not
     *
     * @return bool
     */
    public function check(): bool;
}
