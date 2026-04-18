<?php
/**
 * Student Portal Authentication Middleware
 */
class StudentAuthMiddleware extends Middleware {
    public function handle($params = []) {
        if (!isset($_SESSION['student_id'])) {
            header('location: ' . URLROOT . '/portals/login');
            exit();
        }
    }
}
