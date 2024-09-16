<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static LOCALE_DEFAULT()
 * @method static static ALLOW_LOCALES()
 */
final class LangEnum extends Enum
{
    public const LOCALE_DEFAULT = 0;

    public const ALLOW_LOCALES = [
        [
            'folder' => 'GB',
            'name' => 'English',
            'code' => 'en'
        ],
        [
            'folder' => 'JP',
            'name' => 'Japanese',
            'code' => 'ja'
        ],
    ];
}
