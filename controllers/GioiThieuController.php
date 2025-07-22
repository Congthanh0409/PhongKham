<?php
require_once __DIR__ . '/../models/GioiThieu.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';

class GioiThieuController {
    public function show() {
        if (!isset($_GET['id'])) {
            header('Location: index.php');
            exit;
        }

        $id = $_GET['id'];
        $gioiThieuModel = new GioiThieu();
        $article = $gioiThieuModel->getGioiThieuById($id);
        $otherArticles = $gioiThieuModel->getOtherGioiThieu($id);

        if (!$article) {
            echo "Nội dung không tồn tại.";
            exit;
        }

        $title = $article['title'];

        ob_start();
        require_once __DIR__ . '/../views/nguoidung/gioithieu_detail.php';
        $content = ob_get_clean();

        require_once __DIR__ . '/../views/layouts/app.php';
    }

    // ADMIN: List all records
    public function adminList() {
        $gioiThieuModel = new GioiThieu();
        $error = '';
        $records = $gioiThieuModel->getAllAdmin();
        $title = 'Danh Sách Giới Thiệu';
        ob_start();
        require_once __DIR__ . '/../views/quantri/gioithieu/index.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    // ADMIN: Create record
    public function adminCreate() {
        $error = '';
        $titleVal = '';
        $contentVal = '';
        $currentUser = SessionHelper::getCurrentUser();
        $user_id = $currentUser ? $currentUser['id'] : null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titleVal = $_POST['title'] ?? '';
            $contentVal = $_POST['content'] ?? '';
            $gioiThieuModel = new GioiThieu();
            if ($gioiThieuModel->create($titleVal, $contentVal, $user_id)) {
                header('Location: index.php?action=admin_gioithieu_list');
                exit;
            } else {
                $error = 'Có lỗi xảy ra khi lưu mục.';
            }
        }
        $pageTitle = 'Tạo Giới Thiệu Mới';
        ob_start();
        require_once __DIR__ . '/../views/quantri/gioithieu/create.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    // ADMIN: Edit record
    public function adminEdit() {
        $error = '';
        $id = $_GET['id'] ?? null;
        $gioiThieuModel = new GioiThieu();

        if (!$id) {
            header('Location: index.php?action=admin_gioithieu_list');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titleVal = $_POST['title'] ?? '';
            $contentVal = $_POST['content'] ?? '';
            $currentUser = SessionHelper::getCurrentUser();
            $user_id = $currentUser ? $currentUser['id'] : null;

            $result = $gioiThieuModel->update($id, $titleVal, $contentVal, $user_id);

            if ($result === true) {
                header('Location: index.php?action=admin_gioithieu_list');
                exit;
            } else {
                // If update fails, store the specific error message
                $error = 'Có lỗi xảy ra khi cập nhật: ' . $result;
            }
        }

        // Fetch the record for display
        $record = $gioiThieuModel->getGioiThieuById($id);
        if (!$record) {
            header('Location: index.php?action=admin_gioithieu_list');
            exit;
        }

        $pageTitle = 'Chỉnh Sửa Giới Thiệu';
        ob_start();
        require_once __DIR__ . '/../views/quantri/gioithieu/edit.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    // ADMIN: Delete record (soft delete)
    public function adminDelete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $gioiThieuModel = new GioiThieu();
            $result = $gioiThieuModel->softDelete($id);
            if ($result !== true) {
                // If delete fails, you can set a session flash message to show the error
                $_SESSION['error_message'] = 'Lỗi khi xóa: ' . $result;
            }
        }
        header('Location: index.php?action=admin_gioithieu_list');
        exit;
    }
}

