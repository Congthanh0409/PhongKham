<section id="chungnhan" class="chungnhan">
    <div class="container">
        <h2 class="section-title">Tiêu Chuẩn Chứng Nhận Quốc Gia</h2>
        <div class="row">
            <?php if (!empty($certifications)): ?>
                <?php foreach ($certifications as $cert): ?>
                    <div class="col-md-3">
                        <div class="chungnhan-item">
                            <img src="quantri/assets/image/<?php echo $cert['certification_image']; ?>" alt="Chứng nhận">
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Hiện chưa có chứng nhận nào được thêm.</p>
            <?php endif; ?>
        </div>
    </div>
</section> 