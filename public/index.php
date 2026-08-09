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
$router->get('/blog', [\App\Controllers\BlogController::class, 'list']);
$router->get('/blog/{slug}', [\App\Controllers\BlogController::class, 'detail']);
$router->get('/booking', [\App\Controllers\BookingController::class, 'form']);
$router->post('/booking/submit', [\App\Controllers\BookingController::class, 'submit']);
$router->get('/booking-success', [\App\Controllers\BookingController::class, 'success']);
$router->get('/search', [\App\Controllers\SearchController::class, 'index']);
$router->get('/sitemap.xml', [\App\Controllers\SitemapController::class, 'xml']);
$router->get('/robots.txt', [\App\Controllers\SitemapController::class, 'robots']);

// Admin Routes
$router->get('/admin/login', [\App\Controllers\Admin\AuthController::class, 'loginForm']);
$router->post('/admin/login', [\App\Controllers\Admin\AuthController::class, 'loginSubmit']);
$router->get('/admin/logout', [\App\Controllers\Admin\AuthController::class, 'logout']);
$router->get('/admin/dashboard', [\App\Controllers\Admin\DashboardController::class, 'index']);
$router->get('/admin/bookings', [\App\Controllers\Admin\BookingAdminController::class, 'index']);
$router->get('/admin/bookings/{code}', [\App\Controllers\Admin\BookingAdminController::class, 'detail']);
$router->post('/admin/bookings/{code}/update', [\App\Controllers\Admin\BookingAdminController::class, 'updateStatus']);
$router->get('/admin/tours', [\App\Controllers\Admin\TourAdminController::class, 'index']);
$router->post('/admin/tours/{id}/toggle-status', [\App\Controllers\Admin\TourAdminController::class, 'toggleStatus']);
$router->post('/admin/tours/{id}/toggle-signature', [\App\Controllers\Admin\TourAdminController::class, 'toggleSignature']);
$router->get('/admin/settings', [\App\Controllers\Admin\SettingAdminController::class, 'index']);
$router->post('/admin/settings/save', [\App\Controllers\Admin\SettingAdminController::class, 'save']);

// Dispatch Application
$router->dispatch();
