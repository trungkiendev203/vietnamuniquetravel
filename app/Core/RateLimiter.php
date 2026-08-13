<?php

namespace App\Core;

class RateLimiter {
    private static ?string $storageDir = null;
    private static array $memoryState = [];

    private static function getDir(): string {
        if (self::$storageDir === null) {
            $isVercel = isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || getenv('VERCEL');
            self::$storageDir = $isVercel ? '/tmp/cache/ratelimit/' : __DIR__ . '/../../storage/cache/ratelimit/';
            if (!is_dir(self::$storageDir)) {
                @mkdir(self::$storageDir, 0755, true);
            }
        }
        return self::$storageDir;
    }

    public static function tooManyAttempts(string $key, int $maxAttempts = 60, int $decaySeconds = 60): bool {
        $now = time();
        $file = self::getDir() . md5($key) . '.json';

        if (array_key_exists($key, self::$memoryState)) {
            $data = self::$memoryState[$key];
            if ($data['reset_at'] > $now) {
                return $data['attempts'] >= $maxAttempts;
            }
        }

        if (file_exists($file)) {
            $raw = @file_get_contents($file);
            if ($raw) {
                $data = @json_decode($raw, true);
                if (is_array($data) && isset($data['reset_at']) && $data['reset_at'] > $now) {
                    self::$memoryState[$key] = $data;
                    return ($data['attempts'] ?? 0) >= $maxAttempts;
                }
            }
            @unlink($file);
        }

        return false;
    }

    public static function hit(string $key, int $decaySeconds = 60): int {
        $now = time();
        $file = self::getDir() . md5($key) . '.json';
        $attempts = 1;
        $resetAt = $now + $decaySeconds;

        if (file_exists($file)) {
            $raw = @file_get_contents($file);
            if ($raw) {
                $data = @json_decode($raw, true);
                if (is_array($data) && isset($data['reset_at']) && $data['reset_at'] > $now) {
                    $attempts = ($data['attempts'] ?? 0) + 1;
                    $resetAt = $data['reset_at'];
                }
            }
        }

        $payload = [
            'attempts' => $attempts,
            'reset_at' => $resetAt
        ];

        self::$memoryState[$key] = $payload;
        @file_put_contents($file, json_encode($payload), LOCK_EX);

        return $attempts;
    }

    public static function availableIn(string $key): int {
        $now = time();
        $file = self::getDir() . md5($key) . '.json';

        if (array_key_exists($key, self::$memoryState)) {
            return max(0, self::$memoryState[$key]['reset_at'] - $now);
        }

        if (file_exists($file)) {
            $raw = @file_get_contents($file);
            if ($raw) {
                $data = @json_decode($raw, true);
                if (is_array($data) && isset($data['reset_at'])) {
                    return max(0, $data['reset_at'] - $now);
                }
            }
        }
        return 0;
    }

    public static function clear(string $key): void {
        unset(self::$memoryState[$key]);
        $file = self::getDir() . md5($key) . '.json';
        if (file_exists($file)) {
            @unlink($file);
        }
    }
}
