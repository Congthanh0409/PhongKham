<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <h4 class="text-primary mb-4"><i class="fas fa-notes-medical"></i> Chi tiết hồ sơ bệnh án</h4>
            <dl class="row">
                <dt class="col-sm-3">Ngày khám:</dt>
                <dd class="col-sm-9"><?= date('d/m/Y', strtotime($hoso['ngaykham'])) ?></dd>
                <dt class="col-sm-3">Bác sĩ:</dt>
                <dd class="col-sm-9"><?= htmlspecialchars($hoso['bacsi']) ?></dd>
                <dt class="col-sm-3">Trạng thái:</dt>
                <dd class="col-sm-9">
                    <span class="badge bg-<?= $hoso['trangthai'] === 'active' ? 'success' : 'secondary' ?>">
                        <?= $hoso['trangthai'] === 'active' ? 'Đang điều trị' : 'Hoàn thành' ?>
                    </span>
                </dd>
                <dt class="col-sm-3">Ghi chú:</dt>
                <dd class="col-sm-9"><?= nl2br(htmlspecialchars($hoso['ghichu'])) ?></dd>
            </dl>
            <a href="index.php?action=hoso_user" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left"></i> Quay lại danh sách</a>
        </div>
    </div>
</div> 