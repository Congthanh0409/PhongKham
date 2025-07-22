<?php
require_once __DIR__ . '/../config/dbconnect.php';

class DichVu {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getFeaturedServices($limit = 6) {
        $query = "SELECT id, title, content, image_url FROM dichvu WHERE deleted_at IS NULL LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === FALSE) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getServiceById($id) {
        $query = "SELECT id, title, content, created_at, image_url FROM dichvu WHERE id = ? AND deleted_at IS NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getOtherServices($id, $limit = 5) {
        $query = "SELECT id, title FROM dichvu WHERE id != ? AND deleted_at IS NULL LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllServices() {
        $query = "SELECT * FROM dichvu ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        if ($result === FALSE) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create($title, $content, $image_url, $user_id) {
        $query = "INSERT INTO dichvu (title, content, image_url, user_id, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sssi', $title, $content, $image_url, $user_id);
        return $stmt->execute();
    }

    public function update($id, $title, $content, $image_url = null) {
        if ($image_url) {
            $query = "UPDATE dichvu SET title = ?, content = ?, image_url = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('sssi', $title, $content, $image_url, $id);
        } else {
            $query = "UPDATE dichvu SET title = ?, content = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ssi', $title, $content, $id);
        }
        return $stmt->execute();
    }

    public function getById($id) {
        $query = "SELECT * FROM dichvu WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function delete($id) {
        // Get image filename before deleting
        $service = $this->getById($id);
        if (!$service) {
            return false;
        }
        
        $query = "DELETE FROM dichvu WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        $success = $stmt->execute();
        
        return $success ? $service['image_url'] : false;
    }

    public function softDelete($id) {
        $query = "UPDATE dichvu SET deleted_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
} 