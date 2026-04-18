<?php
class Teacher {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getTeachers() {
        $this->db->query('SELECT * FROM teachers ORDER BY name ASC');
        return $this->db->resultSet();
    }

    public function addTeacher($data) {
        $this->db->query('INSERT INTO teachers (name, phone, salary) VALUES (:name, :phone, :salary)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':salary', $data['salary']);

        if ($this->db->execute()) {
            $teacher_id = $this->db->lastInsertId();
            // Assign subjects
            foreach($data['subjects'] as $subject_id) {
                $this->db->query('INSERT INTO teacher_subjects (teacher_id, subject_id) VALUES (:teacher_id, :subject_id)');
                $this->db->bind(':teacher_id', $teacher_id);
                $this->db->bind(':subject_id', $subject_id);
                $this->db->execute();
            }
            return true;
        } else {
            return false;
        }
    }

    public function updateTeacher($data) {
        $this->db->query('UPDATE teachers SET name = :name, phone = :phone, salary = :salary WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':salary', $data['salary']);

        if ($this->db->execute()) {
            // Update subjects: Remove old, add new
            $this->db->query('DELETE FROM teacher_subjects WHERE teacher_id = :teacher_id');
            $this->db->bind(':teacher_id', $data['id']);
            $this->db->execute();

            foreach($data['subjects'] as $subject_id) {
                $this->db->query('INSERT INTO teacher_subjects (teacher_id, subject_id) VALUES (:teacher_id, :subject_id)');
                $this->db->bind(':teacher_id', $data['id']);
                $this->db->bind(':subject_id', $subject_id);
                $this->db->execute();
            }
            return true;
        } else {
            return false;
        }
    }

    public function deleteTeacher($id) {
        $this->db->query('DELETE FROM teachers WHERE id = :id');
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getTeacherById($id) {
        $this->db->query('SELECT * FROM teachers WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getTeacherSubjects($teacher_id) {
        $this->db->query('SELECT subject_id FROM teacher_subjects WHERE teacher_id = :teacher_id');
        $this->db->bind(':teacher_id', $teacher_id);
        return $this->db->resultSet();
    }
}
