<?php
class FinanceController extends Controller {
    private $financeModel;

    public function __construct() {
        if (!isLoggedIn()) {
            $this->redirect('users/login');
        }
        $this->financeModel = $this->model('Finance');
    }

    public function fees() {
        $status = $_GET['status'] ?? '';
        $month = $_GET['month'] ?? date('Y-m');
        $fees = $this->financeModel->getStudentFees(['status' => $status, 'month' => $month]);
        $data = [
            'fees' => $fees,
            'current_status' => $status,
            'current_month' => $month
        ];
        $this->view('finances/fees', $data);
    }

    public function filter_fees() {
        $status = $_GET['status'] ?? '';
        $month = $_GET['month'] ?? date('Y-m');
        $fees = $this->financeModel->getStudentFees(['status' => $status, 'month' => $month]);
        
        $output = '';
        foreach ($fees as $fee) {
            $month = date('F Y', strtotime($fee->month . '-01'));
            
            $statusClass = 'bg-gray-100 text-gray-800';
            if($fee->status == 'paid') $statusClass = 'bg-emerald-100 text-emerald-800';
            if($fee->status == 'due') $statusClass = 'bg-blue-100 text-blue-800';
            if($fee->status == 'pending') $statusClass = 'bg-rose-100 text-rose-800';
            
            $dueHtml = ($fee->due_amount > 0) ? '<div class="text-xs text-rose-500">Due: $'. $fee->due_amount .'</div>' : '';

            $output .= '<tr class="hover:bg-gray-50">';
            $output .= '<td class="px-6 py-4"><input type="checkbox" name="fee_ids[]" value="'. $fee->id .'" class="row-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" onclick="updateFeeBulkActions()"></td>';
            $output .= '<td class="px-6 py-4"><div class="text-sm font-bold text-gray-900">'. htmlspecialchars($fee->student_name) .'</div><div class="text-xs text-gray-500"><i class="far fa-calendar-alt mr-1"></i> '. $month .'</div></td>';
            $output .= '<td class="px-6 py-4"><div class="text-sm font-semibold text-gray-800">$'. $fee->amount .'</div>' . $dueHtml . '</td>';
            $output .= '<td class="px-6 py-4"><span class="px-3 py-1 rounded-full text-xs font-bold '. $statusClass .'">'. ucfirst($fee->status) .'</span></td>';
            $output .= '<td class="px-6 py-4 text-right"><button type="button" onclick="openModal(\''. $fee->id .'\', \''. $fee->status .'\', \''. $fee->due_amount .'\', \''. htmlspecialchars($fee->student_name, ENT_QUOTES) .'\')" class="text-blue-600 hover:text-blue-900 font-bold text-sm">Update</button></td>';
            $output .= '</tr>';
        }
        
        if (empty($fees)) {
            $output = '<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No records found.</td></tr>';
        }
        
        echo $output;
    }

    public function update_fee() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $status = $_POST['status'];
            $due_amount = $_POST['due_amount'] ?? 0;
            
            if ($this->financeModel->updateFeeStatus($id, $status, $due_amount)) {
                log_action('UPDATE_FEE', "Updated fee status (ID: {$id}) to {$status}");
                flash('finance_message', 'Payment status updated');
            }
            $month = $_POST['current_month'] ?? date('Y-m');
            $this->redirect('finance/fees?month=' . $month);
        }
    }

    public function bulk_update_fees() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ids = $_POST['fee_ids'] ?? [];
            $status = $_POST['bulk_status'] ?? '';
            $month = $_POST['current_month'] ?? date('Y-m');
            
            if (!empty($ids) && in_array($status, ['paid', 'pending', 'due'])) {
                if ($this->financeModel->bulkUpdateFeeStatus($ids, $status)) {
                    log_action('BULK_UPDATE_FEES', "Bulk updated fee status to {$status} for " . count($ids) . " records");
                    flash('finance_message', "Status updated successfully for selected records");
                }
            }
            $this->redirect('finance/fees?month=' . $month);
        }
    }

    public function generate_monthly_fees() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $month = $_POST['month'] ?? date('Y-m');
            if ($this->financeModel->generateStudentMonthlyFees($month)) {
                log_action('GENERATE_FEES', "Generated fees for {$month}");
                flash('finance_message', "Fees for {$month} generated successfully");
            }
            $this->redirect('finance/fees?month=' . $month);
        }
    }

    public function payments() {
        $status = $_GET['status'] ?? '';
        $month = $_GET['month'] ?? date('Y-m');
        $payments = $this->financeModel->getTeacherPayments(['status' => $status, 'month' => $month]);
        $data = [
            'payments' => $payments,
            'current_status' => $status,
            'current_month' => $month
        ];
        $this->view('finances/payments', $data);
    }

    public function filter_payments() {
        $status = $_GET['status'] ?? '';
        $month = $_GET['month'] ?? date('Y-m');
        $payments = $this->financeModel->getTeacherPayments(['status' => $status, 'month' => $month]);
        
        $output = '';
        foreach ($payments as $payment) {
            $month = date('F Y', strtotime($payment->month . '-01'));
            
            $statusClass = 'bg-gray-100 text-gray-800';
            if($payment->status == 'paid') $statusClass = 'bg-emerald-100 text-emerald-800';
            if($payment->status == 'due') $statusClass = 'bg-blue-100 text-blue-800';
            if($payment->status == 'pending') $statusClass = 'bg-rose-100 text-rose-800';
            
            $dueHtml = ($payment->due_amount > 0) ? '<div class="text-xs text-rose-500 text-right">Due: $'. $payment->due_amount .'</div>' : '';

            $output .= '<tr class="hover:bg-gray-50 transition-colors">';
            $output .= '<td class="px-6 py-4"><input type="checkbox" name="payment_ids[]" value="'. $payment->id .'" class="row-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" onclick="updatePaymentBulkActions()"></td>';
            $output .= '<td class="px-6 py-4"><div class="text-sm font-bold text-gray-900">'. htmlspecialchars($payment->teacher_name) .'</div><div class="text-xs text-gray-500"><i class="far fa-calendar-alt mr-1"></i> '. $month .'</div></td>';
            $output .= '<td class="px-6 py-4"><div class="text-sm font-semibold text-gray-800">$'. $payment->amount .'</div>' . $dueHtml . '</td>';
            $output .= '<td class="px-6 py-4"><span class="px-3 py-1 rounded-full text-xs font-bold '. $statusClass .'">'. ucfirst($payment->status) .'</span></td>';
            $output .= '<td class="px-6 py-4 text-right"><button type="button" onclick="openModal(\''. $payment->id .'\', \''. $payment->status .'\', \''. $payment->due_amount .'\', \''. htmlspecialchars($payment->teacher_name, ENT_QUOTES) .'\')" class="text-blue-600 hover:text-blue-900 font-bold text-sm">Update</button></td>';
            $output .= '</tr>';
        }
        
        if (empty($payments)) {
            $output = '<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No records found.</td></tr>';
        }
        
        echo $output;
    }

    public function update_payment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $status = $_POST['status'];
            $due_amount = $_POST['due_amount'] ?? 0;

            if ($this->financeModel->updatePaymentStatus($id, $status, $due_amount)) {
                log_action('UPDATE_TEACHER_PAY', "Updated payment (ID: {$id}) to {$status}");
                flash('finance_message', 'Payment status updated');
            }
            $month = $_POST['current_month'] ?? date('Y-m');
            $this->redirect('finance/payments?month=' . $month);
        }
    }

    public function bulk_update_payments() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ids = $_POST['payment_ids'] ?? [];
            $status = $_POST['bulk_status'] ?? '';
            $month = $_POST['current_month'] ?? date('Y-m');
            
            if (!empty($ids) && in_array($status, ['paid', 'pending', 'due'])) {
                if ($this->financeModel->bulkUpdatePaymentStatus($ids, $status)) {
                    log_action('BULK_UPDATE_PAYMENTS', "Bulk updated payment status to {$status} for " . count($ids) . " records");
                    flash('finance_message', "Status updated successfully for selected records");
                }
            }
            $this->redirect('finance/payments?month=' . $month);
        }
    }

    public function generate_monthly_payments() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $month = $_POST['month'] ?? date('Y-m');
            if ($this->financeModel->generateTeacherMonthlyPayments($month)) {
                log_action('GENERATE_PAYMENTS', "Generated teacher payments for {$month}");
                flash('finance_message', "Payments for {$month} generated successfully");
            }
            $this->redirect('finance/payments?month=' . $month);
        }
    }

    public function expenses() {
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $recordsPerPage = 10;
        $totalRecords = $this->financeModel->getTotalExpensesCount();
        
        $pagination = new Pagination($page, $recordsPerPage, $totalRecords);
        $expenses = $this->financeModel->getExpenses($pagination->getLimit(), $pagination->getOffset());
        
        $data = [
            'expenses' => $expenses,
            'pagination' => $pagination->generateHtml(URLROOT . '/finance/expenses')
        ];
        $this->view('finances/expenses', $data);
    }

    public function add_expense() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data = [
                'title' => trim($_POST['title']),
                'amount' => trim($_POST['amount']),
                'expense_date' => trim($_POST['expense_date']),
                'category' => trim($_POST['category'])
            ];
            
            if ($this->financeModel->addExpense($data)) {
                log_action('ADD_EXPENSE', "Added expense: {$data['title']} (Amount: {$data['amount']})");
                flash('finance_message', 'Expense added successfully');
            } else {
                flash('finance_message', 'Something went wrong', 'bg-red-500 text-white px-4 py-3 rounded mb-4');
            }
            $this->redirect('finance/expenses');
        }
    }

    public function delete_expense($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->financeModel->deleteExpense($id)) {
                log_action('DELETE_EXPENSE', "Deleted expense with ID: {$id}");
                flash('finance_message', 'Expense record removed');
            }
            $this->redirect('finance/expenses');
        }
    }

    public function dashboard() {
        $yearlyStats = $this->financeModel->getYearlyStats();
        $allTimeStats = $this->financeModel->getAllTimeStats();
        $feeStatusBreakdown = $this->financeModel->getFeeStatusBreakdown();

        $data = [
            'yearly_stats' => $yearlyStats,
            'all_time' => $allTimeStats,
            'fee_status' => $feeStatusBreakdown
        ];

        $this->view('finances/dashboard', $data);
    }

    public function invoice($id) {
        $fee = $this->financeModel->getFeeById($id);
        if (!$fee) {
            $this->redirect('finance/fees');
        }

        $data = [
            'fee' => $fee
        ];

        $this->view('finances/invoice', $data);
    }
}
