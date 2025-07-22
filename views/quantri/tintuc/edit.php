<section class="wrapper">
    <h3>Chỉnh Sửa Tin Tức</h3>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?action=admin_tintuc_edit&id=<?php echo $news['id']; ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Tiêu Đề</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($titleVal); ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Nội Dung</label>
            <textarea class="form-control" id="content" name="content" rows="10"><?php echo htmlspecialchars($contentVal); ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Ảnh</label>
            <input type="file" class="form-control-file" id="image" name="image">
            <?php if (!empty($news['image_url'])): ?>
                <img src="quantri/assets/image/<?php echo $news['image_url']; ?>" alt="Current Image" width="100" class="mt-2">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="index.php?action=admin_tintuc_list" class="btn btn-secondary">Hủy</a>
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

    document.querySelector('form').addEventListener('submit', (e) => {
        if (editor) {
            document.querySelector('#content').value = editor.getData();
        }
    });
</script> 