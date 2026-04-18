<?php
/**
 * Role-based Access Control Middleware
 */
class RoleMiddleware extends Middleware {
    public function handle($allowedRoles = []) {
        if (!isLoggedIn()) {
            header('location: ' . URLROOT . '/users/login');
            exit();
        }

        $userRole = $_SESSION['user_role'] ?? 'super_admin';

        if (!empty($allowedRoles) && !in_array($userRole, $allowedRoles)) {
            flash('error', 'You do not have permission to access this area.', 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4');
            header('location: ' . URLROOT . '/pages/dashboard');
            exit();
        }
    }
}
