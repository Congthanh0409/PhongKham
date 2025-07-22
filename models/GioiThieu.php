<?php
require_once __DIR__ . '/../config/dbconnect.php';

class GioiThieu {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getGioiThieuById($id) {
        $query = "SELECT id, title, created_at, content FROM gioithieu WHERE id = ? AND deleted_at IS NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getOtherGioiThieu($id, $limit = 5) {
        $query = "SELECT id, title FROM gioithieu WHERE id != ? AND deleted_at IS NULL LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Admin: Get all records including deleted
    public function getAllAdmin() {
        $query = "SELECT * FROM gioithieu ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        if ($result === FALSE) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Admin: Create record
    public function create($title, $content, $user_id) {
        $query = "INSERT INTO gioithieu (title, content, user_id, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssi', $title, $content, $user_id);
        return $stmt->execute();
    }

    // Admin: Update record
    public function update($id, $title, $content, $user_id) {
        $query = "UPDATE gioithieu SET title = ?, content = ?, user_id = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssii', $title, $content, $user_id, $id);
        if ($stmt->execute()) {
            return true;
        }
        return $stmt->error;
    }

    // Admin: Soft delete record
    public function softDelete($id) {
        $query = "UPDATE gioithieu SET deleted_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            return true;
        }
        return $stmt->error;
    }
} 