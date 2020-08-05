<?php
if($registry->has('theme_options') == false) { 
 header("location: themeinstall/index.php"); 
 exit; 
}
$theme_options = $registry->get('theme_options');
$class = 'col-sm-3 col-xs-6';
if($settings['article_related_per_row'] == 6) { $class = 'col-sm-2 col-xs-6'; }
if($settings['article_related_per_row'] == 5) { $class = 'col-sm-25 col-xs-6'; }
if($settings['article_related_per_row'] == 3) { $class = 'col-sm-4 col-xs-12'; }
?>
<div class="blog-module box-no-advanced" style="padding-top: 20px;padding-bottom: 10px">
	<h2 class="slider-title"><span class="inline-title"><?php echo $text_related_articles; ?></span><span class="line"></span></h2>
    <div class="strip-line"></div>
    <div class="box-content">
        <?php if(!empty($articles)):?> 
        <div class="news v2 row">
            <?php foreach($articles as $article2):?>
            <div class="<?php echo $class; ?>">
                <div class="media">
                        <?php if($article2['thumb']):?>
                        <div  class="thumb-holder">
                            <img alt="" src="<?php echo $article2['thumb'] ?>"></a>
                        </div>
                        <?php endif; ?>
                        
                        <div class="media-body" onclick="window.location.href = '<?php echo $article2['href']; ?>'">
                             <div class="tags">
                                  <?php $s = 0; foreach($article2['tags'] as $tag): ?>
                                       <?php if($s < 2): ?><a href="<?php echo $tag['href']; ?>"><?php echo $tag['tag']; ?></a><?php endif; ?>
                                  <?php $s++; endforeach; ?>
                             </div>
                             
                             <div class="bottom">
                                 <div class="date-published"><?php echo date('d.m.Y', strtotime($article2['date_published'])) ?></div>
                                 <h5><a href="<?php echo $article2['href']; ?>"><?php echo $article2['title'] ?></a></h5>
                             </div>
                        </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
