<?php
require_once 'Middleware.php';

class AuthMiddleware extends Middleware {
    public function handle() {
        if (!isLoggedIn()) {
            header('location: ' . URLROOT . '/users/login');
            exit();
        }
        return true;
    }
}
