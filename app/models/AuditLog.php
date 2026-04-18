<?php
class AuditLog {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function log($user_id, $action, $details = '') {
        $this->db->query('INSERT INTO audit_logs (user_id, action, details, ip_address) VALUES (:user_id, :action, :details, :ip_address)');
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':action', $action);
        $this->db->bind(':details', $details);
        $this->db->bind(':ip_address', $_SERVER['REMOTE_ADDR']);
        return $this->db->execute();
    }

    public function getLogs($limit = 50) {
        $this->db->query('SELECT a.*, u.name as user_name FROM audit_logs a JOIN users u ON a.user_id = u.id ORDER BY created_at DESC LIMIT :limit');
        $this->db->bind(':limit', $limit, PDO::PARAM_INT);
        return $this->db->resultSet();
    }
}
