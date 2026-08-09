<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Csrf;
use App\Core\Cache;
use App\Models\Tour;

class TourAdminController extends Controller {
    public function __construct() {
        parent::__construct();
        if (!Session::has('admin_id')) {
            $this->redirect(base_url('admin/login'));
            exit;
        }
    }

    public function index(): void {
        $tourModel = new Tour();
        $tours = $tourModel->getAll('en');

        $seo = ['title' => 'Tour Management - Admin'];
        $this->render('admin/tours/index', compact('tours', 'seo'), 'layouts/admin');
    }

    public function toggleStatus(int $id): void {
        if (!Csrf::verify($this->request->post('_csrf'))) {
            $this->redirect(base_url('admin/tours'));
            return;
        }

        $tourModel = new Tour();
        $tourModel->execute("UPDATE tours SET status = IF(status=1, 0, 1) WHERE id = :id", ['id' => $id]);
        Cache::flush();
        Session::flash('success', 'Tour status toggled successfully.');
        $this->redirect(base_url('admin/tours'));
    }

    public function toggleSignature(int $id): void {
        if (!Csrf::verify($this->request->post('_csrf'))) {
            $this->redirect(base_url('admin/tours'));
            return;
        }

        $tourModel = new Tour();
        $tourModel->execute("UPDATE tours SET is_signature = IF(is_signature=1, 0, 1) WHERE id = :id", ['id' => $id]);
        Cache::flush();
        Session::flash('success', 'Signature status toggled successfully.');
        $this->redirect(base_url('admin/tours'));
    }
}
