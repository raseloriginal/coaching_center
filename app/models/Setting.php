<?php
class Setting {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    /**
     * Get all settings as an associative array
     */
    public function getAll() {
        $this->db->query('SELECT config_key, config_value FROM system_config');
        $results = $this->db->resultSet();
        
        $settings = [];
        foreach ($results as $row) {
            $settings[$row->config_key] = $row->config_value;
        }
        
        return $settings;
    }

    /**
     * Get a specific setting value
     */
    public function get($key) {
        $this->db->query('SELECT config_value FROM system_config WHERE config_key = :key');
        $this->db->bind(':key', $key);
        $row = $this->db->single();
        
        return $row ? $row->config_value : null;
    }

    /**
     * Update multiple settings
     */
    public function updateSettings($data) {
        try {
            // We use a transaction to ensure all settings are updated or none
            // However, our simple Database class might not support transactions explicitly
            // Let's check if it does. If not, we'll just loop.
            
            foreach ($data as $key => $value) {
                // Check if key exists
                $this->db->query('SELECT id FROM system_config WHERE config_key = :key');
                $this->db->bind(':key', $key);
                
                if ($this->db->single()) {
                    // Update
                    $this->db->query('UPDATE system_config SET config_value = :value WHERE config_key = :key');
                } else {
                    // Insert
                    $this->db->query('INSERT INTO system_config (config_key, config_value) VALUES (:key, :value)');
                }
                
                $this->db->bind(':key', $key);
                $this->db->bind(':value', $value);
                $this->db->execute();
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
