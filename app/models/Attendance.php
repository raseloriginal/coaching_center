<?php
class Attendance {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function markAttendance($student_id, $batch_id, $status = 'present') {
        $date = date('Y-m-d');
        $time = date('H:i:s');

        // Check if already marked for today
        $this->db->query('SELECT * FROM attendance WHERE student_id = :student_id AND batch_id = :batch_id AND date = :date');
        $this->db->bind(':student_id', $student_id);
        $this->db->bind(':batch_id', $batch_id);
        $this->db->bind(':date', $date);
        
        if ($this->db->single()) {
            return 'exists';
        }

        $this->db->query('INSERT INTO attendance (student_id, batch_id, date, time, status) VALUES (:student_id, :batch_id, :date, :time, :status)');
        $this->db->bind(':student_id', $student_id);
        $this->db->bind(':batch_id', $batch_id);
        $this->db->bind(':date', $date);
        $this->db->bind(':time', $time);
        $this->db->bind(':status', $status);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getStudentBatch($student_id) {
        $this->db->query('SELECT batch_id FROM batch_students WHERE student_id = :student_id LIMIT 1');
        $this->db->bind(':student_id', $student_id);
        $row = $this->db->single();
        return $row ? $row->batch_id : false;
    }

    public function getTodayAttendanceLogs($limit = 10) {
        $date = date('Y-m-d');
        $this->db->query('SELECT a.*, s.name as student_name, s.roll_number, b.name as batch_name 
                          FROM attendance a 
                          JOIN students s ON a.student_id = s.id 
                          JOIN batches b ON a.batch_id = b.id 
                          WHERE a.date = :date 
                          ORDER BY a.time DESC 
                          LIMIT :limit');
        $this->db->bind(':date', $date);
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }

    public function getStudentAttendanceHistory($student_id, $limit = 30) {
        $this->db->query('SELECT a.*, b.name as batch_name 
                          FROM attendance a 
                          JOIN batches b ON a.batch_id = b.id 
                          WHERE a.student_id = :student_id 
                          ORDER BY a.date DESC, a.time DESC 
                          LIMIT :limit');
        $this->db->bind(':student_id', $student_id);
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }
}
