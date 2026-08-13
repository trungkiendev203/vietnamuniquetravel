<?php

namespace App\Models;

use App\Core\Model;

class Post extends Model {
    protected string $table = 'posts';

    public function getAll(string $lang = 'en', $filters = [], int $limit = 20): array {
        if (is_numeric($filters)) {
            $limit = (int)$filters;
            $filters = [];
        } elseif (!is_array($filters)) {
            $filters = [];
        }

        $params = ['lang' => $lang];
        $where = ["p.status = 1"];

        if (!empty($filters['category']) && $filters['category'] !== 'all') {
            $where[] = "p.category = :category";
            $params['category'] = $filters['category'];
        }

        if (!empty($filters['destination']) && $filters['destination'] !== 'all') {
            $where[] = "p.destination_id = :destination_id";
            $params['destination_id'] = (int)$filters['destination'];
        }

        if (!empty($filters['q'])) {
            $where[] = "(pt.title LIKE :q OR pt.summary LIKE :q OR p.tags LIKE :q)";
            $params['q'] = '%' . trim($filters['q']) . '%';
        }

        if (!empty($filters['exclude_id'])) {
            $where[] = "p.id != :exclude_id";
            $params['exclude_id'] = (int)$filters['exclude_id'];
        }

        $whereClause = implode(' AND ', $where);
        $sql = "SELECT p.*, 
                       COALESCE(pt.title, pt_fb.title, p.slug) AS title, 
                       COALESCE(pt.summary, pt_fb.summary, '') AS summary, 
                       COALESCE(pt.content, pt_fb.content, '') AS content, 
                       COALESCE(pt.seo_title, pt_fb.seo_title, '') AS seo_title, 
                       COALESCE(pt.seo_description, pt_fb.seo_description, '') AS seo_description
                FROM posts p
                LEFT JOIN post_translations pt ON p.id = pt.post_id AND pt.lang = :lang
                LEFT JOIN post_translations pt_fb ON p.id = pt_fb.post_id AND pt_fb.lang = 'en'
                WHERE {$whereClause}
                ORDER BY p.published_at DESC LIMIT " . (int)$limit;

        return $this->query($sql, $params);
    }

    public function getBySlug(string $slug, string $lang = 'en'): ?array {
        $sql = "SELECT p.*, 
                       COALESCE(pt.title, pt_fb.title, p.slug) AS title, 
                       COALESCE(pt.summary, pt_fb.summary, '') AS summary, 
                       COALESCE(pt.content, pt_fb.content, '') AS content, 
                       COALESCE(pt.seo_title, pt_fb.seo_title, '') AS seo_title, 
                       COALESCE(pt.seo_description, pt_fb.seo_description, '') AS seo_description
                FROM posts p
                LEFT JOIN post_translations pt ON p.id = pt.post_id AND pt.lang = :lang
                LEFT JOIN post_translations pt_fb ON p.id = pt_fb.post_id AND pt_fb.lang = 'en'
                WHERE p.slug = :slug AND p.status = 1
                LIMIT 1";
        return $this->queryOne($sql, ['slug' => $slug, 'lang' => $lang]);
    }
}
