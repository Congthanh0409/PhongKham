<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';

class UserController {
    public function profile() {
        // Use SessionHelper to check authentication
        $currentUser = SessionHelper::getCurrentUser();
        if (!$currentUser) {
            header("Location: index.php?action=login");
            exit();
        }

        $user_id = $currentUser['id'];
        $userModel = new User();
        $success_message = '';
        $error_message = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['update_profile'])) {
                // Handle profile update
                $username = $_POST['username'];
                $fullname = $_POST['fullname'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];
                $dob = $_POST['dob'];

                $result = $userModel->updateUserProfile($user_id, $username, $fullname, $email, $phone, $address, $dob);
                if ($result === true) {
                    $success_message = "Thông tin đã được cập nhật thành công!";
                } else {
                    $error_message = $result;
                }
            } elseif (isset($_POST['avatar_upload'])) {
                // Handle avatar upload attempt
                if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] != 0) {
                    $error_message = "Không có file ảnh được chọn hoặc lỗi upload. Mã lỗi: " . ($_FILES['avatar']['error'] ?? 'No file');
                    error_log("Avatar upload error for user $user_id: " . ($_FILES['avatar']['error'] ?? 'No file uploaded'));
                } else {
                    // Handle avatar upload
                    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                    $filename = $_FILES['avatar']['name'];
                    $filetype = pathinfo($filename, PATHINFO_EXTENSION);

                    if (in_array(strtolower($filetype), $allowed)) {
                        $new_filename = "avatar_" . $user_id . "_" . time() . "." . $filetype;
                        $upload_path = __DIR__ . "/../nguoidung/uploads/avatars/" . $new_filename;
                        
                        // Create directory if it doesn't exist
                        $upload_dir = dirname($upload_path);
                        if (!is_dir($upload_dir)) {
                            mkdir($upload_dir, 0755, true);
                        }
                        
                        // Debug information
                        error_log("Avatar upload attempt - User ID: $user_id, File: $filename, Upload path: $upload_path");
                        
                        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $upload_path)) {
                            if ($userModel->updateUserAvatar($user_id, $new_filename)) {
                                $success_message = "Ảnh đại diện đã được cập nhật thành công!";
                                error_log("Avatar upload successful for user $user_id");
                            } else {
                                $error_message = "Lỗi cập nhật avatar trong database.";
                                error_log("Database update failed for user $user_id avatar");
                            }
                        } else {
                            $error_message = "Không thể tải lên ảnh đại diện. Lỗi: " . (error_get_last() ? error_get_last()['message'] : 'Unknown error');
                            error_log("File upload failed for user $user_id: " . (error_get_last() ? error_get_last()['message'] : 'Unknown error'));
                        }
                    } else {
                        $error_message = "Chỉ chấp nhận file ảnh định dạng JPG, JPEG, PNG hoặc GIF.";
                        error_log("Invalid file type for user $user_id: $filetype");
                    }
                }
            }
        }

        $user = $userModel->getUserProfile($user_id);
        if (!$user) {
            // Handle user not found
            echo "Không tìm thấy thông tin người dùng.";
            exit;
        }

        $title = 'Thông tin cá nhân';
        
        ob_start();
        require_once __DIR__ . '/../views/nguoidung/profile.php';
        $content = ob_get_clean();

        require_once __DIR__ . '/../views/layouts/app.php';
    }

    // ADMIN: List all users for phanquyen
    public function adminPhanQuyen() {
        $userModel = new User();
        $users = $userModel->getAllUsers();
        $title = 'Phân Quyền';
        ob_start();
        require_once __DIR__ . '/../views/quantri/phanquyen/index.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    // ADMIN: List all accounts for dieuchinhquyenhang
    public function adminDieuChinhQuyenHang() {
        $userModel = new User();
        $users = $userModel->getAllUsers();
        $currentUser = SessionHelper::getCurrentUser();
        $currentRole = $currentUser ? $currentUser['role'] : null;
        $success = isset($_GET['success']);
        $title = 'Quản lý tài khoản';
        ob_start();
        require_once __DIR__ . '/../views/quantri/dieuchinhquyenhang/index.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    // ADMIN: Create account
    public function adminDieuChinhQuyenHangCreate() {
        $error = '';
        $username = '';
        $email = '';
        $role = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $role = $_POST['role'] ?? '';
            if (empty($username) || empty($password) || empty($email) || empty($role)) {
                $error = 'Vui lòng điền đầy đủ thông tin.';
            } else {
                $userModel = new User();
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                if ($userModel->createUserWithRole($username, $email, $hashedPassword, $role)) {
                    $_SESSION['success_message'] = 'Thêm tài khoản thành công!';
                    header('Location: index.php?action=admin_dieuchinhquyenhang_list');
                    exit;
                } else {
                    $error = 'Lỗi khi thêm thành viên mới.';
                }
            }
        }
        $title = 'Thêm tài khoản mới';
        ob_start();
        require_once __DIR__ . '/../views/quantri/dieuchinhquyenhang/create.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    // ADMIN: Edit account role
    public function adminDieuChinhQuyenHangEdit() {
        $userModel = new User();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=admin_dieuchinhquyenhang_list');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newRole = $_POST['role'] ?? '';
            if ($userModel->updateUserRole($id, $newRole)) {
                $_SESSION['success_message'] = 'Cập nhật quyền hạn thành công!';
                header('Location: index.php?action=admin_dieuchinhquyenhang_list');
                exit;
            } else {
                $error = 'Có lỗi xảy ra khi cập nhật quyền!';
            }
        }
        
        $editUser = $userModel->getUserById($id);
        if (!$editUser) {
            header('Location: index.php?action=admin_dieuchinhquyenhang_list');
            exit;
        }

        $title = 'Chỉnh sửa quyền hạn';
        ob_start();
        require_once __DIR__ . '/../views/quantri/dieuchinhquyenhang/edit.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    // ADMIN: Delete account
    public function adminDieuChinhQuyenHangDelete() {
        $id = $_GET['id'] ?? null;
        $userModel = new User();
        if ($id && $userModel->deleteUser($id)) {
            $_SESSION['success_message'] = 'Xóa tài khoản thành công!';
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi xóa tài khoản.';
        }
        header('Location: index.php?action=admin_dieuchinhquyenhang_list');
        exit;
    }

    // ADMIN: Social media management
    public function adminSocialMedia() {
        require_once __DIR__ . '/../models/SocialMedia.php';
        $socialModel = new SocialMedia();
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $facebook = $_POST['facebook'] ?: 'Đang cập nhật';
            $zalo = $_POST['zalo'] ?: 'Đang cập nhật';
            $tiktok = $_POST['tiktok'] ?: 'Đang cập nhật';
            $phone_number = $_POST['phone_number'] ?: 'Đang cập nhật';
            $company_email = $_POST['company_email'] ?: 'Đang cập nhật';
            $company_address = $_POST['company_address'] ?: 'Đang cập nhật';
            if ($socialModel->update($id, $facebook, $zalo, $tiktok, $phone_number, $company_email, $company_address)) {
                header('Location: index.php?action=admin_socialmedia');
                exit;
            } else {
                $error = 'Có lỗi xảy ra khi cập nhật thông tin.';
            }
        }
        $records = $socialModel->getAll();
        $title = 'Quản Lý Mạng Xã Hội';
        ob_start();
        require_once __DIR__ . '/../views/quantri/mangxahoi/index.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    // ADMIN: Dashboard
    public function adminDashboard() {
        require_once __DIR__ . '/../models/User.php';
        require_once __DIR__ . '/../models/DichVu.php';
        require_once __DIR__ . '/../models/TaiMuiHong.php';
        require_once __DIR__ . '/../models/DatLichHen.php';
        $userModel = new User();
        $dichVuModel = new DichVu();
        $taiMuiHongModel = new TaiMuiHong();
        $datLichHenModel = new DatLichHen();
        $total_services = count($dichVuModel->getAllServices());
        $total_braces = count($taiMuiHongModel->getAllArticles());
        $total_appointments = $datLichHenModel->getTotalAppointments();
        $total_users = count($userModel->getAllUsers());
        $title = 'Quản Trị Đa Khoa Tai - Mũi Họng';
        ob_start();
        require_once __DIR__ . '/../views/quantri/dashboard.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    // ADMIN: Alias for mangxahoi (same as adminSocialMedia)
    public function adminMangXaHoi() {
        $this->adminSocialMedia();
    }

    public function admin_editpassword()
    {
        $error_message = '';
        $success_message = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Business logic for changing password
        }

        $title = 'Đổi mật khẩu';
        ob_start();
        require_once 'views/quantri/auth/editpassword.php';
        $content = ob_get_clean();
        require_once 'views/layouts/admin.php';
    }

    public function admin_phanquyen_list()
    {
        $userModel = new User();
        $users = $userModel->getAllUsers();

        $title = 'Phân Quyền';
        ob_start();
        require_once 'views/quantri/phanquyen/index.php';
        $content = ob_get_clean();
        require_once 'views/layouts/admin.php';
    }
} 