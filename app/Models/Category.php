<?php

namespace App\Models;

use App\Core\Model;

class Category extends Model {
    protected string $table = 'categories';

    public function getAll(string $lang = 'en'): array {
        $sql = "SELECT c.*, ct.name, ct.description
                FROM categories c
                LEFT JOIN category_translations ct ON c.id = ct.category_id AND ct.lang = :lang
                WHERE c.status = 1
                ORDER BY c.sort_order ASC";
        return $this->query($sql, ['lang' => $lang]);
    }
}
