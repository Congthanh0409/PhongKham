<section class="wrapper">
    <h3>Danh Sách Banner</h3>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <a href="index.php?action=admin_banner_create" class="btn btn-primary">Tạo Mới</a>
    <br><br>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Hình Ảnh</th>
                <th>Liên Kết</th>
                <th>Ngày Tạo</th>
                <th>Ngày Cập Nhật</th>
                <th>Ngày Xóa</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($banners as $row): ?>
                <tr>
                    <td><img src="quantri/assets/image/<?php echo $row['image_url']; ?>" alt="image" width="200"></td>
                    <td><a href="<?php echo $row['link_url']; ?>" target="_blank"><?php echo $row['link_url']; ?></a></td>
                    <td><?php echo date('d-m-Y', strtotime($row['created_at'])); ?></td>
                    <td><?php echo $row['updated_at'] ? date('d-m-Y', strtotime($row['updated_at'])) : 'Chưa Cập Nhật'; ?></td>
                    <td>
                        <?php echo $row['deleted_at'] ? date('d-m-Y', strtotime($row['deleted_at'])) : 'Chưa Xóa'; ?>
                    </td>
                    <td>
                        <a href="index.php?action=admin_banner_edit&id=<?php echo $row['id']; ?>" class="btn btn-warning">Sửa</a>
                        <a href="index.php?action=admin_banner_list&delete_id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa mục này?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section> 