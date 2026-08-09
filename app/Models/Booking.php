<?php

namespace App\Models;

use App\Core\Model;

class Booking extends Model {
    protected string $table = 'bookings';

    public function createBooking(array $data): string {
        $bookingCode = 'VNU-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));

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
            'tour_id' => $data['tour_id'] ?? null,
            'tour_name' => $data['tour_name'] ?? 'Custom Inquiry',
            'travel_date' => $data['travel_date'],
            'adults' => (int)($data['adults'] ?? 1),
            'children' => (int)($data['children'] ?? 0),
            'fullname' => $data['fullname'],
            'nationality' => $data['nationality'] ?? '',
            'email' => $data['email'],
            'phone_whatsapp' => $data['phone_whatsapp'],
            'pickup_location' => $data['pickup_location'],
            'dietary_requirements' => $data['dietary_requirements'] ?? '',
            'health_notes' => $data['health_notes'] ?? '',
            'special_requests' => $data['special_requests'] ?? '',
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
        ];

        $this->execute($sql, $params);
        return $bookingCode;
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
        return $this->queryOne("SELECT * FROM bookings WHERE booking_code = :code", ['code' => $code]);
    }

    public function getAll(array $filters = []): array {
        $sql = "SELECT * FROM bookings WHERE 1=1";
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['search'])) {
            $sql .= " AND (booking_code LIKE :search OR fullname LIKE :search OR email LIKE :search OR phone_whatsapp LIKE :search)";
            $params['search'] = '%' . $filters['search'] . '%';
        }

        $sql .= " ORDER BY id DESC";
        return $this->query($sql, $params);
    }

    public function updateStatus(int $id, string $status, ?string $internalNotes = null): void {
        $sql = "UPDATE bookings SET status = :status, internal_notes = :notes WHERE id = :id";
        $this->execute($sql, ['status' => $status, 'notes' => $internalNotes, 'id' => $id]);
    }
}
