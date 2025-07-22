<section class="wrapper">
    <h3>Tạo Banner Mới</h3>
    <?php if (isset($error) && $error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form action="index.php?action=admin_banner_create" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="link_url">Liên Kết URL</label>
            <input type="text" class="form-control" id="link_url" name="link_url" required>
        </div>
        <div class="form-group">
            <label for="image_url">Ảnh Banner</label>
            <input type="file" class="form-control-file" id="image_url" name="image_url" required>
        </div>
        <button type="submit" class="btn btn-primary">Tạo Banner</button>
        <a href="index.php?action=admin_banner_list" class="btn btn-secondary">Hủy</a>
    </form>
</section> 