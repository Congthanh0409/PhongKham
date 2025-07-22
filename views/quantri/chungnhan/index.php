<section class="wrapper">
    <h3>Danh Sách Chứng Nhận Quốc Gia</h3>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <a href="index.php?action=admin_chungnhan_create" class="btn btn-primary">Thêm Chứng Nhận Mới</a>
    <br><br>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Ảnh Chứng Nhận</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($certifications as $row): ?>
                <tr>
                    <td><img src="quantri/assets/image/<?php echo $row['certification_image']; ?>" alt="image" width="100"></td>
                    <td>
                        <a href="index.php?action=admin_chungnhan_edit&id=<?php echo $row['id']; ?>" class="btn btn-warning">Sửa</a>
                        <a href="index.php?action=admin_chungnhan_delete&id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa chứng nhận này?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section> 