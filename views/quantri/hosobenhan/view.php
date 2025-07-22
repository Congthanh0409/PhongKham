<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fa fa-file-text-o"></i>
                        Chi Tiết Hồ Sơ Bệnh Án #<?php echo $record['id']; ?>
                    </h4>
                    <span class="status-badge <?php echo $record['trangthai'] == 'active' ? 'status-active' : 'status-completed'; ?>">
                        <i class="fa <?php echo $record['trangthai'] == 'active' ? 'fa-clock-o' : 'fa-check'; ?>"></i>
                        <?php echo $record['trangthai'] == 'active' ? 'Đang điều trị' : 'Hoàn thành'; ?>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="record-section">
                                <h4><i class="fa fa-user"></i> Thông tin bệnh nhân</h4>
                                <div class="patient-info">
                                    <div class="patient-avatar">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0"><?php echo htmlspecialchars($record['benhnhan_name']); ?></h5>
                                        <small class="text-muted">BN<?php echo str_pad($record['benhnhan_id'], 5, '0', STR_PAD_LEFT); ?></small>
                                    </div>
                                </div>
                                <div class="info-item">
                                    <span class="record-label">Số điện thoại:</span>
                                    <span class="record-value"><?php echo htmlspecialchars($record['phone'] ?? 'N/A'); ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="record-label">Email:</span>
                                    <span class="record-value"><?php echo htmlspecialchars($record['email'] ?? 'N/A'); ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="record-label">Ngày sinh:</span>
                                    <span class="record-value"><?php echo $record['dob'] ? date('d/m/Y', strtotime($record['dob'])) : 'N/A'; ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="record-label">Địa chỉ:</span>
                                    <span class="record-value"><?php echo htmlspecialchars($record['address'] ?? 'N/A'); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="record-section">
                                <h4><i class="fa fa-stethoscope"></i> Thông tin khám bệnh</h4>
                                <div class="info-item">
                                    <span class="record-label">Bác sĩ phụ trách:</span>
                                    <span class="record-value"><?php echo htmlspecialchars($record['bacsi']); ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="record-label">Ngày khám:</span>
                                    <span class="record-value"><?php echo date('d/m/Y', strtotime($record['ngaykham'])); ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="record-label">Ngày tạo:</span>
                                    <span class="record-value"><?php echo date('d/m/Y H:i:s', strtotime($record['created_at'])); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="record-section">
                        <h4><i class="fa fa-pencil"></i> Ghi chú</h4>
                        <div class="info-item">
                            <p class="mb-0"><?php echo nl2br(htmlspecialchars($record['ghichu'])); ?></p>
                        </div>
                    </div>

                    <div class="action-buttons text-right">
                        <a href="index.php?action=admin_hosobenhan_edit&id=<?php echo $record['id']; ?>" class="btn btn-warning btn-action">
                            <i class="fa fa-edit"></i> Chỉnh sửa
                        </a>
                        <a href="index.php?action=admin_hosobenhan_list" class="btn btn-default btn-action">
                            <i class="fa fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        background: #fff;
        margin-bottom: 30px;
    }
    .card-header {
        background-color: #fff;
        border-bottom: 2px solid #f0f0f0;
        padding: 20px;
    }
    .medical-record {
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .record-section {
        margin-bottom: 25px;
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        transition: all 0.3s;
    }
    .record-section:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    .record-section h4 {
        color: #2c3e50;
        margin-bottom: 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    .record-section h4 i {
        margin-right: 10px;
        color: #4CAF50;
    }
    .record-label {
        font-weight: 600;
        color: #34495e;
        min-width: 150px;
        display: inline-block;
    }
    .record-value {
        color: #2c3e50;
    }
    .status-badge {
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 0.9em;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .status-active {
        background-color: #E8F5E9;
        color: #388E3C;
    }
    .status-completed {
        background-color: #ECEFF1;
        color: #546E7A;
    }
    .info-item {
        margin-bottom: 15px;
        padding: 12px;
        border-radius: 5px;
        transition: all 0.3s;
    }
    .info-item:hover {
        background: #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .btn {
        border-radius: 25px;
        padding: 8px 25px;
        transition: all 0.3s;
    }
    .btn-warning {
        background-color: #FFA726;
        border: none;
        color: white;
    }
    .btn-warning:hover {
        background-color: #FB8C00;
        transform: translateY(-2px);
        color: white;
    }
    .btn-default {
        border: 2px solid #4CAF50;
        color: #4CAF50;
        background: transparent;
    }
    .btn-default:hover {
        background-color: #4CAF50;
        color: white;
        transform: translateY(-2px);
    }
    .action-buttons {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #f0f0f0;
    }
    .btn-action {
        margin-left: 10px;
    }
    .btn-action i {
        margin-right: 5px;
    }
    .patient-info {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }
    .patient-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #E8F5E9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4CAF50;
        font-size: 24px;
    }
</style> 