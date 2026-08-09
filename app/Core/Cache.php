<?php

namespace App\Core;

class Cache {
    private static string $cacheDir = __DIR__ . '/../../storage/cache/';

    private static function initDir(): void {
        if (!is_dir(self::$cacheDir)) {
            mkdir(self::$cacheDir, 0755, true);
        }
    }

    public static function get(string $key) {
        self::initDir();
        $file = self::$cacheDir . md5($key) . '.cache';
        if (file_exists($file)) {
            $data = unserialize(file_get_contents($file));
            if ($data['expires'] > time()) {
                return $data['content'];
            }
            @unlink($file);
        }
        return null;
    }

    public static function set(string $key, $content, int $ttl = 3600): void {
        self::initDir();
        $file = self::$cacheDir . md5($key) . '.cache';
        $data = [
            'expires' => time() + $ttl,
            'content' => $content
        ];
        file_put_contents($file, serialize($data), LOCK_EX);
    }

    public static function flush(): void {
        self::initDir();
        $files = glob(self::$cacheDir . '*.cache');
        if ($files) {
            foreach ($files as $file) {
                @unlink($file);
            }
        }
    }
}
