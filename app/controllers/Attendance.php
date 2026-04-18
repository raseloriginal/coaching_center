<?php
class AttendanceController extends Controller {
    private $attendanceModel;
    private $studentModel;
    private $batchModel;

    public function __construct() {
        $this->middleware('AuthMiddleware');
        $this->attendanceModel = $this->model('Attendance');
        $this->studentModel = $this->model('Student');
        $this->batchModel = $this->model('Batch');
    }

    // Public QR Scanner Page
    public function scan() {
        $recentLogs = $this->attendanceModel->getTodayAttendanceLogs(15);
        $data = [
            'title' => 'QR Attendance Dashboard',
            'recentLogs' => $recentLogs
        ];
        $this->view('attendance/scan', $data);
    }

    // AJAX Endpoint for marking attendance
    public function mark() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $qr_code = trim($_POST['qr_code']);
            
            // Find student
            $student = $this->studentModel->getStudentByQRCode($qr_code);
            
            if (!$student) {
                echo json_encode(['status' => 'error', 'message' => 'Invalid QR Code / Student not found']);
                return;
            }

            if ($student->status !== 'active') {
                echo json_encode(['status' => 'error', 'message' => 'Student is not active (Status: ' . $student->status . ')']);
                return;
            }

            // Find batch
            $batch_id = $this->attendanceModel->getStudentBatch($student->id);
            if (!$batch_id) {
                echo json_encode(['status' => 'error', 'message' => 'Student not assigned to any batch']);
                return;
            }

            $batch = $this->batchModel->getBatchById($batch_id);

            // Mark attendance
            $result = $this->attendanceModel->markAttendance($student->id, $batch_id);

            $scanData = [
                'name' => $student->name,
                'roll' => $student->roll_number,
                'batch' => $batch->name,
                'time' => date('h:i A'),
                'date' => date('d M, Y')
            ];

            if ($result === 'exists') {
                echo json_encode([
                    'status' => 'info', 
                    'message' => 'Already marked for today', 
                    'student' => $scanData
                ]);
            } elseif ($result) {
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Attendance recorded', 
                    'student' => $scanData
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Database error']);
            }
        }
    }
}
