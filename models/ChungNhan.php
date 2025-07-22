<?php
require_once __DIR__ . '/../config/dbconnect.php';

class ChungNhan {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getCertifications($limit = 4) {
        $query = "SELECT certification_image FROM certifications ORDER BY id LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === FALSE) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllCertifications() {
        $query = "SELECT id, certification_image FROM certifications ORDER BY id DESC";
        $result = $this->conn->query($query);
        if ($result === FALSE) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCertificationById($id) {
        $query = "SELECT id, certification_image FROM certifications WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($image_url) {
        $query = "INSERT INTO certifications (certification_image) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $image_url);
        return $stmt->execute();
    }

    public function update($id, $image_url) {
        if ($image_url) {
            $query = "UPDATE certifications SET certification_image = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('si', $image_url, $id);
            return $stmt->execute();
        }
        return true; // No image change
    }

    public function delete($id) {
        $query = "DELETE FROM certifications WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
} 