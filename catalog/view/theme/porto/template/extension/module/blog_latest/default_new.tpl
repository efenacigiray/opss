<?php
if($registry->has('theme_options') == false) { 
 header("location: themeinstall/index.php"); 
 exit; 
}
$theme_options = $registry->get('theme_options');
?>
<div class="widget">
    <div class="owl-carousel post-slider news2 close-dots">
    	<?php foreach($articles as $article):?>
        <div class="post-item clearfix">
            <div class="post-date2">
                <span class="day"><?php echo date('d', strtotime($article['date_published'])) ?></span>-<span class="month"><?php echo date('M', strtotime($article['date_published'])) ?></span>-<span class="year"><?php echo date('Y', strtotime($article['date_published'])) ?></span>
            </div><!-- end .post-date -->
            <h4>
                <a href="<?php echo $article['href']; ?>"><?php echo $article['title'] ?></a>
            </h4>
            <p class="post-excerpt"><?php echo substr($article['description'],0,101); ?>...</p>
        </div><!-- end .post-item -->
        <?php endforeach; ?>
    </div><!-- End .owl-carousel -->
</div><!-- End .widget -->