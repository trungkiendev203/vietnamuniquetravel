<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Language;
use App\Models\Tour;
use App\Models\Destination;
use App\Models\Category;
use App\Models\Testimonial;
use App\Models\Post;

class HomeController extends Controller {
    public function index(): void {
        $lang = Language::current();
        $tourModel = new Tour();
        $destModel = new Destination();
        $catModel = new Category();
        $testModel = new Testimonial();
        $postModel = new Post();

        $signatureTours = $tourModel->getAll($lang, ['signature' => 1, 'limit' => 3]);
        $destinations = $destModel->getAll($lang);
        $categories = $catModel->getAll($lang);
        $testimonials = $testModel->getFeatured($lang);
        $posts = $postModel->getAll($lang, 3);

        $seo = [
            'title' => __('hero_title_1') . ' - Vietnam Unique Travel',
            'description' => __('hero_sub'),
            'image' => asset('assets/images/hero.webp'),
            'canonical' => base_url($lang === 'vi' ? 'vi' : '')
        ];

        $this->render('pages/home', compact(
            'signatureTours', 'destinations', 'categories',
            'testimonials', 'posts', 'seo', 'lang'
        ));
    }
}
