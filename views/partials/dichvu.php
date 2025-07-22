<section id="dich-vu" class="dich-vu">
    <div class="container">
        <h2 class="text-center">Dịch Vụ Của Chúng Tôi</h2>
        <div class="row">
            <?php foreach ($services as $service): ?>
                <div class="col-md-4">
                    <div class="service-item">
                        <img src="quantri/assets/image/<?php echo $service['image_url']; ?>" alt="<?php echo $service['title']; ?>" class="service-img">
                        <h4 class="service-title"><?php echo $service['title']; ?></h4>
                        <p class="service-description"><?php echo $service['content']; ?></p>
                        <a href="index.php?action=dichvu_detail&id=<?php echo $service['id']; ?>" class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<style>.service-item {
    position: relative; 
    padding: 20px;
    background-color: var(--bg-color);
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px; 
    overflow: hidden; 
}

.service-item .btn {
    position: absolute; 
    bottom: 20px; 
    left: 50%; 
    transform: translateX(-50%); 
    background-color:var(--primary-color);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
}

.service-item .btn:hover {
    background-color:var(--primary-color);
    cursor: pointer;
}
</style> 