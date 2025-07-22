<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fa fa-folder-open"></i> Danh Sách Hồ Sơ Bệnh Án</h4>
                    <a href="index.php?action=admin_hosobenhan_add" class="btn btn-primary">Thêm Hồ Sơ</a>
                </div>
                <div class="card-body">
                    <?php if (!empty($success_message)): ?>
                        <div class="alert alert-success"><?php echo $success_message; ?></div>
                    <?php endif; ?>
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <form method="get" action="index.php">
                        <input type="hidden" name="action" value="admin_hosobenhan_list">
                        <div class="input-group mb-3">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="text" class="form-control" name="search" placeholder="Tìm kiếm theo tên bệnh nhân, ghi chú, bác sĩ..." value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Bệnh Nhân</th>
                                    <th>Bác Sĩ</th>
                                    <th>Ngày Khám</th>
                                    <th>Trạng Thái</th>
                                    <th>Ghi Chú</th>
                                    <th>Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($records)): ?>
                                    <tr><td colspan="7" class="empty-state"><i class="fa fa-folder-open"></i><br>Không có hồ sơ nào.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($records as $i => $row): ?>
                                        <tr>
                                            <td><?php echo $i + 1 + ($page - 1) * 10; ?></td>
                                            <td><?php echo htmlspecialchars($row['benhnhan_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['bacsi']); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($row['ngaykham'])); ?></td>
                                            <td>
                                                <span class="status-badge <?php echo $row['trangthai'] === 'active' ? 'status-active' : 'status-completed'; ?>">
                                                    <?php echo $row['trangthai'] === 'active' ? 'Đang điều trị' : 'Hoàn thành'; ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlspecialchars(mb_strimwidth($row['ghichu'], 0, 60, '...')); ?></td>
                                            <td>
                                                <a href="index.php?action=admin_hosobenhan_view&id=<?php echo $row['id']; ?>" class="btn btn-info btn-action">Xem</a>
                                                <a href="index.php?action=admin_hosobenhan_edit&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-action">Sửa</a>
                                                <a href="index.php?action=admin_hosobenhan_delete&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-action" onclick="return confirm('Bạn có chắc chắn muốn xóa hồ sơ này?')">Xóa</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                        <nav>
                            <ul class="pagination">
                                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                                    <li class="page-item <?php if ($p == $page) echo 'active'; ?>">
                                        <a class="page-link" href="index.php?action=admin_hosobenhan_list&page=<?php echo $p; ?>&search=<?php echo urlencode($search); ?>"><?php echo $p; ?></a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section> 