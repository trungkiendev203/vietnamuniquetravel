<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Csrf;
use App\Core\Cache;
use App\Models\Setting;

class SettingAdminController extends Controller {
    public function __construct() {
        parent::__construct();
        if (!Session::has('admin_id')) {
            $this->redirect(base_url('admin/login'));
            exit;
        }
    }

    public function index(): void {
        $settingModel = new Setting();
        $settings = $settingModel->getAllSettings();

        $seo = ['title' => 'System Settings - Admin'];
        $this->render('admin/settings/index', compact('settings', 'seo'), 'layouts/admin');
    }

    public function save(): void {
        if (!Csrf::verify($this->request->post('_csrf'))) {
            Session::flash('error', 'Security token invalid.');
            $this->redirect(base_url('admin/settings'));
            return;
        }

        $settingModel = new Setting();
        $fields = ['site_name', 'company_name', 'tax_code', 'hotline', 'office_phone', 'sales_phone', 'email', 'address', 'whatsapp_number', 'seo_default_title', 'seo_default_description'];

        foreach ($fields as $field) {
            $val = $this->request->post($field);
            if ($val !== null) {
                $settingModel->updateSetting($field, trim($val));
            }
        }

        Cache::flush();
        Session::flash('success', 'Settings updated successfully.');
        $this->redirect(base_url('admin/settings'));
    }
}
