<?php
require_once __DIR__ . '/../config/dbconnect.php';

class TaiMuiHong {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getArticleById($id) {
        $query = "SELECT id, title, content, created_at, updated_at FROM taimuihong WHERE id = ? AND deleted_at IS NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getOtherArticles($id, $limit = 5) {
        $query = "SELECT id, title FROM taimuihong WHERE id != ? AND deleted_at IS NULL LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $id, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllArticles() {
        $query = "SELECT * FROM taimuihong ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        if ($result === FALSE) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function softDeleteArticle($id) {
        $query = "UPDATE taimuihong SET deleted_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function createArticle($title, $content, $user_id) {
        $query = "INSERT INTO taimuihong (title, content, user_id, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssi', $title, $content, $user_id);
        return $stmt->execute();
    }

    public function updateArticle($id, $title, $content) {
        $query = "UPDATE taimuihong SET title = ?, content = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssi', $title, $content, $id);
        return $stmt->execute();
    }
} 