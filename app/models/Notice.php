<?php
class Notice {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    /**
     * Get all active notices
     */
    public function getActiveNotices() {
        $this->db->query('SELECT * FROM notices WHERE is_active = 1 ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    /**
     * Get all notices (for admin)
     */
    public function getAll() {
        $this->db->query('SELECT * FROM notices ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    /**
     * Get notice by ID
     */
    public function getById($id) {
        $this->db->query('SELECT * FROM notices WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Add a new notice
     */
    public function add($data) {
        $this->db->query('INSERT INTO notices (content, is_active) VALUES (:content, :is_active)');
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':is_active', $data['is_active']);
        
        return $this->db->execute();
    }

    /**
     * Update a notice
     */
    public function update($data) {
        $this->db->query('UPDATE notices SET content = :content, is_active = :is_active WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':is_active', $data['is_active']);
        
        return $this->db->execute();
    }

    /**
     * Delete a notice
     */
    public function delete($id) {
        $this->db->query('DELETE FROM notices WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
