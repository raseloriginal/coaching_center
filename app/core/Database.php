<?php
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private static $dbh = null;
    private $stmt;
    private $error;

    public function __construct() {
        if (self::$dbh === null) {
            // Set DSN
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            );

            // Create PDO instance
            try {
                self::$dbh = new PDO($dsn, $this->user, $this->pass, $options);
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                die("Database connection failed: " . $this->error);
            }
        }
    }

    // Prepare statement with query
    public function query($sql) {
        $this->stmt = self::$dbh->prepare($sql);
    }

    // Bind values
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Execute the prepared statement
    public function execute() {
        return $this->stmt->execute();
    }

    // Get result set as array of objects
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    // Get single record as object
    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }

    // Get row count
    public function rowCount() {
        return $this->stmt->rowCount();
    }

    // Get last insert ID
    public function lastInsertId() {
        return self::$dbh->lastInsertId();
    }

    /**
     * Check if a table exists in the database
     */
    public function tableExists($table) {
        try {
            $this->query("SELECT 1 FROM $table LIMIT 1");
            $this->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Run a multi-query SQL script from a file
     */
    public function runScript($filePath) {
        if (!file_exists($filePath)) {
            return false;
        }

        $sql = file_get_contents($filePath);
        if ($sql === false) return false;

        try {
            // Remove comments
            $sql = preg_replace('/--.*$/m', '', $sql);
            $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);
            
            // Split into individual queries
            $queries = array_filter(array_map('trim', explode(';', $sql)));
            
            foreach ($queries as $query) {
                if (!empty($query)) {
                    $this->query($query);
                    $this->execute();
                }
            }
            return true;
        } catch (Exception $e) {
            error_log("SQL Script Error: " . $e->getMessage());
            return false;
        }
    }
}
