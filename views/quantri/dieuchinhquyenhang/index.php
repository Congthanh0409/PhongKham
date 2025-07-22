<section class="wrapper">
    <h3><i class="fa fa-angle-right"></i> Danh Sách Quyền Hạng</h3>
    <a href="index.php?action=admin_dieuchinhquyenhang_create" class="btn btn-primary mb-2">Thêm tài khoản</a>
    <div class="row">
        <div class="col-md-12">
            <div class="content-panel">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tên đăng nhập</th>
                            <th>Quyền hạn</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['role']); ?></td>
                                <td>
                                    <a href="index.php?action=admin_dieuchinhquyenhang_edit&id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Sửa</a>
                                    <?php if ($currentRole == 'admin'): ?>
                                        <a href="index.php?action=admin_dieuchinhquyenhang_delete&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa tài khoản này?');">Xóa</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success mt-3">Thao tác thành công!</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section> 