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
    
    $isTableNotFound = str_contains($e->getMessage(), '42S02');
    
    if (env('APP_DEBUG', '1')) {
        echo "<div style='padding: 30px; background: #fff; border: 1px solid #e1e4e8; margin: 40px auto; max-width: 800px; font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Helvetica, Arial, sans-serif; border-radius: 12px; shadow: 0 4px 6px rgba(0,0,0,0.05);'>";
        
        if ($isTableNotFound) {
            echo "<div style='background: #fff5f5; color: #c53030; padding: 20px; border-radius: 8px; border-left: 5px solid #fc8181; mb-20;'>";
            echo "<h2 style='margin-top: 0; font-size: 20px;'><i class='fas fa-exclamation-triangle'></i> Database Setup Required</h2>";
            echo "<p style='margin-bottom: 20px;'>It looks like some database tables are missing on your server. This usually happens after a new installation or update.</p>";
            echo "<a href='" . URLROOT . "/public/db_check.php' style='display: inline-block; background: #c53030; color: white; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-weight: bold;'>Run Database Diagnostic</a>";
            echo "</div>";
            echo "<hr style='border: none; border-top: 1px solid #e1e4e8; margin: 30px 0;'>";
        }

        echo "<h3 style='color: #24292e; margin-top: 0;'>Application Error</h3>";
        echo "<p style='color: #444;'><strong>Message:</strong> " . $e->getMessage() . "</p>";
        echo "<p style='color: #666; font-size: 14px;'><strong>File:</strong> " . $e->getFile() . " (Line " . $e->getLine() . ")</p>";
        echo "</div>";
    } else {
        if ($isTableNotFound) {
            echo "<h1>Database Configuration Required</h1><p>Please contact the administrator to run database migrations.</p>";
        } else {
            echo "<h1>Something went wrong.</h1><p>Our team has been notified.</p>";
        }
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
