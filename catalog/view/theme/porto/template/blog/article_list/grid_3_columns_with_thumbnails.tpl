<?php if(!empty($articles)):?>
     <?php $s = 0; foreach($articles as $article): ?>
          <?php if($s == 0): ?>
          <div class="big-news post">
             <div class="post-content" onclick="window.location.href = '<?php echo $article['href']; ?>'">
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
                 
                 <div class="right">
                      <div class="overflow">
                           <div class="tags">
                                <?php $s = 0; foreach($article['tags'] as $tag): ?>
                                     <?php if($s < 2): ?><a href="<?php echo $tag['href']; ?>"><?php echo $tag['tag']; ?></a><?php endif; ?>
                                <?php $s++; endforeach; ?>
                           </div>
                           
                           <div class="date-published"><?php echo date('d.m.Y', strtotime($article['date_published'])); ?></div>
                           
                           <h2 class="post-title">
                                <a href="<?php echo $article['href'] ?>"><?php echo $article['title'] ?></a>
                           </h2>
               
                           <div class="post-description">
                               <?php echo $article['description']?>
                           </div>
                           
                           <a href="<?php echo $article['href'] ?>" class="button-more"><?php echo $button_read_more ?></a>
                      </div>
                 </div>
             </div>       
          </div>
          <?php endif; ?>
     <?php $s++; endforeach; ?>
     
    <div class="news v1 row clearfix">
        <?php foreach($articles as $article):?>
        <div class="col-sm-4 col-xs-6">
            <div class="media">
                    <?php if($article['thumb']):?>
                    <div  class="thumb-holder">
                        <img alt="" src="<?php echo $article['thumb'] ?>"></a>
                    </div>
                    <?php endif; ?>
                    
                    <div class="media-body" onclick="window.location.href = '<?php echo $article['href']; ?>'">
                         <div class="tags">
                              <?php $s = 0; foreach($article['tags'] as $tag): ?>
                                   <?php if($s < 2): ?><a href="<?php echo $tag['href']; ?>"><?php echo $tag['tag']; ?></a><?php endif; ?>
                              <?php $s++; endforeach; ?>
                         </div>
                         
                         <div class="bottom">
                             <div class="date-published"><?php echo date('d.m.Y', strtotime($article['date_published'])) ?></div>
                             <h5><?php echo $article['title'] ?></h5>
                         </div>
                    </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>