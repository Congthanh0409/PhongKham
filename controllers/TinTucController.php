<?php
require_once __DIR__ . '/../models/TinTuc.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';

class TinTucController {
    public function showRecentNews() {
        $tinTucModel = new TinTuc();
        $news = $tinTucModel->getRecentNews();

        require __DIR__ . '/../views/partials/tintuc.php';
    }

    public function list() {
        $tinTucModel = new TinTuc();

        $posts_per_page = 9;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $posts_per_page;

        $news = $tinTucModel->getAllNews($posts_per_page, $offset);
        $total_posts = $tinTucModel->getTotalNewsCount();
        $total_pages = ceil($total_posts / $posts_per_page);

        $title = 'Tin Tức';

        ob_start();
        require_once __DIR__ . '/../views/nguoidung/tintuc_list.php';
        $content = ob_get_clean();

        require_once __DIR__ . '/../views/layouts/app.php';
    }

    public function show() {
        if (!isset($_GET['id'])) {
            header('Location: index.php?action=tintuc_list');
            exit;
        }

        $id = $_GET['id'];
        $tinTucModel = new TinTuc();
        $article = $tinTucModel->getNewsById($id);
        $otherArticles = $tinTucModel->getOtherNews($id);

        if (!$article) {
            echo "Bài viết không tồn tại.";
            exit;
        }

        $title = $article['title'];

        ob_start();
        require_once __DIR__ . '/../views/nguoidung/tintuc_detail.php';
        $content = ob_get_clean();

        require_once __DIR__ . '/../views/layouts/app.php';
    }

    // ADMIN: List all news
    public function adminList() {
        $tinTucModel = new TinTuc();
        $error = '';
        $news = $tinTucModel->getAllNewsAdmin();
        $title = 'Danh Sách Tin Tức';
        ob_start();
        require_once __DIR__ . '/../views/quantri/tintuc/index.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    // ADMIN: Create news
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
                    $tinTucModel = new TinTuc();
                    if ($tinTucModel->createNews($titleVal, $contentVal, $image_url, $user_id)) {
                        $_SESSION['success_message'] = 'Tạo tin tức thành công!';
                        header('Location: index.php?action=admin_tintuc_list');
                        exit;
                    } else {
                        $error = 'Có lỗi xảy ra khi tạo tin tức.';
                    }
                }
            }
        }
        $pageTitle = 'Tạo Tin Tức Mới';
        ob_start();
        require_once __DIR__ . '/../views/quantri/tintuc/create.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    // ADMIN: Edit news
    public function adminEdit() {
        $error = '';
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?action=admin_tintuc_list');
            exit;
        }

        $tinTucModel = new TinTuc();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titleVal = $_POST['title'] ?? '';
            $contentVal = $_POST['content'] ?? '';
            $news = $tinTucModel->getNewsById($id);
            $image_url = $news['image_url'];

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
                if ($tinTucModel->updateNews($id, $titleVal, $contentVal, $image_url)) {
                    $_SESSION['success_message'] = 'Cập nhật tin tức thành công!';
                    header('Location: index.php?action=admin_tintuc_list');
                    exit;
                } else {
                    $error = 'Có lỗi xảy ra khi cập nhật tin tức.';
                }
            }
        }
        
        $news = $tinTucModel->getNewsById($id);
        if (!$news) {
            header('Location: index.php?action=admin_tintuc_list');
            exit;
        }
        $titleVal = $news['title'];
        $contentVal = $news['content'];
        
        $pageTitle = 'Chỉnh Sửa Tin Tức';
        ob_start();
        require_once __DIR__ . '/../views/quantri/tintuc/edit.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../views/layouts/admin.php';
    }

    // ADMIN: Delete news (soft delete)
    public function adminDelete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $tinTucModel = new TinTuc();
            if ($tinTucModel->softDeleteNews($id)) {
                $_SESSION['success_message'] = 'Xóa tin tức thành công!';
            } else {
                $_SESSION['error_message'] = 'Có lỗi xảy ra khi xóa tin tức.';
            }
        }
        header('Location: index.php?action=admin_tintuc_list');
        exit;
    }
}