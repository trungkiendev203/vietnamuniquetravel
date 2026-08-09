<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Booking;
use App\Models\Tour;

class DashboardController extends Controller {
    public function __construct() {
        parent::__construct();
        if (!Session::has('admin_id')) {
            $this->redirect(base_url('admin/login'));
            exit;
        }
    }

    public function index(): void {
        $bookingModel = new Booking();
        $tourModel = new Tour();

        $allBookings = $bookingModel->getAll();
        $recentBookings = array_slice($allBookings, 0, 5);
        $tours = $tourModel->getAll('en');

        $stats = [
            'total_bookings' => count($allBookings),
            'new_bookings' => count(array_filter($allBookings, fn($b) => $b['status'] === 'new')),
            'confirmed_bookings' => count(array_filter($allBookings, fn($b) => $b['status'] === 'confirmed')),
            'total_tours' => count($tours)
        ];

        $seo = ['title' => 'Admin Dashboard - Vietnam Unique Travel'];
        $this->render('admin/dashboard', compact('stats', 'recentBookings', 'seo'), 'layouts/admin');
    }
}
