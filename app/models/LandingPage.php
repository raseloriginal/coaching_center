<?php
class LandingPage {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // --- Mentors ---
    public function getMentors() {
        $this->db->query('SELECT * FROM landing_mentors ORDER BY sort_order ASC, name ASC');
        return $this->db->resultSet();
    }

    public function getMentorById($id) {
        $this->db->query('SELECT * FROM landing_mentors WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addMentor($data) {
        $this->db->query('INSERT INTO landing_mentors (name, role, credentials, image, social_fb, social_wa, sort_order) VALUES (:name, :role, :credentials, :image, :social_fb, :social_wa, :sort_order)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':role', $data['role']);
        $this->db->bind(':credentials', $data['credentials']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':social_fb', $data['social_fb']);
        $this->db->bind(':social_wa', $data['social_wa']);
        $this->db->bind(':sort_order', $data['sort_order']);
        return $this->db->execute();
    }

    public function updateMentor($data) {
        $this->db->query('UPDATE landing_mentors SET name = :name, role = :role, credentials = :credentials, image = :image, social_fb = :social_fb, social_wa = :social_wa, sort_order = :sort_order WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':role', $data['role']);
        $this->db->bind(':credentials', $data['credentials']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':social_fb', $data['social_fb']);
        $this->db->bind(':social_wa', $data['social_wa']);
        $this->db->bind(':sort_order', $data['sort_order']);
        return $this->db->execute();
    }

    public function deleteMentor($id) {
        $this->db->query('DELETE FROM landing_mentors WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // --- Programs ---
    public function getPrograms() {
        $this->db->query('SELECT * FROM landing_programs ORDER BY sort_order ASC, title ASC');
        return $this->db->resultSet();
    }

    public function getProgramById($id) {
        $this->db->query('SELECT * FROM landing_programs WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addProgram($data) {
        $this->db->query('INSERT INTO landing_programs (title, description, image, features, is_trending, sort_order) VALUES (:title, :description, :image, :features, :is_trending, :sort_order)');
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':features', $data['features']);
        $this->db->bind(':is_trending', $data['is_trending']);
        $this->db->bind(':sort_order', $data['sort_order']);
        return $this->db->execute();
    }

    public function updateProgram($data) {
        $this->db->query('UPDATE landing_programs SET title = :title, description = :description, image = :image, features = :features, is_trending = :is_trending, sort_order = :sort_order WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':features', $data['features']);
        $this->db->bind(':is_trending', $data['is_trending']);
        $this->db->bind(':sort_order', $data['sort_order']);
        return $this->db->execute();
    }

    public function deleteProgram($id) {
        $this->db->query('DELETE FROM landing_programs WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // --- Testimonials ---
    public function getTestimonials() {
        $this->db->query('SELECT * FROM landing_testimonials ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function getTestimonialById($id) {
        $this->db->query('SELECT * FROM landing_testimonials WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addTestimonial($data) {
        $this->db->query('INSERT INTO landing_testimonials (name, credentials, content, image) VALUES (:name, :credentials, :content, :image)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':credentials', $data['credentials']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':image', $data['image']);
        return $this->db->execute();
    }

    public function updateTestimonial($data) {
        $this->db->query('UPDATE landing_testimonials SET name = :name, credentials = :credentials, content = :content, image = :image WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':credentials', $data['credentials']);
        $this->db->bind(':content', $data['content']);
        $this->db->bind(':image', $data['image']);
        return $this->db->execute();
    }

    public function deleteTestimonial($id) {
        $this->db->query('DELETE FROM landing_testimonials WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
