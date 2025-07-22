<?php
session_start();

// --- CONTROLLER SETUP ---
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/BannerController.php';
require_once __DIR__ . '/controllers/ChungNhanController.php';
require_once __DIR__ . '/controllers/DatLichHenController.php';
require_once __DIR__ . '/controllers/DichVuController.php';
require_once __DIR__ . '/controllers/GioiThieuController.php';
require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/HoSoController.php';
require_once __DIR__ . '/controllers/TaiMuiHongController.php';
require_once __DIR__ . '/controllers/TinTucController.php';
require_once __DIR__ . '/controllers/UserController.php';

$authController = new AuthController();
$bannerController = new BannerController();
$chungNhanController = new ChungNhanController();
$datLichHenController = new DatLichHenController();
$dichVuController = new DichVuController();
$gioiThieuController = new GioiThieuController();
$homeController = new HomeController();
$hoSoController = new HoSoController();
$taiMuiHongController = new TaiMuiHongController();
$tinTucController = new TinTucController();
$userController = new UserController();

// --- ROUTING ---
$action = $_GET['action'] ?? 'home';

// Universal check for all admin routes
if (strpos($action, 'admin_') === 0) {
    // List of admin actions that do not require authentication
    $open_admin_actions = ['admin_login', 'admin_register', 'admin_logout'];
    if (!in_array($action, $open_admin_actions) && (!isset($_SESSION['admin_role']) || $_SESSION['admin_role'] !== 'admin')) {
        header('Location: index.php?action=admin_login');
        exit;
    }
}


switch ($action) {
    // --- PUBLIC-FACING ROUTES ---
    case 'home':
        $homeController->index();
        break;
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        } else {
            $authController->showLoginForm();
        }
        break;
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->register();
        } else {
            $authController->showRegisterForm();
        }
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'dichvu_detail':
        $dichVuController->show();
        break;
    case 'gioithieu_detail':
        $gioiThieuController->show();
        break;
    case 'taimuihong_detail':
        $taiMuiHongController->show();
        break;
    case 'tintuc_list':
        $tinTucController->list();
        break;
    case 'tintuc_detail':
        $tinTucController->show();
        break;
    case 'profile':
        $userController->profile();
        break;
    case 'hoso_user':
        $hoSoController->userRecords();
        break;
    case 'hoso_detail':
        $hoSoController->detail();
        break;
    case 'datlichhen':
        $datLichHenController->form();
        break;
    case 'check_appointment_status':
        $datLichHenController->checkAppointmentStatus();
        break;

    // --- ADMIN AUTH ROUTES ---
    case 'admin_login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->adminLogin();
        } else {
            $authController->showAdminLoginForm();
        }
        break;
    case 'admin_register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->adminRegister();
        } else {
            $authController->showAdminRegisterForm();
        }
        break;
    case 'admin_logout':
        $authController->adminLogout();
        break;
    case 'admin_editpassword':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->adminEditPassword();
        } else {
            $authController->showAdminEditPasswordForm();
        }
        break;

    // --- ADMIN DASHBOARD ---
    case 'admin_dashboard':
        $userController->adminDashboard();
        break;

    // --- ADMIN BANNER ---
    case 'admin_banner_list':
        $bannerController->list();
        break;
    case 'admin_banner_create':
        $bannerController->adminCreate();
        break;
    case 'admin_banner_edit':
        $bannerController->adminEdit();
        break;
    case 'admin_banner_delete':
        $bannerController->adminDelete();
        break;

    // --- ADMIN CHUNG NHAN ---
    case 'admin_chungnhan_list':
        $chungNhanController->list();
        break;
    case 'admin_chungnhan_create':
        $chungNhanController->adminCreate();
        break;
    case 'admin_chungnhan_edit':
        $chungNhanController->adminEdit();
        break;
    case 'admin_chungnhan_delete':
        $chungNhanController->adminDelete();
        break;

    // --- ADMIN DICH VU ---
    case 'admin_dichvu_list':
        $dichVuController->list();
        break;
    case 'admin_dichvu_create':
        $dichVuController->adminCreate();
        break;
    case 'admin_dichvu_edit':
        $dichVuController->adminEdit();
        break;
    case 'admin_dichvu_delete':
        $dichVuController->adminDelete();
        break;

    // --- ADMIN HO SO BENH AN ---
    case 'admin_hosobenhan_list':
        $hoSoController->adminList();
        break;
    case 'admin_hosobenhan_add':
        $hoSoController->adminCreate();
        break;
    case 'admin_hosobenhan_edit':
        $hoSoController->adminEdit();
        break;
    case 'admin_hosobenhan_view':
        $hoSoController->adminView();
        break;
    case 'admin_hosobenhan_delete':
        $hoSoController->adminDelete();
        break;

    // --- ADMIN TAI MUI HONG ---
    case 'admin_taimuihong_list':
        $taiMuiHongController->list();
        break;
    case 'admin_taimuihong_create':
        $taiMuiHongController->create();
        break;
    case 'admin_taimuihong_edit':
        $taiMuiHongController->edit();
        break;
    case 'admin_taimuihong_delete':
        $taiMuiHongController->delete();
        break;

    // --- ADMIN TIN TUC ---
    case 'admin_tintuc_list':
        $tinTucController->adminList();
        break;
    case 'admin_tintuc_create':
        $tinTucController->adminCreate();
        break;
    case 'admin_tintuc_edit':
        $tinTucController->adminEdit();
        break;
    case 'admin_tintuc_delete':
        $tinTucController->adminDelete();
        break;

    // --- ADMIN GIOI THIEU ---
    case 'admin_gioithieu_list':
        $gioiThieuController->adminList();
        break;
    case 'admin_gioithieu_create':
        $gioiThieuController->adminCreate();
        break;
    case 'admin_gioithieu_edit':
        $gioiThieuController->adminEdit();
        break;
    case 'admin_gioithieu_delete':
        $gioiThieuController->adminDelete();
        break;
    
    // --- ADMIN USER & PERMISSIONS ---
    case 'admin_phanquyen_list':
        $userController->adminPhanQuyen();
        break;
    case 'admin_dieuchinhquyenhang_list':
        $userController->adminDieuChinhQuyenHang();
        break;
    case 'admin_dieuchinhquyenhang_create':
        $userController->adminDieuChinhQuyenHangCreate();
        break;
    case 'admin_dieuchinhquyenhang_edit':
        $userController->adminDieuChinhQuyenHangEdit();
        break;
    case 'admin_dieuchinhquyenhang_delete':
        $userController->adminDieuChinhQuyenHangDelete();
        break;

    // --- ADMIN DAT LICH HEN ---
    case 'admin_datlichhen_list':
        $datLichHenController->adminList();
        break;
    case 'admin_datlichhen_create':
        $datLichHenController->adminCreate();
        break;
    case 'admin_datlichhen_statistics':
        $datLichHenController->adminStatistics();
        break;
    case 'admin_datlichhen_update_status':
        $datLichHenController->adminUpdateStatus();
        break;
    case 'admin_datlichhen_delete':
        $datLichHenController->adminDelete();
        break;

    // --- ADMIN SOCIAL MEDIA ---
    case 'admin_mangxahoi_list':
    case 'admin_socialmedia':
        $userController->adminSocialMedia();
        break;

    // --- DEFAULT ---
    default:
        if (strpos($action, 'admin_') === 0) {
            header('Location: index.php?action=admin_dashboard');
        } else {
            header('Location: index.php?action=home');
        }
        exit;
} 