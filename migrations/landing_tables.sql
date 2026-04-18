-- Landing Page Tables Migration

-- 1. Hero & General Settings
REPLACE INTO system_config (config_key, config_value) VALUES ('hero_title', 'Build Your Career with Proper Guidance');
REPLACE INTO system_config (config_key, config_value) VALUES ('hero_subtitle', 'We are one of the most reliable coaching centers in Bangladesh, providing top-notch education for years.');
REPLACE INTO system_config (config_key, config_value) VALUES ('landing_banner', 'https://images.unsplash.com/photo-1523050853063-bd8012fec042?auto=format&fit=crop&w=1920&q=80');
REPLACE INTO system_config (config_key, config_value) VALUES ('about_title', 'The Most Trusted Education Partner in the Region');
REPLACE INTO system_config (config_key, config_value) VALUES ('about_description', 'We provide comprehensive coaching for students from class 6 to 12. Our special focus areas include Science, Mathematics, and English. We believe that every student has the potential to shine if given the right guidance.');
REPLACE INTO system_config (config_key, config_value) VALUES ('principal_name', 'Dr. Abdur Rahman');
REPLACE INTO system_config (config_key, config_value) VALUES ('principal_quote', 'Our mission is to empower the next generation of leaders in Bangladesh through quality education and character building.');
REPLACE INTO system_config (config_key, config_value) VALUES ('principal_image', 'https://i.pravatar.cc/150?u=principal');

-- 2. Mentors Table
DROP TABLE IF EXISTS landing_mentors;
CREATE TABLE landing_mentors (
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

-- Seed Mentors
INSERT INTO landing_mentors (name, role, credentials, image) VALUES 
('Dr. S.M. Kamal', 'Head of Science', 'PhD in Physics, University of Dhaka', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=500&q=80'),
('Engr. Ahmed Rafiq', 'Advanced Mathematics', 'M.Sc. in ME, BUET', 'https://images.unsplash.com/photo-1544168190-79c17527004f?auto=format&fit=crop&w=500&q=80'),
('Prof. Nusrat Jahan', 'English Literature', 'MA in English, North South University', 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=500&q=80'),
('Md. Tanvir Hasan', 'Chemistry Expert', 'B.Sc. in Chemistry, Rajshahi University', 'https://images.unsplash.com/photo-1484863137850-59afca0ff184?auto=format&fit=crop&w=500&q=80');

-- 3. Programs Table
DROP TABLE IF EXISTS landing_programs;
CREATE TABLE landing_programs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    features TEXT, -- Comma separated
    is_trending TINYINT(1) DEFAULT 0,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed Programs
INSERT INTO landing_programs (title, description, image, features, is_trending) VALUES 
('Junior Section (Class 6-8)', 'Building a strong foundation in core subjects for younger learners.', 'https://www.newagebd.com/files/records/news/202305/202578_161.jpg', 'Math & General Science, English & Bengali, Weekly Tests & Results', 0),
('SSC Master Class (Class 9-10)', 'Special focus on Science & Commerce groups for the board exams.', 'https://3gcoachingcenter.com/images/ogimage.jpg', 'Physics, Chemistry, Biology, Advanced Mathematics, Test Paper Solving Classes', 1),
('HSC Advanced (Class 11-12)', 'Preparing students for HSC exams and university admission tests.', 'https://www.tbsnews.net/sites/default/files/styles/big_3/public/images/2024/06/05/coaching_2.jpg', 'Higher Mathematics, Physics & Chemistry (Advanced), Information & Tech (ICT)', 0);

-- 4. Testimonials Table
DROP TABLE IF EXISTS landing_testimonials;
CREATE TABLE landing_testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    credentials VARCHAR(255),
    content TEXT NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed Testimonials
INSERT INTO landing_testimonials (name, credentials, content) VALUES 
('Sabbir Ahmed', 'Batch 2022, Now at BUET', 'The mentors here didn''t just teach me formulas; they taught me how to think. Today, I am a student at BUET, and I owe a huge part of my success to this coaching center.');

-- 5. Notices Table
CREATE TABLE IF NOT EXISTS notices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content TEXT NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed Notices
INSERT INTO notices (content, is_active) VALUES 
('Admissions are open for the upcoming SSC Master Class batch! Visit our desk for details.', 1),
('New Advanced Mathematics batch starting from May 1st. Limited seats available!', 1),
('Download our official mobile app from Google Play Store for regular updates.', 1);
