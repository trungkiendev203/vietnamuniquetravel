<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Language;
use App\Core\Cache;
use App\Models\Post;
use App\Models\Destination;

class BlogController extends Controller {
    public function list(): void {
        $lang = Language::current();
        $postModel = new Post();
        $destModel = new Destination();

        $category = $this->request->get('category', 'all');
        $destination = $this->request->get('destination', 'all');
        $query = trim($this->request->get('q', ''));

        $activeFilters = [
            'category' => $category,
            'destination' => $destination,
            'q' => $query
        ];

        $posts = $postModel->getAll($lang, $activeFilters, 24);
        $destinations = Cache::remember("destinations_all_{$lang}", 3600, fn() => $destModel->getAll($lang));

        // Check if AJAX request for live search/filter
        $isAjax = ($this->request->get('format') === 'json') || 
                  (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

        if ($isAjax) {
            $this->response->json([
                'success' => true,
                'count' => count($posts),
                'posts' => $posts
            ]);
            return;
        }

        $seo = [
            'title' => ($lang === 'vi' ? 'Mẹo Du Lịch & Cẩm Nang Khám Phá' : 'Travel Tips & Insider Guides') . ' - Vietnam Unique Travel',
            'description' => ($lang === 'vi' ? 'Chia sẻ bí quyết lên kế hoạch thông minh, kinh nghiệm trekking, ẩm thực bản địa và cẩm nang du lịch Pù Luông, Mai Châu trọn vẹn.' : 'Expert travel tips, packing guides, and authentic cultural stories for exploring Vietnam off the beaten path.'),
            'image' => asset('assets/images/og-share-banner.jpg'),
            'canonical' => base_url(($lang === 'vi' ? 'vi/' : '') . 'travel-tips')
        ];

        $this->render('pages/blog_list', compact('posts', 'destinations', 'activeFilters', 'seo', 'lang'));
    }

    public function detail(string $slug): void {
        $lang = Language::current();
        $postModel = new Post();
        $destModel = new Destination();

        $post = $postModel->getBySlug($slug, $lang);
        if (!$post) {
            $this->response->setStatusCode(404);
            $this->render('pages/404');
            return;
        }

        $relatedPosts = $postModel->getAll($lang, ['exclude_id' => $post['id']], 4);
        $featuredDestinations = Cache::remember("destinations_featured_{$lang}", 3600, function() use ($destModel, $lang) {
            return $destModel->getAll($lang);
        });

        $seo = [
            'title' => ($post['seo_title'] ?: $post['title']) . ' - Vietnam Unique Travel',
            'description' => $post['seo_description'] ?: $post['summary'],
            'image' => asset($post['featured_image'] ?: 'assets/images/og-share-banner.jpg'),
            'canonical' => base_url(($lang === 'vi' ? 'vi/' : '') . 'travel-tips/' . $post['slug'])
        ];

        $this->render('pages/blog_detail', compact('post', 'relatedPosts', 'featuredDestinations', 'seo', 'lang'));
    }
}
