<?php

class HomeController {
    public function index() {
        $title = 'Trang Chủ - Phòng Khám Tai Mũi Họng';

        // --- Data Fetching ---
        // Banner
        require_once __DIR__ . '/../controllers/BannerController.php';
        $bannerController = new BannerController();
        ob_start();
        $bannerController->showBanner();
        $bannerContent = ob_get_clean();

        // Dich Vu
        require_once __DIR__ . '/../controllers/DichVuController.php';
        $dichVuController = new DichVuController();
        ob_start();
        $dichVuController->showServices();
        $dichVuContent = ob_get_clean();
        
        // Chung Nhan
        require_once __DIR__ . '/../controllers/ChungNhanController.php';
        $chungNhanController = new ChungNhanController();
        ob_start();
        $chungNhanController->showChungNhan();
        $chungNhanContent = ob_get_clean();

        // Tin Tuc
        require_once __DIR__ . '/../controllers/TinTucController.php';
        $tinTucController = new TinTucController();
        ob_start();
        $tinTucController->showRecentNews();
        $tinTucContent = ob_get_clean();

        // --- View Rendering ---
        ob_start();
        require_once __DIR__ . '/../views/nguoidung/home.php';
        $content = ob_get_clean();

        // Render the layout with the content
        require_once __DIR__ . '/../views/layouts/app.php';
    }
} 