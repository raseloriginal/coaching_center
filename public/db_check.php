<?php
/**
 * Database Diagnostic & Repair Utility
 */

require_once '../app/helpers/env_helper.php';
$envPath = dirname(dirname(__FILE__)) . '/.env';
if (file_exists($envPath)) {
    loadEnv($envPath);
} else {
    die("Environment file not found. Please run setup.php first.");
}

require_once '../app/config/config.php';
require_once '../app/core/Database.php';

$db = new Database();

$requiredTables = [
    'users', 'subjects', 'teachers', 'teacher_subjects', 'batches', 
    'students', 'batch_students', 'batch_schedule', 'attendance', 
    'student_fees', 'teacher_payments', 'expenses', 'exams', 
    'exam_subjects', 'exam_marks', 'system_config', 'audit_logs', 
    'notices', 'landing_mentors', 'landing_programs', 
    'landing_testimonials', 'student_discounts', 'student_accounts', 
    'notification_logs'
];

$message = '';
$messageType = '';

// Handle Repair Action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['repair'])) {
    $scriptPath = dirname(dirname(__FILE__)) . '/database.sql';
    if ($db->runScript($scriptPath)) {
        $message = "Database synchronization successful! All missing tables have been created.";
        $messageType = "success";
    } else {
        $message = "Error running database script. Please check app/logs/error.log for details.";
        $messageType = "error";
    }
}

$results = [];
foreach ($requiredTables as $table) {
    $results[$table] = $db->tableExists($table);
}

$allExist = !in_array(false, $results);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Diagnostic - Coaching Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen py-12 px-4">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header -->
            <div class="bg-gray-900 p-8 text-white">
                <div class="flex items-center justify-between mb-2">
                    <h1 class="text-2xl font-bold flex items-center gap-3">
                        <i class="fas fa-database text-blue-400"></i>
                        Database Health Check
                    </h1>
                    <span class="<?php echo $allExist ? 'bg-emerald-500' : 'bg-amber-500'; ?> text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                        <?php echo $allExist ? 'Healthy' : 'Sync Required'; ?>
                    </span>
                </div>
                <p class="text-gray-400 text-sm">Automated diagnostic utility to ensure your database schema is up to date.</p>
            </div>

            <!-- Messages -->
            <?php if ($message): ?>
                <div class="p-6 <?php echo $messageType === 'success' ? 'bg-emerald-50 border-b border-emerald-100 text-emerald-800' : 'bg-rose-50 border-b border-rose-100 text-rose-800'; ?> flex items-center gap-3">
                    <i class="fas <?php echo $messageType === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
                    <p class="font-medium"><?php echo $message; ?></p>
                </div>
            <?php endif; ?>

            <!-- Diagnostic Table -->
            <div class="p-0">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50 text-xs font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100">
                        <tr>
                            <th class="px-8 py-4">Table Name</th>
                            <th class="px-8 py-4 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($results as $table => $exists): ?>
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-8 py-4 text-sm font-medium text-gray-700"><?php echo $table; ?></td>
                                <td class="px-8 py-4 text-right">
                                    <?php if ($exists): ?>
                                        <span class="text-emerald-500 flex items-center justify-end gap-2 text-sm font-bold">
                                            Found <i class="fas fa-check-circle"></i>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-rose-500 flex items-center justify-end gap-2 text-sm font-bold">
                                            Missing <i class="fas fa-times-circle"></i>
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Footer Action -->
            <div class="p-8 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <div>
                    <?php if (!$allExist): ?>
                        <p class="text-gray-500 text-sm">Some required tables are missing from your database.</p>
                    <?php else: ?>
                        <p class="text-emerald-600 text-sm font-medium">Your database is fully synchronized.</p>
                    <?php endif; ?>
                </div>
                <div class="flex gap-4">
                    <a href="<?php echo URLROOT; ?>" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-bold text-sm hover:bg-gray-50 transition">Back to Site</a>
                    <?php if (!$allExist): ?>
                        <form method="POST">
                            <button type="submit" name="repair" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-bold text-sm hover:bg-blue-700 transition shadow-lg shadow-blue-500/20">
                                Synchronize Database
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <p class="text-center text-gray-400 text-xs mt-8">&copy; <?php echo date('Y'); ?> Coaching Center Management System. System Maintenance Port.</p>
    </div>
</body>
</html>
