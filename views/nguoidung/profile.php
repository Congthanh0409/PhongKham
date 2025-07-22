<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <form id="avatar-form" action="index.php?action=profile" method="post" enctype="multipart/form-data" style="display: inline;">
                            <input type="hidden" name="avatar_upload" value="1">
                            <div class="position-relative d-inline-block">
                                <?php 
                                $avatar_path = '';
                                if (!empty($user['avatar'])) {
                                    $avatar_path = 'nguoidung/uploads/avatars/' . $user['avatar'];
                                    // Check if file exists
                                    if (!file_exists($avatar_path)) {
                                        $avatar_path = 'assets/img/default-avatar.png';
                                    }
                                } else {
                                    $avatar_path = 'assets/img/default-avatar.png';
                                }
                                ?>
                                <img src="<?php echo $avatar_path; ?>" 
                                     alt="Avatar" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #2196F3;">
                                <label class="position-absolute" style="bottom: 0; right: 0; background: #2196F3; width: 40px; height: 40px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-camera text-white"></i>
                                    <input type="file" name="avatar" accept="image/*" onchange="this.form.submit();" style="display: none;">
                                </label>
                            </div>
                        </form>
                        <h4 class="mt-3"><?php echo htmlspecialchars($user['fullname'] ?? $user['user_username']); ?></h4>
                        <p class="text-muted"><?php echo htmlspecialchars($user['user_email']); ?></p>
                    </div>
                    <form action="index.php?action=profile" method="post">
                        <input type="hidden" name="update_profile" value="1">
                        
                        
                                <div class="form-group">
                                    <label for="username">Tên đăng nhập</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" readonly >
                                </div>
                            
                            
                                <div class="form-group">
                                    <label for="fullname">Họ và tên</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname'] ?? ''); ?>">
                                </div>
                            
                        
                        
                            
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                                </div>
                            
                            
                                <div class="form-group">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                                </div>
                            
                        
                        <div class="form-group">
                            <label for="dob">Ngày sinh</label>
                            <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($user['dob'] ?? ''); ?>">
                        </div>
                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 