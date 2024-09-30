<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static ROLE()
 * @method static static USER()
 * @method static static ADMIN()
 */
final class LogNameEnum extends Enum
{
    public const ROLE = 'Role';
    public const USER = 'User';
    public const ADMIN = 'Admin';
}
