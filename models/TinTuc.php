<?php
require_once __DIR__ . '/../config/dbconnect.php';

class TinTuc {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getRecentNews($limit = 4) {
        $query = "SELECT id, title, content, image_url FROM tintuc ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === FALSE) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllNews($limit = 9, $offset = 0) {
        $query = "SELECT id, title, content, image_url, created_at FROM tintuc WHERE deleted_at IS NULL ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === FALSE) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalNewsCount() {
        $query = "SELECT COUNT(*) as total_posts FROM tintuc WHERE deleted_at IS NULL";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total_posts'];
    }

    public function getNewsById($id) {
        $query = "SELECT id, title, content, image_url, created_at FROM tintuc WHERE id = ? AND deleted_at IS NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getOtherNews($id, $limit = 5) {
        $query = "SELECT id, title FROM tintuc WHERE id != ? AND deleted_at IS NULL LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Admin: Get all news including deleted
    public function getAllNewsAdmin() {
        $query = "SELECT * FROM tintuc ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        if ($result === FALSE) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Admin: Create news
    public function createNews($title, $content, $image_url, $user_id) {
        $query = "INSERT INTO tintuc (title, content, image_url, user_id, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sssi', $title, $content, $image_url, $user_id);
        return $stmt->execute();
    }

    // Admin: Update news
    public function updateNews($id, $title, $content, $image_url = null) {
        if ($image_url) {
            $query = "UPDATE tintuc SET title = ?, content = ?, image_url = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('sssi', $title, $content, $image_url, $id);
        } else {
            $query = "UPDATE tintuc SET title = ?, content = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ssi', $title, $content, $id);
        }
        return $stmt->execute();
    }

    // Admin: Soft delete news
    public function softDeleteNews($id) {
        $query = "UPDATE tintuc SET deleted_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}