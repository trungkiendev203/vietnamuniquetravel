<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Cache;

class Tour extends Model {
    protected string $table = 'tours';

    public function getAll(string $lang = 'en', array $filters = []): array {
        $sql = "SELECT t.*, 
                       COALESCE(tt.title, tt_en.title, t.code) as title, 
                       COALESCE(tt.sub_title, tt_en.sub_title) as sub_title, 
                       COALESCE(tt.short_description, tt_en.short_description) as short_description, 
                       dt.name as destination_name,
                       d.slug as destination_slug
                FROM tours t
                LEFT JOIN tour_translations tt ON t.id = tt.tour_id AND tt.lang = :lang1
                LEFT JOIN tour_translations tt_en ON t.id = tt_en.tour_id AND tt_en.lang = 'en'
                LEFT JOIN destinations d ON t.destination_id = d.id
                LEFT JOIN destination_translations dt ON t.destination_id = dt.destination_id AND dt.lang = :lang2";
        
        $whereClauses = [];
        $params = [
            'lang1' => $lang,
            'lang2' => $lang
        ];

        if (isset($filters['status']) && $filters['status'] !== 'all') {
            $whereClauses[] = "t.status = :status_val";
            $params['status_val'] = (int)$filters['status'];
        } elseif (empty($filters['include_hidden'])) {
            $whereClauses[] = "t.status = 1";
        }

        if (!empty($filters['search'])) {
            $whereClauses[] = "(t.code LIKE :search OR t.slug LIKE :search OR tt.title LIKE :search OR tt_en.title LIKE :search)";
            $params['search'] = '%' . trim($filters['search']) . '%';
        }

        // Destination Filter
        if (!empty($filters['destination']) && $filters['destination'] !== 'all') {
            if (is_numeric($filters['destination'])) {
                $whereClauses[] = "t.destination_id = :dest_id";
                $params['dest_id'] = (int)$filters['destination'];
            } else {
                $destSlug = trim($filters['destination']);
                if ($destSlug === 'pu-luong') $destSlug = 'pu-luong-nature-reserve';
                if ($destSlug === 'mai-chau') $destSlug = 'mai-chau-valley';
                if ($destSlug === 'northern-vietnam') $destSlug = 'ha-giang-loop';
                
                $whereClauses[] = "(d.slug = :dest_slug OR d.slug LIKE :dest_slug_wild OR t.slug LIKE :dest_slug_wild)";
                $params['dest_slug'] = $destSlug;
                $params['dest_slug_wild'] = "%" . trim($filters['destination']) . "%";
            }
        }

        // Category / Experience Filter
        if (!empty($filters['experience']) && $filters['experience'] !== 'all') {
            $catSlug = trim($filters['experience']);
            $whereClauses[] = "t.id IN (
                SELECT tc.tour_id FROM tour_categories tc 
                JOIN categories c ON tc.category_id = c.id 
                WHERE c.slug = :cat_slug OR c.slug LIKE :cat_slug_wild
            )";
            $params['cat_slug'] = $catSlug;
            $params['cat_slug_wild'] = "%" . $catSlug . "%";
        }

        // Duration Filter
        if (!empty($filters['duration']) && $filters['duration'] !== 'all') {
            $dur = strtolower(trim($filters['duration']));
            if ($dur === 'day-trip' || $dur === 'day_trip' || $dur === 'halfday' || $dur === 'fullday' || $dur === '1') {
                $whereClauses[] = "(t.duration_type IN ('halfday', 'fullday') OR t.duration_days = 1)";
            } elseif ($dur === '2-3-days' || $dur === '2-3' || $dur === '2_3_days') {
                $whereClauses[] = "t.duration_days BETWEEN 2 AND 3";
            } elseif ($dur === '4-5-days' || $dur === '4-5' || $dur === '4_5_days') {
                $whereClauses[] = "t.duration_days BETWEEN 4 AND 5";
            } elseif ($dur === '6-plus' || $dur === '6+' || $dur === '6_plus') {
                $whereClauses[] = "t.duration_days >= 6";
            }
        }

        // Difficulty Filter
        if (!empty($filters['difficulty'])) {
            $whereClauses[] = "t.difficulty = :difficulty";
            $params['difficulty'] = $filters['difficulty'];
        }

        // Featured Filter
        if (!empty($filters['featured'])) {
            $whereClauses[] = "t.is_featured = 1";
        }

        if (!empty($whereClauses)) {
            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        }

        // Sorting
        $sort = $filters['sort'] ?? 'recommended';
        if ($sort === 'price-asc' || $sort === 'price_asc' || $sort === 'price_low') {
            $sql .= " ORDER BY t.price_from_usd ASC, t.sort_order ASC";
        } elseif ($sort === 'price-desc' || $sort === 'price_desc' || $sort === 'price_high') {
            $sql .= " ORDER BY t.price_from_usd DESC, t.sort_order ASC";
        } elseif ($sort === 'duration') {
            $sql .= " ORDER BY t.duration_days ASC, (CASE WHEN t.duration_type = 'halfday' THEN 1 WHEN t.duration_type = 'fullday' THEN 2 ELSE 3 END) ASC";
        } elseif ($sort === 'newest') {
            $sql .= " ORDER BY t.id DESC";
        } else {
            if (!empty($filters['signature'])) {
                $sql .= " AND t.is_signature = 1 ORDER BY t.signature_number ASC, t.sort_order ASC";
            } else {
                $sql .= " ORDER BY t.is_signature DESC, t.signature_number ASC, t.sort_order ASC, t.id DESC";
            }
        }

        if (!empty($filters['limit'])) {
            $sql .= " LIMIT " . (int)$filters['limit'];
        }

        $tours = $this->query($sql, $params);

        if (!empty($tours)) {
            $tourIds = array_column($tours, 'id');
            $placeholders = implode(',', array_fill(0, count($tourIds), '?'));
            $catSql = "SELECT tc.tour_id, c.id as category_id, c.slug, COALESCE(ct.name, c.slug) as name
                       FROM tour_categories tc
                       JOIN categories c ON tc.category_id = c.id
                       LEFT JOIN category_translations ct ON c.id = ct.category_id AND ct.lang = ?
                       WHERE tc.tour_id IN ({$placeholders}) AND c.status = 1
                       ORDER BY c.sort_order ASC";
            
            $catParams = array_merge([$lang], $tourIds);
            $catRows = $this->query($catSql, $catParams);

            $catsByTour = [];
            foreach ($catRows as $row) {
                $catsByTour[$row['tour_id']][] = [
                    'id' => $row['category_id'],
                    'slug' => $row['slug'],
                    'name' => $row['name']
                ];
            }

            foreach ($tours as &$tour) {
                $tCats = $catsByTour[$tour['id']] ?? [];
                $tour['categories'] = $tCats;
                $tour['category_slugs'] = array_column($tCats, 'slug');
                $tour['category_names'] = array_column($tCats, 'name');
            }
            unset($tour);
        }

        return $tours;
    }

    public function getById(int $id, string $lang = 'en'): ?array {
        $sql = "SELECT t.*, 
                       COALESCE(tt.title, tt_en.title, t.code) as title, 
                       COALESCE(tt.sub_title, tt_en.sub_title) as sub_title, 
                       COALESCE(tt.short_description, tt_en.short_description) as short_description, 
                       COALESCE(tt.highlights, tt_en.highlights) as highlights, 
                       COALESCE(tt.overview, tt_en.overview) as overview, 
                       COALESCE(tt.inclusions, tt_en.inclusions) as inclusions, 
                       COALESCE(tt.exclusions, tt_en.exclusions) as exclusions, 
                       COALESCE(tt.what_to_bring, tt_en.what_to_bring) as what_to_bring, 
                       COALESCE(tt.child_policy, tt_en.child_policy) as child_policy, 
                       COALESCE(tt.cancellation_policy, tt_en.cancellation_policy) as cancellation_policy, 
                       COALESCE(tt.seo_title, tt_en.seo_title) as seo_title, 
                       COALESCE(tt.seo_description, tt_en.seo_description) as seo_description,
                       dt.name as destination_name
                FROM tours t
                LEFT JOIN tour_translations tt ON t.id = tt.tour_id AND tt.lang = :lang1
                LEFT JOIN tour_translations tt_en ON t.id = tt_en.tour_id AND tt_en.lang = 'en'
                LEFT JOIN destination_translations dt ON t.destination_id = dt.destination_id AND dt.lang = :lang2
                WHERE t.id = :id";
        return $this->queryOne($sql, ['id' => $id, 'lang1' => $lang, 'lang2' => $lang]);
    }

    public function getBySlug(string $slug, string $lang = 'en'): ?array {
        $sql = "SELECT t.*, 
                       COALESCE(tt.title, tt_en.title, t.code) as title, 
                       COALESCE(tt.sub_title, tt_en.sub_title) as sub_title, 
                       COALESCE(tt.short_description, tt_en.short_description) as short_description, 
                       COALESCE(tt.highlights, tt_en.highlights) as highlights, 
                       COALESCE(tt.overview, tt_en.overview) as overview, 
                       COALESCE(tt.inclusions, tt_en.inclusions) as inclusions, 
                       COALESCE(tt.exclusions, tt_en.exclusions) as exclusions, 
                       COALESCE(tt.what_to_bring, tt_en.what_to_bring) as what_to_bring, 
                       COALESCE(tt.child_policy, tt_en.child_policy) as child_policy, 
                       COALESCE(tt.cancellation_policy, tt_en.cancellation_policy) as cancellation_policy, 
                       COALESCE(tt.seo_title, tt_en.seo_title) as seo_title, 
                       COALESCE(tt.seo_description, tt_en.seo_description) as seo_description,
                       dt.name as destination_name
                FROM tours t
                LEFT JOIN tour_translations tt ON t.id = tt.tour_id AND tt.lang = :lang1
                LEFT JOIN tour_translations tt_en ON t.id = tt_en.tour_id AND tt_en.lang = 'en'
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

    public function getFullDetailForAdmin(int $id): ?array {
        $tour = $this->queryOne("SELECT * FROM tours WHERE id = :id", ['id' => $id]);
        if (!$tour) return null;

        $translations = $this->query("SELECT * FROM tour_translations WHERE tour_id = :id", ['id' => $id]);
        $tour['translations'] = [];
        foreach ($translations as $tr) {
            $tour['translations'][$tr['lang']] = $tr;
        }

        $categories = $this->query("SELECT category_id FROM tour_categories WHERE tour_id = :id", ['id' => $id]);
        $tour['category_ids'] = array_column($categories, 'category_id');

        $tour['images'] = $this->getGallery($id);
        $tour['prices'] = $this->getPrices($id);

        $steps = $this->query("SELECT * FROM tour_itinerary_steps WHERE tour_id = :id ORDER BY sort_order ASC", ['id' => $id]);
        foreach ($steps as &$step) {
            $sTrans = $this->query("SELECT * FROM tour_itinerary_translations WHERE step_id = :step_id", ['step_id' => $step['id']]);
            $step['translations'] = [];
            foreach ($sTrans as $st) {
                $step['translations'][$st['lang']] = $st;
            }
        }
        unset($step);
        $tour['itinerary'] = $steps;

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

    public function saveTour(array $data, ?int $id = null): int {
        $this->db->beginTransaction();
        try {
            if ($id === null) {
                $sql = "INSERT INTO tours (code, slug, destination_id, duration_type, duration_days, difficulty, transportation, group_size, price_from_usd, price_from_vnd, featured_image, is_featured, is_signature, signature_number, sort_order, status)
                        VALUES (:code, :slug, :destination_id, :duration_type, :duration_days, :difficulty, :transportation, :group_size, :price_from_usd, :price_from_vnd, :featured_image, :is_featured, :is_signature, :signature_number, :sort_order, :status)";
                $this->execute($sql, [
                    'code' => trim($data['code']),
                    'slug' => trim($data['slug']),
                    'destination_id' => !empty($data['destination_id']) ? (int)$data['destination_id'] : null,
                    'duration_type' => $data['duration_type'] ?? 'fullday',
                    'duration_days' => (int)($data['duration_days'] ?? 1),
                    'difficulty' => $data['difficulty'] ?? 'easy',
                    'transportation' => trim($data['transportation'] ?? ''),
                    'group_size' => trim($data['group_size'] ?? ''),
                    'price_from_usd' => (float)($data['price_from_usd'] ?? 0),
                    'price_from_vnd' => (int)($data['price_from_vnd'] ?? 0),
                    'featured_image' => trim($data['featured_image'] ?? ''),
                    'is_featured' => !empty($data['is_featured']) ? 1 : 0,
                    'is_signature' => !empty($data['is_signature']) ? 1 : 0,
                    'signature_number' => (int)($data['signature_number'] ?? 0),
                    'sort_order' => (int)($data['sort_order'] ?? 0),
                    'status' => isset($data['status']) ? (int)$data['status'] : 1
                ]);
                $id = (int)$this->db->lastInsertId();
            } else {
                $sql = "UPDATE tours 
                        SET code = :code, slug = :slug, destination_id = :destination_id, duration_type = :duration_type, 
                            duration_days = :duration_days, difficulty = :difficulty, transportation = :transportation, 
                            group_size = :group_size, price_from_usd = :price_from_usd, price_from_vnd = :price_from_vnd, 
                            featured_image = :featured_image, is_featured = :is_featured, is_signature = :is_signature, 
                            signature_number = :signature_number, sort_order = :sort_order, status = :status, updated_at = CURRENT_TIMESTAMP
                        WHERE id = :id";
                $this->execute($sql, [
                    'code' => trim($data['code']),
                    'slug' => trim($data['slug']),
                    'destination_id' => !empty($data['destination_id']) ? (int)$data['destination_id'] : null,
                    'duration_type' => $data['duration_type'] ?? 'fullday',
                    'duration_days' => (int)($data['duration_days'] ?? 1),
                    'difficulty' => $data['difficulty'] ?? 'easy',
                    'transportation' => trim($data['transportation'] ?? ''),
                    'group_size' => trim($data['group_size'] ?? ''),
                    'price_from_usd' => (float)($data['price_from_usd'] ?? 0),
                    'price_from_vnd' => (int)($data['price_from_vnd'] ?? 0),
                    'featured_image' => trim($data['featured_image'] ?? ''),
                    'is_featured' => !empty($data['is_featured']) ? 1 : 0,
                    'is_signature' => !empty($data['is_signature']) ? 1 : 0,
                    'signature_number' => (int)($data['signature_number'] ?? 0),
                    'sort_order' => (int)($data['sort_order'] ?? 0),
                    'status' => isset($data['status']) ? (int)$data['status'] : 1,
                    'id' => $id
                ]);
            }

            // Save Translations for EN & VI
            foreach (['en', 'vi'] as $lang) {
                if (isset($data['translations'][$lang])) {
                    $tData = $data['translations'][$lang];
                    $this->execute(
                        "INSERT INTO tour_translations (tour_id, lang, title, sub_title, short_description, highlights, overview, inclusions, exclusions, what_to_bring, child_policy, cancellation_policy, seo_title, seo_description)
                         VALUES (:tour_id, :lang, :title, :sub_title, :short_description, :highlights, :overview, :inclusions, :exclusions, :what_to_bring, :child_policy, :cancellation_policy, :seo_title, :seo_description)
                         ON DUPLICATE KEY UPDATE 
                         title = VALUES(title), sub_title = VALUES(sub_title), short_description = VALUES(short_description),
                         highlights = VALUES(highlights), overview = VALUES(overview), inclusions = VALUES(inclusions),
                         exclusions = VALUES(exclusions), what_to_bring = VALUES(what_to_bring), child_policy = VALUES(child_policy),
                         cancellation_policy = VALUES(cancellation_policy), seo_title = VALUES(seo_title), seo_description = VALUES(seo_description)",
                        [
                            'tour_id' => $id,
                            'lang' => $lang,
                            'title' => trim($tData['title'] ?? ''),
                            'sub_title' => trim($tData['sub_title'] ?? ''),
                            'short_description' => trim($tData['short_description'] ?? ''),
                            'highlights' => trim($tData['highlights'] ?? ''),
                            'overview' => trim($tData['overview'] ?? ''),
                            'inclusions' => trim($tData['inclusions'] ?? ''),
                            'exclusions' => trim($tData['exclusions'] ?? ''),
                            'what_to_bring' => trim($tData['what_to_bring'] ?? ''),
                            'child_policy' => trim($tData['child_policy'] ?? ''),
                            'cancellation_policy' => trim($tData['cancellation_policy'] ?? ''),
                            'seo_title' => trim($tData['seo_title'] ?? ''),
                            'seo_description' => trim($tData['seo_description'] ?? '')
                        ]
                    );
                }
            }

            // Save Categories
            $this->execute("DELETE FROM tour_categories WHERE tour_id = :id", ['id' => $id]);
            if (!empty($data['category_ids']) && is_array($data['category_ids'])) {
                foreach ($data['category_ids'] as $catId) {
                    $this->execute("INSERT INTO tour_categories (tour_id, category_id) VALUES (:id, :cat_id)", [
                        'id' => $id,
                        'cat_id' => (int)$catId
                    ]);
                }
            }

            // Save Gallery Images
            if (isset($data['images']) && is_array($data['images'])) {
                $this->execute("DELETE FROM tour_images WHERE tour_id = :id", ['id' => $id]);
                foreach ($data['images'] as $idx => $img) {
                    if (!empty($img['path'])) {
                        $this->execute("INSERT INTO tour_images (tour_id, image_path, caption, sort_order) VALUES (:id, :path, :cap, :sort)", [
                            'id' => $id,
                            'path' => trim($img['path']),
                            'cap' => trim($img['caption'] ?? ''),
                            'sort' => $idx
                        ]);
                    }
                }
            }

            $this->db->commit();
            Cache::flush();
            return $id;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function deleteTour(int $id): array {
        // Check for existing bookings or reviews
        $hasBookings = $this->queryOne("SELECT id FROM bookings WHERE tour_id = :id LIMIT 1", ['id' => $id]);
        $hasReviews = $this->queryOne("SELECT id FROM tour_reviews WHERE tour_id = :id LIMIT 1", ['id' => $id]);

        if ($hasBookings || $hasReviews) {
            // Soft delete / archive tour by setting status = 0
            $this->execute("UPDATE tours SET status = 0, updated_at = CURRENT_TIMESTAMP WHERE id = :id", ['id' => $id]);
            Cache::flush();
            return [
                'success' => true,
                'action' => 'archived',
                'message' => 'Tour has existing bookings/reviews. It has been archived (hidden) instead of hard-deleted to preserve records.'
            ];
        }

        // Safe hard delete
        $this->db->beginTransaction();
        try {
            $this->execute("DELETE FROM tours WHERE id = :id", ['id' => $id]);
            $this->db->commit();
            Cache::flush();
            return [
                'success' => true,
                'action' => 'deleted',
                'message' => 'Tour deleted successfully.'
            ];
        } catch (\Throwable $e) {
            $this->db->rollBack();
            return [
                'success' => false,
                'action' => 'error',
                'message' => 'Failed to delete tour: ' . $e->getMessage()
            ];
        }
    }
}
