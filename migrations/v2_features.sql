-- =====================================================
-- Coaching Center MS — v2 Feature Migration
-- Run this file in phpMyAdmin or via update.php
-- =====================================================

-- 1. Add role to users table
ALTER TABLE users ADD COLUMN IF NOT EXISTS role ENUM('super_admin', 'accountant', 'teacher', 'frontdesk') DEFAULT 'super_admin';
ALTER TABLE users ADD COLUMN IF NOT EXISTS is_active TINYINT(1) DEFAULT 1;

-- 2. Student discounts / scholarships
CREATE TABLE IF NOT EXISTS student_discounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    discount_percent DECIMAL(5,2) DEFAULT 0.00,
    reason VARCHAR(255),
    active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

-- 3. Student portal accounts
CREATE TABLE IF NOT EXISTS student_accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL UNIQUE,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    last_login TIMESTAMP NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

-- 4. Audit logs
CREATE TABLE IF NOT EXISTS audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    user_name VARCHAR(255) NOT NULL,
    action VARCHAR(100) NOT NULL,
    target_type VARCHAR(100) NOT NULL,
    target_id INT DEFAULT NULL,
    description TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. Notifications log
CREATE TABLE IF NOT EXISTS notification_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('email', 'sms', 'announcement') DEFAULT 'email',
    recipient_type ENUM('student', 'teacher', 'batch', 'all') DEFAULT 'all',
    recipient_id INT DEFAULT NULL,
    subject VARCHAR(255),
    message TEXT,
    sent_by INT,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 6. System config additions
INSERT IGNORE INTO system_config (config_key, config_value) VALUES ('fee_reminder_days', '3');
INSERT IGNORE INTO system_config (config_key, config_value) VALUES ('portal_enabled', '1');
INSERT IGNORE INTO system_config (config_key, config_value) VALUES ('invoice_footer', 'Thank you for your payment!');
