<?php if(!empty($articles)):?> 
    <?php $index = 1; ?>
    <?php foreach($articles as $article):?>
    <div class="post post-with-3-columns">
        <div class="post-content">
            <?php if(!empty($article['gallery'])):?>
                <?php if($article['article_list_gallery_display'] == 'CLASSIC'):?>
                    <div class="post-media">
                        <?php echo $article['gallery'][0]['output'] ?>
                    </div>
                <?php endif; ?>
                <?php if($article['article_list_gallery_display'] == 'SLIDER'):?>
                    <div class="post-media">
                        <div class="media-slider">
                        <?php foreach($article['gallery'] as $gallery):?>
                            <div class="item"><?php echo $gallery['output'] ?></div>
                        <?php endforeach ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            
            <div class="tags">
                 <?php $s = 0; foreach($article['tags'] as $tag): ?>
                      <?php if($s < 2): ?><a href="<?php echo $tag['href']; ?>"><?php echo $tag['tag']; ?></a><?php endif; ?>
                 <?php $s++; endforeach; ?>
            </div>
            
            <div class="date-published">
                        <span class="day"><?php echo date('d', strtotime($article['date_published'])); ?></span>
                        <span class="month"><?php echo date('M', strtotime($article['date_published'])); ?></span>
            </div>
            
            <h2 class="post-title">
                 <a href="<?php echo $article['href'] ?>"><?php echo $article['title'] ?></a>
            </h2>

            <div class="post-description">
                <?php echo $article['description']?>
            </div>
            
            <a href="<?php echo $article['href'] ?>" class="button-more"><?php echo $button_read_more ?></a>
        </div>       
    </div>
    <?php $index++; ?>
    <?php endforeach; ?>

<?php endif; ?>