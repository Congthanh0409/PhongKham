<?php
require_once __DIR__ . '/../models/HoSo.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';

class HoSoController {
    public function userRecords() {
        $currentUser = SessionHelper::getCurrentUser();
        if (!$currentUser) {
            header('Location: index.php?action=login');
            exit;
        }
        $username = $currentUser['username'];
        $user_id = $currentUser['id'];
        $hosoModel = new HoSo();
        $error_message = '';
        try {
            $user = $hosoModel->getUserInfo($username);
            $hoso_data = $hosoModel->getUserRecords($user_id);
        } catch (Exception $e) {
            $error_message = 'Lỗi khi truy vấn dữ liệu: ' . $e->getMessage();
            $user = null;
            $hoso_data = [];
        }
        $title = 'Hồ sơ bệnh án của tôi';
        ob_start();
        require_once __DIR__ . '/../views/nguoidung/hoso_user.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/app.php';
    }

    public function detail() {
        $currentUser = SessionHelper::getCurrentUser();
        if (!$currentUser) {
            header('Location: index.php?action=login');
            exit;
        }
        $hoso_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $user_id = $currentUser['id'];
        $hosoModel = new HoSo();
        $hoso = $hosoModel->getRecordById($hoso_id, $user_id);
        if (!$hoso) {
            echo "<div class='container mt-5 alert alert-danger'>Không tìm thấy hồ sơ hoặc bạn không có quyền xem.</div>";
            exit;
        }
        $title = 'Chi tiết hồ sơ bệnh án';
        ob_start();
        require_once __DIR__ . '/../views/nguoidung/hoso_detail.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/app.php';
    }

    public function adminList() {
        $currentUser = SessionHelper::getCurrentUser();
        if (!$currentUser || $currentUser['role'] !== 'admin') {
            header('Location: index.php?action=home');
            exit;
        }
        $hosoModel = new HoSo();
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $total = $hosoModel->countRecords($search);
        $totalPages = ceil($total / $limit);
        $records = $hosoModel->searchRecords($search, $limit, $offset);
        $success_message = $_SESSION['success_message'] ?? '';
        $error_message = $_SESSION['error_message'] ?? '';
        unset($_SESSION['success_message'], $_SESSION['error_message']);
        $title = 'Quản Lý Hồ Sơ Bệnh Án';
        ob_start();
        require_once __DIR__ . '/../views/quantri/hosobenhan/index.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    private function handleTranscripts($hoso_id, $hosoModel) {
        if (isset($_POST['transcripts']) && !empty($_POST['transcripts'])) {
            $transcripts = json_decode($_POST['transcripts'], true);
            if (is_array($transcripts)) {
                $audio_upload_dir = 'nguoidung/uploads/audio/';
                if (!is_dir($audio_upload_dir)) {
                    mkdir($audio_upload_dir, 0777, true);
                }

                foreach ($transcripts as $item) {
                    if (isset($item['audio']) && isset($item['text'])) {
                        $audio_data = $item['audio'];
                        list($type, $data) = explode(';', $audio_data);
                        list(, $data)      = explode(',', $data);
                        $decoded_audio = base64_decode($data);
                        
                        $filename = uniqid('audio_') . '.wav';
                        file_put_contents($audio_upload_dir . $filename, $decoded_audio);
                        
                        $hosoModel->addTranscript($hoso_id, $filename, $item['text']);
                    }
                }
            }
        }
    }

    public function adminCreate() {
        $hosoModel = new HoSo();
        $error = '';
        
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $benhnhan_id = $_POST['benhnhan_id'] ?? '';
            $bacsi = $_POST['bacsi'] ?? '';
            $ngaykham = $_POST['ngaykham'] ?? '';
            $trangthai = $_POST['trangthai'] ?? '';
            $ghichu = $_POST['ghichu'] ?? '';
            $appointment_id = $_POST['appointment_id'] ?? '';
            
            if (empty($benhnhan_id) || empty($bacsi) || empty($ngaykham) || empty($trangthai)) {
                $error = 'Vui lòng điền đầy đủ thông tin bắt buộc.';
            } else {
                $new_hoso_id = $hosoModel->create($benhnhan_id, $bacsi, $ngaykham, $trangthai, $ghichu);
                if ($new_hoso_id) {
                    $this->handleTranscripts($new_hoso_id, $hosoModel);
                    
                    if (!empty($appointment_id)) {
                        $hosoModel->deleteAppointment($appointment_id);
                    }
                    $_SESSION['success_message'] = 'Thêm hồ sơ bệnh án thành công!';
                    header('Location: index.php?action=admin_hosobenhan_list');
                    exit;
                } else {
                    $error = 'Có lỗi xảy ra khi thêm hồ sơ bệnh án.';
                }
            }
        }
        
        $patients = $hosoModel->getPatients();
        $appointments = $hosoModel->getConfirmedAppointments();
        
        $title = 'Thêm Hồ Sơ Bệnh Án';
        ob_start();
        require_once __DIR__ . '/../views/quantri/hosobenhan/create.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    public function adminEdit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=admin_hosobenhan_list&error=ID không hợp lệ');
            exit;
        }
        
        $hosoModel = new HoSo();
        $error = '';
        
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $benhnhan_id = $_POST['benhnhan_id'] ?? '';
            $bacsi = $_POST['bacsi'] ?? '';
            $ngaykham = $_POST['ngaykham'] ?? '';
            $trangthai = $_POST['trangthai'] ?? '';
            $ghichu = $_POST['ghichu'] ?? '';
            
            if (empty($benhnhan_id) || empty($bacsi) || empty($ngaykham) || empty($trangthai)) {
                $error = 'Vui lòng điền đầy đủ thông tin bắt buộc.';
            } else {
                if ($hosoModel->update($id, $benhnhan_id, $bacsi, $ngaykham, $trangthai, $ghichu)) {
                    $this->handleTranscripts($id, $hosoModel);
                    $_SESSION['success_message'] = 'Cập nhật hồ sơ bệnh án thành công!';
                    header('Location: index.php?action=admin_hosobenhan_list');
                    exit;
                } else {
                    $error = 'Có lỗi xảy ra khi cập nhật hồ sơ bệnh án.';
                }
            }
        }
        
        $record = $hosoModel->getById($id);
        $media_files = $hosoModel->getTranscriptsForRecord($id);
        $patients = $hosoModel->getPatients();
        
        if (!$record) {
            header('Location: index.php?action=admin_hosobenhan_list&error=Không tìm thấy hồ sơ');
            exit;
        }
        
        $title = 'Cập Nhật Hồ Sơ Bệnh Án';
        ob_start();
        require_once __DIR__ . '/../views/quantri/hosobenhan/edit.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    public function adminView() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=admin_hosobenhan_list&error=ID không hợp lệ');
            exit;
        }
        
        $hosoModel = new HoSo();
        $record = $hosoModel->getById($id);
        $media_files = $hosoModel->getTranscriptsForRecord($id);
        
        if (!$record) {
            header('Location: index.php?action=admin_hosobenhan_list&error=Không tìm thấy hồ sơ');
            exit;
        }
        
        $title = 'Xem Hồ Sơ Bệnh Án';
        ob_start();
        require_once __DIR__ . '/../views/quantri/hosobenhan/view.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    public function adminDelete() {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $hosoModel = new HoSo();
            
            $transcripts = $hosoModel->getTranscriptsForRecord($id);
            foreach ($transcripts as $file) {
                $hosoModel->deleteTranscript($file['id']);
            }

            $result = $hosoModel->delete($id);
            
            if ($result) {
                header('Location: index.php?action=admin_hosobenhan_list&success=Xóa hồ sơ thành công');
            } else {
                header('Location: index.php?action=admin_hosobenhan_list&error=Có lỗi xảy ra khi xóa hồ sơ');
            }
        } else {
            header('Location: index.php?action=admin_hosobenhan_list&error=ID không hợp lệ');
        }
        exit;
    }

    public function adminDeleteTranscript() {
        header('Content-Type: application/json');
        $media_id = isset($_GET['media_id']) ? (int)$_GET['media_id'] : 0;
        
        if ($media_id > 0) {
            $hosoModel = new HoSo();
            if ($hosoModel->deleteTranscript($media_id)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi khi xóa bản ghi khỏi cơ sở dữ liệu.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'ID bản ghi không hợp lệ.']);
        }
        exit;
    }
} 