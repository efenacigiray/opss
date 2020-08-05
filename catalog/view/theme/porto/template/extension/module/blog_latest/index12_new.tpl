<?php
if($registry->has('theme_options') == false) { 
 header("location: themeinstall/index.php"); 
 exit; 
}
$theme_options = $registry->get('theme_options');
?>
<h2 class="filter-title" style="margin-bottom: 20px"><strong><?php echo $heading_title; ?></strong></h2>
<?php foreach($articles as $article):?>
<div class="index12newpost">
    <div class="post-image">
        <a href="<?php echo $article['href']; ?>">
            <?php if($article['thumb']):?>
                <img alt="" src="<?php echo $article['thumb'] ?>">
            <?php endif; ?>
        </a>
        <div class="post-date">
            <span class="day"><?php echo date('d', strtotime($article['date_published'])) ?></span>
            <span class="month"><?php echo date('M', strtotime($article['date_published'])) ?></span>
        </div><!-- end .post-date -->
    </div><!-- End .post-image -->
    <h4>
        <a href="<?php echo $article['href']; ?>"><?php echo $article['title'] ?></a>
    </h4>
    <p class="post-excerpt"><?php echo substr($article['description'],0,71); ?>...<br><a class="read-more" href="<?php echo $article['href']; ?>">(<?php echo $button_read_more; ?>)</a></p>
</div><!-- end .post-item -->
<?php endforeach; ?>