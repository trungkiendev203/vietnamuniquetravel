<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Tour;
use App\Models\Destination;
use App\Models\Post;

class SitemapController extends Controller {
    public function xml(): void {
        header("Content-Type: application/xml; charset=utf-8");
        
        $tourModel = new Tour();
        $destModel = new Destination();
        $postModel = new Post();

        $tours = $tourModel->getAll('en');
        $destinations = $destModel->getAll('en');
        $posts = $postModel->getAll('en', [], 50);

        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.sitemap.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">';

        $staticPages = ['', 'tours', 'destinations', 'experiences', 'about-us', 'responsible-tourism', 'faq', 'contact', 'booking'];
        foreach ($staticPages as $page) {
            foreach (['en', 'vi'] as $lang) {
                $prefix = $lang === 'vi' ? 'vi/' : '';
                $url = base_url($prefix . $page);
                $altUrl = base_url(($lang === 'en' ? 'vi/' : '') . $page);
                
                echo '<url>';
                echo '<loc>' . e($url) . '</loc>';
                echo '<xhtml:link rel="alternate" hreflang="' . ($lang === 'vi' ? 'en' : 'vi') . '" href="' . e($altUrl) . '"/>';
                echo '<changefreq>weekly</changefreq>';
                echo '<priority>' . ($page === '' ? '1.0' : '0.8') . '</priority>';
                echo '</url>';
            }
        }

        foreach ($tours as $t) {
            foreach (['en', 'vi'] as $lang) {
                $prefix = $lang === 'vi' ? 'vi/' : '';
                $url = base_url($prefix . 'tours/' . $t['slug']);
                echo '<url><loc>' . e($url) . '</loc><changefreq>weekly</changefreq><priority>0.9</priority></url>';
            }
        }

        foreach ($destinations as $d) {
            foreach (['en', 'vi'] as $lang) {
                $prefix = $lang === 'vi' ? 'vi/' : '';
                $url = base_url($prefix . 'destinations/' . $d['slug']);
                echo '<url><loc>' . e($url) . '</loc><changefreq>monthly</changefreq><priority>0.7</priority></url>';
            }
        }

        foreach ($posts as $p) {
            foreach (['en', 'vi'] as $lang) {
                $prefix = $lang === 'vi' ? 'vi/' : '';
                $url = base_url($prefix . 'blog/' . $p['slug']);
                echo '<url><loc>' . e($url) . '</loc><changefreq>monthly</changefreq><priority>0.6</priority></url>';
            }
        }

        echo '</urlset>';
        exit;
    }

    public function robots(): void {
        header("Content-Type: text/plain; charset=utf-8");
        echo "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /storage/\n\n";
        echo "User-agent: facebookexternalhit\nAllow: /\n\n";
        echo "User-agent: Facebot\nAllow: /\n\n";
        echo "User-agent: Twitterbot\nAllow: /\n\n";
        echo "User-agent: WhatsApp\nAllow: /\n\n";
        echo "User-agent: TelegramBot\nAllow: /\n\n";
        echo "Sitemap: " . base_url('sitemap.xml') . "\n";
        exit;
    }
}
