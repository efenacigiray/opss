<?php
if($registry->has('theme_options') == false) { 
 header("location: themeinstall/index.php"); 
 exit; 
}
$theme_options = $registry->get('theme_options');
?>
<div class="box blog-module blog-tags">
    <div class="box-heading"><?php echo $heading_title; ?></div>
    <div class="strip-line"></div>
    <div class="box-content box-tags">
        <?php if(!empty($tags)):?>
        <div class="tagcloud">
            <?php foreach($tags as $tag): ?>
			<a href="<?php echo $tag['href'] ?>"><?php echo $tag['tag'] ?></a> 
            <?php endforeach; ?>
		</div>
        <?php endif; ?>
    </div>
</div>