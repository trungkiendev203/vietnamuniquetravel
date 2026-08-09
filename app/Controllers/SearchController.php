<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Language;
use App\Models\Tour;

class SearchController extends Controller {
    public function index(): void {
        $lang = Language::current();
        $query = trim($this->request->get('q', ''));
        $tourModel = new Tour();

        $tours = [];
        if ($query !== '') {
            $sql = "SELECT t.*, tt.title, tt.sub_title, tt.short_description, dt.name as destination_name
                    FROM tours t
                    LEFT JOIN tour_translations tt ON t.id = tt.tour_id AND tt.lang = :lang
                    LEFT JOIN destination_translations dt ON t.destination_id = dt.destination_id AND dt.lang = :lang
                    WHERE t.status = 1 AND (tt.title LIKE :q OR tt.short_description LIKE :q OR tt.overview LIKE :q)
                    ORDER BY t.sort_order ASC";
            $tours = $tourModel->query($sql, ['lang' => $lang, 'q' => '%' . $query . '%']);
        }

        $seo = [
            'title' => 'Search Results for "' . e($query) . '" - Vietnam Unique Travel',
            'canonical' => base_url(($lang === 'vi' ? 'vi/' : '') . 'search?q=' . urlencode($query))
        ];

        $this->render('pages/search', compact('query', 'tours', 'seo', 'lang'));
    }
}
