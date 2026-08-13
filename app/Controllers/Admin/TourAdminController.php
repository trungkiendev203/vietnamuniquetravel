<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Csrf;
use App\Core\Cache;
use App\Models\Tour;
use App\Models\Destination;
use App\Models\Category;

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
        $status = $this->request->get('status', 'all');
        $search = $this->request->get('search', '');

        $filters = [
            'status' => $status,
            'search' => $search,
            'include_hidden' => true
        ];

        $tours = $tourModel->getAll('en', $filters);

        $seo = ['title' => 'Tour Management - Admin'];
        $this->render('admin/tours/index', compact('tours', 'status', 'search', 'seo'), 'layouts/admin');
    }

    public function create(): void {
        $destModel = new Destination();
        $catModel = new Category();

        $destinations = $destModel->query("SELECT d.id, dt.name FROM destinations d LEFT JOIN destination_translations dt ON d.id = dt.destination_id AND dt.lang = 'en' ORDER BY dt.name ASC");
        $categories = $catModel->query("SELECT c.id, ct.name FROM categories c LEFT JOIN category_translations ct ON c.id = ct.category_id AND ct.lang = 'en' ORDER BY ct.name ASC");

        $tour = null;
        $seo = ['title' => 'Add New Tour - Admin'];
        $this->render('admin/tours/form', compact('tour', 'destinations', 'categories', 'seo'), 'layouts/admin');
    }

    public function edit(int $id): void {
        $tourModel = new Tour();
        $tour = $tourModel->getFullDetailForAdmin($id);

        if (!$tour) {
            Session::flash('error', 'Tour not found.');
            $this->redirect(base_url('admin/tours'));
            return;
        }

        $destModel = new Destination();
        $catModel = new Category();

        $destinations = $destModel->query("SELECT d.id, dt.name FROM destinations d LEFT JOIN destination_translations dt ON d.id = dt.destination_id AND dt.lang = 'en' ORDER BY dt.name ASC");
        $categories = $catModel->query("SELECT c.id, ct.name FROM categories c LEFT JOIN category_translations ct ON c.id = ct.category_id AND ct.lang = 'en' ORDER BY ct.name ASC");

        $seo = ['title' => 'Edit Tour: ' . $tour['code'] . ' - Admin'];
        $this->render('admin/tours/form', compact('tour', 'destinations', 'categories', 'seo'), 'layouts/admin');
    }

    public function save(): void {
        if (!Csrf::verify($this->request->post('_csrf'))) {
            Session::flash('error', 'Invalid security token.');
            $this->redirect(base_url('admin/tours'));
            return;
        }

        $id = $this->request->post('id') ? (int)$this->request->post('id') : null;
        $code = trim($this->request->post('code', ''));
        $slug = trim($this->request->post('slug', ''));
        $titleEn = trim($this->request->post('title_en', ''));
        $titleVi = trim($this->request->post('title_vi', ''));

        // Server-side Validation
        if (!$code || !$slug || !$titleEn) {
            Session::flash('error', 'Tour code, slug, and English title are required.');
            if ($id) {
                $this->redirect(base_url('admin/tours/' . $id . '/edit'));
            } else {
                $this->redirect(base_url('admin/tours/create'));
            }
            return;
        }

        // Format Gallery Images
        $imagePaths = $this->request->post('gallery_image_path', []);
        $imageCaptions = $this->request->post('gallery_image_caption', []);
        $images = [];
        if (is_array($imagePaths)) {
            foreach ($imagePaths as $k => $p) {
                if (!empty($p)) {
                    $images[] = [
                        'path' => $p,
                        'caption' => $imageCaptions[$k] ?? ''
                    ];
                }
            }
        }

        $data = [
            'code' => $code,
            'slug' => $slug,
            'destination_id' => $this->request->post('destination_id'),
            'duration_type' => $this->request->post('duration_type', 'fullday'),
            'duration_days' => (int)$this->request->post('duration_days', 1),
            'difficulty' => $this->request->post('difficulty', 'easy'),
            'transportation' => trim($this->request->post('transportation', '')),
            'group_size' => trim($this->request->post('group_size', '')),
            'price_from_usd' => (float)$this->request->post('price_from_usd', 0),
            'price_from_vnd' => (int)$this->request->post('price_from_vnd', 0),
            'featured_image' => trim($this->request->post('featured_image', '')),
            'is_featured' => $this->request->post('is_featured') ? 1 : 0,
            'is_signature' => $this->request->post('is_signature') ? 1 : 0,
            'signature_number' => (int)$this->request->post('signature_number', 0),
            'sort_order' => (int)$this->request->post('sort_order', 0),
            'status' => (int)$this->request->post('status', 1),
            'category_ids' => $this->request->post('category_ids', []),
            'images' => $images,
            'translations' => [
                'en' => [
                    'title' => $titleEn,
                    'sub_title' => trim($this->request->post('sub_title_en', '')),
                    'short_description' => trim($this->request->post('short_description_en', '')),
                    'highlights' => trim($this->request->post('highlights_en', '')),
                    'overview' => trim($this->request->post('overview_en', '')),
                    'inclusions' => trim($this->request->post('inclusions_en', '')),
                    'exclusions' => trim($this->request->post('exclusions_en', '')),
                    'what_to_bring' => trim($this->request->post('what_to_bring_en', '')),
                    'child_policy' => trim($this->request->post('child_policy_en', '')),
                    'cancellation_policy' => trim($this->request->post('cancellation_policy_en', '')),
                    'seo_title' => trim($this->request->post('seo_title_en', '')),
                    'seo_description' => trim($this->request->post('seo_description_en', ''))
                ],
                'vi' => [
                    'title' => $titleVi ?: $titleEn,
                    'sub_title' => trim($this->request->post('sub_title_vi', '')),
                    'short_description' => trim($this->request->post('short_description_vi', '')),
                    'highlights' => trim($this->request->post('highlights_vi', '')),
                    'overview' => trim($this->request->post('overview_vi', '')),
                    'inclusions' => trim($this->request->post('inclusions_vi', '')),
                    'exclusions' => trim($this->request->post('exclusions_vi', '')),
                    'what_to_bring' => trim($this->request->post('what_to_bring_vi', '')),
                    'child_policy' => trim($this->request->post('child_policy_vi', '')),
                    'cancellation_policy' => trim($this->request->post('cancellation_policy_vi', '')),
                    'seo_title' => trim($this->request->post('seo_title_vi', '')),
                    'seo_description' => trim($this->request->post('seo_description_vi', ''))
                ]
            ]
        ];

        try {
            $tourModel = new Tour();
            $tourId = $tourModel->saveTour($data, $id);
            Session::flash('success', $id ? 'Tour updated successfully.' : 'Tour created successfully.');
            $this->redirect(base_url('admin/tours/' . $tourId . '/edit'));
        } catch (\Throwable $e) {
            Session::flash('error', 'Error saving tour: ' . $e->getMessage());
            if ($id) {
                $this->redirect(base_url('admin/tours/' . $id . '/edit'));
            } else {
                $this->redirect(base_url('admin/tours/create'));
            }
        }
    }

    public function toggleStatus(int $id): void {
        if (!Csrf::verify($this->request->post('_csrf'))) {
            $this->redirect(base_url('admin/tours'));
            return;
        }

        $tourModel = new Tour();
        $tourModel->execute("UPDATE tours SET status = CASE WHEN status=1 THEN 0 ELSE 1 END, updated_at = CURRENT_TIMESTAMP WHERE id = :id", ['id' => $id]);
        Cache::flush();
        Session::flash('success', 'Tour status updated.');
        $this->redirect(base_url('admin/tours'));
    }

    public function toggleSignature(int $id): void {
        if (!Csrf::verify($this->request->post('_csrf'))) {
            $this->redirect(base_url('admin/tours'));
            return;
        }

        $tourModel = new Tour();
        $tourModel->execute("UPDATE tours SET is_signature = CASE WHEN is_signature=1 THEN 0 ELSE 1 END, updated_at = CURRENT_TIMESTAMP WHERE id = :id", ['id' => $id]);
        Cache::flush();
        Session::flash('success', 'Signature status updated.');
        $this->redirect(base_url('admin/tours'));
    }

    public function delete(int $id): void {
        if (!Csrf::verify($this->request->post('_csrf'))) {
            Session::flash('error', 'Invalid token.');
            $this->redirect(base_url('admin/tours'));
            return;
        }

        $tourModel = new Tour();
        $res = $tourModel->deleteTour($id);
        if ($res['success']) {
            Session::flash('success', $res['message']);
        } else {
            Session::flash('error', $res['message']);
        }

        $this->redirect(base_url('admin/tours'));
    }
}
