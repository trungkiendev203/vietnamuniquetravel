<?php

namespace App\Core;

class Language {
    private static string $currentLang = 'en';
    private static array $translations = [];

    public static function setLang(string $lang): void {
        self::$currentLang = in_array($lang, ['en', 'vi']) ? $lang : 'en';
        self::load();
    }

    public static function current(): string {
        return self::$currentLang;
    }

    private static function load(): void {
        $file = __DIR__ . '/../../lang/' . self::$currentLang . '.php';
        if (file_exists($file)) {
            self::$translations = require $file;
        } else {
            self::$translations = [];
        }
    }

    public static function get(string $key, ?string $lang = null): string {
        if ($lang && $lang !== self::$currentLang) {
            $file = __DIR__ . '/../../lang/' . $lang . '.php';
            if (file_exists($file)) {
                $trans = require $file;
                return $trans[$key] ?? $key;
            }
        }
        if (empty(self::$translations)) {
            self::load();
        }
        return self::$translations[$key] ?? $key;
    }
}
