<?php

namespace App\Models;

use App\Core\Model;

class Tour extends Model {
    protected string $table = 'tours';

    public function getAll(string $lang = 'en', array $filters = []): array {
        $sql = "SELECT t.*, tt.title, tt.sub_title, tt.short_description, dt.name as destination_name
                FROM tours t
                LEFT JOIN tour_translations tt ON t.id = tt.tour_id AND tt.lang = :lang1
                LEFT JOIN destination_translations dt ON t.destination_id = dt.destination_id AND dt.lang = :lang2
                WHERE t.status = 1";
        
        $params = [
            'lang1' => $lang,
            'lang2' => $lang
        ];

        if (!empty($filters['destination'])) {
            $sql .= " AND t.destination_id = :dest_id";
            $params['dest_id'] = $filters['destination'];
        }

        if (!empty($filters['duration'])) {
            $sql .= " AND t.duration_type = :duration";
            $params['duration'] = $filters['duration'];
        }

        if (!empty($filters['difficulty'])) {
            $sql .= " AND t.difficulty = :difficulty";
            $params['difficulty'] = $filters['difficulty'];
        }

        if (!empty($filters['featured'])) {
            $sql .= " AND t.is_featured = 1";
        }

        if (!empty($filters['signature'])) {
            $sql .= " AND t.is_signature = 1 ORDER BY t.signature_number ASC, t.sort_order ASC";
        } else {
            $sql .= " ORDER BY t.sort_order ASC, t.id DESC";
        }

        if (!empty($filters['limit'])) {
            $sql .= " LIMIT " . (int)$filters['limit'];
        }

        return $this->query($sql, $params);
    }

    public function getBySlug(string $slug, string $lang = 'en'): ?array {
        $sql = "SELECT t.*, tt.title, tt.sub_title, tt.short_description, tt.highlights, 
                       tt.overview, tt.inclusions, tt.exclusions, tt.what_to_bring, 
                       tt.child_policy, tt.cancellation_policy, tt.seo_title, tt.seo_description,
                       dt.name as destination_name
                FROM tours t
                LEFT JOIN tour_translations tt ON t.id = tt.tour_id AND tt.lang = :lang1
                LEFT JOIN destination_translations dt ON t.destination_id = dt.destination_id AND dt.lang = :lang2
                WHERE t.slug = :slug AND t.status = 1";

        $tour = $this->queryOne($sql, ['slug' => $slug, 'lang1' => $lang, 'lang2' => $lang]);
        if ($tour) {
            $tour['itinerary'] = $this->getItinerary($tour['id'], $lang);
            $tour['prices'] = $this->getPrices($tour['id']);
            $tour['images'] = $this->getGallery($tour['id']);
        }
        return $tour;
    }

    public function getItinerary(int $tourId, string $lang = 'en'): array {
        $sql = "SELECT s.id, s.step_time, s.sort_order, it.title, it.description
                FROM tour_itinerary_steps s
                LEFT JOIN tour_itinerary_translations it ON s.id = it.step_id AND it.lang = :lang
                WHERE s.tour_id = :tour_id
                ORDER BY s.sort_order ASC";
        return $this->query($sql, ['tour_id' => $tourId, 'lang' => $lang]);
    }

    public function getPrices(int $tourId): array {
        $sql = "SELECT MIN(id) as id, transport_type, pax_tier, price_vnd, price_usd, note 
                FROM tour_prices 
                WHERE tour_id = :tour_id 
                GROUP BY transport_type, pax_tier, price_vnd, price_usd, note 
                ORDER BY id ASC";
        return $this->query($sql, ['tour_id' => $tourId]);
    }

    public function getGallery(int $tourId): array {
        $sql = "SELECT * FROM tour_images WHERE tour_id = :tour_id ORDER BY sort_order ASC";
        return $this->query($sql, ['tour_id' => $tourId]);
    }

    public function incrementViews(int $tourId): void {
        $this->execute("UPDATE tours SET views = views + 1 WHERE id = :id", ['id' => $tourId]);
    }
}
