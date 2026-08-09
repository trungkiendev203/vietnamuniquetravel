<?php

namespace App\Models;

use App\Core\Model;

class Post extends Model {
    protected string $table = 'posts';

    public function getAll(string $lang = 'en', int $limit = 10): array {
        $sql = "SELECT p.*, pt.title, pt.summary, pt.content, pt.seo_title, pt.seo_description
                FROM posts p
                LEFT JOIN post_translations pt ON p.id = pt.post_id AND pt.lang = :lang
                WHERE p.status = 1
                ORDER BY p.published_at DESC LIMIT " . (int)$limit;
        return $this->query($sql, ['lang' => $lang]);
    }

    public function getBySlug(string $slug, string $lang = 'en'): ?array {
        $sql = "SELECT p.*, pt.title, pt.summary, pt.content, pt.seo_title, pt.seo_description
                FROM posts p
                LEFT JOIN post_translations pt ON p.id = pt.post_id AND pt.lang = :lang
                WHERE p.slug = :slug AND p.status = 1";
        return $this->queryOne($sql, ['slug' => $slug, 'lang' => $lang]);
    }
}
