<?php
class Subject {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getSubjects() {
        $this->db->query('SELECT * FROM subjects ORDER BY name ASC');
        return $this->db->resultSet();
    }

    public function addSubject($data) {
        $this->db->query('INSERT INTO subjects (name) VALUES (:name)');
        $this->db->bind(':name', $data['name']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateSubject($data) {
        $this->db->query('UPDATE subjects SET name = :name WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteSubject($id) {
        $this->db->query('DELETE FROM subjects WHERE id = :id');
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getSubjectById($id) {
        $this->db->query('SELECT * FROM subjects WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
}
