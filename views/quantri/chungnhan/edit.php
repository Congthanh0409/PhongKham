<section class="wrapper">
    <h3>Sửa Chứng Nhận</h3>
    <form method="POST" action="index.php?action=admin_chungnhan_edit&id=<?php echo $certification['id']; ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label for="certification_image">Ảnh Hiện Tại</label>
            <br>
            <img src="quantri/assets/image/<?php echo $certification['certification_image']; ?>" alt="Current Image" width="100">
        </div>
        <div class="form-group">
            <label for="certification_image">Tải Lên Ảnh Mới (tùy chọn)</label>
            <input type="file" class="form-control-file" id="certification_image" name="certification_image">
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
        <a href="index.php?action=admin_chungnhan_list" class="btn btn-secondary">Hủy</a>
    </form>
</section> 