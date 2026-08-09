<?php

namespace App\Core;

class View {
    public static function render(string $viewPath, array $data = [], string $layout = 'layouts/main'): void {
        $lang = Language::current();
        $seo = $data['seo'] ?? [
            'title' => __('site_name'),
            'description' => __('hero_sub'),
            'image' => asset('assets/images/hero.webp'),
            'canonical' => base_url($_SERVER['REQUEST_URI'] ?? ''),
        ];

        extract($data);

        ob_start();
        $viewFile = __DIR__ . '/../../views/' . ltrim($viewPath, '/') . '.php';
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            echo "View file not found: " . e($viewPath);
        }
        $content = ob_get_clean();

        if ($layout) {
            $layoutFile = __DIR__ . '/../../views/' . ltrim($layout, '/') . '.php';
            if (file_exists($layoutFile)) {
                require $layoutFile;
            } else {
                echo $content;
            }
        } else {
            echo $content;
        }
    }
}
