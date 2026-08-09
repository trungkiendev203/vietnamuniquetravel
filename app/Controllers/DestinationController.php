<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Language;
use App\Models\Destination;
use App\Models\Tour;

class DestinationController extends Controller {
    public function list(): void {
        $lang = Language::current();
        $destModel = new Destination();
        $destinations = $destModel->getAll($lang);

        $seo = [
            'title' => __('nav_destinations') . ' - Vietnam Unique Travel',
            'description' => 'Discover stunning nature reserves, mist-covered valleys and cultural hubs in Vietnam.',
            'canonical' => base_url(($lang === 'vi' ? 'vi/' : '') . 'destinations')
        ];

        $this->render('pages/destination_list', compact('destinations', 'seo', 'lang'));
    }

    public function detail(string $slug): void {
        $lang = Language::current();
        $destModel = new Destination();
        $tourModel = new Tour();

        $destination = $destModel->getBySlug($slug, $lang);
        if (!$destination) {
            $this->response->setStatusCode(404);
            $this->render('pages/404');
            return;
        }

        $tours = $tourModel->getAll($lang, ['destination' => $destination['id']]);

        $seo = [
            'title' => ($destination['seo_title'] ?: $destination['name']) . ' - Vietnam Unique Travel',
            'description' => $destination['seo_description'] ?: $destination['short_description'],
            'image' => asset($destination['image'] ?: 'assets/images/hero.webp'),
            'canonical' => base_url(($lang === 'vi' ? 'vi/' : '') . 'destinations/' . $destination['slug'])
        ];

        $this->render('pages/destination_detail', compact('destination', 'tours', 'seo', 'lang'));
    }
}
