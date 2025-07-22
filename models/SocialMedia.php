<?php
require_once __DIR__ . '/../config/dbconnect.php';

class SocialMedia {
    private $conn;
    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }
    public function getAll() {
        $query = "SELECT id, facebook, zalo, tiktok, phone_number, created_at, updated_at, company_email, company_address FROM social_media ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        if ($result === FALSE) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function update($id, $facebook, $zalo, $tiktok, $phone_number, $company_email, $company_address) {
        $query = "UPDATE social_media SET facebook = ?, zalo = ?, tiktok = ?, phone_number = ?, company_email = ?, company_address = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ssssssi', $facebook, $zalo, $tiktok, $phone_number, $company_email, $company_address, $id);
        return $stmt->execute();
    }
} 