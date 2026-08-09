<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Language;
use App\Models\Category;
use App\Models\Tour;

class ExperienceController extends Controller {
    public function index(): void {
        $lang = Language::current();
        $catModel = new Category();
        $tourModel = new Tour();

        $categories = $catModel->getAll($lang);
        $tours = $tourModel->getAll($lang, ['limit' => 6]);

        $seo = [
            'title' => __('nav_experiences') . ' - Vietnam Unique Travel',
            'description' => 'Authentic activities: trekking, motorbike adventures, local Thai weaving, petrified waterfalls, and bamboo rafting.',
            'canonical' => base_url(($lang === 'vi' ? 'vi/' : '') . 'experiences')
        ];

        $this->render('pages/experiences', compact('categories', 'tours', 'seo', 'lang'));
    }
}
