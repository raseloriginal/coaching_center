<?php
class SubjectsController extends Controller {
    private $subjectModel;

    public function __construct() {
        if (!isLoggedIn()) {
            $this->redirect('users/login');
        }
        $this->subjectModel = $this->model('Subject');
    }

    public function index() {
        $subjects = $this->subjectModel->getSubjects();
        $data = [
            'subjects' => $subjects
        ];
        $this->view('subjects/index', $data);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'name' => trim($_POST['name']),
                'name_err' => ''
            ];

            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter subject name';
            }

            if (empty($data['name_err'])) {
                if ($this->subjectModel->addSubject($data)) {
                    flash('subject_message', 'Subject added successfully');
                    $this->redirect('subjects');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('subjects/add', $data);
            }
        } else {
            $data = [
                'name' => '',
                'name_err' => ''
            ];
            $this->view('subjects/add', $data);
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'name_err' => ''
            ];

            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter subject name';
            }

            if (empty($data['name_err'])) {
                if ($this->subjectModel->updateSubject($data)) {
                    flash('subject_message', 'Subject updated successfully');
                    $this->redirect('subjects');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('subjects/edit', $data);
            }
        } else {
            $subject = $this->subjectModel->getSubjectById($id);
            $data = [
                'id' => $id,
                'name' => $subject->name,
                'name_err' => ''
            ];
            $this->view('subjects/edit', $data);
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->subjectModel->deleteSubject($id)) {
                flash('subject_message', 'Subject removed');
                $this->redirect('subjects');
            } else {
                die('Something went wrong');
            }
        } else {
            $this->redirect('subjects');
        }
    }
}
