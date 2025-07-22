<section class="wrapper">
    <h3>Xóa Giới Thiệu</h3>
    <p>Bạn có chắc chắn muốn xóa mục "<strong><?php echo htmlspecialchars($record['title']); ?></strong>"?</p>
    <p class="text-danger">Hành động này không thể hoàn tác.</p>
    <form method="POST" action="index.php?action=admin_gioithieu_delete&id=<?php echo $record['id']; ?>">
        <button type="submit" class="btn btn-danger">Xóa Vĩnh Viễn</button>
        <a href="index.php?action=admin_gioithieu_list" class="btn btn-secondary">Hủy</a>
    </form>
</section> 