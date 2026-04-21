<?php
class LandingpagesController extends Controller {
    private $landingModel;
    private $settingModel;

    public function __construct() {
        if (!isLoggedIn()) {
            $this->redirect('users/login');
        }
        $this->landingModel = $this->model('LandingPage');
        $this->settingModel = $this->model('Setting');
    }

    public function index() {
        $data = [
            'settings' => $this->settingModel->getAll(),
            'mentors' => $this->landingModel->getMentors(),
            'programs' => $this->landingModel->getPrograms(),
            'testimonials' => $this->landingModel->getTestimonials()
        ];
        $this->view('landing_pages/index', $data);
    }

    // --- General Settings Update ---
    public function update_settings() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            $data = [
                'hero_title' => trim($_POST['hero_title']),
                'hero_subtitle' => trim($_POST['hero_subtitle']),
                'landing_banner' => trim($_POST['landing_banner']),
                'about_title' => trim($_POST['about_title']),
                'about_description' => trim($_POST['about_description']),
                'principal_name' => trim($_POST['principal_name']),
                'principal_quote' => trim($_POST['principal_quote']),
                'principal_image' => trim($_POST['principal_image'])
            ];

            if ($this->settingModel->updateSettings($data)) {
                log_action('UPDATE_LANDING_SETTINGS', 'Updated landing page general content');
                flash('landing_message', 'General settings updated successfully');
            } else {
                flash('landing_message', 'Something went wrong', 'bg-red-500 text-white');
            }
            $this->redirect('landingpages');
        }
    }

    // --- Mentors CRUD ---
    public function mentor_add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'name' => trim($_POST['name']),
                'role' => trim($_POST['role']),
                'credentials' => trim($_POST['credentials']),
                'image' => trim($_POST['image']),
                'social_fb' => trim($_POST['social_fb']),
                'social_wa' => trim($_POST['social_wa']),
                'sort_order' => (int)$_POST['sort_order']
            ];

            if ($this->landingModel->addMentor($data)) {
                flash('landing_message', 'Mentor added successfully');
            } else {
                flash('landing_message', 'Failed to add mentor', 'bg-red-500 text-white');
            }
            $this->redirect('landingpages?tab=mentors');
        }
    }

    public function mentor_update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'role' => trim($_POST['role']),
                'credentials' => trim($_POST['credentials']),
                'image' => trim($_POST['image']),
                'social_fb' => trim($_POST['social_fb']),
                'social_wa' => trim($_POST['social_wa']),
                'sort_order' => (int)$_POST['sort_order']
            ];

            if ($this->landingModel->updateMentor($data)) {
                flash('landing_message', 'Mentor updated successfully');
            } else {
                flash('landing_message', 'Failed to update mentor', 'bg-red-500 text-white');
            }
            $this->redirect('landingpages?tab=mentors');
        }
    }

    public function mentor_delete($id) {
        if ($this->landingModel->deleteMentor($id)) {
            flash('landing_message', 'Mentor removed');
        }
        $this->redirect('landingpages?tab=mentors');
    }

    // --- Programs CRUD ---
    public function program_add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'features' => trim($_POST['features']),
                'image' => trim($_POST['image']),
                'is_trending' => isset($_POST['is_trending']) ? 1 : 0,
                'sort_order' => (int)$_POST['sort_order']
            ];

            if ($this->landingModel->addProgram($data)) {
                flash('landing_message', 'Program added successfully');
            }
            $this->redirect('landingpages?tab=programs');
        }
    }

    public function program_delete($id) {
        if ($this->landingModel->deleteProgram($id)) {
            flash('landing_message', 'Program removed');
        }
        $this->redirect('landingpages?tab=programs');
    }

    // --- Testimonials CRUD ---
    public function testimonial_add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'name' => trim($_POST['name']),
                'credentials' => trim($_POST['credentials']),
                'content' => trim($_POST['content']),
                'image' => trim($_POST['image'])
            ];

            if ($this->landingModel->addTestimonial($data)) {
                flash('landing_message', 'Testimonial added');
            }
            $this->redirect('landingpages?tab=testimonials');
        }
    }

    public function testimonial_delete($id) {
        if ($this->landingModel->deleteTestimonial($id)) {
            flash('landing_message', 'Testimonial removed');
        }
        $this->redirect('landingpages?tab=testimonials');
    }
}
