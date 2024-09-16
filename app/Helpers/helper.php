<?php

use App\Enums\LangEnum;

if (!function_exists('activeRoute')) {
    function activeRoute($route, $isClass = false): string
    {
        $requestUrl = request()->fullUrl() === $route ? true : false;

        if ($isClass) {
            return $requestUrl ? $isClass : '';
        } else {
            return $requestUrl ? 'active' : '';
        }
    }
}

if (!function_exists('getFlagByLocale')) {
    /**
     * @param string $locale
     * @return array
     */
    function getFlagByLocale(string $locale): array
    {
        $key = array_search($locale, array_column(LangEnum::ALLOW_LOCALES, 'code'));

        if (!$key) $key = LangEnum::LOCALE_DEFAULT;

        return LangEnum::ALLOW_LOCALES[$key];
    }
}
