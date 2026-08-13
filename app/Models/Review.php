<?php

namespace App\Models;

use App\Core\Model;

class Review extends Model {
    protected string $table = 'tour_reviews';

    public function createReview(array $data): int {
        $sql = "INSERT INTO tour_reviews (tour_id, booking_id, client_name, email, rating, content, status)
                VALUES (:tour_id, :booking_id, :client_name, :email, :rating, :content, 'pending')";
        
        $this->execute($sql, [
            'tour_id' => (int)$data['tour_id'],
            'booking_id' => !empty($data['booking_id']) ? (int)$data['booking_id'] : null,
            'client_name' => trim($data['client_name']),
            'email' => trim($data['email']),
            'rating' => max(1, min(5, (int)$data['rating'])),
            'content' => trim($data['content'])
        ]);

        return (int)$this->db->lastInsertId();
    }

    public function hasReviewForBooking(int $bookingId): bool {
        $row = $this->queryOne("SELECT id FROM tour_reviews WHERE booking_id = :bid", ['bid' => $bookingId]);
        return !empty($row);
    }

    public function getApprovedByTourId(int $tourId): array {
        return $this->query(
            "SELECT id, tour_id, client_name, rating, content, created_at 
             FROM tour_reviews 
             WHERE tour_id = :tour_id AND status = 'approved' 
             ORDER BY id DESC",
            ['tour_id' => $tourId]
        );
    }

    public function getTourRatingStats(int $tourId): array {
        $row = $this->queryOne(
            "SELECT COUNT(*) as total_reviews, COALESCE(AVG(rating), 0) as avg_rating 
             FROM tour_reviews 
             WHERE tour_id = :tour_id AND status = 'approved'",
            ['tour_id' => $tourId]
        );
        return [
            'total_reviews' => (int)($row['total_reviews'] ?? 0),
            'avg_rating' => round((float)($row['avg_rating'] ?? 0), 1)
        ];
    }

    public function getAllForAdmin(array $filters = []): array {
        $sql = "SELECT r.*, COALESCE(tt.title, tt_en.title, t.code) as tour_name, b.booking_code
                FROM tour_reviews r
                LEFT JOIN tours t ON r.tour_id = t.id
                LEFT JOIN tour_translations tt ON t.id = tt.tour_id AND tt.lang = 'vi'
                LEFT JOIN tour_translations tt_en ON t.id = tt_en.tour_id AND tt_en.lang = 'en'
                LEFT JOIN bookings b ON r.booking_id = b.id
                WHERE 1=1";
        $params = [];

        if (!empty($filters['status']) && in_array($filters['status'], ['pending', 'approved', 'rejected'])) {
            $sql .= " AND r.status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['tour_id'])) {
            $sql .= " AND r.tour_id = :tour_id";
            $params['tour_id'] = (int)$filters['tour_id'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (r.client_name LIKE :search OR r.email LIKE :search OR r.content LIKE :search)";
            $params['search'] = '%' . trim($filters['search']) . '%';
        }

        $sql .= " ORDER BY r.id DESC";
        return $this->query($sql, $params);
    }

    public function getById(int $id): ?array {
        $sql = "SELECT r.*, COALESCE(tt.title, tt_en.title, t.code) as tour_name, b.booking_code
                FROM tour_reviews r
                LEFT JOIN tours t ON r.tour_id = t.id
                LEFT JOIN tour_translations tt ON t.id = tt.tour_id AND tt.lang = 'vi'
                LEFT JOIN tour_translations tt_en ON t.id = tt_en.tour_id AND tt_en.lang = 'en'
                LEFT JOIN bookings b ON r.booking_id = b.id
                WHERE r.id = :id";
        return $this->queryOne($sql, ['id' => $id]);
    }

    public function updateStatus(int $id, string $status): void {
        if (!in_array($status, ['pending', 'approved', 'rejected'])) {
            return;
        }
        $this->execute("UPDATE tour_reviews SET status = :status, updated_at = CURRENT_TIMESTAMP WHERE id = :id", [
            'status' => $status,
            'id' => $id
        ]);
    }

    public function updateReview(int $id, array $data): void {
        $sql = "UPDATE tour_reviews 
                SET client_name = :client_name, rating = :rating, content = :content, status = :status, updated_at = CURRENT_TIMESTAMP 
                WHERE id = :id";
        $this->execute($sql, [
            'client_name' => trim($data['client_name']),
            'rating' => max(1, min(5, (int)$data['rating'])),
            'content' => trim($data['content']),
            'status' => in_array($data['status'], ['pending', 'approved', 'rejected']) ? $data['status'] : 'pending',
            'id' => $id
        ]);
    }

    public function deleteReview(int $id): void {
        $this->execute("DELETE FROM tour_reviews WHERE id = :id", ['id' => $id]);
    }

    public function getPendingCount(): int {
        $row = $this->queryOne("SELECT COUNT(*) as cnt FROM tour_reviews WHERE status = 'pending'");
        return $row ? (int)$row['cnt'] : 0;
    }
}
