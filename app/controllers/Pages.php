<?php
class PagesController extends Controller {
    private $financeModel;
    private $studentModel;
    private $batchModel;
    private $teacherModel;
    private $auditModel;
    private $settingModel;
    private $noticeModel;
    private $landingModel;

    public function __construct() {
        $this->financeModel = $this->model('Finance');
        $this->studentModel = $this->model('Student');
        $this->batchModel = $this->model('Batch');
        $this->teacherModel = $this->model('Teacher');
        $this->auditModel = $this->model('AuditLog');
        $this->settingModel = $this->model('Setting');
        $this->noticeModel = $this->model('Notice');
        $this->landingModel = $this->model('LandingPage');
    }

    // Public Landing Page
    public function index() {
        $settings = $this->settingModel->getAll();
        $notices = $this->noticeModel->getActiveNotices();
        
        // Fetch some stats for the landing page
        $students = $this->studentModel->getStudents();
        $active_students_count = count(array_filter($students, function($s) { return $s->status == 'active'; }));
        $teachers_count = count($this->teacherModel->getTeachers());

        $data = [
            'settings' => $settings,
            'notices' => $notices,
            'mentors' => $this->landingModel->getMentors(),
            'programs' => $this->landingModel->getPrograms(),
            'testimonials' => $this->landingModel->getTestimonials(),
            'stats' => [
                'active_students' => $active_students_count,
                'total_teachers' => $teachers_count,
                'total_courses' => count($this->landingModel->getPrograms())
            ]
        ];

        $this->view('pages/landing', $data);
    }

    // Admin Dashboard (Requires Login)
    public function dashboard() {
        if (!isLoggedIn()) {
            $this->redirect('users/login');
        }

        // Trigger monthly automation on every dashboard load - Removed as per user request
        // $this->financeModel->runMonthlyAutomation();

        // Gather stats
        $students = $this->studentModel->getStudents();
        $batches = $this->batchModel->getBatches();
        $teachers = $this->teacherModel->getTeachers();
        
        // Count active
        $active_students = array_filter($students, function($s) { return $s->status == 'active'; });
        $active_batches = array_filter($batches, function($b) { return $b->status == 'active'; });
        
        // Get advanced monthly financial stats
        $financial_stats = $this->financeModel->getMonthlyFinancialStats();
        $all_time = $this->financeModel->getAllTimeStats();
        
        $data = [
            'total_students' => count($students),
            'active_students' => count($active_students),
            'active_batches' => count($active_batches),
            'total_teachers' => count($teachers),
            'financial_stats' => $financial_stats,
            'all_time' => $all_time
        ];

        $this->view('pages/index', $data);
    }

    public function about() {
        $data = [
            'title' => 'About Us',
            'description' => 'We are dedicated to providing the best education management tools.'
        ];
        $this->view('pages/about', $data);
    }

    public function audit_logs() {
        if (!isLoggedIn()) {
            $this->redirect('users/login');
        }
        
        $logs = $this->auditModel->getLogs(100);
        $data = [
            'logs' => $logs
        ];
        $this->view('pages/audit_logs', $data);
    }
}
