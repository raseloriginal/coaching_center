<?php
/**
 * Server Diagnostic Tool
 * Upload to /public/check.php and visit it once to verify your server setup.
 * DELETE THIS FILE after you're done!
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Server Check</title>
    <style>
        body { font-family: monospace; background: #0f172a; color: #e2e8f0; padding: 30px; }
        h2 { color: #60a5fa; border-bottom: 1px solid #334155; padding-bottom: 8px; }
        .ok { color: #4ade80; } .err { color: #f87171; } .warn { color: #fbbf24; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 30px; }
        td, th { border: 1px solid #334155; padding: 8px 14px; text-align: left; }
        th { background: #1e293b; color: #94a3b8; }
        form { background: #1e293b; border: 1px solid #334155; border-radius: 8px; padding: 20px; margin-top: 20px; }
        input { background: #0f172a; border: 1px solid #475569; color: #e2e8f0; padding: 8px; border-radius: 4px; width: 250px; margin-bottom: 8px; display: block; }
        button { background: #3b82f6; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; margin-top: 8px; }
        .result { margin-top: 16px; padding: 12px; border-radius: 6px; }
        .result.ok { background: rgba(74,222,128,0.1); border: 1px solid rgba(74,222,128,0.3); }
        .result.err { background: rgba(248,113,113,0.1); border: 1px solid rgba(248,113,113,0.3); }
        code { background: #334155; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>
<h2>🔍 Server Diagnostic Tool</h2>

<h2>1. PHP Info</h2>
<table>
    <tr><th>Setting</th><th>Value</th></tr>
    <tr><td>PHP Version</td><td class="<?= version_compare(PHP_VERSION, '8.0.0', '>=') ? 'ok' : 'warn' ?>"><?= PHP_VERSION ?></td></tr>
    <tr><td>Server Software</td><td><?= htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') ?></td></tr>
    <tr><td>Document Root</td><td><?= htmlspecialchars($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') ?></td></tr>
    <tr><td>HTTP Host</td><td><?= htmlspecialchars($_SERVER['HTTP_HOST'] ?? 'Unknown') ?></td></tr>
    <tr><td>Script Path</td><td><?= htmlspecialchars(__FILE__) ?></td></tr>
    <tr><td>PDO MySQL</td><td class="<?= extension_loaded('pdo_mysql') ? 'ok' : 'err' ?>"><?= extension_loaded('pdo_mysql') ? '✔ Enabled' : '✘ NOT Available' ?></td></tr>
    <tr><td>.env file exists</td><td class="<?= file_exists(dirname(dirname(__FILE__)) . '/.env') ? 'ok' : 'warn' ?>"><?= file_exists(dirname(dirname(__FILE__)) . '/.env') ? '✔ Yes' : '✘ No (Setup needed)' ?></td></tr>
    <tr><td>setup.php version</td><td class="ok">check.php v2 — NEW file is uploaded ✔</td></tr>
</table>

<h2>2. Test Database Connection</h2>
<p style="color:#94a3b8;font-size:13px;">Enter your cPanel database credentials to test the connection:</p>

<?php
$testResult = '';
$testClass = '';
$databases = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['test_host'])) {
    $h = trim($_POST['test_host']);
    $u = trim($_POST['test_user']);
    $p = trim($_POST['test_pass']);
    $d = trim($_POST['test_db']);

    try {
        // Step 1: Test basic connection
        $pdo = new PDO("mysql:host=$h", $u, $p);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Step 2: List available databases for this user
        $stmt = $pdo->query("SHOW DATABASES");
        $dbs = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $databases = array_filter($dbs, fn($db) => !in_array($db, ['information_schema', 'performance_schema', 'mysql', 'sys']));

        if (!empty($d)) {
            // Step 3: Try connecting to specific DB
            $pdo2 = new PDO("mysql:host=$h;dbname=$d", $u, $p);
            $testResult = "✔ SUCCESS! Connected to database <code>$d</code>. You can use these credentials in the setup wizard.";
            $testClass = 'ok';
        } else {
            $testResult = "✔ Basic connection works! See available databases below.";
            $testClass = 'ok';
        }
    } catch (PDOException $e) {
        $code = $e->errorInfo[1] ?? 0;
        if ($code == 1044 || $code == 1045) {
            $testResult = "✘ Access Denied — Username or password is wrong. Error: " . htmlspecialchars($e->getMessage());
        } elseif ($code == 1049) {
            $testResult = "✘ Database <code>$d</code> does not exist. Try leaving DB Name empty to see what's available.";
        } else {
            $testResult = "✘ Error: " . htmlspecialchars($e->getMessage());
        }
        $testClass = 'err';
    }
}
?>

<form method="POST">
    <label style="color:#94a3b8;font-size:12px;">DB Host</label>
    <input name="test_host" value="<?= htmlspecialchars($_POST['test_host'] ?? 'localhost') ?>" placeholder="localhost">

    <label style="color:#94a3b8;font-size:12px;">DB Username (from cPanel)</label>
    <input name="test_user" value="<?= htmlspecialchars($_POST['test_user'] ?? '') ?>" placeholder="e.g. nuroxtec_coaching">

    <label style="color:#94a3b8;font-size:12px;">DB Password</label>
    <input type="password" name="test_pass" placeholder="Your database password">

    <label style="color:#94a3b8;font-size:12px;">DB Name (leave empty to list all available)</label>
    <input name="test_db" value="<?= htmlspecialchars($_POST['test_db'] ?? '') ?>" placeholder="e.g. nuroxtec_coaching (optional)">

    <button type="submit">Test Connection</button>
</form>

<?php if ($testResult): ?>
    <div class="result <?= $testClass ?>">
        <?= $testResult ?>
        <?php if (!empty($databases)): ?>
            <br><br><strong>Available Databases for this user:</strong><br>
            <?php foreach ($databases as $db): ?>
                <code><?= htmlspecialchars($db) ?></code><br>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>

<p style="margin-top:40px;color:#f87171;font-size:12px;">⚠️ Delete this file from your server after you're done with setup!</p>
</body>
</html>
