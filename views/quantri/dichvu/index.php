<section class="wrapper">
    <h3>Danh Sách Dịch Vụ</h3>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <a href="index.php?action=admin_dichvu_create" class="btn btn-primary">Tạo Mới</a>
    <br><br>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Tiêu Đề</th>
                <th>Nội Dung</th>
                <th>Ảnh</th>
                <th>Ngày Tạo</th>
                <th>Ngày Cập Nhật</th>
                <th>Ngày Xóa</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $row): ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td>
                        <button class="btn btn-info" data-toggle="modal" data-target="#modal_<?php echo $row['id']; ?>">Xem Chi Tiết</button>
                    </td>
                    <td><img src="quantri/assets/image/<?php echo $row['image_url']; ?>" alt="image" width="100"></td>
                    <td><?php echo date('d-m-Y', strtotime($row['created_at'])); ?></td>
                    <td><?php echo $row['updated_at'] ? date('d-m-Y', strtotime($row['updated_at'])) : 'Chưa Cập Nhật'; ?></td>
                    <td>
                        <?php echo $row['deleted_at'] ? date('d-m-Y', strtotime($row['deleted_at'])) : 'Chưa Xóa'; ?>
                    </td>
                    <td>
                        <a href="index.php?action=admin_dichvu_edit&id=<?php echo $row['id']; ?>" class="btn btn-warning">Sửa</a>
                        <a href="index.php?action=admin_dichvu_delete&id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa mục này?')">Xóa</a>
                    </td>
                </tr>
                <!-- Modal Xem Chi Tiết -->
                <div id="modal_<?php echo $row['id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Chi Tiết Nội Dung</h4>
                            </div>
                            <div class="modal-body">
                                <div><?php echo $row['content']; ?></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</section> 