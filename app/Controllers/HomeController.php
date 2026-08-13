<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Language;
use App\Core\Cache;
use App\Models\Tour;
use App\Models\Destination;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\Post;

class HomeController extends Controller {
    public function index(): void {
        $lang = Language::current();

        $signatureTours = Cache::remember("home_signatures_{$lang}", 3600, function() use ($lang) {
            $tourModel = new Tour();
            return $tourModel->getAll($lang, ['signature' => 1, 'limit' => 3]);
        });

        $destinations = Cache::remember("home_destinations_{$lang}", 3600, function() use ($lang) {
            $destModel = new Destination();
            return $destModel->getAll($lang);
        });

        $categories = Cache::remember("home_categories_{$lang}", 3600, function() use ($lang) {
            $catModel = new Category();
            return $catModel->getAll($lang);
        });

        $testimonials = Cache::remember("home_testimonials_{$lang}", 3600, function() use ($lang) {
            $testModel = new Testimonial();
            return $testModel->getFeatured($lang);
        });

        $posts = Cache::remember("home_posts_{$lang}", 3600, function() use ($lang) {
            $postModel = new Post();
            return $postModel->getAll($lang, [], 3);
        });

        $seo = [
            'title' => ($lang === 'vi' ? 'Vietnam Unique Travel — Du Lịch Trải Nghiệm Bản Địa & Có Trách Nhiệm' : 'Vietnam Unique Travel — Authentic & Responsible Journeys'),
            'description' => ($lang === 'vi' ? 'Chuyên các chương trình du lịch trải nghiệm độc đáo, văn hóa bản địa và du lịch có trách nhiệm tại Pù Luông, Mai Châu, Ninh Bình và Việt Nam.' : 'Your trusted partner for authentic experiential, nature and responsible journeys across Vietnam.'),
            'image' => asset('assets/images/og-share-banner.jpg'),
            'canonical' => base_url($lang === 'vi' ? 'vi' : '')
        ];

        $this->render('pages/home', compact(
            'signatureTours', 'destinations', 'categories',
            'testimonials', 'posts', 'seo', 'lang'
        ));
    }
}
