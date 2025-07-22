<section class="wrapper">
    <h3>Chỉnh Sửa Mục Tai Mũi Họng</h3>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="title">Tiêu Đề</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($article['title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Nội Dung</label>
            <textarea class="form-control" id="content" name="content" rows="5" required><?php echo htmlspecialchars($article['content']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="index.php?action=admin_taimuihong_list" class="btn btn-danger">Quay lại</a>
    </form>
</section> 