<?php
class NoticesController extends Controller {
    private $noticeModel;
    private $auditModel;

    public function __construct() {
        if (!isLoggedIn()) {
            $this->redirect('users/login');
        }
        $this->noticeModel = $this->model('Notice');
        $this->auditModel = $this->model('AuditLog');
    }

    public function index() {
        $notices = $this->noticeModel->getAll();
        $data = [
            'notices' => $notices
        ];
        $this->view('notices/index', $data);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'content' => trim($_POST['content']),
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'content_err' => ''
            ];

            if (empty($data['content'])) {
                $data['content_err'] = 'Please enter notice content';
            }

            if (empty($data['content_err'])) {
                if ($this->noticeModel->add($data)) {
                    $this->auditModel->log($_SESSION['user_id'], 'Notice Created', 'Added notice: ' . substr($data['content'], 0, 50));
                    flash('notice_message', 'Notice Added');
                    $this->redirect('notices');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('notices/add', $data);
            }
        } else {
            $data = [
                'content' => '',
                'is_active' => 1,
                'content_err' => ''
            ];
            $this->view('notices/add', $data);
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'id' => $id,
                'content' => trim($_POST['content']),
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'content_err' => ''
            ];

            if (empty($data['content'])) {
                $data['content_err'] = 'Please enter notice content';
            }

            if (empty($data['content_err'])) {
                if ($this->noticeModel->update($data)) {
                    $this->auditModel->log($_SESSION['user_id'], 'Notice Updated', 'Updated notice ID: ' . $id);
                    flash('notice_message', 'Notice Updated');
                    $this->redirect('notices');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('notices/edit', $data);
            }
        } else {
            $notice = $this->noticeModel->getById($id);
            if (!$notice) {
                $this->redirect('notices');
            }
            $data = [
                'id' => $id,
                'content' => $notice->content,
                'is_active' => $notice->is_active,
                'content_err' => ''
            ];
            $this->view('notices/edit', $data);
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->noticeModel->delete($id)) {
                $this->auditModel->log($_SESSION['user_id'], 'Notice Deleted', 'Deleted notice ID: ' . $id);
                flash('notice_message', 'Notice Removed');
                $this->redirect('notices');
            } else {
                die('Something went wrong');
            }
        } else {
            $this->redirect('notices');
        }
    }
}
