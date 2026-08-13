<?php

namespace App\Core;

class Router {
    private array $routes = [];

    public function get(string $path, $callback): void {
        $this->addRoute('GET', $path, $callback);
    }

    public function post(string $path, $callback): void {
        $this->addRoute('POST', $path, $callback);
    }

    private function addRoute(string $method, string $path, $callback): void {
        $this->routes[] = [
            'method' => $method,
            'path' => rtrim($path, '/') ?: '/',
            'callback' => $callback
        ];
    }

    public function dispatch(): void {
        $startTime = microtime(true);
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        
        $pos = strpos($uri, '?');
        if ($pos !== false) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rtrim($uri, '/') ?: '/';

        // Healthcheck & Observability endpoint
        if ($uri === '/healthz' || $uri === '/api/health') {
            header('Content-Type: application/json; charset=utf-8');
            header('Cache-Control: no-cache, no-store, must-revalidate');
            echo json_encode([
                'status' => 'healthy',
                'service' => 'vietnamuniquetravel',
                'php_version' => PHP_VERSION,
                'memory_usage_mb' => round(memory_get_usage(true) / 1024 / 1024, 2),
                'peak_memory_mb' => round(memory_get_peak_usage(true) / 1024 / 1024, 2),
                'timestamp' => time()
            ]);
            return;
        }

        // Global Security & Performance Headers
        if (!headers_sent()) {
            header('X-Content-Type-Options: nosniff');
            header('X-Frame-Options: SAMEORIGIN');
            header('Vary: Accept-Encoding, Accept-Language');
        }

        // Extract language prefix if present (e.g., /en/..., /vi/...)
        $lang = 'en';
        if (preg_match('#^/(en|vi)(/.*)?$#i', $uri, $matches)) {
            $lang = strtolower($matches[1]);
            $uri = $matches[2] ?? '/';
            $uri = rtrim($uri, '/') ?: '/';
        } elseif (preg_match('#^/(meo-du-lich|ve-chung-toi|lien-he)(/.*)?$#i', $uri)) {
            $lang = 'vi';
        }
        Language::setLang($lang);

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) continue;

            $pattern = preg_replace('#\{([a-zA-Z0-9_]+)\}#', '(?P<\1>[^/]+)', $route['path']);
            $pattern = "#^" . $pattern . "$#i";

            if (preg_match($pattern, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                if (!headers_sent()) {
                    $executionMs = round((microtime(true) - $startTime) * 1000, 2);
                    header("Server-Timing: app;dur={$executionMs}");
                }

                if (is_array($route['callback'])) {
                    list($class, $methodName) = $route['callback'];
                    $controller = new $class();
                    call_user_func_array([$controller, $methodName], $params);
                    return;
                } elseif (is_callable($route['callback'])) {
                    call_user_func_array($route['callback'], $params);
                    return;
                }
            }
        }

        // 404 fallback
        http_response_code(404);
        View::render('pages/404', [
            'seo' => ['title' => '404 - Page Not Found | Vietnam Unique Travel']
        ]);
    }
}
