<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Csrf;
use App\Core\RateLimiter;
use App\Models\Admin;

class AuthController extends Controller {
    public function loginForm(): void {
        if (Session::has('admin_id')) {
            $this->redirect(base_url('admin/dashboard'));
            return;
        }

        $seo = ['title' => 'Admin Login - Vietnam Unique Travel'];
        $this->render('admin/login', compact('seo'), 'layouts/admin_auth');
    }

    public function loginSubmit(): void {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        if (RateLimiter::tooManyAttempts("admin_login_{$ip}", 5, 900)) {
            $waitMinutes = ceil(RateLimiter::availableIn("admin_login_{$ip}") / 60);
            Session::flash('error', "Too many failed login attempts. Please wait {$waitMinutes} minutes.");
            $this->redirect(base_url('admin/login'));
            return;
        }

        if (!Csrf::verify($this->request->post('_csrf'))) {
            Session::flash('error', 'Security token invalid.');
            $this->redirect(base_url('admin/login'));
            return;
        }

        $username = trim($this->request->post('username', ''));
        $password = trim($this->request->post('password', ''));

        $adminModel = new Admin();
        $user = $adminModel->verifyCredentials($username, $password);

        if ($user) {
            RateLimiter::clear("admin_login_{$ip}");
            Session::set('admin_id', $user['id']);
            Session::set('admin_username', $user['username']);
            Session::set('admin_name', $user['name']);
            Session::set('admin_role', $user['role']);

            $this->redirect(base_url('admin/dashboard'));
            return;
        }

        RateLimiter::hit("admin_login_{$ip}", 900);
        Session::flash('error', 'Invalid username or password.');
        $this->redirect(base_url('admin/login'));
    }

    public function logout(): void {
        Session::remove('admin_id');
        Session::remove('admin_username');
        Session::remove('admin_name');
        Session::remove('admin_role');
        $this->redirect(base_url('admin/login'));
    }
}
