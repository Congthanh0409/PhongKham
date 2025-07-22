<?php
require_once __DIR__ . '/../models/DatLichHen.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';

class DatLichHenController {
    public function form() {
        $message = '';
        $message_type = '';
        
        // Use SessionHelper to get current user
        $currentUser = SessionHelper::getCurrentUser();
        if (!$currentUser) {
            header('Location: index.php?action=login');
            exit;
        }
        
        $user_id = $currentUser['id'];
        $datlichModel = new DatLichHen();
        $patient = $datlichModel->getPatient($user_id);
        if (!$patient) {
            $error_message = "Không tìm thấy thông tin bệnh nhân của tài khoản này.";
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book'])) {
            $name = $patient['fullname'];
            $phone = $patient['phone'];
            $email = $patient['email'];
            $appointment_date = $_POST['appointment_date'];
            $appointment_time = $_POST['appointment_time'];
            if (empty($appointment_date) || empty($appointment_time)) {
                $error_message = "Vui lòng chọn ngày và giờ hẹn hợp lệ.";
            } else {
                $result = $datlichModel->createAppointment($name, $phone, $email, $appointment_date, $appointment_time, $user_id);
                if ($result) {
                    $success_message = "Lịch hẹn đã được đặt thành công! Vui lòng chờ xác nhận từ phòng khám.";
                } else {
                    $error_message = "Lỗi khi đặt lịch.";
                }
            }
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_appointment'])) {
            // Handle appointment editing
            $appointment_id = (int)$_POST['appointment_id'];
            $appointment_date = $_POST['appointment_date'];
            $appointment_time = $_POST['appointment_time'];
            
            // Debug: Log the received values
            error_log("DEBUG: Edit appointment - ID: $appointment_id, Date: $appointment_date, Time: $appointment_time");
            
            if (empty($appointment_date) || empty($appointment_time)) {
                $error_message = "Vui lòng chọn ngày và giờ hẹn hợp lệ.";
            } else {
                // Check if user owns this appointment and it's still waiting
                $appointment = $datlichModel->getAppointmentById($appointment_id);
                if ($appointment && $appointment['created_by'] == $user_id && $appointment['confirmed'] == 0) {
                    $result = $datlichModel->updateAppointment($appointment_id, $appointment_date, $appointment_time);
                    if ($result) {
                        $success_message = "Lịch hẹn đã được cập nhật thành công!";
                        error_log("DEBUG: Appointment updated successfully");
                    } else {
                        $error_message = "Lỗi khi cập nhật lịch hẹn.";
                        error_log("DEBUG: Failed to update appointment");
                    }
                } else {
                    $error_message = "Không thể chỉnh sửa lịch hẹn này.";
                    error_log("DEBUG: Cannot edit appointment - user mismatch or already confirmed");
                }
            }
        } elseif (isset($_GET['delete_id'])) {
            // Handle appointment deletion by user
            $appointment_id = (int)$_GET['delete_id'];
            
            // Debug: Log the deletion attempt
            error_log("DEBUG: Attempting to delete appointment ID: $appointment_id for user: $user_id");
            
            // Check if user owns this appointment and it's still waiting
            $appointment = $datlichModel->getAppointmentById($appointment_id);
            error_log("DEBUG: Found appointment: " . ($appointment ? "yes" : "no"));
            
            if ($appointment && $appointment['created_by'] == $user_id && $appointment['confirmed'] == 0) {
                error_log("DEBUG: User can delete this appointment");
                if ($datlichModel->deleteAppointment($appointment_id)) {
                    $success_message = "Lịch hẹn đã được hủy thành công!";
                    error_log("DEBUG: Appointment deleted successfully");
                    
                    // If this is an AJAX request, return JSON response
                    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => true, 'message' => $success_message]);
                        exit;
                    }
                } else {
                    $error_message = "Lỗi khi hủy lịch hẹn.";
                    error_log("DEBUG: Failed to delete appointment");
                    
                    // If this is an AJAX request, return JSON response
                    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => $error_message]);
                        exit;
                    }
                }
            } else {
                $error_message = "Không thể hủy lịch hẹn này.";
                error_log("DEBUG: User cannot delete this appointment - user_id: " . ($appointment['created_by'] ?? 'null') . ", confirmed: " . ($appointment['confirmed'] ?? 'null'));
                
                // If this is an AJAX request, return JSON response
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => $error_message]);
                    exit;
                }
            }
        }
        $appointments = $datlichModel->getAppointments($user_id);
        $title = 'Đặt Lịch Hẹn';
        ob_start();
        require_once __DIR__ . '/../views/nguoidung/datlichhen.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/app.php';
    }

    // AJAX endpoint to check appointment status
    public function checkAppointmentStatus() {
        // Use SessionHelper to get current user
        $currentUser = SessionHelper::getCurrentUser();
        if (!$currentUser) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        
        $user_id = $currentUser['id'];
        $datlichModel = new DatLichHen();
        $appointments = $datlichModel->getAppointments($user_id);
        
        // Return appointment statuses as JSON
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'appointments' => $appointments
        ]);
        exit;
    }

    // ADMIN: List all appointments
    public function adminList() {
        $datlichModel = new DatLichHen();
        
        // Get search parameters
        $search_name = trim($_GET['search_name'] ?? '');
        $search_phone = trim($_GET['search_phone'] ?? '');
        
        // Get appointments with search filter
        $appointments = $datlichModel->getAllAppointmentsWithSearch($search_name, $search_phone);
        
        $message = $_SESSION['message'] ?? '';
        $message_type = $_SESSION['message_type'] ?? '';
        unset($_SESSION['message'], $_SESSION['message_type']);
        
        $title = 'Quản lý lịch hẹn';
        ob_start();
        require_once __DIR__ . '/../views/quantri/datlichhen/index.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    // ADMIN: Update appointment status
    public function adminUpdateStatus() {
        if (isset($_GET['update_id']) && isset($_GET['status'])) {
            $update_id = (int)$_GET['update_id'];
            $new_status = (int)$_GET['status'];
            $datlichModel = new DatLichHen();
            if ($datlichModel->updateStatus($update_id, $new_status)) {
                $_SESSION['message'] = 'Cập nhật trạng thái thành công!';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Lỗi khi cập nhật trạng thái!';
                $_SESSION['message_type'] = 'danger';
            }
        }
        header('Location: index.php?action=admin_datlichhen_list');
        exit;
    }

    // ADMIN: Appointment statistics
    public function adminStatistics() {
        $datlichModel = new DatLichHen();
        $total_appointments = $datlichModel->getTotalAppointments();
        $confirmed_appointments = $datlichModel->getConfirmedAppointments();
        $pending_appointments = $total_appointments - $confirmed_appointments;
        $monthly_data = $datlichModel->getMonthlyStats();
        $weekday_data = $datlichModel->getWeekdayStats();
        $timeslot_data = $datlichModel->getTimeslotStats();
        $title = 'Thống kê lịch hẹn';
        ob_start();
        require_once __DIR__ . '/../views/quantri/datlichhen/statistics.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    // ADMIN: Create new appointment
    public function adminCreate() {
        $error = '';
        $success = '';
        $form_data = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $appointment_date = $_POST['appointment_date'] ?? '';
            $appointment_time = $_POST['appointment_time'] ?? '';
            $confirmed = (int)($_POST['confirmed'] ?? 0);

            // Validation
            if (empty($name) || empty($phone) || empty($email) || empty($appointment_date) || empty($appointment_time)) {
                $error = 'Vui lòng điền đầy đủ thông tin bắt buộc.';
                $form_data = $_POST;
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Email không hợp lệ.';
                $form_data = $_POST;
            } elseif (strtotime($appointment_date) < strtotime(date('Y-m-d'))) {
                $error = 'Ngày hẹn không thể là ngày trong quá khứ.';
                $form_data = $_POST;
            } else {
                $datlichModel = new DatLichHen();
                if ($datlichModel->createAppointmentByAdmin($name, $phone, $email, $appointment_date, $appointment_time, '', $confirmed)) {
                    $success = 'Lịch hẹn đã được tạo thành công!';
                    $form_data = []; // Clear form data
                } else {
                    $error = 'Có lỗi xảy ra khi tạo lịch hẹn.';
                    $form_data = $_POST;
                }
            }
        }

        $title = 'Thêm lịch hẹn mới';
        ob_start();
        require_once __DIR__ . '/../views/quantri/datlichhen/create.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    // ADMIN: Delete appointment
    public function adminDelete() {
        if (isset($_GET['id'])) {
            $appointment_id = (int)$_GET['id'];
            $datlichModel = new DatLichHen();
            
            // Check if appointment exists
            $appointment = $datlichModel->getAppointmentById($appointment_id);
            if ($appointment) {
                if ($datlichModel->deleteAppointment($appointment_id)) {
                    $_SESSION['message'] = 'Lịch hẹn đã được xóa thành công!';
                    $_SESSION['message_type'] = 'success';
                } else {
                    $_SESSION['message'] = 'Lỗi khi xóa lịch hẹn!';
                    $_SESSION['message_type'] = 'danger';
                }
            } else {
                $_SESSION['message'] = 'Không tìm thấy lịch hẹn!';
                $_SESSION['message_type'] = 'danger';
            }
        } else {
            $_SESSION['message'] = 'ID lịch hẹn không hợp lệ!';
            $_SESSION['message_type'] = 'danger';
        }
        
        header('Location: index.php?action=admin_datlichhen_list');
        exit;
    }
} 