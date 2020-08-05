<div class="widget">
    <h3 class="widget-title"><?php echo $module['content']['title']; ?></h3>
    <div class="row">
        <div class="post-slide">
        	<?php foreach($module['content']['articles'] as $article) { ?>
            <div class="post-item-small">
                <div class="post-image thumbnail">
                    <a href="<?php echo $article['href']; ?>">
                        <img src="<?php echo $article['thumb']; ?>" alt="Post">
                    </a>
                </div>
                <a href="<?php echo $article['href']; ?>"><?php echo $article['title']; ?></a>
                <span class="post-date"><?php echo date('M d, Y', strtotime($article['date_published'])); ?></span>
            </div>
            <?php } ?>
        </div>
    </div>
</div><!-- End .widget -->