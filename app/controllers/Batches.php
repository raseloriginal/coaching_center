<?php
class BatchesController extends Controller {
    private $batchModel;
    private $studentModel;

    public function __construct() {
        if (!isLoggedIn()) {
            $this->redirect('users/login');
        }
        $this->batchModel = $this->model('Batch');
        $this->studentModel = $this->model('Student');
    }

    public function index() {
        $batches = $this->batchModel->getBatchesWithCount();
        $data = ['batches' => $batches];
        $this->view('batches/index', $data);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'name' => trim($_POST['name']),
                'start_time' => trim($_POST['start_time']),
                'end_time' => trim($_POST['end_time']),
                'name_err' => '', 'time_err' => ''
            ];

            if (empty($data['name'])) $data['name_err'] = 'Name is required';
            if (empty($data['start_time']) || empty($data['end_time'])) $data['time_err'] = 'Times are required';

            if (empty($data['name_err']) && empty($data['time_err'])) {
                if ($this->batchModel->addBatch($data)) {
                    log_action('ADD_BATCH', "Created new batch: {$data['name']}");
                    flash('batch_message', 'Batch created successfully');
                    $this->redirect('batches');
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('batches/add', $data);
            }
        } else {
            $data = ['name' => '', 'start_time' => '', 'end_time' => '', 'name_err' => '', 'time_err' => ''];
            $this->view('batches/add', $data);
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'start_time' => trim($_POST['start_time']),
                'end_time' => trim($_POST['end_time']),
                'status' => $_POST['status'],
                'name_err' => '', 'time_err' => ''
            ];

            if ($this->batchModel->updateBatch($data)) {
                log_action('UPDATE_BATCH', "Updated batch: {$data['name']} (ID: {$id})");
                flash('batch_message', 'Batch updated');
                $this->redirect('batches');
            } else {
                die('Something went wrong');
            }
        } else {
            $batch = $this->batchModel->getBatchById($id);
            $data = [
                'id' => $id,
                'name' => $batch->name,
                'start_time' => $batch->start_time,
                'end_time' => $batch->end_time,
                'status' => $batch->status,
                'name_err' => '', 'time_err' => ''
            ];
            $this->view('batches/edit', $data);
        }
    }

    public function assign($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $student_ids = $_POST['students'] ?? [];
            if ($this->batchModel->assignStudents($id, $student_ids)) {
                log_action('ASSIGN_STUDENTS', "Assigned " . count($student_ids) . " students to batch ID: {$id}");
                flash('batch_message', 'Students assigned to batch');
                $this->redirect('batches');
            }
        } else {
            $batch = $this->batchModel->getBatchById($id);
            // Only students not in any OTHER batch + already in this batch
            $students = $this->batchModel->getAssignableStudents($id);
            // IDs already assigned to this batch (for pre-checking checkboxes)
            $assignedIds = $this->batchModel->getAssignedStudentIds($id);

            $data = [
                'batch'       => $batch,
                'students'    => $students,
                'assignedIds' => $assignedIds
            ];
            $this->view('batches/assign', $data);
        }
    }

    // View students in a batch and allow removing them
    public function view_batch($id) {
        $batch = $this->batchModel->getBatchById($id);
        $students = $this->batchModel->getBatchStudents($id);
        $data = [
            'batch'    => $batch,
            'students' => $students
        ];
        $this->view('batches/view', $data);
    }

    // Remove a single student from a batch (AJAX or POST)
    public function remove_student($batch_id, $student_id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->batchModel->removeStudentFromBatch($batch_id, $student_id);
            log_action('REMOVE_STUDENT_BATCH', "Removed student ID: {$student_id} from batch ID: {$batch_id}");
            flash('batch_message', 'Student removed from batch');
        }
        $this->redirect('batches/view_batch/' . $batch_id);
    }

    public function bulk_action() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ids = $_POST['batch_ids'] ?? [];
            $action = $_POST['action'] ?? '';
            
            if ($action == 'finish' && !empty($ids)) {
                $this->batchModel->bulkFinish($ids);
                log_action('BULK_FINISH_BATCH', "Marked batches as finished: " . implode(', ', $ids));
                flash('batch_message', 'Selected batches marked as finished. Students updated.');
            }
            $this->redirect('batches');
        }
    }
}
