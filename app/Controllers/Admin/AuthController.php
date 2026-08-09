<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Csrf;
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
            Session::set('admin_id', $user['id']);
            Session::set('admin_username', $user['username']);
            Session::set('admin_name', $user['name']);
            Session::set('admin_role', $user['role']);

            $this->redirect(base_url('admin/dashboard'));
            return;
        }

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
