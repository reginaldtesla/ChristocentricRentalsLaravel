<?php

namespace App\Support;

use RuntimeException;

class EnvWriter
{
    /**
     * @param  array<string, string|null>  $values
     */
    public static function set(array $values): void
    {
        $path = base_path('.env');

        if (! is_file($path) || ! is_writable($path)) {
            throw new RuntimeException('.env file is missing or not writable.');
        }

        $content = file_get_contents($path);

        foreach ($values as $key => $value) {
            if ($value === null) {
                continue;
            }

            $formatted = self::formatValue($value);
            $pattern = '/^'.preg_quote($key, '/').'=.*/m';

            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, "{$key}={$formatted}", $content);
            } else {
                $content = rtrim($content).PHP_EOL."{$key}={$formatted}".PHP_EOL;
            }
        }

        file_put_contents($path, $content);
    }

    private static function formatValue(string $value): string
    {
        if ($value === '') {
            return '';
        }

        if (preg_match('/[\s#="\']/', $value)) {
            return '"'.str_replace(['\\', '"'], ['\\\\', '\\"'], $value).'"';
        }

        return $value;
    }
}
