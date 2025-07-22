<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';

class AuthController {
    
    public function showLoginForm() {
        // Check if user is already logged in
        if (isset($_SESSION['user_user_id'])) {
            if ($_SESSION['user_role'] === 'user') {
                header("Location: index.php?action=home");
            } else {
                // Redirect admins to their dashboard, assuming a route exists
                header("Location: index.php?action=login"); 
            }
            exit();
        }

        // Check for registration success message
        if (isset($_SESSION['register_success'])) {
            $success = $_SESSION['register_success'];
            unset($_SESSION['register_success']);
        }
        
        require_once __DIR__ . '/../views/nguoidung/login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=login');
            exit;
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $error = "Vui lòng nhập đầy đủ thông tin đăng nhập.";
            require_once __DIR__ . '/../views/nguoidung/login.php';
            return;
        }
        
        $userModel = new User();
        $user = $userModel->getUserByUsernameOrEmail($username);
        
        if ($user && password_verify($password, $user['password'])) {
            // Store data in session variables for USER login
            $_SESSION["user_user_id"] = $user["id"];
            $_SESSION["user_username"] = $user["username"];
            $_SESSION["user_role"] = $user["role"];
            $_SESSION["user_email"] = $user["email"];
            
            // If this is the first login (no benhnhan record), create one
            if (!isset($user["fullname"])) {
                $userModel->createBenhNhanRecord($user["id"], $user["username"], $user["email"]);
            }
            
            if (isset($_POST['remember']) && $_POST['remember'] == 'on') {
                setcookie("user_login", $user["username"], time() + (30 * 24 * 60 * 60), "/");
                setcookie("user_id", $user["id"], time() + (30 * 24 * 60 * 60), "/");
            }
            
            // Redirect based on role
            if ($user['role'] === 'admin') {
                header('Location: index.php?action=admin_dashboard');
            } else {
                header('Location: index.php?action=home');
            }
            exit();
        } else if (!$user) {
            $error = "Tên đăng nhập hoặc email không tồn tại.";
        } else {
            $error = "Mật khẩu không đúng.";
        }
        
        // If login fails, show the form again with an error
        require_once __DIR__ . '/../views/nguoidung/login.php';
    }

    public function showRegisterForm() {
        require_once __DIR__ . '/../views/nguoidung/register.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=register');
            exit;
        }

        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if ($password !== $confirm_password) {
            $register_error = "Mật khẩu xác nhận không khớp!";
            require_once __DIR__ . '/../views/nguoidung/register.php';
            return;
        }

        $userModel = new User();

        if ($userModel->getUserByUsernameOrEmail($username)) {
            $register_error = "Tên đăng nhập đã tồn tại.";
            require_once __DIR__ . '/../views/nguoidung/register.php';
            return;
        } elseif ($userModel->getUserByUsernameOrEmail($email)) {
            $register_error = "Email đã tồn tại.";
            require_once __DIR__ . '/../views/nguoidung/register.php';
            return;
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            if ($userModel->createUser($username, $email, $password_hash)) {
                $_SESSION['register_success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                header("Location: index.php?action=login");
                exit();
            } else {
                $register_error = "Có lỗi xảy ra khi đăng ký.";
                require_once __DIR__ . '/../views/nguoidung/register.php';
            }
        }
    }

    public function logout() {
        // Clear only user session variables
        unset($_SESSION['user_user_id']);
        unset($_SESSION['user_username']);
        unset($_SESSION['user_role']);
        unset($_SESSION['user_email']);
        header('Location: index.php?action=login');
        exit;
    }

    // ADMIN AUTH METHODS
    public function showAdminLoginForm() {
        // If already logged in as admin, redirect to dashboard
        if (isset($_SESSION['admin_user_id']) && isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'admin') {
            header("Location: index.php?action=admin_dashboard");
            exit();
        }
        $login_error = $_SESSION['login_error'] ?? null;
        unset($_SESSION['login_error']);
        require __DIR__ . '/../views/quantri/auth/login.php';
    }

    public function adminLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=admin_login');
            exit;
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        if (empty($username) || empty($password)) {
            $login_error = "Vui lòng nhập đầy đủ thông tin đăng nhập.";
            $_SESSION['login_error'] = $login_error;
            header("Location: index.php?action=admin_login");
            exit();
        }

        $userModel = new User();
        $user = $userModel->getUserByUsernameOrEmail($username);
        if ($user && $user['role'] === 'admin' && password_verify($password, $user['password'])) {
            // Store data in session variables for ADMIN login
            $_SESSION["admin_user_id"] = $user["id"];
            $_SESSION["admin_username"] = $user["username"];
            $_SESSION["admin_role"] = $user["role"];
            $_SESSION["admin_email"] = $user["email"];
            if (isset($_POST['remember']) && $_POST['remember'] == 'on') {
                setcookie("admin_login", $user["username"], time() + (30 * 24 * 60 * 60), "/");
                setcookie("admin_id", $user["id"], time() + (30 * 24 * 60 * 60), "/");
            }
            header("Location: index.php?action=admin_dashboard");
            exit();
        } else {
            $login_error = "Tên đăng nhập hoặc mật khẩu không chính xác hoặc bạn không có quyền truy cập.";
            $_SESSION['login_error'] = $login_error;
            header("Location: index.php?action=admin_login");
            exit();
        }
    }

    public function showAdminRegisterForm() {
        $register_error = $_SESSION['register_error'] ?? null;
        $register_success = $_SESSION['register_success'] ?? null;
        $errors = $_SESSION['register_errors'] ?? [];
        unset($_SESSION['register_error'], $_SESSION['register_success'], $_SESSION['register_errors']);
        require __DIR__ . '/../views/quantri/auth/register.php';
    }

    public function adminRegister() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=admin_register');
            exit;
        }

        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        if (strlen($username) < 3) {
            $errors['username'] = "Tên đăng nhập phải có ít nhất 3 ký tự";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email không hợp lệ";
        }
        if (strlen($password) < 6) {
            $errors['password'] = "Mật khẩu phải có ít nhất 6 ký tự";
        }
        if ($password !== $confirm_password) {
            $errors['confirm_password'] = "Mật khẩu xác nhận không khớp";
        }
        $userModel = new User();
        if ($userModel->getUserByUsernameOrEmail($username)) {
            $errors['username'] = "Tên đăng nhập đã tồn tại.";
        } elseif ($userModel->getUserByUsernameOrEmail($email)) {
            $errors['email'] = "Email đã tồn tại.";
        }
        if (empty($errors)) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            if ($userModel->createUserWithRole($username, $email, $password_hash, 'user')) {
                $_SESSION['register_success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                header("Location: index.php?action=admin_login");
                exit();
            } else {
                $register_error = "Có lỗi xảy ra khi đăng ký.";
                require_once __DIR__ . '/../views/quantri/auth/register.php';
            }
        } else {
            $register_error = "Vui lòng kiểm tra lại thông tin.";
            require_once __DIR__ . '/../views/quantri/auth/register.php';
        }
    }

    public function adminLogout() {
        // Clear only admin session variables
        unset($_SESSION['admin_user_id']);
        unset($_SESSION['admin_username']);
        unset($_SESSION['admin_role']);
        unset($_SESSION['admin_email']);
        header("Location: index.php?action=admin_login");
        exit;
    }

    public function showAdminEditPasswordForm() {
        $error_message = $_SESSION['editpw_error'] ?? null;
        $success_message = $_SESSION['editpw_success'] ?? null;
        unset($_SESSION['editpw_error'], $_SESSION['editpw_success']);
        require __DIR__ . '/../views/quantri/auth/editpassword.php';
    }

    public function adminEditPassword() {
        $currentUser = SessionHelper::getCurrentUser();
        if (!$currentUser || $currentUser['role'] !== 'admin') {
            header('Location: index.php?action=admin_login');
            exit;
        }
        $userModel = new User();
        $user = $userModel->getUserByUsernameOrEmail($currentUser['username']);
        $error_message = "";
        $success_message = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];
            if (!password_verify($current_password, $user['password'])) {
                $error_message = "Mật khẩu hiện tại không đúng.";
            } elseif ($new_password !== $confirm_password) {
                $error_message = "Mật khẩu mới và xác nhận mật khẩu không khớp.";
            } elseif (strlen($new_password) < 6) {
                $error_message = "Mật khẩu mới phải có ít nhất 6 ký tự.";
            } else {
                $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $db = new Database();
                $conn = $db->getConnection();
                $update_sql = "UPDATE users SET password = ? WHERE username = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param('ss', $new_password_hashed, $currentUser['username']);
                if ($update_stmt->execute()) {
                    $success_message = "Đổi mật khẩu thành công.";
                    $_SESSION['editpw_success'] = $success_message;
                    header('Location: index.php?action=admin_dashboard');
                    exit;
                } else {
                    $error_message = "Có lỗi xảy ra, vui lòng thử lại.";
                }
            }
        }
        $_SESSION['editpw_error'] = $error_message;
        header('Location: index.php?action=admin_editpassword');
        exit;
    }
} 