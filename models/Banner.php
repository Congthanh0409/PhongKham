<?php
require_once __DIR__ . '/../config/dbconnect.php';

class Banner {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getActiveBanners() {
        $query = "SELECT id, image_url, link_url FROM banner WHERE deleted_at IS NULL";
        $result = $this->conn->query($query);

        if ($result === FALSE) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllBanners() {
        $query = "SELECT * FROM banner ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        if ($result === FALSE) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function softDeleteBanner($id) {
        $query = "UPDATE banner SET deleted_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function createBanner($image_url, $link_url, $user_id) {
        $query = "INSERT INTO banner (image_url, link_url, user_id, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssi', $image_url, $link_url, $user_id);
        return $stmt->execute();
    }

    public function updateBanner($id, $image_url, $link_url) {
        $query = "UPDATE banner SET image_url = ?, link_url = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssi', $image_url, $link_url, $id);
        return $stmt->execute();
    }
} 