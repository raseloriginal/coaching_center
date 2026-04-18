<?php
class ExamsController extends Controller {
    private $examModel;
    private $batchModel;
    private $subjectModel;

    public function __construct() {
        $this->middleware('AuthMiddleware');
        $this->examModel = $this->model('Exam');
        $this->batchModel = $this->model('Batch');
        $this->subjectModel = $this->model('Subject');
    }

    public function index() {
        $exams = $this->examModel->getExams();
        $data = [
            'exams' => $exams
        ];
        $this->view('exams/index', $data);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            $data = [
                'title' => trim($_POST['title']),
                'exam_date' => trim($_POST['exam_date']),
                'batch_id' => !empty($_POST['batch_id']) ? $_POST['batch_id'] : null,
                'subjects' => $_POST['subject_ids'] ?? [],
                'total_marks' => $_POST['total_marks'] ?? [],
                'title_err' => '',
                'subject_err' => ''
            ];

            if (empty($data['title'])) $data['title_err'] = 'Please enter title';
            if (empty($data['subjects'])) $data['subject_err'] = 'Please select at least one subject';

            if (empty($data['title_err']) && empty($data['subject_err'])) {
                $exam_id = $this->examModel->addExam($data);
                if ($exam_id) {
                    $this->examModel->addExamSubjects($exam_id, $data['subjects'], $data['total_marks']);
                    log_action('CREATE_EXAM', "Created exam: {$data['title']} (Exam ID: {$exam_id})");
                    flash('exam_message', 'Exam created successfully with ' . count($data['subjects']) . ' subjects');
                    $this->redirect('exams');
                } else {
                    die('Something went wrong');
                }
            } else {
                $data['all_subjects'] = $this->subjectModel->getSubjects();
                $data['batches'] = $this->batchModel->getBatches();
                $this->view('exams/add', $data);
            }
        } else {
            $data = [
                'title' => '',
                'exam_date' => date('Y-m-d'),
                'batch_id' => '',
                'all_subjects' => $this->subjectModel->getSubjects(),
                'batches' => $this->batchModel->getBatches(),
                'title_err' => '',
                'subject_err' => ''
            ];
            $this->view('exams/add', $data);
        }
    }

    public function marks($id, $exam_subject_id = null) {
        $exam = $this->examModel->getExamById($id);
        if (!$exam) {
            $this->redirect('exams');
        }

        if ($exam_subject_id === null) {
            // Show subject selection for this exam
            $subjects = $this->examModel->getExamSubjects($id);
            $data = [
                'exam' => $exam,
                'subjects' => $subjects
            ];
            $this->view('exams/marks_subject_select', $data);
            return;
        }

        // Show marks entry for specific subject
        $examSubject = $this->examModel->getExamSubjectById($exam_subject_id);
        if (!$examSubject || $examSubject->exam_id != $id) {
            $this->redirect('exams/marks/' . $id);
        }

        // If batch is assigned, get students from batch. Otherwise, get all active students (generic exam)
        if ($exam->batch_id) {
            $students = $this->batchModel->getBatchStudents($exam->batch_id);
        } else {
            $studentModel = $this->model('Student');
            $students = $studentModel->getActiveStudents();
        }

        // Get existing marks if any
        $existingMarks = $this->examModel->getExamMarks($exam_subject_id);
        $marksMap = [];
        foreach($existingMarks as $m) {
            $marksMap[$m->student_id] = $m;
        }

        $data = [
            'exam' => $exam,
            'examSubject' => $examSubject,
            'students' => $students,
            'marks' => $marksMap
        ];

        $this->view('exams/marks', $data);
    }

    public function save_marks() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $exam_id = $_POST['exam_id'];
            $exam_subject_id = $_POST['exam_subject_id'];
            $marks = $_POST['marks']; // Array student_id => score
            $remarks = $_POST['remarks'] ?? []; // Array student_id => text

            foreach($marks as $student_id => $score) {
                if ($score !== '') {
                    $this->examModel->saveMark([
                        'exam_subject_id' => $exam_subject_id,
                        'student_id' => $student_id,
                        'marks_obtained' => $score,
                        'remarks' => $remarks[$student_id] ?? ''
                    ]);
                }
            }

            log_action('UPDATE_MARKS', "Updated marks for exam: {$exam_id}, Subject ID: {$exam_subject_id}");
            flash('exam_message', 'Marks updated successfully for ' . $_POST['subject_name']);
            $this->redirect('exams/marks/' . $exam_id . '/' . $exam_subject_id);
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->examModel->deleteExam($id)) {
                log_action('DELETE_EXAM', "Deleted exam with ID: {$id}");
                flash('exam_message', 'Exam removed');
                $this->redirect('exams');
            } else {
                die('Something went wrong');
            }
        } else {
            $this->redirect('exams');
        }
    }

    // =====================
    // ANALYTICS
    // =====================
    public function analytics($batch_id = null) {
        $batches = $this->batchModel->getBatches();
        $data = [
            'batches'           => $batches,
            'selected_batch_id' => $batch_id,
            'trend'             => [],
            'exams'             => [],
            'leaderboard'       => [],
            'selected_exam_id'  => $_GET['exam'] ?? null,
        ];

        if ($batch_id) {
            $data['trend'] = $this->examModel->getBatchExamTrend($batch_id);
            $data['exams'] = $this->examModel->getExamsByBatch($batch_id);

            if ($data['selected_exam_id']) {
                $data['leaderboard'] = $this->examModel->getExamLeaderboard($data['selected_exam_id']);
            } elseif (!empty($data['exams'])) {
                $data['selected_exam_id'] = $data['exams'][0]->id;
                $data['leaderboard'] = $this->examModel->getExamLeaderboard($data['exams'][0]->id);
            }
        }

        $this->view('exams/analytics', $data);
    }
}
