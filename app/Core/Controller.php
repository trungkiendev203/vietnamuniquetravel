<?php

namespace App\Core;

abstract class Controller {
    protected Request $request;
    protected Response $response;

    public function __construct() {
        $this->request = new Request();
        $this->response = new Response();
    }

    protected function render(string $viewPath, array $data = [], string $layout = 'layouts/main'): void {
        View::render($viewPath, $data, $layout);
    }

    protected function json(array $data, int $statusCode = 200): void {
        $this->response->json($data, $statusCode);
    }

    protected function redirect(string $url): void {
        $this->response->redirect($url);
    }
}
