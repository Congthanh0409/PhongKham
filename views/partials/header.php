<?php
require_once __DIR__ . '/../../config/dbconnect.php';

// This logic should be in a controller
$db = new Database();
$conn = $db->getConnection();

$gioiThieu = $conn->query("SELECT id, title FROM gioithieu WHERE deleted_at IS NULL");
$dichVu = $conn->query("SELECT id, title FROM dichvu WHERE deleted_at IS NULL");
$taimuihong = $conn->query("SELECT id, title FROM taimuihong WHERE deleted_at IS NULL");
$tinTuc = $conn->query("SELECT id, title FROM tintuc WHERE deleted_at IS NULL");

function renderMenu($result, $action) {
    $count = 0;
    while ($row = $result->fetch_assoc()):
        if ($count > 0 && $count % 4 == 0): ?>
            <li><hr class="dropdown-divider"></li>
        <?php endif; ?>
        <li><a class="dropdown-item" href="<?= $action ?>&id=<?= $row['id'] ?>"><?= $row['title'] ?></a></li>
        <?php $count++;
    endwhile;
}
?>

<style>
    header.navbar {
        background: linear-gradient(to right, #ffffff, #f8f9fa);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 0.5rem 0;
    }

    .navbar-brand img {
        transition: transform 0.3s ease;
    }

    .navbar-brand img:hover {
        transform: scale(1.05);
    }

    .navbar-nav .nav-link {
        color: #2c3e50 !important;
        font-weight: 500;
        padding: 0.8rem 1.2rem !important;
        transition: all 0.3s ease;
        position: relative;
    }

    .navbar-nav .nav-link:hover {
        color: #3498db !important;
    }

    .navbar-nav .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 50%;
        background-color: #3498db;
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    .navbar-nav .nav-link:hover::after {
        width: 70%;
    }

    .dropdown-menu {
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 0.5rem;
        animation: fadeIn 0.3s ease;
    }

    .dropdown-item {
        padding: 0.7rem 1.2rem;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
        color: #3498db;
    }

    .dropdown-divider {
        margin: 0.5rem 0;
        opacity: 0.1;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 991.98px) {
        .navbar-collapse {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 1rem;
        }
    }
</style>

<header class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="index.php?action=home">
            <img src="assets/img/tải xuống.jpg" alt="Logo" style="height: 80px; object-fit: contain;">
        </a>
        <!-- Navbar Toggle Button -->
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=home">Trang Chủ</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link " href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Giới Thiệu
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php renderMenu($gioiThieu, 'index.php?action=gioithieu_detail'); ?>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link " href="#" id="navbarDropdown2" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Dịch Vụ
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown2">
                        <?php renderMenu($dichVu, 'index.php?action=dichvu_detail'); ?>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link " href="#" id="navbarDropdown3" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                        Tai - Mũi - Họng
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown3">
                        <?php renderMenu($taimuihong, 'index.php?action=taimuihong_detail'); ?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=tintuc_list">Tin Tức</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link " href="index.php?action=datlichhen">Đặt Lịch Hẹn</a>
                </li>
                <?php 
                // Use SessionHelper to check if any user is logged in
                $currentUser = SessionHelper::getCurrentUser();
                if($currentUser): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i>
                            <?php echo htmlspecialchars($currentUser['username']); ?>
                            <?php if($currentUser['type'] === 'admin'): ?>
                                <span class="badge bg-warning text-dark ms-1">Admin</span>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="index.php?action=profile"><i class="fas fa-user me-2"></i>Thông tin cá nhân</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a href="index.php?action=hoso_user" class="dropdown-item"><i class="fas fa-file-medical"></i> Hồ sơ khám bệnh</a></li>
                            <?php if($currentUser['type'] === 'admin'): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="index.php?action=admin_dashboard"><i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="index.php?action=logout"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link " href="index.php?action=login">Đăng nhập</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</header> 