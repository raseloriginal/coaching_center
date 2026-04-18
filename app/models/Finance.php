<?php
class Finance {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // STUDENT FEES
    public function getStudentFees($filter = []) {
        $sql = 'SELECT f.*, s.name as student_name FROM student_fees f JOIN students s ON f.student_id = s.id';
        if (!empty($filter['status'])) {
            $sql .= ' WHERE f.status = :status';
        }
        $sql .= ' ORDER BY f.month DESC, s.name ASC';
        
        $this->db->query($sql);
        if (!empty($filter['status'])) {
            $this->db->bind(':status', $filter['status']);
        }
        return $this->db->resultSet();
    }

    public function updateFeeStatus($id, $status, $due_amount = 0) {
        $this->db->query('UPDATE student_fees SET status = :status, due_amount = :due_amount WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        $this->db->bind(':due_amount', $due_amount);
        
        // If status is terminated, cancel student
        if ($status == 'terminated') {
            $this->db->query('UPDATE students s JOIN student_fees f ON s.id = f.student_id SET s.status = "cancelled" WHERE f.id = :id');
            $this->db->bind(':id', $id);
            $this->db->execute();
        }

        return $this->db->execute();
    }

    // TEACHER PAYMENTS
    public function getTeacherPayments($filter = []) {
        $sql = 'SELECT p.*, t.name as teacher_name FROM teacher_payments p JOIN teachers t ON p.teacher_id = t.id';
        if (!empty($filter['status'])) {
            $sql .= ' WHERE p.status = :status';
        }
        $sql .= ' ORDER BY p.month DESC, t.name ASC';

        $this->db->query($sql);
        if (!empty($filter['status'])) {
            $this->db->bind(':status', $filter['status']);
        }
        return $this->db->resultSet();
    }

    public function updatePaymentStatus($id, $status, $due_amount = 0) {
        $this->db->query('UPDATE teacher_payments SET status = :status, due_amount = :due_amount WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        $this->db->bind(':due_amount', $due_amount);
        return $this->db->execute();
    }

    // AUTOMATION: Run on first visit of month
    public function runMonthlyAutomation() {
        $currentMonth = date('Y-m');
        
        // Check last run month
        $this->db->query('SELECT config_value FROM system_config WHERE config_key = "last_automation_month"');
        $row = $this->db->single();
        $lastMonth = $row ? $row->config_value : '';

        if ($lastMonth !== $currentMonth) {
            // 1. Insert fees for ALL ACTIVE students
            $this->db->query('INSERT INTO student_fees (student_id, month, amount, status) 
                             SELECT id, :month, 500, "pending" FROM students WHERE status = "active"');
            $this->db->bind(':month', $currentMonth);
            $this->db->execute();

            // 2. Insert payments for ALL teachers
            $this->db->query('INSERT INTO teacher_payments (teacher_id, month, amount, status) 
                             SELECT id, :month, salary, "pending" FROM teachers');
            $this->db->bind(':month', $currentMonth);
            $this->db->execute();

            // Update last run month
            $this->db->query('UPDATE system_config SET config_value = :current_month WHERE config_key = "last_automation_month"');
            $this->db->bind(':current_month', $currentMonth);
            $this->db->execute();
            return true;
        }
        return false;
    }

    // EXPENSES
    public function getTotalExpensesCount() {
        $this->db->query('SELECT COUNT(*) as count FROM expenses');
        $row = $this->db->single();
        return $row->count;
    }

    public function getExpenses($limit = null, $offset = null) {
        $sql = 'SELECT * FROM expenses ORDER BY expense_date DESC';
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

    public function addExpense($data) {
        $this->db->query('INSERT INTO expenses (title, amount, expense_date, category) VALUES (:title, :amount, :expense_date, :category)');
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':expense_date', $data['expense_date']);
        $this->db->bind(':category', $data['category']);
        return $this->db->execute();
    }

    public function deleteExpense($id) {
        $this->db->query('DELETE FROM expenses WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // YEARLY STATS (last 12 months)
    public function getYearlyStats() {
        $stats = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $label = date('M Y', strtotime("-$i months"));

            // Revenue (collected fees)
            $this->db->query('SELECT COALESCE(SUM(CASE WHEN status="paid" THEN amount WHEN status="due" THEN amount - due_amount ELSE 0 END), 0) as revenue FROM student_fees WHERE month = :month');
            $this->db->bind(':month', $month);
            $rev = $this->db->single();

            // Expenses (teacher payments + general expenses)
            $this->db->query('SELECT COALESCE(SUM(CASE WHEN status="paid" THEN amount WHEN status="due" THEN amount - due_amount ELSE 0 END), 0) as paid FROM teacher_payments WHERE month = :month');
            $this->db->bind(':month', $month);
            $tpay = $this->db->single();

            $this->db->query('SELECT COALESCE(SUM(amount), 0) as total FROM expenses WHERE DATE_FORMAT(expense_date, "%Y-%m") = :month');
            $this->db->bind(':month', $month);
            $exp = $this->db->single();

            $stats[] = [
                'month'    => $label,
                'revenue'  => round((float)$rev->revenue, 2),
                'expenses' => round((float)$tpay->paid + (float)$exp->total, 2),
            ];
        }
        return $stats;
    }

    public function getAllTimeStats() {
        $stats = [];

        $this->db->query('SELECT COALESCE(SUM(CASE WHEN status="paid" THEN amount WHEN status="due" THEN amount - due_amount ELSE 0 END), 0) as total FROM student_fees');
        $stats['total_revenue'] = (float)$this->db->single()->total;

        $this->db->query('SELECT COALESCE(SUM(CASE WHEN status="paid" THEN amount WHEN status="due" THEN amount - due_amount ELSE 0 END), 0) as total FROM teacher_payments');
        $tp = (float)$this->db->single()->total;

        $this->db->query('SELECT COALESCE(SUM(amount), 0) as total FROM expenses');
        $ge = (float)$this->db->single()->total;

        $stats['total_expenses'] = $tp + $ge;
        $stats['net_profit'] = $stats['total_revenue'] - $stats['total_expenses'];

        $this->db->query('SELECT COALESCE(SUM(CASE WHEN status="pending" THEN amount WHEN status="due" THEN due_amount ELSE 0 END), 0) as total FROM student_fees');
        $stats['total_outstanding'] = (float)$this->db->single()->total;

        return $stats;
    }

    public function getFeeStatusBreakdown($month = null) {
        if (!$month) $month = date('Y-m');
        $this->db->query('SELECT status, COUNT(*) as count, SUM(amount) as total FROM student_fees WHERE month = :month GROUP BY status');
        $this->db->bind(':month', $month);
        $rows = $this->db->resultSet();
        $result = ['paid' => 0, 'pending' => 0, 'due' => 0, 'terminated' => 0];
        foreach ($rows as $row) {
            $result[$row->status] = (int)$row->count;
        }
        return $result;
    }

    // ANALYTICS
    public function getMonthlyFinancialStats($month = null) {
        if (!$month) $month = date('Y-m');

        $stats = [
            'revenue_collected' => 0,
            'revenue_pending' => 0,
            'expenses_paid' => 0,
            'liabilities_pending' => 0,
            'fee_status_counts' => ['paid' => 0, 'pending' => 0, 'due' => 0]
        ];

        // 1. Student Fees
        $this->db->query('SELECT amount, status, due_amount FROM student_fees WHERE month = :month');
        $this->db->bind(':month', $month);
        $fees = $this->db->resultSet();

        foreach ($fees as $fee) {
            $stats['fee_status_counts'][$fee->status]++;
            if ($fee->status === 'paid') {
                $stats['revenue_collected'] += $fee->amount;
            } elseif ($fee->status === 'due') {
                // partial payment collected
                $stats['revenue_collected'] += ($fee->amount - $fee->due_amount);
                $stats['revenue_pending'] += $fee->due_amount;
            } elseif ($fee->status === 'pending') {
                $stats['revenue_pending'] += $fee->amount;
            }
        }

        // 2. Teacher Payments
        $this->db->query('SELECT amount, status, due_amount FROM teacher_payments WHERE month = :month');
        $this->db->bind(':month', $month);
        $payments = $this->db->resultSet();

        foreach ($payments as $payment) {
            if ($payment->status === 'paid') {
                $stats['expenses_paid'] += $payment->amount;
            } elseif ($payment->status === 'due') {
                $stats['expenses_paid'] += ($payment->amount - $payment->due_amount);
                $stats['liabilities_pending'] += $payment->due_amount;
            } elseif ($payment->status === 'pending') {
                $stats['liabilities_pending'] += $payment->amount;
            }
        }

        // 3. General Expenses
        $this->db->query('SELECT SUM(amount) as total_expenses FROM expenses WHERE DATE_FORMAT(expense_date, "%Y-%m") = :month');
        $this->db->bind(':month', $month);
        $expenseRow = $this->db->single();
        if ($expenseRow && $expenseRow->total_expenses) {
            $stats['expenses_paid'] += $expenseRow->total_expenses;
        }

        return $stats;
    }

    public function getFeeById($id) {
        $this->db->query('SELECT f.*, s.name as student_name, s.roll_number, s.father_name, s.phone as student_phone 
                          FROM student_fees f 
                          JOIN students s ON f.student_id = s.id 
                          WHERE f.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
}
