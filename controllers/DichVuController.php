<?php
require_once __DIR__ . '/../models/DichVu.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';

class DichVuController {
    public function showServices() {
        $dichVuModel = new DichVu();
        $services = $dichVuModel->getFeaturedServices();

        require __DIR__ . '/../views/partials/dichvu.php';
    }

    public function show() {
        if (!isset($_GET['id'])) {
            // Or handle as an error
            header('Location: index.php');
            exit;
        }

        $id = $_GET['id'];
        $dichVuModel = new DichVu();
        $service = $dichVuModel->getServiceById($id);
        $otherServices = $dichVuModel->getOtherServices($id);

        if (!$service) {
            // Handle service not found, e.g., show a 404 page
            echo "Dịch vụ không tồn tại.";
            exit;
        }

        $title = $service['title'];

        ob_start();
        require_once __DIR__ . '/../views/nguoidung/dichvu_detail.php';
        $content = ob_get_clean();

        require_once __DIR__ . '/../views/layouts/app.php';
    }

    public function list() {
        $dichVuModel = new DichVu();
        $services = $dichVuModel->getAllServices();
        $title = 'Danh Sách Dịch Vụ';
        ob_start();
        require_once __DIR__ . '/../views/quantri/dichvu/index.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }
    
    public function adminCreate() {
        $error = '';
        $titleVal = '';
        $contentVal = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titleVal = $_POST['title'] ?? '';
            $contentVal = $_POST['content'] ?? '';

            if (empty($titleVal) || empty($contentVal)) {
                $error = "Tiêu đề và nội dung không được để trống.";
            } else {
                $currentUser = SessionHelper::getCurrentUser();
                $user_id = $currentUser ? $currentUser['id'] : null;
                $image_url = '';

                // Handle file upload
                if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                    $target_dir = "quantri/assets/image/";
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                        $image_url = basename($_FILES["image"]["name"]);
                    } else {
                        $error = "Sorry, there was an error uploading your file.";
                    }
                }

                if (empty($error)) {
                    $dichVuModel = new DichVu();
                    if ($dichVuModel->create($titleVal, $contentVal, $image_url, $user_id)) {
                        $_SESSION['success_message'] = 'Tạo dịch vụ thành công!';
                        header('Location: index.php?action=admin_dichvu_list');
                        exit;
                    } else {
                        $error = 'Failed to create service.';
                    }
                }
            }
        }
        $title = 'Tạo Dịch Vụ Mới';
        ob_start();
        require_once __DIR__ . '/../views/quantri/dichvu/create.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }
    
    public function adminEdit() {
        $error = '';
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=admin_dichvu_list');
            exit;
        }

        $dichVuModel = new DichVu();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titleVal = $_POST['title'] ?? '';
            $contentVal = $_POST['content'] ?? '';
            $service = $dichVuModel->getServiceById($id);
            $image_url = $service['image_url']; // Keep old image by default

            // Handle file upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = "quantri/assets/image/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_url = basename($_FILES["image"]["name"]); // Update to new image
                } else {
                    $error = "Sorry, there was an error uploading your file.";
                }
            }
            
            if (empty($error)) {
                if ($dichVuModel->update($id, $titleVal, $contentVal, $image_url)) {
                    $_SESSION['success_message'] = 'Cập nhật dịch vụ thành công!';
                    header('Location: index.php?action=admin_dichvu_list');
                    exit;
                } else {
                    $error = 'Failed to update service.';
                }
            }
        }
        
        // Fetch existing data for the form
        $service = $dichVuModel->getServiceById($id);
        $titleVal = $service['title'];
        $contentVal = $service['content'];

        $title = 'Cập Nhật Dịch Vụ';
        ob_start();
        require_once __DIR__ . '/../views/quantri/dichvu/edit.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }
    
    public function adminDelete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $dichVuModel = new DichVu();
            if ($dichVuModel->softDelete($id)) {
                $_SESSION['success_message'] = 'Xóa dịch vụ thành công!';
            } else {
                $_SESSION['error_message'] = 'Có lỗi xảy ra khi xóa dịch vụ.';
            }
        }
        header('Location: index.php?action=admin_dichvu_list');
        exit;
    }
} 