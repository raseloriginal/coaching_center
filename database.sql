-- Tables for Coaching Center MS


-- Table: users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('super_admin', 'accountant', 'teacher', 'frontdesk') DEFAULT 'super_admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: subjects
CREATE TABLE IF NOT EXISTS subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Table: teachers
CREATE TABLE IF NOT EXISTS teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    salary DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: teacher_subjects
CREATE TABLE IF NOT EXISTS teacher_subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT NOT NULL,
    subject_id INT NOT NULL,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

-- Table: batches
CREATE TABLE IF NOT EXISTS batches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    status ENUM('active', 'finished') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: students
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    father_name VARCHAR(255) DEFAULT NULL,
    phone VARCHAR(20) NOT NULL,
    roll_number VARCHAR(50) DEFAULT NULL,
    fees_amount DECIMAL(10,2) DEFAULT 0.00,
    joining_date DATE DEFAULT NULL,
    date_to_pay DATE DEFAULT NULL,
    qr_code VARCHAR(255) UNIQUE NOT NULL,
    status ENUM('active', 'completed', 'cancelled') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: batch_students
CREATE TABLE IF NOT EXISTS batch_students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    batch_id INT NOT NULL,
    student_id INT NOT NULL,
    FOREIGN KEY (batch_id) REFERENCES batches(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

-- Table: batch_schedule
CREATE TABLE IF NOT EXISTS batch_schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    batch_id INT NOT NULL,
    attendance_time TIME NOT NULL,
    FOREIGN KEY (batch_id) REFERENCES batches(id) ON DELETE CASCADE
);

-- Table: attendance
CREATE TABLE IF NOT EXISTS attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    batch_id INT NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    status ENUM('present', 'late') DEFAULT 'present',
    UNIQUE KEY (student_id, batch_id, date),
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (batch_id) REFERENCES batches(id) ON DELETE CASCADE
);

-- Table: student_fees
CREATE TABLE IF NOT EXISTS student_fees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    month VARCHAR(20) NOT NULL, -- Format: YYYY-MM
    amount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'paid', 'due', 'terminated') DEFAULT 'pending',
    due_amount DECIMAL(10, 2) DEFAULT 0.00,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

-- Table: teacher_payments
CREATE TABLE IF NOT EXISTS teacher_payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT NOT NULL,
    month VARCHAR(20) NOT NULL, -- Format: YYYY-MM
    amount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'paid', 'due') DEFAULT 'pending',
    due_amount DECIMAL(10, 2) DEFAULT 0.00,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE
);

-- Table: expenses
CREATE TABLE IF NOT EXISTS expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    expense_date DATE NOT NULL,
    category VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: exams
CREATE TABLE IF NOT EXISTS exams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    exam_date DATE NOT NULL,
    batch_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (batch_id) REFERENCES batches(id) ON DELETE CASCADE
);

-- Table: exam_subjects
CREATE TABLE IF NOT EXISTS exam_subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    exam_id INT NOT NULL,
    subject_id INT NOT NULL,
    total_marks INT DEFAULT 100,
    FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE
);

-- Table: exam_marks
CREATE TABLE IF NOT EXISTS exam_marks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    exam_subject_id INT NOT NULL,
    student_id INT NOT NULL,
    marks_obtained DECIMAL(5, 2) DEFAULT 0.00,
    remarks TEXT,
    UNIQUE KEY (exam_subject_id, student_id),
    FOREIGN KEY (exam_subject_id) REFERENCES exam_subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

-- Table: system_config (To track automation runs)
CREATE TABLE IF NOT EXISTS system_config (
    id INT AUTO_INCREMENT PRIMARY KEY,
    config_key VARCHAR(255) UNIQUE NOT NULL,
    config_value VARCHAR(255) NOT NULL
);

-- Sample Data
-- Admin Password: admin123
INSERT IGNORE INTO users (name, email, password) VALUES ('Admin', 'admin@example.com', '$2y$10$otr11fz4xg8jXUmI3KhU3.j.hrbJqzJfsM/gDDiFGEv39elsoKIaq');

-- Initial System Config
INSERT IGNORE INTO system_config (config_key, config_value) VALUES ('last_automation_month', '');
INSERT IGNORE INTO system_config (config_key, config_value) VALUES ('site_title', 'Coaching Center MS');
INSERT IGNORE INTO system_config (config_key, config_value) VALUES ('site_email', 'admin@example.com');
INSERT IGNORE INTO system_config (config_key, config_value) VALUES ('site_phone', '+880123456789');
INSERT IGNORE INTO system_config (config_key, config_value) VALUES ('site_address', '123, Coaching Street, Dhaka');
INSERT IGNORE INTO system_config (config_key, config_value) VALUES ('smtp_host', 'smtp.mailtrap.io');
INSERT IGNORE INTO system_config (config_key, config_value) VALUES ('smtp_user', '');
INSERT IGNORE INTO system_config (config_key, config_value) VALUES ('smtp_pass', '');
INSERT IGNORE INTO system_config (config_key, config_value) VALUES ('smtp_port', '2525');
INSERT IGNORE INTO system_config (config_key, config_value) VALUES ('smtp_encryption', 'tls');
INSERT IGNORE INTO system_config (config_key, config_value) VALUES ('fee_reminder_days', '3');
INSERT IGNORE INTO system_config (config_key, config_value) VALUES ('portal_enabled', '1');
INSERT IGNORE INTO system_config (config_key, config_value) VALUES ('invoice_footer', 'Thank you for your payment!');

-- Landing Page Default Configs
REPLACE INTO system_config (config_key, config_value) VALUES ('hero_title', 'Build Your Career with Proper Guidance');
REPLACE INTO system_config (config_key, config_value) VALUES ('hero_subtitle', 'We are one of the most reliable coaching centers in Bangladesh, providing top-notch education for years.');
REPLACE INTO system_config (config_key, config_value) VALUES ('landing_banner', 'https://images.unsplash.com/photo-1523050853063-bd8012fec042?auto=format&fit=crop&w=1920&q=80');
REPLACE INTO system_config (config_key, config_value) VALUES ('about_title', 'The Most Trusted Education Partner in the Region');
REPLACE INTO system_config (config_key, config_value) VALUES ('about_description', 'We provide comprehensive coaching for students from class 6 to 12. Our special focus areas include Science, Mathematics, and English.');
REPLACE INTO system_config (config_key, config_value) VALUES ('principal_name', 'Dr. Abdur Rahman');
REPLACE INTO system_config (config_key, config_value) VALUES ('principal_quote', 'Our mission is to empower the next generation of leaders in Bangladesh through quality education.');
REPLACE INTO system_config (config_key, config_value) VALUES ('principal_image', 'https://i.pravatar.cc/150?u=principal');
REPLACE INTO system_config (config_key, config_value) VALUES ('years_excellence', '10+');
REPLACE INTO system_config (config_key, config_value) VALUES ('gpa5_holders', '500+');
REPLACE INTO system_config (config_key, config_value) VALUES ('active_students', '500');
REPLACE INTO system_config (config_key, config_value) VALUES ('total_teachers', '40');
REPLACE INTO system_config (config_key, config_value) VALUES ('total_courses', '15');

-- Table: audit_logs (Activity Logging)
CREATE TABLE IF NOT EXISTS audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action VARCHAR(255) NOT NULL,
    details TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT IGNORE INTO subjects (name) VALUES ('English'), ('Mathematics'), ('Physics'), ('Chemistry');

-- Table: notices
CREATE TABLE IF NOT EXISTS notices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Landing Page Tables
CREATE TABLE IF NOT EXISTS landing_mentors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL,
    credentials VARCHAR(255),
    image VARCHAR(255),
    social_fb VARCHAR(255),
    social_wa VARCHAR(255),
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS landing_programs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    features TEXT,
    is_trending TINYINT(1) DEFAULT 0,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS landing_testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    credentials VARCHAR(255),
    content TEXT NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Advanced Features Tables
CREATE TABLE IF NOT EXISTS student_discounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    discount_percent DECIMAL(5,2) DEFAULT 0.00,
    reason VARCHAR(255),
    active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

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
