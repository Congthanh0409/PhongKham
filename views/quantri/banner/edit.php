<section class="wrapper">
    <h3>Chỉnh Sửa Banner</h3>
    <?php if (isset($error) && $error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form action="index.php?action=admin_banner_edit&id=<?php echo $banner['id']; ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="link_url">Liên kết URL</label>
            <input type="text" class="form-control" name="link_url" id="link_url" value="<?php echo htmlspecialchars($banner['link_url']); ?>" required>
        </div>
        <div class="form-group">
            <label for="image_url">Ảnh Banner</label>
            <input type="file" class="form-control" id="image_url" name="image_url">
            <?php if ($banner['image_url']): ?>
                <img src="assets/image/<?php echo htmlspecialchars($banner['image_url']); ?>" alt="Current Image" width="100">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="index.php?action=admin_banner_list" class="btn btn-secondary">Hủy</a>
    </form>
</section> 