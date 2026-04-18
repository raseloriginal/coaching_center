<?php
class AdminController extends Controller {
    public function __construct() {
        // Redirection logic for /admin route
        if (isLoggedIn()) {
            $this->redirect('pages/dashboard');
        } else {
            $this->redirect('users/login');
        }
    }

    public function index() {
        // This is handled by constructor, but keep index for route safety
        if (isLoggedIn()) {
            $this->redirect('pages/dashboard');
        } else {
            $this->redirect('users/login');
        }
    }
}
