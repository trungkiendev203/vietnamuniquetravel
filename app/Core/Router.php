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
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        
        $pos = strpos($uri, '?');
        if ($pos !== false) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rtrim($uri, '/') ?: '/';

        // Extract language prefix if present (e.g., /en/..., /vi/...)
        $lang = 'en';
        if (preg_match('#^/(en|vi)(/.*)?$#i', $uri, $matches)) {
            $lang = strtolower($matches[1]);
            $uri = $matches[2] ?? '/';
            $uri = rtrim($uri, '/') ?: '/';
        }
        Language::setLang($lang);

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) continue;

            $pattern = preg_replace('#\{([a-zA-Z0-9_]+)\}#', '(?P<\1>[^/]+)', $route['path']);
            $pattern = "#^" . $pattern . "$#i";

            if (preg_match($pattern, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
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
