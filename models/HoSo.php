<?php
require_once __DIR__ . '/../config/dbconnect.php';

class HoSo {
    private $conn;
    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getUserInfo($username) {
        $sql = "SELECT u.id, u.username, u.role, b.avatar, b.fullname 
                FROM users u 
                LEFT JOIN benhnhan b ON u.id = b.id 
                WHERE u.username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getUserRecords($user_id) {
        $sql = "SELECT * FROM hosobenhan WHERE benhnhan_id = ? ORDER BY ngaykham DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getRecordById($hoso_id, $user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM hosobenhan WHERE id = ? AND benhnhan_id = ?");
        $stmt->bind_param("ii", $hoso_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function searchRecords($search = '', $limit = 10, $offset = 0) {
        $query = "SELECT h.*, b.fullname as benhnhan_name, b.id as benhnhan_id FROM hosobenhan h LEFT JOIN benhnhan b ON h.benhnhan_id = b.id WHERE 1=1";
        $params = [];
        $types = '';
        if (!empty($search)) {
            $query .= " AND (b.fullname LIKE ? OR h.ghichu LIKE ? OR h.bacsi LIKE ?)";
            $searchTerm = "%$search%";
            $params = [$searchTerm, $searchTerm, $searchTerm];
            $types = 'sss';
        }
        $query .= " ORDER BY h.ngaykham DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= 'ii';
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countRecords($search = '') {
        $query = "SELECT COUNT(*) as total FROM hosobenhan h LEFT JOIN benhnhan b ON h.benhnhan_id = b.id WHERE 1=1";
        $params = [];
        $types = '';
        if (!empty($search)) {
            $query .= " AND (b.fullname LIKE ? OR h.ghichu LIKE ? OR h.bacsi LIKE ?)";
            $searchTerm = "%$search%";
            $params = [$searchTerm, $searchTerm, $searchTerm];
            $types = 'sss';
        }
        $stmt = $this->conn->prepare($query);
        if (!empty($search)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function getAllRecords() {
        $query = "SELECT h.*, b.fullname as benhnhan_name FROM hosobenhan h 
                  LEFT JOIN benhnhan b ON h.benhnhan_id = b.id 
                  ORDER BY h.ngaykham DESC";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT h.*, b.fullname as benhnhan_name, b.phone, b.email, b.dob, b.address 
                  FROM hosobenhan h 
                  LEFT JOIN benhnhan b ON h.benhnhan_id = b.id 
                  WHERE h.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($benhnhan_id, $bacsi, $ngaykham, $trangthai, $ghichu) {
        $query = "INSERT INTO hosobenhan (benhnhan_id, bacsi, ngaykham, trangthai, ghichu, created_at) 
                  VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('issss', $benhnhan_id, $bacsi, $ngaykham, $trangthai, $ghichu);
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        } else {
            return false;
        }
    }

    public function update($id, $benhnhan_id, $bacsi, $ngaykham, $trangthai, $ghichu) {
        $query = "UPDATE hosobenhan SET benhnhan_id = ?, bacsi = ?, ngaykham = ?, trangthai = ?, ghichu = ? 
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('issssi', $benhnhan_id, $bacsi, $ngaykham, $trangthai, $ghichu, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM hosobenhan WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function getPatients() {
        $query = "SELECT id, fullname FROM benhnhan ORDER BY fullname";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getConfirmedAppointments() {
        $query = "SELECT d.id AS appointment_id, d.name, d.appointment_date, b.id AS benhnhan_id
                  FROM datlichhen d
                  JOIN benhnhan b ON d.name COLLATE utf8mb4_unicode_ci = b.fullname COLLATE utf8mb4_unicode_ci
                  WHERE d.confirmed = 1 AND d.deleted_at IS NULL
                  ORDER BY d.appointment_date DESC";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteAppointment($appointment_id) {
        $query = "DELETE FROM datlichhen WHERE id = ? AND confirmed = 1 AND deleted_at IS NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $appointment_id);
        return $stmt->execute();
    }

    public function addTranscript($hoso_id, $file_name, $transcript_text) {
        $query = "INSERT INTO transcript (hosobenhan_id, file_audio, transcript, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('iss', $hoso_id, $file_name, $transcript_text);
        return $stmt->execute();
    }

    public function getTranscriptsForRecord($hoso_id) {
        $query = "SELECT id, file_audio, transcript FROM transcript WHERE hosobenhan_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $hoso_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteTranscript($media_id) {
        $query = "SELECT file_audio FROM transcript WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $media_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        
        if ($result && !empty($result['file_audio'])) {
            $file_path = "nguoidung/uploads/audio/" . $result['file_audio'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        $query = "DELETE FROM transcript WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $media_id);
        return $stmt->execute();
    }
} 