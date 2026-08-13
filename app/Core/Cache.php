<?php

namespace App\Core;

class Cache {
    private static ?string $cacheDir = null;
    private static array $memoryCache = [];

    private static function getDir(): string {
        if (self::$cacheDir === null) {
            $isVercel = isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || getenv('VERCEL');
            self::$cacheDir = $isVercel ? '/tmp/cache/' : __DIR__ . '/../../storage/cache/';
            if (!is_dir(self::$cacheDir)) {
                @mkdir(self::$cacheDir, 0755, true);
            }
        }
        return self::$cacheDir;
    }

    public static function get(string $key) {
        if (array_key_exists($key, self::$memoryCache)) {
            $mem = self::$memoryCache[$key];
            if ($mem['expires'] > time()) {
                return $mem['content'];
            }
            unset(self::$memoryCache[$key]);
        }

        $dir = self::getDir();
        $file = $dir . md5($key) . '.cache';
        if (file_exists($file)) {
            $raw = @file_get_contents($file);
            if ($raw !== false) {
                $data = @unserialize($raw);
                if (is_array($data) && isset($data['expires']) && $data['expires'] > time()) {
                    self::$memoryCache[$key] = $data;
                    return $data['content'];
                }
            }
            @unlink($file);
        }
        return null;
    }

    public static function set(string $key, $content, int $ttl = 3600): void {
        $expires = time() + $ttl;
        $data = [
            'expires' => $expires,
            'content' => $content
        ];
        self::$memoryCache[$key] = $data;

        $dir = self::getDir();
        $file = $dir . md5($key) . '.cache';
        @file_put_contents($file, serialize($data), LOCK_EX);
    }

    public static function remember(string $key, int $ttl, callable $callback) {
        $cached = self::get($key);
        if ($cached !== null) {
            return $cached;
        }

        $fresh = $callback();
        self::set($key, $fresh, $ttl);
        return $fresh;
    }

    public static function forget(string $key): void {
        unset(self::$memoryCache[$key]);
        $dir = self::getDir();
        $file = $dir . md5($key) . '.cache';
        if (file_exists($file)) {
            @unlink($file);
        }
    }

    public static function flush(): void {
        self::$memoryCache = [];
        $dir = self::getDir();
        $files = @glob($dir . '*.cache');
        if ($files) {
            foreach ($files as $file) {
                @unlink($file);
            }
        }
    }
}
