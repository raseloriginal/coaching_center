<?php
class SettingsController extends Controller {
    private $settingModel;

    public function __construct() {
        // Only admins can access settings
        if (!isLoggedIn()) {
            $this->redirect('users/login');
        }
        
        $this->settingModel = $this->model('Setting');
    }

    public function index() {
        $settings = $this->settingModel->getAll();

        $data = [
            'settings' => $settings,
            'title' => 'System Settings'
        ];

        $this->view('settings/index', $data);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'site_title' => trim($_POST['site_title']),
                'site_email' => trim($_POST['site_email']),
                'site_phone' => trim($_POST['site_phone']),
                'site_address' => trim($_POST['site_address']),
                'smtp_host' => trim($_POST['smtp_host']),
                'smtp_user' => trim($_POST['smtp_user']),
                'smtp_pass' => $_POST['smtp_pass'], // Don't trim password
                'smtp_port' => trim($_POST['smtp_port']),
                'smtp_encryption' => trim($_POST['smtp_encryption']),
                'portal_enabled' => $_POST['portal_enabled'] ?? '0',
                'invoice_footer' => trim($_POST['invoice_footer'])
            ];

            if ($this->settingModel->updateSettings($data)) {
                log_action('UPDATE_SETTINGS', 'Updated system configurations');
                flash('settings_message', 'Settings updated successfully');
                $this->redirect('settings');
            } else {
                flash('settings_message', 'Something went wrong while updating settings', 'bg-red-500');
                $this->redirect('settings');
            }
        } else {
            $this->redirect('settings');
        }
    }
}
