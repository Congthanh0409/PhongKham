<section class="wrapper">
    <h3>Tạo Dịch Vụ Mới</h3>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="index.php?action=admin_dichvu_create" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Tiêu Đề</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($titleVal); ?>" required>
        </div>

        <div class="form-group">
            <label for="content">Nội Dung</label>
            <textarea class="form-control" id="content" name="content" rows="5"></textarea>
        </div>

        <div class="form-group">
            <label for="image">Ảnh Dịch Vụ</label>
            <input type="file" class="form-control-file" id="image" name="image" required>
        </div>

        <button type="submit" class="btn btn-primary">Tạo Dịch Vụ</button>
        <a href="index.php?action=admin_dichvu_list" class="btn btn-secondary">Hủy</a>
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