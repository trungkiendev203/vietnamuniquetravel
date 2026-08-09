<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Language;
use App\Models\Tour;
use App\Models\Destination;

class TourController extends Controller {
    public function list(): void {
        $lang = Language::current();
        $tourModel = new Tour();
        $destModel = new Destination();

        $destId = $this->request->get('destination');
        $duration = $this->request->get('duration');
        $difficulty = $this->request->get('difficulty');

        $tours = $tourModel->getAll($lang, [
            'destination' => $destId,
            'duration' => $duration,
            'difficulty' => $difficulty
        ]);

        $destinations = $destModel->getAll($lang);

        $seo = [
            'title' => __('nav_tours') . ' - Vietnam Unique Travel',
            'description' => 'Explore authentic travel itineraries across Vietnam featuring Pu Luong, Mai Chau, and hidden destinations.',
            'canonical' => base_url(($lang === 'vi' ? 'vi/' : '') . 'tours')
        ];

        $this->render('pages/tour_list', compact('tours', 'destinations', 'seo', 'lang'));
    }

    public function detail(string $slug): void {
        $lang = Language::current();
        $tourModel = new Tour();

        $tour = $tourModel->getBySlug($slug, $lang);
        if (!$tour) {
            $this->response->setStatusCode(404);
            $this->render('pages/404');
            return;
        }

        $tourModel->incrementViews($tour['id']);
        $relatedTours = $tourModel->getAll($lang, ['limit' => 3]);

        $seo = [
            'title' => ($tour['seo_title'] ?: $tour['title']) . ' - Vietnam Unique Travel',
            'description' => $tour['seo_description'] ?: $tour['short_description'],
            'image' => asset($tour['featured_image'] ?: 'assets/images/hero.webp'),
            'canonical' => base_url(($lang === 'vi' ? 'vi/' : '') . 'tours/' . $tour['slug'])
        ];

        $this->render('pages/tour_detail', compact('tour', 'relatedTours', 'seo', 'lang'));
    }
}
