<section class="wrapper">
    <h3>Cập Nhật Dịch Vụ</h3>

    <form method="POST" action="index.php?action=admin_dichvu_edit&id=<?php echo $service['id']; ?>" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? ''; ?>">
        
        <div class="form-group">
            <label for="title">Tiêu đề</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($titleVal); ?>" required>
        </div>

        <div class="form-group">
            <label for="content">Mô tả</label>
            <textarea class="form-control" id="content" name="content" rows="5"><?php echo htmlspecialchars($contentVal); ?></textarea>
        </div>

        <div class="form-group">
            <label for="image">Ảnh</label>
            <input type="file" class="form-control-file" id="image" name="image">
            <?php if (!empty($service['image_url'])): ?>
                <img src="quantri/assets/image/<?php echo $service['image_url']; ?>" alt="Current Image" width="100" class="mt-2">
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Cập Nhật</button>
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