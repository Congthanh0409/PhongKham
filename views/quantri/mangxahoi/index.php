<section class="wrapper">
    <h3>Danh Sách Mạng Xã Hội</h3>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Facebook</th>
                <th>Zalo</th>
                <th>TikTok</th>
                <th>Số Điện Thoại</th>
                <th>Email Công Ty</th>
                <th>Địa Chỉ Công Ty</th>
                <th>Ngày Tạo</th>
                <th>Ngày Cập Nhật</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($records as $row): ?>
                <tr>
                    <form method="POST" action="index.php?action=admin_socialmedia">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <td><input type="text" name="facebook" value="<?php echo $row['facebook'] ?: 'Đang cập nhật'; ?>" class="form-control"></td>
                        <td><input type="text" name="zalo" value="<?php echo $row['zalo'] ?: 'Đang cập nhật'; ?>" class="form-control"></td>
                        <td><input type="text" name="tiktok" value="<?php echo $row['tiktok'] ?: 'Đang cập nhật'; ?>" class="form-control"></td>
                        <td><input type="text" name="phone_number" value="<?php echo $row['phone_number'] ?: 'Đang cập nhật'; ?>" class="form-control"></td>
                        <td><input type="email" name="company_email" value="<?php echo $row['company_email'] ?: 'Đang cập nhật'; ?>" class="form-control"></td>
                        <td><input type="text" name="company_address" value="<?php echo $row['company_address'] ?: 'Đang cập nhật'; ?>" class="form-control"></td>
                        <td><?php echo date('d-m-Y', strtotime($row['created_at'])); ?></td>
                        <td><?php echo $row['updated_at'] ? date('d-m-Y', strtotime($row['updated_at'])) : 'Chưa Cập Nhật'; ?></td>
                        <td>
                            <button type="submit" class="btn btn-primary">Cập Nhật</button>
                        </td>
                    </form>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section> 