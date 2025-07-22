<?php
require_once __DIR__ . '/../config/dbconnect.php';

class DatLichHen {
    private $conn;
    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getPatient($user_id) {
        $query = "SELECT id, fullname, phone, email FROM benhnhan WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createAppointment($name, $phone, $email, $appointment_date, $appointment_time, $created_by) {
        $query = "INSERT INTO datlichhen (name, phone, email, appointment_date, appointment_time, created_by, confirmed, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, 0, NOW(), NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssi", $name, $phone, $email, $appointment_date, $appointment_time, $created_by);
        return $stmt->execute();
    }

    // ADMIN: Create appointment with additional fields
    public function createAppointmentByAdmin($name, $phone, $email, $appointment_date, $appointment_time, $notes, $confirmed) {
        $query = "INSERT INTO datlichhen (name, phone, email, appointment_date, appointment_time, confirmed, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssi", $name, $phone, $email, $appointment_date, $appointment_time, $confirmed);
        return $stmt->execute();
    }

    public function getAppointments($user_id) {
        $appointments_query = "SELECT d.*, b.fullname AS benhnhan_name FROM datlichhen d JOIN benhnhan b ON d.created_by = b.id WHERE d.created_by = ? AND d.deleted_at IS NULL ORDER BY d.appointment_date DESC, d.appointment_time DESC";
        $stmt = $this->conn->prepare($appointments_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $appointments = $result->fetch_all(MYSQLI_ASSOC);
        
        // Debug: Log the number of appointments found
        error_log("DEBUG: Found " . count($appointments) . " appointments for user $user_id");
        
        return $appointments;
    }

    // Get appointment by ID
    public function getAppointmentById($appointment_id) {
        $query = "SELECT * FROM datlichhen WHERE id = ? AND deleted_at IS NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $appointment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Update appointment
    public function updateAppointment($appointment_id, $appointment_date, $appointment_time) {
        // Debug: Log the values being updated
        error_log("DEBUG: Model updateAppointment - ID: $appointment_id, Date: $appointment_date, Time: $appointment_time");
        
        $query = "UPDATE datlichhen SET appointment_date = ?, appointment_time = ?, updated_at = NOW() WHERE id = ? AND deleted_at IS NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssi", $appointment_date, $appointment_time, $appointment_id);
        $result = $stmt->execute();
        
        // Debug: Log the result
        error_log("DEBUG: Update result: " . ($result ? "success" : "failed"));
        if (!$result) {
            error_log("DEBUG: SQL error: " . $stmt->error);
        }
        
        return $result;
    }

    // Delete appointment (soft delete)
    public function deleteAppointment($appointment_id) {
        $query = "UPDATE datlichhen SET deleted_at = NOW() WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $appointment_id);
        $result = $stmt->execute();
        
        // Debug: Log the deletion result
        error_log("DEBUG: Soft delete result for ID $appointment_id: " . ($result ? "success" : "failed"));
        if (!$result) {
            error_log("DEBUG: SQL error in deleteAppointment: " . $stmt->error);
        }
        
        return $result;
    }

    // ADMIN: Get all appointments (not deleted)
    public function getAllAppointments() {
        $query = "SELECT * FROM datlichhen WHERE deleted_at IS NULL ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        if ($result === FALSE) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ADMIN: Get all appointments with search filter
    public function getAllAppointmentsWithSearch($search_name = '', $search_phone = '') {
        $query = "SELECT * FROM datlichhen WHERE deleted_at IS NULL";
        $params = [];
        $types = '';
        
        // Add search conditions
        if (!empty($search_name)) {
            $query .= " AND name LIKE ?";
            $params[] = "%$search_name%";
            $types .= 's';
        }
        
        if (!empty($search_phone)) {
            $query .= " AND phone LIKE ?";
            $params[] = "%$search_phone%";
            $types .= 's';
        }
        
        $query .= " ORDER BY created_at DESC";
        
        if (empty($params)) {
            // No search parameters, use simple query
            $result = $this->conn->query($query);
            if ($result === FALSE) {
                return [];
            }
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            // Use prepared statement for search
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result === FALSE) {
                return [];
            }
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    // ADMIN: Update appointment status
    public function updateStatus($id, $status) {
        $query = "UPDATE datlichhen SET confirmed = ?, updated_at = NOW() WHERE id = ? AND deleted_at IS NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ii', $status, $id);
        return $stmt->execute();
    }

    // ADMIN: Statistics methods
    public function getTotalAppointments() {
        $query = "SELECT COUNT(*) as total FROM datlichhen WHERE deleted_at IS NULL";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    public function getConfirmedAppointments() {
        $query = "SELECT COUNT(*) as confirmed FROM datlichhen WHERE confirmed = 1 AND deleted_at IS NULL";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['confirmed'];
    }
    public function getMonthlyStats() {
        $query = "SELECT DATE_FORMAT(appointment_date, '%m') as month, COUNT(*) as count, SUM(CASE WHEN confirmed = 1 THEN 1 ELSE 0 END) as confirmed_count FROM datlichhen WHERE YEAR(appointment_date) = YEAR(CURRENT_DATE) AND deleted_at IS NULL GROUP BY month ORDER BY month";
        $result = $this->conn->query($query);
        $data = array_fill(1, 12, ['total' => 0, 'confirmed' => 0]);
        while ($row = $result->fetch_assoc()) {
            $month = (int)$row['month'];
            $data[$month] = [
                'total' => (int)$row['count'],
                'confirmed' => (int)$row['confirmed_count']
            ];
        }
        return $data;
    }
    public function getWeekdayStats() {
        $query = "SELECT DAYOFWEEK(appointment_date) as weekday, COUNT(*) as count FROM datlichhen WHERE deleted_at IS NULL GROUP BY weekday ORDER BY weekday";
        $result = $this->conn->query($query);
        $data = array_fill(1, 7, 0);
        while ($row = $result->fetch_assoc()) {
            $data[$row['weekday']] = (int)$row['count'];
        }
        return $data;
    }
    public function getTimeslotStats() {
        $query = "SELECT HOUR(appointment_time) as hour, COUNT(*) as count FROM datlichhen WHERE deleted_at IS NULL GROUP BY hour ORDER BY hour";
        $result = $this->conn->query($query);
        $data = array_fill(0, 24, 0);
        while ($row = $result->fetch_assoc()) {
            $data[(int)$row['hour']] = (int)$row['count'];
        }
        return $data;
    }
} 