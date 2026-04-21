<?php
class StudentsController extends Controller {
    private $studentModel;
    private $batchModel;

    public function __construct() {
        $this->middleware('AuthMiddleware');
        $this->studentModel = $this->model('Student');
        $this->batchModel = $this->model('Batch');
    }

    public function index() {
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $recordsPerPage = 10;
        $totalRecords = $this->studentModel->getTotalStudentsCount();
        
        $pagination = new Pagination($page, $recordsPerPage, $totalRecords);
        $students = $this->studentModel->getStudents($pagination->getLimit(), $pagination->getOffset());
        
        $data = [
            'students' => $students,
            'pagination' => $pagination->generateHtml(URLROOT . '/students')
        ];
        $this->view('students/index', $data);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'name' => trim($_POST['name']),
                'phone' => trim($_POST['phone']),
                'fees_amount' => trim($_POST['fees_amount'] ?? ''),
                'father_name' => trim($_POST['father_name'] ?? ''),
                'joining_date' => trim($_POST['joining_date'] ?? ''),
                'roll_number' => trim($_POST['roll_number'] ?? ''),
                'qr_code' => 'ST-' . strtoupper(uniqid()),
                'name_err' => '',
                'phone_err' => ''
            ];

            if (empty($data['name'])) $data['name_err'] = 'Name is required';
            if (empty($data['phone'])) $data['phone_err'] = 'Phone is required';

            if (empty($data['name_err']) && empty($data['phone_err'])) {
                if ($this->studentModel->addStudent($data)) {
                    log_action('ADD_STUDENT', "Added student: {$data['name']} (Roll: {$data['roll_number']})");
                    flash('student_message', 'Student registered successfully');
                    $this->redirect('students');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('students/add', $data);
            }
        } else {
            $data = [
                'name' => '', 'phone' => '', 
                'fees_amount' => '', 'father_name' => '', 'joining_date' => '', 'roll_number' => '',
                'name_err' => '', 'phone_err' => ''
            ];
            $this->view('students/add', $data);
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'phone' => trim($_POST['phone']),
                'fees_amount' => trim($_POST['fees_amount'] ?? ''),
                'father_name' => trim($_POST['father_name'] ?? ''),
                'joining_date' => trim($_POST['joining_date'] ?? ''),
                'roll_number' => trim($_POST['roll_number'] ?? ''),
                'status' => $_POST['status'],
                'name_err' => '', 'phone_err' => ''
            ];

            if (empty($data['name'])) $data['name_err'] = 'Name is required';
            if (empty($data['phone'])) $data['phone_err'] = 'Phone is required';

            if (empty($data['name_err']) && empty($data['phone_err'])) {
                if ($this->studentModel->updateStudent($data)) {
                    log_action('UPDATE_STUDENT', "Updated student: {$data['name']} (ID: {$data['id']})");
                    flash('student_message', 'Student info updated');
                    $this->redirect('students');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('students/edit', $data);
            }
        } else {
            $student = $this->studentModel->getStudentById($id);
            $data = [
                'id' => $id,
                'name' => $student->name,
                'phone' => $student->phone,
                'fees_amount' => $student->fees_amount,
                'father_name' => $student->father_name,
                'joining_date' => $student->joining_date,
                'roll_number' => $student->roll_number,
                'status' => $student->status,
                'name_err' => '', 'phone_err' => ''
            ];
            $this->view('students/edit', $data);
        }
    }

    public function view_qr($id) {
        $student = $this->studentModel->getStudentById($id);
        $data = ['student' => $student];
        $this->view('students/view_qr', $data);
    }

    public function id_card($id) {
        $student = $this->studentModel->getStudentById($id);
        if (!$student) {
            $this->redirect('students');
        }

        $data = [
            'students' => [$student]
        ];

        $this->view('students/id_card', $data);
    }

    public function bulk_id_cards($batch_id = null) {
        if ($batch_id) {
            $students = $this->batchModel->getBatchStudents($batch_id);
        } else {
            $students = $this->studentModel->getStudents();
        }

        $data = [
            'students' => $students
        ];

        $this->view('students/id_card', $data);
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->studentModel->deleteStudent($id)) {
                log_action('DELETE_STUDENT', "Deleted student with ID: {$id}");
                flash('student_message', 'Student removed');
                $this->redirect('students');
            } else {
                die('Something went wrong');
            }
        } else {
            $this->redirect('students');
        }
    }

    public function discount($id) {
        $student = $this->studentModel->getStudentById($id);
        if (!$student) {
            $this->redirect('students');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'student_id' => $id,
                'discount_type' => $_POST['discount_type'],
                'amount' => trim($_POST['amount']),
                'reason' => trim($_POST['reason']),
                'expires_at' => !empty($_POST['expires_at']) ? $_POST['expires_at'] : null
            ];

            if ($this->studentModel->saveDiscount($data)) {
                log_action('APPLY_DISCOUNT', "Applied {$data['discount_type']} discount of {$data['amount']} to student: {$student->name}");
                flash('student_message', 'Discount applied successfully');
                $this->redirect('students');
            } else {
                die('Something went wrong');
            }
        } else {
            $discounts = $this->studentModel->getDiscounts($id);
            $data = [
                'student' => $student,
                'discounts' => $discounts
            ];
            $this->view('students/discount', $data);
        }
    }
}
