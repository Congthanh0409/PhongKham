<section class="wrapper">
    <h3>Thêm Chứng Nhận Mới</h3>
    <form method="POST" action="index.php?action=admin_chungnhan_create" enctype="multipart/form-data">
        <div class="form-group">
            <label for="certification_image">Ảnh Chứng Nhận</label>
            <input type="file" class="form-control-file" id="certification_image" name="certification_image" required>
        </div>
        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="index.php?action=admin_chungnhan_list" class="btn btn-secondary">Hủy</a>
    </form>
</section> 