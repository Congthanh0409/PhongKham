<div class="container mt-5">
    <h2 class="text-center">Tin Tức Mới</h2>
    <div class="row">
        <?php if (!empty($news)): ?>
            <?php foreach ($news as $news_item): ?>
                <div class='col-md-4 mb-4'>
                    <div class='card'>
                        <img src='quantri/assets/image/<?php echo $news_item['image_url']; ?>' class='card-img-top' alt='Image'>
                        <div class='card-body'>
                            <h5 class='card-title'><?php echo $news_item['title']; ?></h5>
                            <?php
                            $clean_content = strip_tags($news_item['content']);
                            $short_content = strlen($clean_content) > 100 ? substr($clean_content, 0, 100) . '...' : $clean_content;
                            if (!empty($short_content)):
                            ?>
                                <p class='card-text'><?php echo $short_content; ?></p>
                            <?php endif; ?>
                            <p class='text-muted'>Ngày đăng: <?php echo $news_item['created_at']; ?></p>
                            <a href='index.php?action=tintuc_detail&id=<?php echo $news_item['id']; ?>' class='btn btn-primary'>Xem thêm</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Không có bài viết nào.</p>
        <?php endif; ?>
    </div>

    <!-- Phân trang -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item"><a class="page-link" href="index.php?action=tintuc_list&page=1">Đầu</a></li>
                <li class="page-item"><a class="page-link" href="index.php?action=tintuc_list&page=<?php echo $page - 1; ?>">Trước</a></li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="index.php?action=tintuc_list&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <li class="page-item"><a class="page-link" href="index.php?action=tintuc_list&page=<?php echo $page + 1; ?>">Sau</a></li>
                <li class="page-item"><a class="page-link" href="index.php?action=tintuc_list&page=<?php echo $total_pages; ?>">Cuối</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
<style>
/* Căn giữa và tạo khoảng cách cho các khung bài viết */
.btn-primary {
    background-color: var(--primary-color);
}
.card {
    width: 100%;
    max-width: 350px;
    height: 450px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
.card-img-top {
    height: 200px;
    object-fit: cover;
}
.card-body {
    flex-grow: 1;
    overflow: hidden;
    padding: 15px;
}
.card-title {
    font-size: 1.2em;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.card-text {
    font-size: 1em;
    color: #555;
    margin-bottom: 15px;
    height: 60px;
    overflow: hidden;
    text-overflow: ellipsis;
}
.card-body .btn {
    margin-top: auto;
    align-self: center;
}
.pagination {
    margin-top: 30px;
}
.pagination .page-item.active .page-link {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}
.pagination .page-item .page-link {
    color: var(--primary-color);
}
.pagination .page-item .page-link:hover {
    color: var(--primary-color);
    text-decoration: none;
}
.pagination .page-item.disabled .page-link {
    color: #6c757d;
}
</style> 