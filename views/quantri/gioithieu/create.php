<section class="wrapper">
    <h3>Tạo Giới Thiệu Mới</h3>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="index.php?action=admin_gioithieu_create">
        <div class="form-group">
            <label for="title">Tiêu Đề</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($titleVal ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Nội Dung</label>
            <textarea class="form-control" id="content" name="content" rows="10"><?php echo htmlspecialchars($contentVal ?? ''); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Tạo Giới Thiệu</button>
        <a href="index.php?action=admin_gioithieu_list" class="btn btn-secondary">Hủy</a>
    </form>
</section>
<script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#content')).catch(error => { console.error(error); });
</script> 