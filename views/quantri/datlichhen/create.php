<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-panel">
                <h4 class="mb"><i class="fa fa-angle-right"></i> Thêm Lịch Hẹn Mới</h4>
                
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <form class="form-horizontal style-form" method="post" action="index.php?action=admin_datlichhen_create">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Họ tên <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($form_data['name'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Số điện thoại <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="tel" class="form-control" name="phone" value="<?php echo htmlspecialchars($form_data['phone'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Email <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ngày hẹn <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="appointment_date" value="<?php echo htmlspecialchars($form_data['appointment_date'] ?? ''); ?>" required min="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Giờ hẹn <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-control" name="appointment_time" required>
                                <option value="">-- Chọn giờ hẹn --</option>
                                <?php
                                $start_hour = 8; // 8:00 AM
                                $end_hour = 17; // 5:00 PM
                                for ($hour = $start_hour; $hour <= $end_hour; $hour++) {
                                    for ($minute = 0; $minute < 60; $minute += 30) {
                                        $time = sprintf('%02d:%02d', $hour, $minute);
                                        $selected = ($form_data['appointment_time'] ?? '') === $time ? 'selected' : '';
                                        echo "<option value=\"$time\" $selected>$time</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Trạng thái</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="confirmed">
                                <option value="0" <?php echo ($form_data['confirmed'] ?? '0') === '0' ? 'selected' : ''; ?>>Chờ xác nhận</option>
                                <option value="1" <?php echo ($form_data['confirmed'] ?? '0') === '1' ? 'selected' : ''; ?>>Đã xác nhận</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Lưu lịch hẹn
                            </button>
                            <a href="index.php?action=admin_datlichhen_list" class="btn btn-default">
                                <i class="fa fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
.form-panel {
    background: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.alert {
    margin-bottom: 20px;
}

.text-danger {
    color: #dc3545;
}

.form-control:focus {
    border-color: #2196F3;
    box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
}
</style> 