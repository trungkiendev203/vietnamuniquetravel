<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Csrf;
use App\Models\Notification;

class NotificationAdminController extends Controller {
    public function __construct() {
        parent::__construct();
        if (!Session::has('admin_id')) {
            $this->redirect(base_url('admin/login'));
            exit;
        }
    }

    public function index(): void {
        $notifModel = new Notification();
        $notifications = $notifModel->getAll(100);

        $seo = ['title' => 'Admin Notifications - Vietnam Unique Travel'];
        $this->render('admin/notifications/index', compact('notifications', 'seo'), 'layouts/admin');
    }

    public function markRead(int $id): void {
        if (!Csrf::verify($this->request->post('_csrf'))) {
            $this->redirect(base_url('admin/notifications'));
            return;
        }

        $notifModel = new Notification();
        $notifModel->markAsRead($id);
        
        $redirectUrl = $this->request->post('redirect', base_url('admin/notifications'));
        $this->redirect($redirectUrl);
    }

    public function markAllRead(): void {
        if (!Csrf::verify($this->request->post('_csrf'))) {
            $this->redirect(base_url('admin/notifications'));
            return;
        }

        $notifModel = new Notification();
        $notifModel->markAllAsRead();

        Session::flash('success', 'All notifications marked as read.');
        $this->redirect(base_url('admin/notifications'));
    }

    public function open(int $id): void {
        $notifModel = new Notification();
        $notif = $notifModel->getById($id);

        if ($notif) {
            $notifModel->markAsRead($id);
            if (!empty($notif['link'])) {
                $this->redirect(base_url($notif['link']));
                return;
            }
        }

        $this->redirect(base_url('admin/notifications'));
    }
}
