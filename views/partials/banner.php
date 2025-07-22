<div id="carouselBanner" class="carousel slide" data-ride="carousel" data-interval="5000">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php foreach ($banners as $index => $banner): ?>
            <li data-target="#carouselBanner" data-slide-to="<?php echo $index; ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>"></li>
        <?php endforeach; ?>
    </ol>

    <!-- Carousel items -->
    <div class="carousel-inner">
        <?php foreach ($banners as $index => $banner): ?>
            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                <img src="quantri/assets/image/<?php echo $banner['image_url']; ?>" class="d-block w-100" alt="Banner">
            </div>
        <?php endforeach; ?>
    </div>
</div> 