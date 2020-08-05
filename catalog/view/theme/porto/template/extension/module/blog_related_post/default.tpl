<?php
if($registry->has('theme_options') == false) { 
 header("location: themeinstall/index.php"); 
 exit; 
}
$theme_options = $registry->get('theme_options');
?>
<?php if(!empty($articles)):?> 
<div class="box blog-module blog-product-related-posts box-no-advanced">
    <div class="box-heading"><?php echo $heading_title; ?></div>
    <div class="strip-line"></div>
    <div class="box-content box-product-related-posts">
        <ul class="blog-list-default">
            <?php foreach($articles as $article):?>
            <li>
                <div class="media">
                    <a href="<?php echo $article['href']; ?>">
                        <?php if($article['thumb']):?>
                        <div  class="thumb-holder">
                            <img alt="" src="<?php echo $article['thumb'] ?>">
                        </div>
                        <?php endif; ?>
                        <div class="media-body">
                            <div class="date-published"><?php echo date('d.m.Y', strtotime($article['date_published'])) ?></div>
                            <h5><?php echo $article['title'] ?></h5>
                        </div>
                    </a>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php endif; ?>