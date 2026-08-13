<?php
/**
 * Vietnam Unique Travel - Front Controller Entry Point
 */

define('VNU_START', microtime(true));

// Load Composer / Custom Autoloader
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Helpers/Functions.php';

// Session & Security initialization
\App\Core\Session::start();

// Enable Error Logging without exposing details to visitors
ini_set('display_errors', env('APP_DEBUG', 'false') === 'true' ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../storage/logs/error.log');

// Router Setup & Routes Dispatch
$router = new \App\Core\Router();

// Public Frontend Routes
$router->get('/', [\App\Controllers\HomeController::class, 'index']);
$router->get('/tours', [\App\Controllers\TourController::class, 'list']);
$router->get('/tours/{slug}', [\App\Controllers\TourController::class, 'detail']);
$router->post('/tours/{slug}/review', [\App\Controllers\TourController::class, 'submitReview']);
$router->get('/destinations', [\App\Controllers\DestinationController::class, 'list']);
$router->get('/destinations/{slug}', [\App\Controllers\DestinationController::class, 'detail']);
$router->get('/experiences', [\App\Controllers\ExperienceController::class, 'index']);
$router->get('/about-us', [\App\Controllers\PageController::class, 'about']);
$router->get('/ve-chung-toi', [\App\Controllers\PageController::class, 'about']);
$router->get('/responsible-tourism', [\App\Controllers\PageController::class, 'responsibleTourism']);
$router->get('/faq', [\App\Controllers\PageController::class, 'faq']);
$router->get('/contact', [\App\Controllers\PageController::class, 'contact']);
$router->get('/lien-he', [\App\Controllers\PageController::class, 'contact']);
$router->post('/contact/submit', [\App\Controllers\PageController::class, 'submitContact']);
$router->get('/policy/{type}', [\App\Controllers\PageController::class, 'policy']);
$router->get('/travel-tips', [\App\Controllers\BlogController::class, 'list']);
$router->get('/meo-du-lich', [\App\Controllers\BlogController::class, 'list']);
$router->get('/travel-tips/{slug}', [\App\Controllers\BlogController::class, 'detail']);
$router->get('/meo-du-lich/{slug}', [\App\Controllers\BlogController::class, 'detail']);
$router->get('/blog', [\App\Controllers\BlogController::class, 'list']);
$router->get('/blog/{slug}', [\App\Controllers\BlogController::class, 'detail']);
$router->get('/booking', [\App\Controllers\BookingController::class, 'form']);
$router->post('/booking/submit', [\App\Controllers\BookingController::class, 'submit']);
$router->get('/booking-success', [\App\Controllers\BookingController::class, 'success']);
$router->get('/search', [\App\Controllers\SearchController::class, 'index']);
$router->get('/healthz', function() {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'status' => 'healthy',
        'service' => 'vietnamuniquetravel',
        'php_version' => PHP_VERSION,
        'memory_usage_mb' => round(memory_get_usage(true) / 1024 / 1024, 2),
        'timestamp' => time()
    ]);
});
$router->get('/sitemap.xml', [\App\Controllers\SitemapController::class, 'xml']);
$router->get('/robots.txt', [\App\Controllers\SitemapController::class, 'robots']);

// Admin Auth Routes
$router->get('/admin/login', [\App\Controllers\Admin\AuthController::class, 'loginForm']);
$router->post('/admin/login', [\App\Controllers\Admin\AuthController::class, 'loginSubmit']);
$router->get('/admin/logout', [\App\Controllers\Admin\AuthController::class, 'logout']);

// Admin Dashboard Routes
$router->get('/admin/dashboard', [\App\Controllers\Admin\DashboardController::class, 'index']);

// Admin Booking Routes
$router->get('/admin/bookings', [\App\Controllers\Admin\BookingAdminController::class, 'index']);
$router->get('/admin/bookings/{code}', [\App\Controllers\Admin\BookingAdminController::class, 'detail']);
$router->post('/admin/bookings/{code}/update', [\App\Controllers\Admin\BookingAdminController::class, 'updateStatus']);

// Admin Tour Management Routes
$router->get('/admin/tours', [\App\Controllers\Admin\TourAdminController::class, 'index']);
$router->get('/admin/tours/create', [\App\Controllers\Admin\TourAdminController::class, 'create']);
$router->get('/admin/tours/{id}/edit', [\App\Controllers\Admin\TourAdminController::class, 'edit']);
$router->post('/admin/tours/save', [\App\Controllers\Admin\TourAdminController::class, 'save']);
$router->post('/admin/tours/{id}/toggle-status', [\App\Controllers\Admin\TourAdminController::class, 'toggleStatus']);
$router->post('/admin/tours/{id}/toggle-signature', [\App\Controllers\Admin\TourAdminController::class, 'toggleSignature']);
$router->post('/admin/tours/{id}/delete', [\App\Controllers\Admin\TourAdminController::class, 'delete']);

// Admin Review Moderation Routes
$router->get('/admin/reviews', [\App\Controllers\Admin\ReviewAdminController::class, 'index']);
$router->get('/admin/reviews/{id}', [\App\Controllers\Admin\ReviewAdminController::class, 'detail']);
$router->post('/admin/reviews/{id}/status', [\App\Controllers\Admin\ReviewAdminController::class, 'updateStatus']);
$router->post('/admin/reviews/{id}/update', [\App\Controllers\Admin\ReviewAdminController::class, 'update']);
$router->post('/admin/reviews/{id}/delete', [\App\Controllers\Admin\ReviewAdminController::class, 'delete']);

// Admin Notification Routes
$router->get('/admin/notifications', [\App\Controllers\Admin\NotificationAdminController::class, 'index']);
$router->get('/admin/notifications/{id}/open', [\App\Controllers\Admin\NotificationAdminController::class, 'open']);
$router->post('/admin/notifications/{id}/read', [\App\Controllers\Admin\NotificationAdminController::class, 'markRead']);
$router->post('/admin/notifications/mark-all-read', [\App\Controllers\Admin\NotificationAdminController::class, 'markAllRead']);

// Admin Settings & Media Routes
$router->get('/admin/settings', [\App\Controllers\Admin\SettingAdminController::class, 'index']);
$router->post('/admin/settings/save', [\App\Controllers\Admin\SettingAdminController::class, 'save']);
$router->post('/admin/api/upload-image', [\App\Controllers\Admin\MediaAdminController::class, 'upload']);

// Dispatch Application
$router->dispatch();

