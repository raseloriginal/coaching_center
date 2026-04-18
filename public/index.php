<?php
/**
 * Coaching Center MS - Frontend Entry Point
 */

// Polyfill for str_contains for PHP < 8.0 compatibility
if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}

// Load env helper and .env file first
require_once '../app/helpers/env_helper.php';
$envPath = dirname(dirname(__FILE__)) . '/.env';

// Check if .env exists, if not redirect to setup
if (!file_exists($envPath)) {
    $requestUri = $_SERVER['REQUEST_URI'];
    if (str_contains($requestUri, 'setup.php')) {
        // Prevent MVC core from loading to avoid routing conflicts
        require_once 'setup.php';
        exit;
    } else {
        // More robust redirection logic
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $baseDir = str_replace('/public/index.php', '', $scriptName);
        $baseDir = str_replace('/index.php', '', $baseDir);
        $baseDir = rtrim($baseDir, '/');
        
        header('Location: ' . $baseDir . '/public/setup.php');
        exit;
    }
}

loadEnv($envPath);

// Global Error & Exception Handling
error_reporting(E_ALL);
ini_set('display_errors', env('APP_DEBUG', '1') ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', dirname(dirname(__FILE__)) . '/app/logs/error.log');

set_exception_handler(function($e) {
    error_log($e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
    if (env('APP_DEBUG', '1')) {
        echo "<div style='padding: 20px; background: #fff5f5; border: 2px solid #feb2b2; margin: 20px; font-family: sans-serif; border-radius: 8px;'>";
        echo "<h3 style='color: #c53030; margin-top: 0;'>Application Error</h3>";
        echo "<p><strong>Message:</strong> " . $e->getMessage() . "</p>";
        echo "<p><strong>File:</strong> " . $e->getFile() . " (Line " . $e->getLine() . ")</p>";
        echo "</div>";
    } else {
        echo "<h1>Something went wrong.</h1><p>Our team has been notified.</p>";
    }
    exit();
});

require_once '../app/config/config.php';
require_once '../app/helpers/session_helper.php';
require_once '../app/helpers/settings_helper.php';
require_once '../app/helpers/util_helper.php';

// Autoload Core Libraries
spl_autoload_register(function($className) {
    if (file_exists('../app/core/' . $className . '.php')) {
        require_once '../app/core/' . $className . '.php';
    } elseif (file_exists('../app/middlewares/' . $className . '.php')) {
        require_once '../app/middlewares/' . $className . '.php';
    } elseif (file_exists('../app/models/' . $className . '.php')) {
        require_once '../app/models/' . $className . '.php';
    }
});

// Init Core Library
$init = new App();
