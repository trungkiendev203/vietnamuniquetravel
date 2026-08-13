<?php

namespace App\Models;

use App\Core\Model;

class Booking extends Model {
    protected string $table = 'bookings';

    public static array $allowedStatuses = ['new', 'contacted', 'confirmed', 'completed', 'cancelled'];

    public function createBooking(array $data): array {
        $bookingCode = 'VNU-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

        $tourId = !empty($data['tour_id']) ? (int)$data['tour_id'] : null;
        $tourName = trim($data['tour_name'] ?? 'Custom Inquiry');

        if ($tourId) {
            $tourModel = new Tour();
            $tInfo = $tourModel->getById($tourId);
            if ($tInfo && !empty($tInfo['title'])) {
                $tourName = $tInfo['title'];
            }
        }

        $sql = "INSERT INTO bookings (
                    booking_code, tour_id, tour_name, travel_date, adults, children,
                    fullname, nationality, email, phone_whatsapp, pickup_location,
                    dietary_requirements, health_notes, special_requests, status,
                    ip_address, user_agent
                ) VALUES (
                    :code, :tour_id, :tour_name, :travel_date, :adults, :children,
                    :fullname, :nationality, :email, :phone_whatsapp, :pickup_location,
                    :dietary_requirements, :health_notes, :special_requests, 'new',
                    :ip_address, :user_agent
                )";

        $params = [
            'code' => $bookingCode,
            'tour_id' => $tourId,
            'tour_name' => $tourName,
            'travel_date' => $data['travel_date'],
            'adults' => (int)($data['adults'] ?? 1),
            'children' => (int)($data['children'] ?? 0),
            'fullname' => trim($data['fullname']),
            'nationality' => trim($data['nationality'] ?? ''),
            'email' => trim($data['email']),
            'phone_whatsapp' => trim($data['phone_whatsapp']),
            'pickup_location' => trim($data['pickup_location']),
            'dietary_requirements' => trim($data['dietary_requirements'] ?? ''),
            'health_notes' => trim($data['health_notes'] ?? ''),
            'special_requests' => trim($data['special_requests'] ?? ''),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
        ];

        $this->execute($sql, $params);
        $id = (int)$this->db->lastInsertId();

        return [
            'id' => $id,
            'code' => $bookingCode,
            'tour_name' => $tourName
        ];
    }

    public function updateEmailStatus(string $code, bool $sentAdmin, bool $sentCustomer, ?string $errorLog = null): void {
        $sql = "UPDATE bookings SET email_sent_admin = :admin, email_sent_customer = :customer, email_error_log = :error WHERE booking_code = :code";
        $this->execute($sql, [
            'admin' => $sentAdmin ? 1 : 0,
            'customer' => $sentCustomer ? 1 : 0,
            'error' => $errorLog,
            'code' => $code
        ]);
    }

    public function getByCode(string $code): ?array {
        return $this->queryOne("SELECT * FROM bookings WHERE booking_code = :code", ['code' => trim($code)]);
    }

    public function getByCodeAndEmail(string $code, string $email): ?array {
        $sql = "SELECT * FROM bookings WHERE LOWER(booking_code) = LOWER(:code) AND LOWER(email) = LOWER(:email)";
        return $this->queryOne($sql, [
            'code' => trim($code),
            'email' => trim($email)
        ]);
    }

    public function getAll(array $filters = []): array {
        $sql = "SELECT * FROM bookings WHERE 1=1";
        $params = [];

        if (!empty($filters['status']) && in_array($filters['status'], self::$allowedStatuses)) {
            $sql .= " AND status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (booking_code LIKE :search OR fullname LIKE :search OR email LIKE :search OR phone_whatsapp LIKE :search)";
            $params['search'] = '%' . trim($filters['search']) . '%';
        }

        $sql .= " ORDER BY id DESC";
        return $this->query($sql, $params);
    }

    public function updateStatus(int $id, string $status, ?string $internalNotes = null): bool {
        if (!in_array($status, self::$allowedStatuses)) {
            return false;
        }
        $sql = "UPDATE bookings SET status = :status, internal_notes = :notes, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
        return $this->execute($sql, ['status' => $status, 'notes' => $internalNotes, 'id' => $id]);
    }
}
