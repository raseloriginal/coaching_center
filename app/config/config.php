<?php
// Database configuration
define('DB_HOST', env('DB_HOST', 'localhost'));
define('DB_USER', env('DB_USER', 'root'));
define('DB_PASS', env('DB_PASS', ''));
define('DB_NAME', env('DB_NAME', 'coaching_db'));

// App URL
define('URLROOT', env('URLROOT', 'http://localhost/coaching-center'));

// Site Name
define('SITENAME', env('SITENAME', 'Coaching Center MS'));

// App Root
define('APPROOT', dirname(dirname(__FILE__)));
