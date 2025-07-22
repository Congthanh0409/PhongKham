<?php
require_once __DIR__ . '/../models/Banner.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';

class BannerController {
    public function showBanner() {
        $bannerModel = new Banner();
        $banners = $bannerModel->getActiveBanners();

        // This is not ideal to require a view from a controller like this
        // for a partial view, but it's a step in the refactoring process.
        require __DIR__ . '/../views/partials/banner.php';
    }

    public function list() {
        $bannerModel = new Banner();
        $banners = $bannerModel->getAllBanners();
        $error = '';
        // Handle soft delete
        if (isset($_GET['delete_id'])) {
            $delete_id = (int)$_GET['delete_id'];
            if ($bannerModel->softDeleteBanner($delete_id)) {
                header('Location: index.php?action=admin_banner_list');
                exit;
            } else {
                $error = 'Có lỗi xảy ra khi cập nhật mục.';
            }
        }
        $title = 'Danh Sách Banner';
        ob_start();
        require_once __DIR__ . '/../views/quantri/banner/index.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    public function adminCreate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $link_url = $_POST['link_url'];
            $image_url = $_FILES['image_url']['name'];
            $currentUser = SessionHelper::getCurrentUser();
            $user_id = $currentUser ? $currentUser['id'] : null;
            if ($image_url) {
                $target_dir = 'quantri/assets/image/';
                $target_file = $target_dir . basename($image_url);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array($imageFileType, $allowed_types)) {
                    if (move_uploaded_file($_FILES['image_url']['tmp_name'], $target_file)) {
                        $bannerModel = new Banner();
                        if ($bannerModel->createBanner($image_url, $link_url, $user_id)) {
                            header('Location: index.php?action=admin_banner_list');
                            exit;
                        } else {
                            $error = 'Có lỗi xảy ra khi tạo banner.';
                        }
                    } else {
                        $error = 'Không thể tải lên ảnh.';
                    }
                } else {
                    $error = 'Chỉ chấp nhận định dạng ảnh JPG, JPEG, PNG, GIF.';
                }
            } else {
                $error = 'Ảnh không thể để trống.';
            }
        }
        $title = 'Tạo Banner Mới';
        ob_start();
        require __DIR__ . '/../views/quantri/banner/create.php';
        $content = ob_get_clean();
        require __DIR__ . '/../views/layouts/admin.php';
    }

    public function adminEdit() {
        $id = $_GET['id'];
        $bannerModel = new Banner();
        $banner = null;
        $error = '';
        $success = '';
        // Get current banner
        $banners = $bannerModel->getAllBanners();
        foreach ($banners as $b) {
            if ($b['id'] == $id) {
                $banner = $b;
                break;
            }
        }
        if (!$banner) {
            header('Location: index.php?action=admin_banner_list');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $link_url = $_POST['link_url'];
            $image_url = $_FILES['image_url']['name'];
            if ($image_url) {
                $target_dir = 'quantri/assets/image/';
                $target_file = $target_dir . basename($image_url);
                move_uploaded_file($_FILES['image_url']['tmp_name'], $target_file);
            } else {
                $image_url = $banner['image_url'];
            }
            if ($bannerModel->updateBanner($id, $image_url, $link_url)) {
                $success = 'Cập nhật banner thành công!';
                header('Location: index.php?action=admin_banner_list');
                exit;
            } else {
                $error = 'Có lỗi xảy ra khi cập nhật banner.';
            }
        }
        $title = 'Chỉnh Sửa Banner';
        ob_start();
        require __DIR__ . '/../views/quantri/banner/edit.php';
        $content = ob_get_clean();
        require __DIR__ . '/../views/layouts/admin.php';
    }

    public function adminDelete() {
        $id = $_GET['id'];
        $bannerModel = new Banner();
        $error = '';
        if ($bannerModel->softDeleteBanner($id)) {
            header('Location: index.php?action=admin_banner_list');
            exit;
        } else {
            $error = 'Có lỗi xảy ra khi xóa banner.';
        }
        $title = 'Xóa Banner';
        ob_start();
        require __DIR__ . '/../views/quantri/banner/delete.php';
        $content = ob_get_clean();
        require __DIR__ . '/../views/layouts/admin.php';
    }
} 