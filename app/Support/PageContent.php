<?php

namespace App\Support;

use Illuminate\Support\Facades\View;

class PageContent
{
    /** @var array<string, array<string, mixed>> */
    private static array $defaults = [];

    /**
     * @return array<string, mixed>
     */
    public static function get(string $page): array
    {
        $defaults = self::defaults($page);
        $stored = config("site.page_{$page}");

        if (! is_array($stored) || $stored === []) {
            return $defaults;
        }

        return array_replace_recursive($defaults, $stored);
    }

    /**
     * @return array<string, mixed>
     */
    private static function defaults(string $page): array
    {
        if (isset(self::$defaults[$page])) {
            return self::$defaults[$page];
        }

        $path = config_path("page_defaults/{$page}.php");

        if (is_file($path)) {
            self::$defaults[$page] = require $path;

            return self::$defaults[$page];
        }

        self::$defaults[$page] = [];

        return self::$defaults[$page];
    }

    public static function defaultBodyHtml(string $page): string
    {
        $view = "pages.partials.{$page}-body";

        if (! View::exists($view)) {
            return '';
        }

        return trim(View::make($view)->render());
    }

    /**
     * @return array<string, string>
     */
    public static function documentToc(string $page): array
    {
        $content = self::get($page);

        return is_array($content['toc'] ?? null) ? $content['toc'] : [];
    }

    public static function documentBodyHtml(string $page): string
    {
        $content = self::get($page);
        $body = $content['body_html'] ?? null;

        if (is_string($body) && trim($body) !== '') {
            return $body;
        }

        return self::defaultBodyHtml($page);
    }
}
