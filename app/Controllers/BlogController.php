<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Language;
use App\Models\Post;

class BlogController extends Controller {
    public function list(): void {
        $lang = Language::current();
        $postModel = new Post();
        $posts = $postModel->getAll($lang, 12);

        $seo = [
            'title' => __('nav_blog') . ' - Vietnam Unique Travel',
            'description' => 'Travel guides, ethnic cultural insights, and travel tips for exploring Vietnam off the beaten track.',
            'canonical' => base_url(($lang === 'vi' ? 'vi/' : '') . 'blog')
        ];

        $this->render('pages/blog_list', compact('posts', 'seo', 'lang'));
    }

    public function detail(string $slug): void {
        $lang = Language::current();
        $postModel = new Post();

        $post = $postModel->getBySlug($slug, $lang);
        if (!$post) {
            $this->response->setStatusCode(404);
            $this->render('pages/404');
            return;
        }

        $recentPosts = $postModel->getAll($lang, 3);

        $seo = [
            'title' => ($post['seo_title'] ?: $post['title']) . ' - Vietnam Unique Travel',
            'description' => $post['seo_description'] ?: $post['summary'],
            'image' => asset($post['featured_image'] ?: 'assets/images/hero.webp'),
            'canonical' => base_url(($lang === 'vi' ? 'vi/' : '') . 'blog/' . $post['slug'])
        ];

        $this->render('pages/blog_detail', compact('post', 'recentPosts', 'seo', 'lang'));
    }
}
