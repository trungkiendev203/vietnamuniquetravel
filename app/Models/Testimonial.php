<?php

namespace App\Models;

use App\Core\Model;

class Testimonial extends Model {
    protected string $table = 'testimonials';

    public function getFeatured(string $lang = 'en'): array {
        $sql = "SELECT id, client_name, client_country, client_avatar, rating, tour_name,
                       " . ($lang === 'vi' ? 'COALESCE(content_vi, content_en)' : 'content_en') . " as content
                FROM testimonials
                WHERE is_featured = 1
                ORDER BY sort_order ASC, id DESC";
        return $this->query($sql);
    }
}
