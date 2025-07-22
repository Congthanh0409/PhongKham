<section class="wrapper">
    <h3><i class="fa fa-angle-right"></i> Chỉnh sửa quyền hạn tài khoản</h3>
    <div class="form-panel">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form class="form-horizontal style-form" method="POST" action="index.php?action=admin_dieuchinhquyenhang_edit&id=<?php echo $editUser['id']; ?>">
            <div class="form-group">
                <label class="col-sm-2 col-form-label">Tên đăng nhập</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($editUser['username']); ?>" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-form-label">Quyền hạn</label>
                <div class="col-sm-10">
                    <select class="form-control" name="role" required>
                        <option value="user" <?php if ($editUser['role'] == 'user') echo 'selected'; ?>>User</option>
                        <option value="admin" <?php if ($editUser['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="index.php?action=admin_dieuchinhquyenhang_list" class="btn btn-secondary">Hủy</a>
                </div>
            </div>
        </form>
    </div>
</section> 