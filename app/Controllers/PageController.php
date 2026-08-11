<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Language;
use App\Models\Faq;
use App\Models\Setting;

use App\Core\Csrf;
use App\Core\Mailer;
use App\Core\Session;

class PageController extends Controller {
    public function about(): void {
        $lang = Language::current();
        $settingModel = new Setting();
        $settings = $settingModel->getAllSettings();

        $seo = [
            'title' => __('nav_about') . ' - Vietnam Unique Travel',
            'description' => 'Learn about Vietnam Unique Travel brand history, vision, mission, core values and our dedicated team.',
            'canonical' => base_url(($lang === 'vi' ? 'vi/' : '') . 'about-us')
        ];

        $this->render('pages/about', compact('settings', 'seo', 'lang'));
    }

    public function responsibleTourism(): void {
        $lang = Language::current();
        $seo = [
            'title' => __('nav_responsible') . ' - Vietnam Unique Travel',
            'description' => 'Our commitment to responsible tourism, eco-preservation, and local community empowerment in Vietnam.',
            'canonical' => base_url(($lang === 'vi' ? 'vi/' : '') . 'responsible-tourism')
        ];

        $this->render('pages/responsible_tourism', compact('seo', 'lang'));
    }

    public function faq(): void {
        $lang = Language::current();
        $faqModel = new Faq();
        $faqs = $faqModel->getAll($lang);

        $seo = [
            'title' => __('nav_faq') . ' - Vietnam Unique Travel',
            'description' => 'Frequently asked questions regarding tour booking, customization, preparation, and policies.',
            'canonical' => base_url(($lang === 'vi' ? 'vi/' : '') . 'faq')
        ];

        $this->render('pages/faq', compact('faqs', 'seo', 'lang'));
    }

    public function contact(): void {
        $lang = Language::current();
        $settingModel = new Setting();
        $settings = $settingModel->getAllSettings();

        $seo = [
            'title' => __('nav_contact') . ' - Vietnam Unique Travel',
            'description' => 'Get in touch with Vietnam Unique Travel via hotline, email, WhatsApp, or visit our Hanoi office.',
            'canonical' => base_url(($lang === 'vi' ? 'vi/lien-he' : 'contact'))
        ];

        $this->render('pages/contact', compact('settings', 'seo', 'lang'));
    }

    public function submitContact(): void {
        $lang = Language::current();
        $redirectUrl = base_url($lang === 'vi' ? 'vi/lien-he#contact-form' : 'contact#contact-form');

        // Honeypot check for bots
        if (!empty($_POST['website_url'])) {
            Session::flash('error', $lang === 'vi' ? 'Phát hiện truy cập bất thường.' : 'Spam submission detected.');
            $this->redirect($redirectUrl);
            return;
        }

        // Validate CSRF token
        if (!Csrf::verify($_POST['_csrf'] ?? null)) {
            Session::flash('error', $lang === 'vi' ? 'Mã bảo mật đã hết hạn. Vui lòng thử lại.' : 'Security token expired. Please try again.');
            $this->redirect($redirectUrl);
            return;
        }

        // Extract and sanitize input fields
        $fullname = trim($_POST['fullname'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone_whatsapp'] ?? '');
        $nationality = trim($_POST['nationality'] ?? '');
        $subject = trim($_POST['subject'] ?? 'General Inquiry');
        $message = trim($_POST['message'] ?? '');
        $agree = isset($_POST['agree_policy']);

        // Validation
        $errors = [];
        if (empty($fullname)) {
            $errors['fullname'] = $lang === 'vi' ? 'Vui lòng nhập họ và tên.' : 'Full Name is required.';
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = $lang === 'vi' ? 'Vui lòng nhập địa chỉ email hợp lệ.' : 'Valid Email Address is required.';
        }
        if (empty($phone)) {
            $errors['phone_whatsapp'] = $lang === 'vi' ? 'Vui lòng nhập số điện thoại / WhatsApp.' : 'Phone / WhatsApp is required.';
        }
        if (empty($message)) {
            $errors['message'] = $lang === 'vi' ? 'Vui lòng nhập nội dung tin nhắn.' : 'Message content is required.';
        }
        if (!$agree) {
            $errors['agree_policy'] = $lang === 'vi' ? 'Bạn chưa đồng ý với Chính sách bảo mật.' : 'You must agree to the Privacy Policy.';
        }

        if (!empty($errors)) {
            Session::flash('contact_errors', $errors);
            Session::flash('contact_old', [
                'fullname' => $fullname,
                'email' => $email,
                'phone_whatsapp' => $phone,
                'nationality' => $nationality,
                'subject' => $subject,
                'message' => $message
            ]);
            Session::flash('error', $lang === 'vi' ? 'Vui lòng kiểm tra lại các trường bắt buộc.' : 'Please correct the errors in the form.');
            $this->redirect($redirectUrl);
            return;
        }

        // Build Email HTML for Sales team
        $mailSubject = "New Contact Inquiry from " . $fullname . " - Vietnam Unique Travel";
        $mailBody = "
        <div style='font-family: Arial, sans-serif; font-size: 15px; color: #1E293B; line-height: 1.6; max-width: 600px;'>
            <h2 style='color: #005825; border-bottom: 2px solid #005825; padding-bottom: 8px;'>New Contact Inquiry</h2>
            <p><strong>Full Name:</strong> {$fullname}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Phone / WhatsApp:</strong> " . ($phone ?: 'N/A') . "</p>
            <p><strong>Nationality:</strong> " . ($nationality ?: 'N/A') . "</p>
            <p><strong>Subject:</strong> {$subject}</p>
            <p><strong>Message:</strong></p>
            <div style='background: #F8F6EF; padding: 16px; border-left: 4px solid #005825; border-radius: 4px;'>
                " . nl2br(e($message)) . "
            </div>
            <hr style='margin-top: 24px; border: none; border-top: 1px solid #CBD5E1;'>
            <p style='font-size: 12px; color: #64748B;'>Sent from Vietnam Unique Travel Contact Form</p>
        </div>";

        // Send Email via Mailer
        Mailer::send('sales.vietnamuniquetravel@gmail.com', $mailSubject, $mailBody);

        // Success Flash & PRG Redirect
        Session::flash('success', $lang === 'vi' 
            ? 'Cảm ơn bạn đã liên hệ! Đội ngũ tư vấn của Vietnam Unique Travel sẽ phản hồi lại bạn trong thời gian sớm nhất.' 
            : 'Thank you for reaching out! Our travel specialists will review your enquiry and get back to you shortly.');
        
        $this->redirect($redirectUrl);
    }

    public function policy(string $type = 'privacy'): void {
        $lang = Language::current();
        $titles = [
            'privacy' => 'Privacy Policy',
            'terms' => 'Terms and Conditions',
            'booking' => 'Booking, Cancellation and Date-Change Policy'
        ];

        $title = $titles[$type] ?? 'Policy';

        $seo = [
            'title' => $title . ' - Vietnam Unique Travel',
            'description' => $title . ' of Vietnam Unique Travel.',
            'canonical' => base_url(($lang === 'vi' ? 'vi/' : '') . 'policy/' . $type)
        ];

        $this->render('pages/legal_policy', compact('type', 'title', 'seo', 'lang'));
    }
}
