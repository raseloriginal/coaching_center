<?php
/*
 * App Core Class
 * Creates URL & loads core controller
 * URL FORMAT - /controller/method/params
 */
class App {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->getUrl();

        // Look in controllers for first value
        if (isset($url[0])) {
            if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
                // If exists, set as controller
                $this->currentController = ucwords($url[0]);
                // Unset 0 Index
                unset($url[0]);
            }
        }

        // Require the controller
        require_once '../app/controllers/' . $this->currentController . '.php';

        // Instantiate controller class with 'Controller' suffix
        $controllerClassName = ucwords($this->currentController) . 'Controller';
        $this->currentController = new $controllerClassName;

        // Check for second part of url
        if (isset($url[1])) {
            // Check to see if method exists in controller
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                // Unset 1 index
                unset($url[1]);
            } else {
                // Method DOES NOT exist - Redirect to landing or handle error
                // To avoid loops, we'll only redirect if we are not already on the default landing
                if ($this->currentController instanceof PagesController && $this->currentMethod == 'index') {
                    // We are already trying to load the default, just let it fail or load index
                } else {
                    if (isLoggedIn()) {
                        header('location: ' . URLROOT . '/pages/dashboard');
                    } else {
                        header('location: ' . URLROOT . '/users/login');
                    }
                    exit();
                }
            }
        }

        // Get params
        $this->params = $url ? array_values($url) : [];

        // --- Middleware Execution ---
        if (isset($this->currentController->middlewares)) {
            foreach ($this->currentController->middlewares as $middlewareData) {
                $middlewareName = $middlewareData['middleware'];
                $only = $middlewareData['only'];
                $except = $middlewareData['except'];

                // Check if middleware should run for this method
                $shouldRun = true;
                if (!empty($only) && !in_array($this->currentMethod, $only)) {
                    $shouldRun = false;
                }
                if (!empty($except) && in_array($this->currentMethod, $except)) {
                    $shouldRun = false;
                }

                if ($shouldRun) {
                    $middleware = new $middlewareName();
                    $middleware->handle();
                }
            }
        }

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl() {
        if (isset($_GET['url']) && !empty(trim($_GET['url']))) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return null;
    }
}
