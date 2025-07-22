<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-calendar"></i> Quản lý lịch hẹn</h3>
            <div class="mb-3">
                <a href="index.php?action=admin_datlichhen_create" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Thêm lịch hẹn
                </a>
                <a href="index.php?action=admin_datlichhen_statistics" class="btn btn-info">
                    <i class="fa fa-bar-chart"></i> Thống kê
                </a>
            </div>
        </div>
    </div>
    
    <!-- Search Form -->
    <div class="row mb-3">
        <div class="col-lg-12">
                    <form method="GET" action="index.php" class="form-inline">
                        <input type="hidden" name="action" value="admin_datlichhen_list">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="search_name" class="sr-only">Tên bệnh nhân</label>
                                    <input type="text" class="form-control" id="search_name" name="search_name" 
                                           placeholder="Tên bệnh nhân" value="<?php echo htmlspecialchars($search_name ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="search_phone" class="sr-only">Số điện thoại</label>
                                    <input type="text" class="form-control" id="search_phone" name="search_phone" 
                                           placeholder="Số điện thoại" value="<?php echo htmlspecialchars($search_phone ?? ''); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i> Tìm kiếm
                                    </button>
                                    <a href="index.php?action=admin_datlichhen_list" class="btn btn-secondary">
                                        <i class="fa fa-refresh"></i> Làm mới
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
        </div>
    </div>
    
    <?php if (!empty($message)): ?>
        <div class="alert alert-<?php echo $message_type; ?>"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <!-- Search Results Info -->
    <?php if (!empty($search_name) || !empty($search_phone)): ?>
        <div class="alert alert-info">
            <i class="fa fa-info-circle"></i> 
            Kết quả tìm kiếm: 
            <?php 
            $search_terms = [];
            if (!empty($search_name)) $search_terms[] = "Tên: " . htmlspecialchars($search_name);
            if (!empty($search_phone)) $search_terms[] = "SĐT: " . htmlspecialchars($search_phone);
            echo implode(', ', $search_terms);
            ?>
            <span class="badge badge-info ml-2"><?php echo count($appointments); ?> kết quả</span>
        </div>
    <?php endif; ?>
    
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Ngày hẹn</th>
                    <th>Giờ hẹn</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($appointments)): ?>
                    <tr>
                        <td colspan="8" class="text-center">
                            <i class="fa fa-inbox fa-3x text-muted"></i>
                            <p class="mt-2">Không có lịch hẹn nào.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($appointments as $row): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($row['appointment_date'])); ?></td>
                            <td><?php echo htmlspecialchars($row['appointment_time']); ?></td>
                            <td>
                                <?php if ($row['confirmed']): ?>
                                    <span class="label label-success">Đã xác nhận</span>
                                <?php else: ?>
                                    <span class="label label-warning">Chờ xác nhận</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <?php if (!$row['confirmed']): ?>
                                        <a href="index.php?action=admin_datlichhen_update_status&update_id=<?php echo $row['id']; ?>&status=1" class="btn btn-success btn-sm" title="Xác nhận">
                                            <i class="fa fa-check"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="index.php?action=admin_datlichhen_update_status&update_id=<?php echo $row['id']; ?>&status=0" class="btn btn-warning btn-sm" title="Hủy xác nhận">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a href="index.php?action=admin_datlichhen_delete&id=<?php echo $row['id']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       title="Xóa"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa lịch hẹn này?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<style>
.btn-group .btn {
    margin-right: 5px;
}

.label {
    padding: 5px 10px;
    border-radius: 3px;
    font-size: 12px;
}

.label-success {
    background-color: #5cb85c;
    color: white;
}

.label-warning {
    background-color: #f0ad4e;
    color: white;
}

.mb-3 {
    margin-bottom: 15px;
}

.form-inline .form-group {
    margin-right: 10px;
    margin-bottom: 10px;
}

.card {
    border: 1px solid #ddd;
    border-radius: 5px;
}

.badge {
    padding: 5px 10px;
    border-radius: 3px;
    font-size: 12px;
}

.badge-info {
    background-color: #17a2b8;
    color: white;
}

.ml-2 {
    margin-left: 10px;
}

.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
}
</style> 