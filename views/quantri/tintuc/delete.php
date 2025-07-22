<section class="wrapper">
    <h3>Xóa Tin Tức</h3>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <p>Bạn có chắc chắn muốn xóa tin tức "<?php echo htmlspecialchars($news['title']); ?>"?</p>
        <button type="submit" class="btn btn-danger">Xóa</button>
        <a href="index.php?action=admin_tintuc_list" class="btn btn-secondary">Hủy</a>
    </form>
</section> 