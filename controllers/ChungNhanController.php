<?php
require_once __DIR__ . '/../models/ChungNhan.php';

class ChungNhanController {
    public function showChungNhan() {
        $chungNhanModel = new ChungNhan();
        $certifications = $chungNhanModel->getAllCertifications();
        require __DIR__ . '/../views/partials/chungnhan.php';
    }

    public function list() {
        $chungNhanModel = new ChungNhan();
        $certifications = $chungNhanModel->getAllCertifications();
        $title = 'Danh Sách Chứng Nhận';
        ob_start();
        require_once __DIR__ . '/../views/quantri/chungnhan/index.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    public function adminCreate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['certification_image'])) {
            $chungNhanModel = new ChungNhan();
            $image_url = '';

            if (isset($_FILES['certification_image']) && $_FILES['certification_image']['error'] == 0) {
                $target_dir = "quantri/assets/image/";
                $target_file = $target_dir . basename($_FILES["certification_image"]["name"]);
                if (move_uploaded_file($_FILES["certification_image"]["tmp_name"], $target_file)) {
                    $image_url = basename($_FILES["certification_image"]["name"]);
                } else {
                    $_SESSION['error_message'] = "Sorry, there was an error uploading your file.";
                }
            } else {
                $_SESSION['error_message'] = "No file uploaded or an error occurred.";
            }

            if (empty($_SESSION['error_message'])) {
                if ($chungNhanModel->create($image_url)) {
                    $_SESSION['success_message'] = 'Thêm chứng nhận thành công!';
                } else {
                    $_SESSION['error_message'] = 'Không thể tạo chứng nhận.';
                }
            }
            header('Location: index.php?action=admin_chungnhan_list');
            exit;
        }
        $title = 'Thêm Chứng Nhận';
        ob_start();
        require_once __DIR__ . '/../views/quantri/chungnhan/create.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    public function adminEdit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=admin_chungnhan_list');
            exit;
        }

        $chungNhanModel = new ChungNhan();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $image_url = null;
            if (isset($_FILES['certification_image']) && $_FILES['certification_image']['error'] == 0) {
                $target_dir = "quantri/assets/image/";
                $target_file = $target_dir . basename($_FILES["certification_image"]["name"]);
                if (move_uploaded_file($_FILES["certification_image"]["tmp_name"], $target_file)) {
                    $image_url = basename($_FILES["certification_image"]["name"]);
                } else {
                     $_SESSION['error_message'] = "Sorry, there was an error uploading your file.";
                }
            }

            if (empty($_SESSION['error_message'])) {
                if ($chungNhanModel->update($id, $image_url)) {
                    $_SESSION['success_message'] = 'Cập nhật chứng nhận thành công!';
                } else {
                    $_SESSION['error_message'] = 'Không thể cập nhật chứng nhận.';
                }
            }
            header('Location: index.php?action=admin_chungnhan_list');
            exit;
        }
        
        $certification = $chungNhanModel->getCertificationById($id);
        $title = 'Sửa Chứng Nhận';
        ob_start();
        require_once __DIR__ . '/../views/quantri/chungnhan/edit.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    public function adminDelete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $chungNhanModel = new ChungNhan();
            if ($chungNhanModel->delete($id)) {
                $_SESSION['success_message'] = 'Xóa chứng nhận thành công!';
            } else {
                $_SESSION['error_message'] = 'Không thể xóa chứng nhận.';
            }
        }
        header('Location: index.php?action=admin_chungnhan_list');
        exit;
    }
} 