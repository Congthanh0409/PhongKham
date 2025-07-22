<section class="wrapper">
    <h3>Chỉnh Sửa Giới Thiệu</h3>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="index.php?action=admin_gioithieu_edit&id=<?php echo $record['id']; ?>">
        <div class="form-group">
            <label for="title">Tiêu Đề</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($record['title']); ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Nội Dung</label>
            <textarea class="form-control" id="content" name="content" rows="10"><?php echo htmlspecialchars($record['content']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="index.php?action=admin_gioithieu_list" class="btn btn-secondary">Hủy</a>
    </form>
</section>
<script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
<script>
    let editor;
    ClassicEditor
        .create(document.querySelector('#content'))
        .then(newEditor => {
            editor = newEditor;
        })
        .catch(error => {
            console.error(error);
        });

    document.querySelector('form').addEventListener('submit', () => {
        if (editor) {
            document.querySelector('#content').value = editor.getData();
        }
    });
</script> 