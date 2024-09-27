<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static LOCAL_DISKS()
 * @method static static ACL_PUBLIC()
 * @method static static ACL_PRIVATE()
 */
final class FileSystemEnum extends Enum
{
    const LOCAL_DISKS = ['local', 'public'];

    const ACL_PUBLIC = 'public';

    const ACL_PRIVATE = 'private';
}
