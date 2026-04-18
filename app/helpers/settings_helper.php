<?php
/**
 * Settings Helper
 * Provides global access to system configuration
 */

class SettingsHelper {
    private static $settings = null;

    /**
     * Load all settings from database
     */
    private static function loadSettings() {
        if (self::$settings === null) {
            try {
                $db = new Database();
                $db->query('SELECT config_key, config_value FROM system_config');
                $results = $db->resultSet();
                
                self::$settings = [];
                foreach ($results as $row) {
                    self::$settings[$row->config_key] = $row->config_value;
                }
            } catch (Exception $e) {
                // Fallback to empty array if DB connection fails during load
                self::$settings = [];
            }
        }
    }

    /**
     * Get a setting value
     * 
     * @param string $key Configuration key
     * @param mixed $default Default value if key is not found
     * @return mixed
     */
    public static function get($key, $default = null) {
        self::loadSettings();
        return isset(self::$settings[$key]) ? self::$settings[$key] : $default;
    }

    /**
     * Refresh settings from database
     */
    public static function refresh() {
        self::$settings = null;
        self::loadSettings();
    }
}

/**
 * Global helper function for ease of use
 */
function get_setting($key, $default = null) {
    return SettingsHelper::get($key, $default);
}
