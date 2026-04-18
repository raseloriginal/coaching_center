<?php
/**
 * Setup Wizard - Coaching Center Management System
 * v3 - Shared Hosting Compatible
 */

// Polyfill for PHP < 8.0
if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        return $needle !== '' && mb_strpos($haystack, $needle) !== false;
    }
}

session_start();

$envPath = dirname(dirname(__FILE__)) . '/.env';
$sqlPath = dirname(dirname(__FILE__)) . '/database.sql';

// If .env already exists, redirect to app
if (file_exists($envPath)) {
    header('Location: index.php');
    exit;
}

$error  = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db_host  = trim($_POST['db_host']  ?? 'localhost');
    $db_user  = trim($_POST['db_user']  ?? '');
    $db_pass  = trim($_POST['db_pass']  ?? '');
    $db_name  = trim($_POST['db_name']  ?? '');
    $site_name = trim($_POST['site_name'] ?? 'Coaching Center MS');
    $url_root  = trim($_POST['url_root']  ?? '');

    if (empty($db_user) || empty($db_name)) {
        $error = 'DB Name and DB Username are required.';
    } else {
        // --- Connect directly to the given database (shared hosting safe) ---
        $connected = false;
        $pdo       = null;

        // Attempt 1: Direct connection with dbname
        try {
            $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";
            $pdo = new PDO($dsn, $db_user, $db_pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            ]);
            $connected = true;
        } catch (PDOException $e1) {
            $code1   = (int)($e1->errorInfo[1] ?? 0);
            $sqlstate = (string)$e1->getCode();

            if ($code1 === 1049) {
                // DB doesn't exist – try to create it (works on local/VPS, not shared hosting)
                try {
                    $pdo2 = new PDO("mysql:host={$db_host}", $db_user, $db_pass, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    ]);
                    $pdo2->exec("CREATE DATABASE IF NOT EXISTS `{$db_name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                    $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";
                    $pdo = new PDO($dsn, $db_user, $db_pass, [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    ]);
                    $connected = true;
                } catch (PDOException $e2) {
                    $error = "Database '{$db_name}' does not exist and could not be created.<br>"
                           . "<strong>Fix:</strong> Create the database manually in cPanel first, then retry.";
                }
            } elseif ($code1 === 1044 || $code1 === 1045) {
                $error = "Access Denied — wrong username or password for user <code>{$db_user}</code>.<br>"
                       . "<strong>Fix:</strong> Double-check your cPanel database username and password.";
            } else {
                $error = "Connection error [{$code1}]: " . htmlspecialchars($e1->getMessage());
            }
        }

        // --- If connected, run SQL and write .env ---
        if ($connected && $pdo !== null) {
            if (!file_exists($sqlPath)) {
                $error = "database.sql not found. Please upload it to the project root.";
            } else {
                try {
                    $sql     = file_get_contents($sqlPath);
                    $queries = array_filter(array_map('trim', explode(';', $sql)));
                    foreach ($queries as $query) {
                        $pdo->exec($query);
                    }

                    $envContent  = "DB_HOST={$db_host}\n";
                    $envContent .= "DB_USER={$db_user}\n";
                    $envContent .= "DB_PASS={$db_pass}\n";
                    $envContent .= "DB_NAME={$db_name}\n\n";
                    $envContent .= "URLROOT={$url_root}\n";
                    $envContent .= "SITENAME=\"{$site_name}\"\n\n";
                    $envContent .= "APP_DEBUG=true\n";

                    if (file_put_contents($envPath, $envContent) !== false) {
                        $success = "Setup completed! Your application is ready.";
                    } else {
                        $error = "Could not write .env file. Check folder permissions on the root directory.";
                    }
                } catch (PDOException $eSQL) {
                    $error = "SQL import error: " . htmlspecialchars($eSQL->getMessage());
                }
            }
        }
    }
}

// Auto-detect App URL
$detectedUrl = 'http' . ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 's' : '')
             . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost')
             . rtrim(str_replace('/public/setup.php', '', $_SERVER['REQUEST_URI'] ?? ''), '/');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Wizard | Coaching Center MS</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-main);
            padding: 20px;
        }
        .blob {
            position: fixed;
            width: 500px; height: 500px;
            background: rgba(79, 70, 229, 0.15);
            filter: blur(80px);
            border-radius: 50%;
            z-index: -1;
            animation: move 20s infinite alternate;
        }
        .blob-1 { top: -100px; left: -100px; }
        .blob-2 { bottom: -100px; right: -100px; background: rgba(147, 51, 234, 0.15); animation-delay: -5s; }
        @keyframes move {
            from { transform: translate(0, 0) scale(1); }
            to   { transform: translate(100px, 100px) scale(1.1); }
        }
        .setup-container {
            width: 100%; max-width: 520px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.8s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .header { text-align: center; margin-bottom: 24px; }
        .logo {
            width: 64px; height: 64px;
            background: var(--primary);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
            font-size: 28px; font-weight: 700;
            box-shadow: 0 0 20px rgba(79, 70, 229, 0.4);
        }
        h1 { font-size: 24px; font-weight: 700; margin-bottom: 6px; }
        p.subtitle { color: var(--text-muted); font-size: 14px; }
        .notice {
            background: rgba(59,130,246,0.12);
            border: 1px solid rgba(59,130,246,0.3);
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 22px;
            font-size: 13px;
            color: #93c5fd;
            line-height: 1.6;
        }
        .notice strong { color: #bfdbfe; }
        .notice code {
            background: rgba(0,0,0,0.35);
            padding: 1px 5px;
            border-radius: 4px;
            font-size: 12px;
        }
        .form-group { margin-bottom: 18px; }
        label {
            display: block;
            font-size: 12px; font-weight: 600;
            margin-bottom: 7px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        label .hint { color: #f87171; font-size: 10px; text-transform: none; margin-left: 4px; font-weight: 400; }
        input {
            width: 100%;
            background: rgba(255,255,255,0.06);
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            padding: 11px 14px;
            color: white;
            font-size: 14px;
            transition: all 0.25s ease;
        }
        input:focus {
            outline: none;
            border-color: var(--primary);
            background: rgba(255,255,255,0.1);
            box-shadow: 0 0 0 3px rgba(79,70,229,0.15);
        }
        input::placeholder { color: #475569; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .btn-submit {
            width: 100%;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 15px; font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 8px;
        }
        .btn-submit:hover { background: var(--primary-hover); transform: translateY(-1px); box-shadow: 0 10px 20px -5px rgba(79,70,229,0.4); }
        .btn-submit:active { transform: translateY(0); }
        .alert {
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 20px;
            font-size: 13px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            line-height: 1.6;
        }
        .alert span { font-size: 18px; flex-shrink: 0; }
        .alert-error  { background: rgba(239,68,68,0.1);  border: 1px solid rgba(239,68,68,0.25);  color: #fca5a5; }
        .alert-success { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.25); color: #86efac; }
        .alert-error code { background: rgba(0,0,0,0.3); padding: 1px 5px; border-radius: 3px; font-size: 12px; }
        .success-screen { text-align: center; }
        .success-icon {
            width: 80px; height: 80px;
            background: #22c55e;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            font-size: 40px;
            animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        @keyframes scaleIn { from { transform: scale(0); } to { transform: scale(1); } }
        .divider { border: 0; border-top: 1px solid var(--glass-border); margin: 20px 0; }
        .loader {
            width: 18px; height: 18px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 0.8s linear infinite;
            display: none; margin: 0 auto;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .btn-submit.loading .btn-text { display: none; }
        .btn-submit.loading .loader    { display: block; }
    </style>
</head>
<body>
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="setup-container">
    <?php if ($success): ?>
        <div class="success-screen">
            <div class="success-icon">✓</div>
            <h1>Installation Complete!</h1>
            <p class="subtitle" style="margin-bottom:28px;"><?= $success ?></p>
            <a href="index.php" class="btn-submit" style="text-decoration:none;display:block;text-align:center;">Go to Dashboard →</a>
        </div>
    <?php else: ?>
        <div class="header">
            <div class="logo">C</div>
            <h1>System Setup</h1>
            <p class="subtitle">Configure your database to get started</p>
        </div>



        <?php if ($error): ?>
            <div class="alert alert-error">
                <span>⚠</span>
                <div><?= $error ?></div>
            </div>
        <?php endif; ?>

        <form method="POST" id="setupForm">
            <div class="grid-2">
                <div class="form-group">
                    <label>DB Host</label>
                    <input type="text" name="db_host"
                           value="<?= htmlspecialchars($_POST['db_host'] ?? 'localhost') ?>"
                           placeholder="localhost" required>
                </div>
                <div class="form-group">
                    <label>DB Name</label>
                    <input type="text" name="db_name"
                           value="<?= htmlspecialchars($_POST['db_name'] ?? '') ?>"
                           placeholder="e.g. nuroxtec_coaching" required>
                </div>
            </div>

            <div class="form-group">
                <label>DB Username</label>
                <input type="text" name="db_user"
                       value="<?= htmlspecialchars($_POST['db_user'] ?? '') ?>"
                       placeholder="e.g. nuroxtec_coaching" required>
            </div>

            <div class="form-group">
                <label>DB Password</label>
                <input type="password" name="db_pass" placeholder="Database password">
            </div>

            <hr class="divider">

            <div class="form-group">
                <label>Site Name</label>
                <input type="text" name="site_name"
                       value="<?= htmlspecialchars($_POST['site_name'] ?? 'Coaching Center MS') ?>"
                       required>
            </div>

            <div class="form-group">
                <label>App URL</label>
                <input type="text" name="url_root"
                       value="<?= htmlspecialchars($_POST['url_root'] ?? $detectedUrl) ?>"
                       required>
                <p class="subtitle" style="margin-top:6px;font-size:11px;">Auto-detected — update if wrong</p>
            </div>

            <button type="submit" class="btn-submit" id="submitBtn">
                <span class="btn-text">Install Application</span>
                <div class="loader"></div>
            </button>
        </form>
    <?php endif; ?>
</div>

<script>
const form = document.getElementById('setupForm');
const btn  = document.getElementById('submitBtn');
if (form) {
    form.onsubmit = function() {
        btn.classList.add('loading');
        btn.disabled = true;
    };
}
</script>
</body>
</html>
