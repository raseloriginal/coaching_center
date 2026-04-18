<?php
/**
 * Student & Parent Portal Controller
 */
class PortalsController extends Controller {
    private $studentModel;
    private $financeModel;
    private $examModel;
    private $attendanceModel;

    public function __construct() {
        $this->studentModel = $this->model('Student');
        $this->financeModel = $this->model('Finance');
        $this->examModel = $this->model('Exam');
        $this->attendanceModel = $this->model('Attendance');
    }

    // ... (login, logout, dashboard, results methods ...)

    public function attendance() {
        $this->middleware('StudentAuthMiddleware');
        $attendance = $this->attendanceModel->getStudentAttendanceHistory($_SESSION['student_id']);
        $this->view('portals/attendance', ['attendance' => $attendance]);
    }
}
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $studentAccount = $this->studentModel->portalLogin($username, $password);

            if ($studentAccount) {
                $_SESSION['student_id'] = $studentAccount->student_id;
                $_SESSION['student_name'] = $studentAccount->name;
                $_SESSION['student_roll'] = $studentAccount->roll_number;
                $this->redirect('portals/dashboard');
            } else {
                $data = ['error' => 'Invalid username or password'];
                $this->view('portals/login', $data);
            }
        } else {
            if (isset($_SESSION['student_id'])) $this->redirect('portals/dashboard');
            $this->view('portals/login');
        }
    }

    public function dashboard() {
        $this->middleware('StudentAuthMiddleware');
        
        $student_id = $_SESSION['student_id'];
        $student = $this->studentModel->getStudentById($student_id);
        $fees = $this->financeModel->getStudentFees(['student_id' => $student_id]);
        $results = $this->examModel->getStudentResults($student_id);

        $data = [
            'student' => $student,
            'fees' => $fees,
            'results' => $results
        ];

        $this->view('portals/student_dashboard', $data);
    }

    public function results() {
        $this->middleware('StudentAuthMiddleware');
        $results = $this->examModel->getStudentResults($_SESSION['student_id']);
        $this->view('portals/results', ['results' => $results]);
    }

    public function logout() {
        unset($_SESSION['student_id']);
        unset($_SESSION['student_name']);
        unset($_SESSION['student_roll']);
        $this->redirect('portals/login');
    }
}
