<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Language;
use App\Core\Csrf;
use App\Core\Mailer;
use App\Core\Session;
use App\Models\Booking;
use App\Models\Tour;

class BookingController extends Controller {
    public function form(): void {
        $lang = Language::current();
        $tourModel = new Tour();
        
        $selectedTourId = $this->request->get('tour_id');
        $selectedTourSlug = $this->request->get('tour');

        $tours = $tourModel->getAll($lang);
        $selectedTour = null;

        if ($selectedTourSlug) {
            $selectedTour = $tourModel->getBySlug($selectedTourSlug, $lang);
        } elseif ($selectedTourId) {
            foreach ($tours as $t) {
                if ((int)$t['id'] === (int)$selectedTourId) {
                    $selectedTour = $t;
                    break;
                }
            }
        }

        $seo = [
            'title' => __('btn_book_tour') . ' - Vietnam Unique Travel',
            'description' => 'Submit your tour booking inquiry. Our team will verify availability and confirm within minutes.',
            'canonical' => base_url(($lang === 'vi' ? 'vi/' : '') . 'booking')
        ];

        $this->render('pages/booking_form', compact('tours', 'selectedTour', 'seo', 'lang'));
    }

    public function submit(): void {
        $lang = Language::current();

        // Check Honeypot field (anti-spam)
        if (!empty($this->request->post('website_hp'))) {
            $this->response->setStatusCode(400);
            exit('Spam detected.');
        }

        // Validate CSRF
        if (!Csrf::verify($this->request->post('_csrf'))) {
            Session::flash('error', 'Security token expired. Please try submitting again.');
            $this->redirect(base_url(($lang === 'vi' ? 'vi/' : '') . 'booking'));
            return;
        }

        // Extract & sanitize post data
        $fullname = trim($this->request->post('fullname', ''));
        $email = trim($this->request->post('email', ''));
        $phone = trim($this->request->post('phone_whatsapp', ''));
        $travelDate = trim($this->request->post('travel_date', ''));
        $adults = (int)$this->request->post('adults', 1);
        $children = (int)$this->request->post('children', 0);
        $pickup = trim($this->request->post('pickup_location', ''));
        $tourName = trim($this->request->post('tour_name', 'Custom Inquiry'));
        $tourId = $this->request->post('tour_id') ? (int)$this->request->post('tour_id') : null;
        $nationality = trim($this->request->post('nationality', ''));
        $dietary = trim($this->request->post('dietary_requirements', ''));
        $health = trim($this->request->post('health_notes', ''));
        $special = trim($this->request->post('special_requests', ''));
        $agree = $this->request->post('agree_policy');

        // Validation checks
        if (!$fullname || !$email || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$phone || !$travelDate || !$pickup || !$agree) {
            Session::flash('error', 'Please fill in all required fields accurately.');
            $this->redirect(base_url(($lang === 'vi' ? 'vi/' : '') . 'booking'));
            return;
        }

        $bookingModel = new Booking();
        $code = $bookingModel->createBooking([
            'tour_id' => $tourId,
            'tour_name' => $tourName,
            'travel_date' => $travelDate,
            'adults' => $adults,
            'children' => $children,
            'fullname' => $fullname,
            'nationality' => $nationality,
            'email' => $email,
            'phone_whatsapp' => $phone,
            'pickup_location' => $pickup,
            'dietary_requirements' => $dietary,
            'health_notes' => $health,
            'special_requests' => $special
        ]);

        // Build Email HTML for Sales & Customer
        $salesSubject = "New Booking Inquiry [{$code}] - " . $tourName;
        $salesBody = $this->buildSalesEmailHtml($code, $tourName, $travelDate, $adults, $children, $fullname, $nationality, $email, $phone, $pickup, $dietary, $health, $special);

        $customerSubject = $lang === 'vi' 
            ? "Xác nhận yêu cầu đặt tour [{$code}] – Vietnam Unique Travel"
            : "Booking request confirmation [{$code}] – Vietnam Unique Travel";
            
        $customerBody = $this->buildCustomerEmailHtml($lang, $code, $tourName, $travelDate, $adults, $children, $fullname, $nationality, $email, $phone, $pickup, $dietary, $health, $special);

        $sentAdmin = Mailer::send('sales.vietnamuniquetravel@gmail.com', $salesSubject, $salesBody);
        $sentCustomer = Mailer::send($email, $customerSubject, $customerBody);

        $errorLog = null;
        if (!$sentAdmin || !$sentCustomer) {
            $errorLog = "Admin email sent: " . ($sentAdmin ? 'YES' : 'NO') . " | Customer email sent: " . ($sentCustomer ? 'YES' : 'NO');
        }

        $bookingModel->updateEmailStatus($code, $sentAdmin, $sentCustomer, $errorLog);

        // PRG Redirect to success page
        $this->redirect(base_url(($lang === 'vi' ? 'vi/' : '') . 'booking-success?code=' . urlencode($code)));
    }

    public function success(): void {
        $lang = Language::current();
        $code = $this->request->get('code');
        $bookingModel = new Booking();
        $booking = $code ? $bookingModel->getByCode($code) : null;

        $seo = [
            'title' => 'Booking Request Received - Vietnam Unique Travel',
            'canonical' => base_url(($lang === 'vi' ? 'vi/' : '') . 'booking-success')
        ];

        $this->render('pages/booking_success', compact('booking', 'code', 'seo', 'lang'));
    }

    private function buildSalesEmailHtml(...$args): string {
        list($code, $tourName, $date, $adults, $children, $name, $nat, $email, $phone, $pickup, $diet, $health, $spec) = $args;
        return "<h2>New Booking Inquiry: {$code}</h2>
                <p><strong>Tour:</strong> {$tourName}</p>
                <p><strong>Travel Date:</strong> {$date}</p>
                <p><strong>Guests:</strong> {$adults} Adults, {$children} Children</p>
                <p><strong>Customer Name:</strong> {$name}</p>
                <p><strong>Nationality:</strong> {$nat}</p>
                <p><strong>Email:</strong> {$email}</p>
                <p><strong>Phone/WhatsApp:</strong> {$phone}</p>
                <p><strong>Pickup Location:</strong> {$pickup}</p>
                <p><strong>Dietary Req:</strong> {$diet}</p>
                <p><strong>Health Notes:</strong> {$health}</p>
                <p><strong>Special Requests:</strong> {$spec}</p>";
    }

    private function buildCustomerEmailHtml($lang, ...$args): string {
        list($code, $tourName, $date, $adults, $children, $name, $nat, $email, $phone, $pickup, $diet, $health, $spec) = $args;
        if ($lang === 'vi') {
            return "<h3>Xin chào {$name},</h3>
                    <p>Cảm ơn Quý khách đã quan tâm đến các chương trình của <strong>Vietnam Unique Travel</strong>.</p>
                    <p>Chúng tôi đã nhận được yêu cầu đặt tour (Mã: <strong>{$code}</strong>) của Quý khách và đội ngũ tư vấn sẽ kiểm tra tình trạng dịch vụ, sau đó liên hệ lại trong thời gian sớm nhất.</p>
                    <h4>Thông tin Quý khách đã gửi:</h4>
                    <ul>
                        <li><strong>Tour quan tâm:</strong> {$tourName}</li>
                        <li><strong>Ngày dự kiến:</strong> {$date}</li>
                        <li><strong>Số lượng:</strong> {$adults} người lớn, {$children} trẻ em</li>
                        <li><strong>Họ và tên:</strong> {$name}</li>
                        <li><strong>Quốc tịch:</strong> {$nat}</li>
                        <li><strong>Email:</strong> {$email}</li>
                        <li><strong>Số điện thoại/WhatsApp:</strong> {$phone}</li>
                        <li><strong>Địa điểm đón:</strong> {$pickup}</li>
                        <li><strong>Yêu cầu ăn uống:</strong> {$diet}</li>
                        <li><strong>Ghi chú sức khỏe:</strong> {$health}</li>
                        <li><strong>Yêu cầu đặc biệt:</strong> {$spec}</li>
                    </ul>
                    <p>Hotline hỗ trợ: +84 362 191 568 | Email: sales.vietnamuniquetravel@gmail.com</p>
                    <p>Trân trọng,<br>Vietnam Unique Travel</p>";
        }
        return "<h3>Dear {$name},</h3>
                <p>Thank you for your interest in the tours and experiences offered by <strong>Vietnam Unique Travel</strong>.</p>
                <p>We have successfully received your tour inquiry (Booking Reference: <strong>{$code}</strong>). Our travel consultants will check availability and contact you as soon as possible to assist you with the next steps.</p>
                <h4>Your Submitted Information:</h4>
                <ul>
                    <li><strong>Tour of Interest:</strong> {$tourName}</li>
                    <li><strong>Preferred Travel Date:</strong> {$date}</li>
                    <li><strong>Group Size:</strong> {$adults} Adults, {$children} Children</li>
                    <li><strong>Full Name:</strong> {$name}</li>
                    <li><strong>Nationality:</strong> {$nat}</li>
                    <li><strong>Email Address:</strong> {$email}</li>
                    <li><strong>Phone Number / WhatsApp:</strong> {$phone}</li>
                    <li><strong>Hotel / Pickup Location:</strong> {$pickup}</li>
                    <li><strong>Dietary Requirements:</strong> {$diet}</li>
                    <li><strong>Health Information:</strong> {$health}</li>
                    <li><strong>Special Requests:</strong> {$spec}</li>
                </ul>
                <p>Hotline: +84 362 191 568 | Email: sales.vietnamuniquetravel@gmail.com</p>
                <p>Kind regards,<br>Vietnam Unique Travel</p>";
    }
}
