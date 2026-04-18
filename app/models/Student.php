<?php
class Student {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getTotalStudentsCount() {
        $this->db->query('SELECT COUNT(*) as count FROM students');
        $row = $this->db->single();
        return $row->count;
    }

    public function getStudents($limit = null, $offset = null) {
        $sql = 'SELECT * FROM students ORDER BY created_at DESC';
        if ($limit !== null && $offset !== null) {
            $sql .= ' LIMIT :limit OFFSET :offset';
            $this->db->query($sql);
            $this->db->bind(':limit', (int)$limit, PDO::PARAM_INT);
            $this->db->bind(':offset', (int)$offset, PDO::PARAM_INT);
        } else {
            $this->db->query($sql);
        }
        return $this->db->resultSet();
    }

    public function addStudent($data) {
        $this->db->query('INSERT INTO students (name, phone, qr_code, status, fees_amount, father_name, joining_date, date_to_pay, roll_number) VALUES (:name, :phone, :qr_code, "active", :fees_amount, :father_name, :joining_date, :date_to_pay, :roll_number)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':qr_code', $data['qr_code']);
        $this->db->bind(':fees_amount', $data['fees_amount'] ?: 0);
        $this->db->bind(':father_name', $data['father_name']);
        $this->db->bind(':joining_date', $data['joining_date']);
        $this->db->bind(':date_to_pay', $data['date_to_pay']);
        $this->db->bind(':roll_number', $data['roll_number']);

        return $this->db->execute();
    }

    public function updateStudent($data) {
        $this->db->query('UPDATE students SET name = :name, phone = :phone, status = :status, fees_amount = :fees_amount, father_name = :father_name, joining_date = :joining_date, date_to_pay = :date_to_pay, roll_number = :roll_number WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':fees_amount', $data['fees_amount'] ?: 0);
        $this->db->bind(':father_name', $data['father_name']);
        $this->db->bind(':joining_date', $data['joining_date']);
        $this->db->bind(':date_to_pay', $data['date_to_pay']);
        $this->db->bind(':roll_number', $data['roll_number']);

        return $this->db->execute();
    }

    public function getStudentById($id) {
        $this->db->query('SELECT * FROM students WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getStudentByQRCode($qr_code) {
        $this->db->query('SELECT * FROM students WHERE qr_code = :qr_code');
        $this->db->bind(':qr_code', $qr_code);
        return $this->db->single();
    }

    public function getActiveStudents() {
        $this->db->query('SELECT * FROM students WHERE status = "active"');
        return $this->db->resultSet();
    }

    public function deleteStudent($id) {
        $this->db->query('DELETE FROM students WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // =====================
    // DISCOUNT MANAGEMENT
    // =====================
    public function getDiscounts($student_id) {
        $this->db->query('SELECT * FROM student_discounts WHERE student_id = :student_id ORDER BY created_at DESC');
        $this->db->bind(':student_id', $student_id);
        return $this->db->resultSet();
    }

    public function saveDiscount($data) {
        $this->db->query('INSERT INTO student_discounts (student_id, discount_type, amount, reason, expires_at) VALUES (:student_id, :discount_type, :amount, :reason, :expires_at)');
        $this->db->bind(':student_id', $data['student_id']);
        $this->db->bind(':discount_type', $data['discount_type']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':reason', $data['reason']);
        $this->db->bind(':expires_at', $data['expires_at']);
        return $this->db->execute();
    }

    public function deleteDiscount($id) {
        $this->db->query('DELETE FROM student_discounts WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // =====================
    // PORTAL ACCOUNTS
    // =====================
    public function getAccount($student_id) {
        $this->db->query('SELECT * FROM student_accounts WHERE student_id = :student_id');
        $this->db->bind(':student_id', $student_id);
        return $this->db->single();
    }

    public function createAccount($data) {
        $this->db->query('INSERT INTO student_accounts (student_id, username, password) VALUES (:student_id, :username, :password)');
        $this->db->bind(':student_id', $data['student_id']);
        $this->db->bind(':username', $data['student_id']); // Default username is ID for now
        $this->db->bind(':password', $data['password']);
        return $this->db->execute();
    }

    public function portalLogin($username, $password) {
        $this->db->query('SELECT a.*, s.name, s.roll_number FROM student_accounts a JOIN students s ON a.student_id = s.id WHERE a.username = :username AND a.is_active = 1');
        $this->db->bind(':username', $username);
        $row = $this->db->single();

        if ($row && password_verify($password, $row->password)) {
            return $row;
        }
        return false;
    }
}
