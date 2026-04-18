<?php
class Exam {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getExams() {
        $this->db->query('SELECT e.*, b.name as batch_name,
                          (SELECT COUNT(*) FROM exam_subjects WHERE exam_id = e.id) as subject_count
                          FROM exams e 
                          LEFT JOIN batches b ON e.batch_id = b.id 
                          ORDER BY e.exam_date DESC');
        return $this->db->resultSet();
    }

    public function addExam($data) {
        $this->db->query('INSERT INTO exams (title, exam_date, batch_id) VALUES (:title, :exam_date, :batch_id)');
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':exam_date', $data['exam_date']);
        $this->db->bind(':batch_id', $data['batch_id']);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function addExamSubjects($exam_id, $subjects, $marks) {
        foreach ($subjects as $index => $subject_id) {
            $total_marks = $marks[$index] ?? 100;
            $this->db->query('INSERT INTO exam_subjects (exam_id, subject_id, total_marks) VALUES (:exam_id, :subject_id, :total_marks)');
            $this->db->bind(':exam_id', $exam_id);
            $this->db->bind(':subject_id', $subject_id);
            $this->db->bind(':total_marks', $total_marks);
            $this->db->execute();
        }
    }

    public function getExamById($id) {
        $this->db->query('SELECT e.*, b.name as batch_name 
                          FROM exams e 
                          LEFT JOIN batches b ON e.batch_id = b.id 
                          WHERE e.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getExamSubjects($exam_id) {
        $this->db->query('SELECT es.*, s.name as subject_name 
                          FROM exam_subjects es 
                          JOIN subjects s ON es.subject_id = s.id 
                          WHERE es.exam_id = :exam_id');
        $this->db->bind(':exam_id', $exam_id);
        return $this->db->resultSet();
    }

    public function getExamSubjectById($id) {
        $this->db->query('SELECT es.*, s.name as subject_name, e.title as exam_title, e.batch_id
                          FROM exam_subjects es 
                          JOIN subjects s ON es.subject_id = s.id 
                          JOIN exams e ON es.exam_id = e.id
                          WHERE es.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getExamMarks($exam_subject_id) {
        $this->db->query('SELECT m.*, s.name as student_name, s.phone 
                          FROM exam_marks m 
                          JOIN students s ON m.student_id = s.id 
                          WHERE m.exam_subject_id = :exam_subject_id');
        $this->db->bind(':exam_subject_id', $exam_subject_id);
        return $this->db->resultSet();
    }

    public function saveMark($data) {
        $this->db->query('INSERT INTO exam_marks (exam_subject_id, student_id, marks_obtained, remarks) 
                          VALUES (:exam_subject_id, :student_id, :marks_obtained, :remarks)
                          ON DUPLICATE KEY UPDATE marks_obtained = :marks_obtained, remarks = :remarks');
        $this->db->bind(':exam_subject_id', $data['exam_subject_id']);
        $this->db->bind(':student_id', $data['student_id']);
        $this->db->bind(':marks_obtained', $data['marks_obtained']);
        $this->db->bind(':remarks', $data['remarks']);
        return $this->db->execute();
    }

    public function deleteExam($id) {
        $this->db->query('DELETE FROM exams WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // =====================
    // ANALYTICS
    // =====================

    /**
     * Get all exams for a batch with overall average per exam
     */
    public function getBatchExamTrend($batch_id) {
        $this->db->query('SELECT e.id, e.title, e.exam_date,
            ROUND(AVG(m.marks_obtained / es.total_marks * 100), 2) as avg_percent
            FROM exams e
            JOIN exam_subjects es ON es.exam_id = e.id
            JOIN exam_marks m ON m.exam_subject_id = es.id
            WHERE e.batch_id = :batch_id
            GROUP BY e.id, e.title, e.exam_date
            ORDER BY e.exam_date ASC');
        $this->db->bind(':batch_id', $batch_id);
        return $this->db->resultSet();
    }

    /**
     * Get a leaderboard for all students in a specific exam
     */
    public function getExamLeaderboard($exam_id) {
        $this->db->query('SELECT s.id, s.name, s.roll_number,
            ROUND(SUM(m.marks_obtained), 2) as total_marks,
            ROUND(SUM(es.total_marks), 2) as max_marks,
            ROUND(SUM(m.marks_obtained) / SUM(es.total_marks) * 100, 2) as percentage
            FROM exam_marks m
            JOIN exam_subjects es ON m.exam_subject_id = es.id
            JOIN students s ON m.student_id = s.id
            WHERE es.exam_id = :exam_id
            GROUP BY s.id, s.name, s.roll_number
            ORDER BY percentage DESC');
        $this->db->bind(':exam_id', $exam_id);
        return $this->db->resultSet();
    }

    /**
     * Get all exam results for a single student (for student portal)
     */
    public function getStudentResults($student_id) {
        $this->db->query('SELECT e.title as exam_title, e.exam_date, s.name as subject_name,
            es.total_marks,
            m.marks_obtained,
            m.remarks,
            ROUND(m.marks_obtained / es.total_marks * 100, 2) as percentage
            FROM exam_marks m
            JOIN exam_subjects es ON m.exam_subject_id = es.id
            JOIN exams e ON es.exam_id = e.id
            JOIN subjects s ON es.subject_id = s.id
            WHERE m.student_id = :student_id
            ORDER BY e.exam_date DESC');
        $this->db->bind(':student_id', $student_id);
        return $this->db->resultSet();
    }

    /**
     * Get all exams with their batch for a batch list
     */
    public function getExamsByBatch($batch_id) {
        $this->db->query('SELECT e.*, b.name as batch_name,
            (SELECT COUNT(*) FROM exam_subjects WHERE exam_id = e.id) as subject_count
            FROM exams e
            LEFT JOIN batches b ON e.batch_id = b.id
            WHERE e.batch_id = :batch_id
            ORDER BY e.exam_date DESC');
        $this->db->bind(':batch_id', $batch_id);
        return $this->db->resultSet();
    }
}
