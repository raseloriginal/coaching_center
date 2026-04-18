<?php
/*
 * Base Controller
 * Loads the models and views
 */
class Controller {
    public $middlewares = [];

    /**
     * Register a middleware for this controller
     */
    public function middleware($middleware, $options = []) {
        $this->middlewares[] = [
            'middleware' => $middleware,
            'only' => $options['only'] ?? [],
            'except' => $options['except'] ?? []
        ];
    }
    // Load model
    public function model($model) {
        // Require model file
        require_once '../app/models/' . $model . '.php';

        // Instantiate model
        return new $model();
    }

    // Load view
    public function view($view, $data = []) {
        // Check for view file
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            // View does not exist
            die('View does not exist');
        }
    }

    // Redirect
    public function redirect($url) {
        header('location: ' . URLROOT . '/' . $url);
    }
}
