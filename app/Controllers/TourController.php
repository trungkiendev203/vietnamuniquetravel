<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Language;
use App\Core\Cache;
use App\Core\Csrf;
use App\Core\Session;
use App\Core\RateLimiter;
use App\Models\Tour;
use App\Models\Destination;
use App\Models\Category;
use App\Models\Review;
use App\Models\Booking;

class TourController extends Controller {
    public function list(): void {
        $lang = Language::current();
        $tourModel = new Tour();
        $destModel = new Destination();
        $catModel = new Category();

        $destination = $this->request->get('destination');
        $experience = $this->request->get('experience');
        $duration = $this->request->get('duration');
        $sort = $this->request->get('sort', 'recommended');

        $activeFilters = [
            'destination' => $destination,
            'experience' => $experience,
            'duration' => $duration,
            'sort' => $sort
        ];

        $filterKey = md5(json_encode($activeFilters));
        $tours = Cache::remember("tours_filtered_{$lang}_{$filterKey}", 1800, function() use ($tourModel, $lang, $activeFilters) {
            return $tourModel->getAll($lang, $activeFilters);
        });

        $allTours = Cache::remember("tours_all_{$lang}", 3600, function() use ($tourModel, $lang) {
            return $tourModel->getAll($lang);
        });

        $destinations = Cache::remember("destinations_all_{$lang}", 3600, function() use ($destModel, $lang) {
            return $destModel->getAll($lang);
        });

        $categories = Cache::remember("categories_all_{$lang}", 3600, function() use ($catModel, $lang) {
            return $catModel->getAll($lang);
        });

        // Check if AJAX request
        $isAjax = ($this->request->get('format') === 'json') || 
                  (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

        if ($isAjax) {
            $this->response->json([
                'success' => true,
                'count' => count($tours),
                'tours' => $tours
            ]);
            return;
        }

        $seo = [
            'title' => ($lang === 'vi' ? 'Danh Sách Tour Khám Phá' : 'Our Journeys') . ' - Vietnam Unique Travel',
            'description' => 'Explore authentic travel itineraries across Vietnam featuring Pu Luong, Mai Chau, Ninh Binh and Northern frontier.',
            'canonical' => base_url(($lang === 'vi' ? 'vi/' : '') . 'tours')
        ];

        $this->render('pages/tour_list', compact('tours', 'allTours', 'destinations', 'categories', 'activeFilters', 'seo', 'lang'));
    }

    public function detail(string $slug): void {
        $lang = Language::current();
        $tourModel = new Tour();

        $tour = Cache::remember("tour_detail_{$slug}_{$lang}", 3600, function() use ($tourModel, $slug, $lang) {
            return $tourModel->getBySlug($slug, $lang);
        });

        if (!$tour) {
            $this->response->setStatusCode(404);
            $this->render('pages/404');
            return;
        }

        $tourModel->incrementViews($tour['id']);
        $relatedTours = Cache::remember("tours_related_{$lang}", 3600, function() use ($tourModel, $lang) {
            return $tourModel->getAll($lang, ['limit' => 3]);
        });

        // Fetch Approved Reviews & Stats for this tour (uncached/short-cache for freshness)
        $reviewModel = new Review();
        $approvedReviews = $reviewModel->getApprovedByTourId($tour['id']);
        $ratingStats = $reviewModel->getTourRatingStats($tour['id']);

        $seo = [
            'title' => ($tour['seo_title'] ?: $tour['title']) . ' - Vietnam Unique Travel',
            'description' => $tour['seo_description'] ?: $tour['short_description'],
            'image' => asset($tour['featured_image'] ?: 'assets/images/hero.webp'),
            'canonical' => base_url(($lang === 'vi' ? 'vi/' : '') . 'tours/' . $tour['slug'])
        ];

        $this->render('pages/tour_detail', compact('tour', 'relatedTours', 'approvedReviews', 'ratingStats', 'seo', 'lang'));
    }

    public function submitReview(string $slug): void {
        $lang = Language::current();
        $prefix = $lang === 'vi' ? 'vi/' : '';

        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        if (RateLimiter::tooManyAttempts("review_submit_{$ip}", 5, 600)) {
            Session::flash('error', 'Too many review attempts. Please try again later.');
            $this->redirect(base_url($prefix . 'tours/' . $slug . '#reviews'));
            return;
        }
        RateLimiter::hit("review_submit_{$ip}", 600);

        if (!empty($this->request->post('website_hp'))) {
            $this->response->setStatusCode(400);
            exit('Spam detected.');
        }

        if (!Csrf::verify($this->request->post('_csrf'))) {
            Session::flash('error', 'Security token invalid or expired.');
            $this->redirect(base_url($prefix . 'tours/' . $slug . '#reviews'));
            return;
        }

        $tourModel = new Tour();
        $tour = $tourModel->getBySlug($slug, $lang);
        if (!$tour) {
            Session::flash('error', 'Tour not found.');
            $this->redirect(base_url($prefix . 'tours'));
            return;
        }

        $name = trim($this->request->post('client_name', ''));
        $rating = (int)$this->request->post('rating', 5);
        $content = trim($this->request->post('content', ''));

        if (!$name || strlen($name) > 100 || !$content || strlen($content) < 10 || strlen($content) > 2000) {
            Session::flash('error', 'Please fill in all fields accurately (content: 10-2000 chars).');
            $this->redirect(base_url($prefix . 'tours/' . $slug . '#reviews'));
            return;
        }

        $reviewModel = new Review();

        $reviewModel->createReview([
            'tour_id' => $tour['id'],
            'client_name' => $name,
            'rating' => $rating,
            'content' => $content
        ]);

        Session::flash('success', 'Thank you! Your review has been submitted and is pending moderation.');
        $this->redirect(base_url($prefix . 'tours/' . $slug . '#reviews'));
    }
}
