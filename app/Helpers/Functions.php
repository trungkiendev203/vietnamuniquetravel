<?php

if (!function_exists('env')) {
    function env($key, $default = null) {
        static $envVars = null;
        if ($envVars === null) {
            $envVars = [];
            $envPath = __DIR__ . '/../../.env';
            if (file_exists($envPath)) {
                $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '' || strpos($line, '#') === 0) continue;
                    if (strpos($line, '=') !== false) {
                        list($name, $val) = explode('=', $line, 2);
                        $name = trim($name);
                        $val = trim($val, " \t\n\r\0\x0B\"'");
                        $envVars[$name] = $val;
                    }
                }
            }
        }
        return array_key_exists($key, $envVars) ? $envVars[$key] : $default;
    }
}

if (!function_exists('base_url')) {
    function base_url($path = '') {
        $baseUrl = rtrim(env('APP_URL', 'http://localhost:8000'), '/');
        $path = ltrim($path, '/');
        return $path ? $baseUrl . '/' . $path : $baseUrl;
    }
}

if (!function_exists('asset')) {
    function asset($path) {
        return base_url(ltrim($path, '/'));
    }
}

if (!function_exists('__')) {
    function __($key, $lang = null) {
        return \App\Core\Language::get($key, $lang);
    }
}

if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('sanitize_output')) {
    function sanitize_output($value) {
        return e($value);
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field() {
        return '<input type="hidden" name="_csrf" value="' . \App\Core\Csrf::generate() . '">';
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token() {
        return \App\Core\Csrf::generate();
    }
}

if (!function_exists('current_lang')) {
    function current_lang() {
        return \App\Core\Language::current();
    }
}

if (!function_exists('format_price_vnd')) {
    function format_price_vnd($amount) {
        return number_format($amount, 0, ',', '.') . ' VNĐ';
    }
}

if (!function_exists('format_price_usd')) {
    function format_price_usd($amount) {
        return '$' . number_format($amount, 0);
    }
}
