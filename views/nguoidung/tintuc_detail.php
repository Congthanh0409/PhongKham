<div class='article-container'>
    <div class='article-content'>
        <h1><?php echo $article['title']; ?></h1>
        <p><strong>Ngày đăng: </strong><?php echo $article['created_at']; ?></p>
        <img src='quantri/assets/image/<?php echo $article['image_url']; ?>' alt='Image' class='img-fluid'>
        <p><?php echo $article['content']; ?></p>
    </div>

    <div class='article-navbar'>
        <div class='recommended'>
            <h3>Bài viết khác</h3>
            <ul>
                <?php foreach ($otherArticles as $otherArticle): ?>
                    <li><a href='index.php?action=tintuc_detail&id=<?php echo $otherArticle['id']; ?>'><i class='fas fa-newspaper'></i><?php echo $otherArticle['title']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<style>
/* Căn giữa nội dung bài viết và tạo khoảng trắng hai bên */
.article-container {
    width: 100%; /* Chiều rộng của container */
    max-width: 1200px; /* Đặt chiều rộng tối đa của khung bài viết */
    margin: 0 auto; /* Căn giữa nội dung */
    padding: 20px; /* Thêm khoảng cách trong khung */
    box-sizing: border-box; /* Đảm bảo padding không làm tăng kích thước */
}

/* Căn giữa bài viết trong khung */
.article-content {
    background-color: var(--bg-color); /* Màu nền cho phần nội dung bài viết */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Đổ bóng cho khung bài viết */
}

/* Định dạng cho tiêu đề bài viết */
.article-content h1 {
    font-size: 2em;
    color: #333;
    font-weight: bold;
    margin-bottom: 20px;
}

/* Định dạng cho nội dung bài viết */
.article-content p {
    line-height: 1.6;
    font-size: 1.1em;
    color: #555;
    margin-bottom: 20px;
}

/* Định dạng hình ảnh trong bài viết */
.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 20px;
}

/* Định dạng phần navbar bài viết */
.article-navbar {
    position: sticky;
    top: 20px;
    background-color: var(--bg-color);
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
}

/* Khung bài viết khác */
.article-navbar .recommended {
    margin-bottom: 20px;
    padding: 10px;
    background-color: var(--bg-color);
    border: 1px solid #ddd;
    border-radius: 8px;
}

.article-navbar .recommended h3 {
    font-size: 1.3em;
    font-weight: bold;
    color: var(--primary-color);
    margin-bottom: 10px;
}

.article-navbar ul {
    list-style-type: none;
    padding: 0;
}

.article-navbar li {
    margin-bottom: 10px;
}

.article-navbar li a {
    color: #333;
    text-decoration: none;
    font-size: 1.1em;
}

.article-navbar li a:hover {
    color: var(--primary-color);
}

/* Thêm icon chiếc răng vào */
.article-navbar li a i {
    margin-right: 8px;
}

/* Tối ưu hóa giao diện trên thiết bị di động */
@media (max-width: 768px) {
    .article-container {
        padding: 10px;
    }

    .article-navbar {
        position: relative;
        width: 100%;
        margin-top: 20px;
    }
}
</style> 