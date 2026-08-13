<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Csrf;
use App\Core\Cache;
use App\Models\Review;
use App\Models\Tour;

class ReviewAdminController extends Controller {
    public function __construct() {
        parent::__construct();
        if (!Session::has('admin_id')) {
            $this->redirect(base_url('admin/login'));
            exit;
        }
    }

    public function index(): void {
        $reviewModel = new Review();
        $tourModel = new Tour();

        $status = $this->request->get('status', 'all');
        $tourId = $this->request->get('tour_id', '');
        $search = $this->request->get('search', '');

        $reviews = $reviewModel->getAllForAdmin([
            'status' => $status,
            'tour_id' => $tourId,
            'search' => $search
        ]);

        $tours = $tourModel->getAll('en', ['include_hidden' => true]);

        $seo = ['title' => 'Review Moderation - Admin'];
        $this->render('admin/reviews/index', compact('reviews', 'tours', 'status', 'tourId', 'search', 'seo'), 'layouts/admin');
    }

    public function detail(int $id): void {
        $reviewModel = new Review();
        $review = $reviewModel->getById($id);

        if (!$review) {
            Session::flash('error', 'Review not found.');
            $this->redirect(base_url('admin/reviews'));
            return;
        }

        $seo = ['title' => 'Review #' . $id . ' - Admin'];
        $this->render('admin/reviews/detail', compact('review', 'seo'), 'layouts/admin');
    }

    public function updateStatus(int $id): void {
        if (!Csrf::verify($this->request->post('_csrf'))) {
            Session::flash('error', 'Invalid token.');
            $this->redirect(base_url('admin/reviews'));
            return;
        }

        $status = $this->request->post('status');
        $reviewModel = new Review();
        $reviewModel->updateStatus($id, $status);
        Cache::flush();

        Session::flash('success', 'Review status updated to ' . $status . '.');
        $this->redirect(base_url('admin/reviews'));
    }

    public function update(int $id): void {
        if (!Csrf::verify($this->request->post('_csrf'))) {
            Session::flash('error', 'Invalid token.');
            $this->redirect(base_url('admin/reviews/' . $id));
            return;
        }

        $clientName = trim($this->request->post('client_name', ''));
        $rating = (int)$this->request->post('rating', 5);
        $content = trim($this->request->post('content', ''));
        $status = $this->request->post('status', 'pending');

        if (!$clientName || !$content) {
            Session::flash('error', 'Client name and review content cannot be empty.');
            $this->redirect(base_url('admin/reviews/' . $id));
            return;
        }

        $reviewModel = new Review();
        $reviewModel->updateReview($id, [
            'client_name' => $clientName,
            'rating' => $rating,
            'content' => $content,
            'status' => $status
        ]);
        Cache::flush();

        Session::flash('success', 'Review details updated successfully.');
        $this->redirect(base_url('admin/reviews/' . $id));
    }

    public function delete(int $id): void {
        if (!Csrf::verify($this->request->post('_csrf'))) {
            Session::flash('error', 'Invalid token.');
            $this->redirect(base_url('admin/reviews'));
            return;
        }

        $reviewModel = new Review();
        $reviewModel->deleteReview($id);
        Cache::flush();

        Session::flash('success', 'Review deleted successfully.');
        $this->redirect(base_url('admin/reviews'));
    }
}
