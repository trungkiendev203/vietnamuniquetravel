<?php

namespace App\Models;

use App\Core\Model;

class Faq extends Model {
    protected string $table = 'faqs';

    public function getAll(string $lang = 'en'): array {
        $sql = "SELECT id, category, 
                       " . ($lang === 'vi' ? 'COALESCE(question_vi, question_en)' : 'question_en') . " as question,
                       " . ($lang === 'vi' ? 'COALESCE(answer_vi, answer_en)' : 'answer_en') . " as answer
                FROM faqs
                WHERE status = 1
                ORDER BY sort_order ASC";
        return $this->query($sql);
    }
}
