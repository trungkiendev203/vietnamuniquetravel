<?php

namespace App\Services;

class ImageService {
    private string $uploadBasePath;
    private array $allowedMimes = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/webp',
        'image/gif'
    ];

    public function __construct() {
        $this->uploadBasePath = rtrim(__DIR__ . '/../../public/uploads', '/\\');
    }

    /**
     * Upload an image and automatically convert it to optimized WebP format
     *
     * @param array $file $_FILES['image'] entry
     * @param string $subfolder e.g. 'posts', 'tours', 'destinations'
     * @param int $maxWidth Max width constraint (default 1920px)
     * @param int $quality WebP quality 1-100 (default 82)
     * @return array [success => bool, url => string, filename => string, ...]
     */
    public function uploadAndConvertToWebp(array $file, string $subfolder = 'posts', int $maxWidth = 1920, int $quality = 82): array {
        if (!isset($file['error']) || is_array($file['error'])) {
            return ['success' => false, 'message' => 'Invalid upload parameters.'];
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'Upload failed with code: ' . $file['error']];
        }

        // Limit file size (10 MB max)
        if ($file['size'] > 10 * 1024 * 1024) {
            return ['success' => false, 'message' => 'File size exceeds maximum limit of 10MB.'];
        }

        // Validate MIME type
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        if (!in_array($mimeType, $this->allowedMimes)) {
            return ['success' => false, 'message' => 'Invalid image format. Allowed: JPG, PNG, WebP, GIF.'];
        }

        // Target folder
        $cleanSubfolder = preg_replace('#[^a-zA-Z0-9_-]#', '', $subfolder) ?: 'general';
        $targetDir = $this->uploadBasePath . DIRECTORY_SEPARATOR . $cleanSubfolder;
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Generate safe unique filename with .webp extension
        $origName = pathinfo($file['name'], PATHINFO_FILENAME);
        $safeSlug = preg_replace('#[^a-zA-Z0-9_-]#', '-', strtolower($origName));
        $safeSlug = substr(trim($safeSlug, '-'), 0, 50) ?: 'image';
        $uniqueFilename = $safeSlug . '-' . time() . '-' . mt_rand(100, 999) . '.webp';
        $targetPath = $targetDir . DIRECTORY_SEPARATOR . $uniqueFilename;

        // Perform WebP conversion and optimization
        $converted = $this->processAndSaveWebp($file['tmp_name'], $targetPath, $mimeType, $maxWidth, $quality);

        if (!$converted || !file_exists($targetPath)) {
            // Fallback: move uploaded file directly if WebP processing failed
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $fallbackFilename = $safeSlug . '-' . time() . '.' . $ext;
            $fallbackPath = $targetDir . DIRECTORY_SEPARATOR . $fallbackFilename;
            if (move_uploaded_file($file['tmp_name'], $fallbackPath)) {
                return [
                    'success' => true,
                    'url' => '/uploads/' . $cleanSubfolder . '/' . $fallbackFilename,
                    'filename' => $fallbackFilename,
                    'format' => $ext,
                    'size' => filesize($fallbackPath)
                ];
            }
            return ['success' => false, 'message' => 'Failed to process and save image.'];
        }

        $fileSize = filesize($targetPath);
        $imgSize = @getimagesize($targetPath);

        return [
            'success' => true,
            'url' => '/uploads/' . $cleanSubfolder . '/' . $uniqueFilename,
            'filename' => $uniqueFilename,
            'format' => 'webp',
            'width' => $imgSize[0] ?? null,
            'height' => $imgSize[1] ?? null,
            'size_bytes' => $fileSize,
            'size_formatted' => round($fileSize / 1024, 1) . ' KB'
        ];
    }

    /**
     * Convert and resize image to WebP using available drivers
     */
    private function processAndSaveWebp(string $sourcePath, string $targetPath, string $mimeType, int $maxWidth, int $quality): bool {
        // Driver 1: PHP GD Extension
        if (extension_loaded('gd') && function_exists('imagewebp')) {
            $srcImg = null;
            switch ($mimeType) {
                case 'image/jpeg':
                case 'image/jpg':
                    $srcImg = @imagecreatefromjpeg($sourcePath);
                    break;
                case 'image/png':
                    $srcImg = @imagecreatefrompng($sourcePath);
                    break;
                case 'image/webp':
                    $srcImg = @imagecreatefromwebp($sourcePath);
                    break;
                case 'image/gif':
                    $srcImg = @imagecreatefromgif($sourcePath);
                    break;
            }

            if ($srcImg) {
                $origWidth = imagesx($srcImg);
                $origHeight = imagesy($srcImg);

                // Calculate proportional resize
                if ($origWidth > $maxWidth) {
                    $newWidth = $maxWidth;
                    $newHeight = (int)round(($origHeight / $origWidth) * $newWidth);
                } else {
                    $newWidth = $origWidth;
                    $newHeight = $origHeight;
                }

                $dstImg = imagecreatetruecolor($newWidth, $newHeight);

                // Preserve PNG Alpha Channel Transparency
                imagealphablending($dstImg, false);
                imagesavealpha($dstImg, true);
                $transparent = imagecolorallocatealpha($dstImg, 255, 255, 255, 127);
                imagefilledrectangle($dstImg, 0, 0, $newWidth, $newHeight, $transparent);

                // Resample with high quality interpolation
                imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

                // Save as WebP
                $success = imagewebp($dstImg, $targetPath, $quality);

                imagedestroy($srcImg);
                imagedestroy($dstImg);

                if ($success && file_exists($targetPath)) {
                    return true;
                }
            }
        }

        // Driver 2: PHP Imagick Extension
        if (extension_loaded('imagick') && class_exists('\Imagick')) {
            try {
                $imagick = new \Imagick($sourcePath);
                $imagick->stripImage(); // Remove metadata

                if ($imagick->getImageWidth() > $maxWidth) {
                    $imagick->resizeImage($maxWidth, 0, \Imagick::FILTER_LANCZOS, 1);
                }

                $imagick->setImageFormat('webp');
                $imagick->setImageCompressionQuality($quality);
                $imagick->setOption('webp:lossless', 'false');
                $imagick->setOption('webp:method', '6');

                $success = $imagick->writeImage($targetPath);
                $imagick->clear();
                $imagick->destroy();

                if ($success && file_exists($targetPath)) {
                    return true;
                }
            } catch (\Exception $e) {
                // proceed to fallback
            }
        }

        return false;
    }
}
