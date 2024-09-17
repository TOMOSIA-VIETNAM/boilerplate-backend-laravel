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

if (! function_exists('logErrorMessage')) {
    /**
     * @param string $message
     * @param string $file
     * @param int|string $line
     * @return array|string
     */
    function logErrorMessage(string $message, string $file = '', int|string $line = ''): array|string
    {
        return "\n【ERROR】: {$message} \n【File】: {$file} \n【Line】: {$line}";
    }
}

if (! function_exists('randomString')) {

    /**
     * Generate random string
     */
    function randomString(): string
    {
        return md5(uniqid((string)mt_rand(), true));
    }
}

if (! function_exists('normalizeStr')) {
    /**
     * @param string|null $text
     * @return string
     */
    function normalizeStr(?string $text): string
    {
        return $text ? Normalizer::normalize($text, Normalizer::FORM_C) : '';
    }
}
