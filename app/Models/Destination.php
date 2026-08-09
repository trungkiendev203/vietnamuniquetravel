<?php

namespace App\Models;

use App\Core\Model;

class Destination extends Model {
    protected string $table = 'destinations';

    public function getAll(string $lang = 'en'): array {
        $sql = "SELECT d.*, dt.name, dt.short_description, dt.description, dt.seo_title, dt.seo_description
                FROM destinations d
                LEFT JOIN destination_translations dt ON d.id = dt.destination_id AND dt.lang = :lang
                WHERE d.status = 1
                ORDER BY d.sort_order ASC";
        return $this->query($sql, ['lang' => $lang]);
    }

    public function getBySlug(string $slug, string $lang = 'en'): ?array {
        $sql = "SELECT d.*, dt.name, dt.short_description, dt.description, dt.seo_title, dt.seo_description
                FROM destinations d
                LEFT JOIN destination_translations dt ON d.id = dt.destination_id AND dt.lang = :lang
                WHERE d.slug = :slug AND d.status = 1";
        return $this->queryOne($sql, ['slug' => $slug, 'lang' => $lang]);
    }
}
