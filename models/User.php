<?php
require_once __DIR__ . '/../config/dbconnect.php';

class User {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getUserByUsernameOrEmail($username) {
        $sql = "SELECT u.id, u.username, u.password, u.role, u.email, b.fullname 
                FROM users u 
                LEFT JOIN benhnhan b ON u.id = b.id 
                WHERE u.username = ? OR u.email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    public function createBenhNhanRecord($userId, $username, $email) {
        $insert_benhnhan = "INSERT INTO benhnhan (id, username, email) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($insert_benhnhan);
        $stmt->bind_param("iss", $userId, $username, $email);
        return $stmt->execute();
    }

    public function createUser($username, $email, $password_hash) {
        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('sss', $username, $email, $password_hash);
        return $stmt->execute();
    }

    public function getUserProfile($userId) {
        $query = "SELECT b.*, u.username as user_username, u.email as user_email, u.role 
                  FROM benhnhan b 
                  INNER JOIN users u ON b.id = u.id 
                  WHERE b.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateUserProfile($userId, $username, $fullname, $email, $phone, $address, $dob) {
        // Check if username or email already exists for other users
        $check_query = "SELECT id FROM benhnhan WHERE (username = ? OR email = ?) AND id != ?";
        $check_stmt = $this->conn->prepare($check_query);
        $check_stmt->bind_param("ssi", $username, $email, $userId);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            return "Tên đăng nhập hoặc email đã tồn tại";
        }

        $this->conn->begin_transaction();
        try {
            $update_benhnhan = "UPDATE benhnhan SET username = ?, fullname = ?, email = ?, phone = ?, address = ?, dob = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $this->conn->prepare($update_benhnhan);
            $stmt->bind_param("ssssssi", $username, $fullname, $email, $phone, $address, $dob, $userId);
            if (!$stmt->execute()) {
                throw new Exception("Lỗi cập nhật bảng benhnhan: " . $stmt->error);
            }

            $update_users = "UPDATE users SET email = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $this->conn->prepare($update_users);
            $stmt->bind_param("si", $email, $userId);
            if (!$stmt->execute()) {
                throw new Exception("Lỗi cập nhật bảng users: " . $stmt->error);
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return $e->getMessage();
        }
    }

    public function updateUserAvatar($userId, $avatar_filename) {
        $avatar_update = "UPDATE benhnhan SET avatar = ? WHERE id = ?";
        $stmt = $this->conn->prepare($avatar_update);
        $stmt->bind_param("si", $avatar_filename, $userId);
        return $stmt->execute();
    }

    // ADMIN: List all users for phanquyen
    public function getAllUsers() {
        $query = "SELECT id, username, role FROM users";
        $result = $this->conn->query($query);
        if ($result === FALSE) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ADMIN: Create user with role
    public function createUserWithRole($username, $email, $password_hash, $role) {
        $now = date('Y-m-d H:i:s');
        $sql = "INSERT INTO users (username, password, email, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ssssss', $username, $password_hash, $email, $role, $now, $now);
        return $stmt->execute();
    }

    // ADMIN: Update user role
    public function updateUserRole($id, $role) {
        $sql = "UPDATE users SET role = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('si', $role, $id);
        return $stmt->execute();
    }

    // ADMIN: Delete user
    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public function getUserById($id) {
        $sql = "SELECT id, username, email, role FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}