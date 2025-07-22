<section class="wrapper">
    <h3><i class="fa fa-angle-right"></i> Thêm tài khoản mới</h3>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form class="form-horizontal style-form" method="POST" action="index.php?action=admin_dieuchinhquyenhang_create">
        <div class="form-group">
            <label class="col-sm-2 col-form-label">Tên đăng nhập</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-form-label">Mật khẩu</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 col-form-label">Quyền hạn</label>
            <div class="col-sm-10">
                <select class="form-control" name="role" required>
                    <option value="user" <?php if ($role == 'user') echo 'selected'; ?>>User</option>
                    <option value="admin" <?php if ($role == 'admin') echo 'selected'; ?>>Admin</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Thêm</button>
                <a href="index.php?action=admin_dieuchinhquyenhang_list" class="btn btn-secondary">Hủy</a>
            </div>
        </div>
    </form>
</section> 