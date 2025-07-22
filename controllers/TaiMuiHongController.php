<?php
require_once __DIR__ . '/../models/TaiMuiHong.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';

class TaiMuiHongController {
    public function show() {
        if (!isset($_GET['id'])) {
            header('Location: index.php');
            exit;
        }

        $id = $_GET['id'];
        $taiMuiHongModel = new TaiMuiHong();
        $article = $taiMuiHongModel->getArticleById($id);
        $otherArticles = $taiMuiHongModel->getOtherArticles($id);

        if (!$article) {
            echo "Nội dung không tồn tại.";
            exit;
        }

        $title = $article['title'];

        ob_start();
        require_once __DIR__ . '/../views/nguoidung/taimuihong_detail.php';
        $content = ob_get_clean();

        require_once __DIR__ . '/../views/layouts/app.php';
    }

    public function list() {
        $taiMuiHongModel = new TaiMuiHong();
        $articles = $taiMuiHongModel->getAllArticles();
        $title = 'Danh Sách Tai Mũi Họng';
        ob_start();
        require_once __DIR__ . '/../views/quantri/taimuihong/index.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    public function create() {
        $error = '';
        $titleVal = '';
        $contentVal = '';
        $currentUser = SessionHelper::getCurrentUser();
        $user = [ 'id' => $currentUser ? $currentUser['id'] : null, 'username' => $currentUser ? $currentUser['username'] : '' ];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titleVal = $_POST['title'] ?? '';
            $contentVal = $_POST['content'] ?? '';
            $taiMuiHongModel = new TaiMuiHong();
            if ($taiMuiHongModel->createArticle($titleVal, $contentVal, $user['id'])) {
                header('Location: index.php?action=admin_taimuihong_list');
                exit;
            } else {
                $error = 'Có lỗi xảy ra khi lưu mục.';
            }
        }
        $pageTitle = 'Tạo Mới Tai Mũi Họng';
        ob_start();
        require_once __DIR__ . '/../views/quantri/taimuihong/create.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    public function edit() {
        $error = '';
        $id = $_GET['id'] ?? null;
        $taiMuiHongModel = new TaiMuiHong();
        if (!$id) {
            header('Location: index.php?action=admin_taimuihong_list');
            exit;
        }
        $article = $taiMuiHongModel->getArticleById($id);
        if (!$article) {
            header('Location: index.php?action=admin_taimuihong_list');
            exit;
        }
        $title = $article['title'];
        $content = $article['content'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            if ($taiMuiHongModel->updateArticle($id, $title, $content)) {
                header('Location: index.php?action=admin_taimuihong_list');
                exit;
            } else {
                $error = 'Có lỗi xảy ra khi cập nhật mục.';
            }
        }
        $pageTitle = 'Chỉnh Sửa Tai Mũi Họng';
        ob_start();
        require_once __DIR__ . '/../views/quantri/taimuihong/edit.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $taiMuiHongModel = new TaiMuiHong();
            $taiMuiHongModel->softDeleteArticle($id);
        }
        header('Location: index.php?action=admin_taimuihong_list');
        exit;
    }
} 