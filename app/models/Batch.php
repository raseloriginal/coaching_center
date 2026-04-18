<?php
class Batch {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getBatches() {
        $this->db->query('SELECT * FROM batches ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function addBatch($data) {
        $this->db->query('INSERT INTO batches (name, start_time, end_time, status) VALUES (:name, :start_time, :end_time, "active")');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':start_time', $data['start_time']);
        $this->db->bind(':end_time', $data['end_time']);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    public function updateBatch($data) {
        $this->db->query('UPDATE batches SET name = :name, start_time = :start_time, end_time = :end_time, status = :status WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':start_time', $data['start_time']);
        $this->db->bind(':end_time', $data['end_time']);
        $this->db->bind(':status', $data['status']);

        return $this->db->execute();
    }

    public function getBatchById($id) {
        $this->db->query('SELECT * FROM batches WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function assignStudents($batch_id, $student_ids) {
        // Clear existing
        $this->db->query('DELETE FROM batch_students WHERE batch_id = :batch_id');
        $this->db->bind(':batch_id', $batch_id);
        $this->db->execute();

        foreach($student_ids as $student_id) {
            $this->db->query('INSERT INTO batch_students (batch_id, student_id) VALUES (:batch_id, :student_id)');
            $this->db->bind(':batch_id', $batch_id);
            $this->db->bind(':student_id', $student_id);
            $this->db->execute();
        }
        return true;
    }

    public function bulkFinish($ids) {
        $id_list = implode(',', array_map('intval', $ids));
        
        // Update batches
        $this->db->query("UPDATE batches SET status = 'finished' WHERE id IN ($id_list)");
        $this->db->execute();

        // Update students in those batches to 'completed'
        $this->db->query("UPDATE students s 
                         JOIN batch_students bs ON s.id = bs.student_id 
                         SET s.status = 'completed' 
                         WHERE bs.batch_id IN ($id_list)");
        return $this->db->execute();
    }
    public function getBatchStudents($batch_id) {
        $this->db->query('SELECT s.* FROM students s 
                          JOIN batch_students bs ON s.id = bs.student_id 
                          WHERE bs.batch_id = :batch_id
                          ORDER BY s.name ASC');
        $this->db->bind(':batch_id', $batch_id);
        return $this->db->resultSet();
    }

    // Students NOT assigned to any batch + students already in THIS batch
    public function getAssignableStudents($batch_id) {
        $this->db->query(
            'SELECT s.*, 
                    (SELECT bs2.batch_id FROM batch_students bs2 WHERE bs2.student_id = s.id LIMIT 1) as assigned_batch_id
             FROM students s
             WHERE s.id NOT IN (
                 SELECT student_id FROM batch_students WHERE batch_id != :batch_id
             )
             ORDER BY s.name ASC'
        );
        $this->db->bind(':batch_id', $batch_id);
        return $this->db->resultSet();
    }

    public function getAssignedStudentIds($batch_id) {
        $this->db->query('SELECT student_id FROM batch_students WHERE batch_id = :batch_id');
        $this->db->bind(':batch_id', $batch_id);
        $rows = $this->db->resultSet();
        return array_map(fn($r) => $r->student_id, $rows);
    }

    public function getBatchStudentCount($batch_id) {
        $this->db->query('SELECT COUNT(*) as cnt FROM batch_students WHERE batch_id = :batch_id');
        $this->db->bind(':batch_id', $batch_id);
        $row = $this->db->single();
        return $row ? $row->cnt : 0;
    }

    public function removeStudentFromBatch($batch_id, $student_id) {
        $this->db->query('DELETE FROM batch_students WHERE batch_id = :batch_id AND student_id = :student_id');
        $this->db->bind(':batch_id', $batch_id);
        $this->db->bind(':student_id', $student_id);
        return $this->db->execute();
    }

    public function getBatchesWithCount() {
        $this->db->query(
            'SELECT b.*, COUNT(bs.student_id) as student_count
             FROM batches b
             LEFT JOIN batch_students bs ON b.id = bs.batch_id
             GROUP BY b.id
             ORDER BY b.created_at DESC'
        );
        return $this->db->resultSet();
    }
}
