<section id="tintuc" class="tintuc">
    <div class="container">
        <h2 class="section-title">Tin Tức Mới Nhất</h2>
        <div class="row">
            <?php if (!empty($news)): ?>
                <?php foreach ($news as $news_item):
                    $clean_content = strip_tags($news_item['content']);
                    $short_content = strlen($clean_content) > 100 ? substr($clean_content, 0, 100) . '...' : $clean_content;
                ?>
                    <div class="col-12 col-md-3">
                        <div class="tintuc-item">
                            <img src="quantri/assets/image/<?php echo $news_item['image_url']; ?>" alt="Tin Tức <?php echo $news_item['id']; ?>">
                            <h3 class="tintuc-title"><a class="tintuc-color" href="index.php?action=tintuc_detail&id=<?php echo $news_item['id']; ?>"><?php echo $news_item['title']; ?></a></h3>
                            <?php if (!empty($short_content)): ?>
                                <p class="tintuc-description"><?php echo $short_content; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không có tin tức.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
<style>
    .tintuc-color{
        color: var(--primary-color);
    }
    /* Fix letter and word spacing, font, and color for all text in the news section */
    .tintuc, .tintuc * {
        letter-spacing: normal !important;
        word-spacing: normal !important;
        font-family: Arial, Helvetica, sans-serif !important;
        color: #222 !important;
    }
</style> 