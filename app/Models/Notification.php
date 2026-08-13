<?php

namespace App\Models;

use App\Core\Model;

class Notification extends Model {
    protected string $table = 'admin_notifications';

    public function createNotification(array $data): int {
        // Check duplicate notification for same booking if booking_id is provided
        if (!empty($data['booking_id'])) {
            $existing = $this->queryOne("SELECT id FROM admin_notifications WHERE booking_id = :bid", ['bid' => $data['booking_id']]);
            if ($existing) {
                return (int)$existing['id'];
            }
        }

        $sql = "INSERT INTO admin_notifications (type, booking_id, title, message, link, is_read)
                VALUES (:type, :booking_id, :title, :message, :link, 0)";
        
        $this->execute($sql, [
            'type' => $data['type'] ?? 'booking',
            'booking_id' => $data['booking_id'] ?? null,
            'title' => $data['title'],
            'message' => $data['message'],
            'link' => $data['link'] ?? null
        ]);

        return (int)$this->db->lastInsertId();
    }

    public function getUnreadCount(): int {
        $row = $this->queryOne("SELECT COUNT(*) as cnt FROM admin_notifications WHERE is_read = 0");
        return $row ? (int)$row['cnt'] : 0;
    }

    public function getAll(int $limit = 50): array {
        return $this->query("SELECT * FROM admin_notifications ORDER BY id DESC LIMIT " . (int)$limit);
    }

    public function getById(int $id): ?array {
        return $this->queryOne("SELECT * FROM admin_notifications WHERE id = :id", ['id' => $id]);
    }

    public function markAsRead(int $id): void {
        $this->execute("UPDATE admin_notifications SET is_read = 1 WHERE id = :id", ['id' => $id]);
    }

    public function markAsUnread(int $id): void {
        $this->execute("UPDATE admin_notifications SET is_read = 0 WHERE id = :id", ['id' => $id]);
    }

    public function markAllAsRead(): void {
        $this->execute("UPDATE admin_notifications SET is_read = 1 WHERE is_read = 0");
    }
}
