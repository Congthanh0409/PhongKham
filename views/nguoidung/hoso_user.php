<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">
            <div class="text-center mb-4">
                <img src="<?= !empty($user['avatar']) ? 'nguoidung/uploads/avatars/' . $user['avatar'] : 'nguoidung/assets/images/default-avatar.png' ?>"
                     class="rounded-circle" width="120" height="120" style="object-fit: cover; border: 3px solid #2196F3;">
                <h3 class="mt-3 text-primary">Hồ sơ khám bệnh của bạn</h3>
            </div>
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <?php if (empty($hoso_data)): ?>
                <div class="alert alert-info text-center">Bạn chưa có hồ sơ bệnh án nào.</div>
            <?php else: ?>
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Số lần khám</th>
                            <th>Ngày khám</th>
                            <th>Bác sĩ</th>
                            <th>Trạng thái</th>
                            <th>Chuẩn đoán của bác sĩ</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($hoso_data as $index => $row): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= date('d/m/Y', strtotime($row['ngaykham'])) ?></td>
                                <td><?= htmlspecialchars($row['bacsi']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $row['trangthai'] === 'active' ? 'success' : 'secondary' ?>">
                                        <?= $row['trangthai'] === 'active' ? 'Đang điều trị' : 'Hoàn thành' ?>
                                    </span>
                                </td>
                                <td>
                                    <?= strlen($row['ghichu']) > 100 
                                        ? htmlspecialchars(substr($row['ghichu'], 0, 100)) . '...' 
                                        : htmlspecialchars($row['ghichu']) ?>
                                </td>
                                <td>
                                    <a href="index.php?action=hoso_detail&id=<?= $row['id'] ?>" class="btn btn-sm btn-info">
                                         Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div> 