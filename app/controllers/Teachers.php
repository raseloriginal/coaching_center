<?php
class TeachersController extends Controller {
    private $teacherModel;
    private $subjectModel;

    public function __construct() {
        if (!isLoggedIn()) {
            $this->redirect('users/login');
        }
        $this->teacherModel = $this->model('Teacher');
        $this->subjectModel = $this->model('Subject');
    }

    public function index() {
        $teachers = $this->teacherModel->getTeachers();
        $data = [
            'teachers' => $teachers
        ];
        $this->view('teachers/index', $data);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'name' => trim($_POST['name']),
                'phone' => trim($_POST['phone']),
                'salary' => trim($_POST['salary']),
                'subjects' => $_POST['subjects'] ?? [],
                'name_err' => '',
                'phone_err' => '',
                'salary_err' => ''
            ];

            if (empty($data['name'])) $data['name_err'] = 'Name is required';
            if (empty($data['phone'])) $data['phone_err'] = 'Phone is required';
            if (empty($data['salary'])) $data['salary_err'] = 'Salary is required';

            if (empty($data['name_err']) && empty($data['phone_err']) && empty($data['salary_err'])) {
                if ($this->teacherModel->addTeacher($data)) {
                    flash('teacher_message', 'Teacher added successfully');
                    $this->redirect('teachers');
                } else {
                    die('Something went wrong');
                }
            } else {
                $data['all_subjects'] = $this->subjectModel->getSubjects();
                $this->view('teachers/add', $data);
            }
        } else {
            $data = [
                'name' => '', 'phone' => '', 'salary' => '', 'subjects' => [],
                'all_subjects' => $this->subjectModel->getSubjects(),
                'name_err' => '', 'phone_err' => '', 'salary_err' => ''
            ];
            $this->view('teachers/add', $data);
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'phone' => trim($_POST['phone']),
                'salary' => trim($_POST['salary']),
                'subjects' => $_POST['subjects'] ?? [],
                'name_err' => '', 'phone_err' => '', 'salary_err' => ''
            ];

            if (empty($data['name'])) $data['name_err'] = 'Name is required';
            if (empty($data['phone'])) $data['phone_err'] = 'Phone is required';
            if (empty($data['salary'])) $data['salary_err'] = 'Salary is required';

            if (empty($data['name_err']) && empty($data['phone_err']) && empty($data['salary_err'])) {
                if ($this->teacherModel->updateTeacher($data)) {
                    flash('teacher_message', 'Teacher updated');
                    $this->redirect('teachers');
                } else {
                    die('Something went wrong');
                }
            } else {
                $data['all_subjects'] = $this->subjectModel->getSubjects();
                $this->view('teachers/edit', $data);
            }
        } else {
            $teacher = $this->teacherModel->getTeacherById($id);
            $selected_subjects = $this->teacherModel->getTeacherSubjects($id);
            $subjects_ids = array_map(function($s) { return $s->subject_id; }, $selected_subjects);

            $data = [
                'id' => $id,
                'name' => $teacher->name,
                'phone' => $teacher->phone,
                'salary' => $teacher->salary,
                'subjects' => $subjects_ids,
                'all_subjects' => $this->subjectModel->getSubjects(),
                'name_err' => '', 'phone_err' => '', 'salary_err' => ''
            ];
            $this->view('teachers/edit', $data);
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->teacherModel->deleteTeacher($id)) {
                flash('teacher_message', 'Teacher removed');
                $this->redirect('teachers');
            } else {
                die('Something went wrong');
            }
        } else {
            $this->redirect('teachers');
        }
    }
}
