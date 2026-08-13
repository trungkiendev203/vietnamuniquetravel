<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Services\ImageService;

class MediaAdminController extends Controller {
    /**
     * AJAX Endpoint: Upload image and auto-convert to WebP
     * POST /admin/api/upload-image
     */
    public function upload(): void {
        header('Content-Type: application/json; charset=utf-8');

        // Check if admin is authenticated (or allow session auth)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $folder = $this->request->get('folder', 'general');
        if (empty($_FILES['image']) && empty($_FILES['file']) && empty($_FILES['upload'])) {
            $this->response->json([
                'success' => false,
                'message' => 'No image file uploaded.'
            ], 400);
            return;
        }

        $fileEntry = $_FILES['image'] ?? $_FILES['file'] ?? $_FILES['upload'];
        $imageService = new ImageService();
        $result = $imageService->uploadAndConvertToWebp($fileEntry, $folder);

        if (!$result['success']) {
            $this->response->json($result, 422);
            return;
        }

        // Return standard response format (compatible with dropzone, custom file inputs & CKEditor/TinyMCE)
        $this->response->json([
            'success' => true,
            'url' => base_url($result['url']),
            'relative_url' => $result['url'],
            'filename' => $result['filename'],
            'format' => $result['format'],
            'size' => $result['size_formatted'] ?? '',
            'message' => 'Image successfully uploaded and optimized as WebP.'
        ]);
    }
}
