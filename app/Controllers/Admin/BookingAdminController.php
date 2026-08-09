<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Csrf;
use App\Models\Booking;

class BookingAdminController extends Controller {
    public function __construct() {
        parent::__construct();
        if (!Session::has('admin_id')) {
            $this->redirect(base_url('admin/login'));
            exit;
        }
    }

    public function index(): void {
        $status = $this->request->get('status');
        $search = $this->request->get('search');
        $bookingModel = new Booking();

        $bookings = $bookingModel->getAll(['status' => $status, 'search' => $search]);

        $seo = ['title' => 'Booking Management - Admin'];
        $this->render('admin/bookings/index', compact('bookings', 'status', 'search', 'seo'), 'layouts/admin');
    }

    public function detail(string $code): void {
        $bookingModel = new Booking();
        $booking = $bookingModel->getByCode($code);

        if (!$booking) {
            Session::flash('error', 'Booking not found.');
            $this->redirect(base_url('admin/bookings'));
            return;
        }

        $seo = ['title' => 'Booking ' . $code . ' - Admin'];
        $this->render('admin/bookings/detail', compact('booking', 'seo'), 'layouts/admin');
    }

    public function updateStatus(string $code): void {
        if (!Csrf::verify($this->request->post('_csrf'))) {
            Session::flash('error', 'Invalid token.');
            $this->redirect(base_url('admin/bookings/' . $code));
            return;
        }

        $bookingModel = new Booking();
        $booking = $bookingModel->getByCode($code);

        if ($booking) {
            $status = $this->request->post('status');
            $notes = $this->request->post('internal_notes');
            $bookingModel->updateStatus($booking['id'], $status, $notes);
            Session::flash('success', 'Booking status updated successfully.');
        }

        $this->redirect(base_url('admin/bookings/' . $code));
    }
}
