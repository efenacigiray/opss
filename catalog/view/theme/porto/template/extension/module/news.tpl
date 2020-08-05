<div class="box ">
	<div class="box-heading"><?php echo $heading_title; ?></div>
	<div class="strip-line"></div>
	<div class="box-content box-blog-latest">
		<?php if( !empty($article) ) { ?>
		<div class="blog-latest row">
			<?php 
			$columns = 12;
			if(count($article) == 2) $columns = 6;
			if(count($article) == 3) $columns = 4;
			if(count($article) == 4) $columns = 3;
			if(count($article) == 5) $columns = 25;
			if(count($article) == 6) $columns = 2;
			foreach ($article as $articles) { ?>
			<div class="col-sm-<?php echo $columns; ?>">
				<?php if ($articles['thumb']) { ?>
					<a href="<?php echo $articles['href']; ?>" style="background-image: url(<?php echo $articles['thumb']; ?>)"></a>
				<?php } ?>
				
				<?php if ($articles['name']) { ?>
					<h4><a href="<?php echo $articles['href']; ?>"><?php echo $articles['name']; ?></a></h4>
				<?php } ?>
				
				<div class="article-meta">
				     <i class="fa fa-calendar"></i> 
					<?php if ($articles['author']) { ?>
						<?php echo $text_posted_by; ?> <a href="<?php echo $articles['author_link']; ?>"><?php echo $articles['author']; ?></a>
					<?php } ?>
					<?php if ($articles['date_added']) { ?>
						<?php if ($articles['author']) { ?><?php echo $text_posted_on; ?><?php } else { ?><?php echo $text_posted_pon; ?><?php } ?> <?php echo $articles['date_added']; ?>
					<?php } ?>
				</div>
				
				<?php if ($articles['date_added']) { ?>
				<div class="article-date-added">
					<i class="fa fa-calendar"></i> <?php echo $articles['date_added']; ?>
				</div>
				<?php } ?>
				
				<?php if ($articles['thumb']) { ?>
					<a href="<?php echo $articles['href']; ?>"><img src="<?php echo $articles['thumb']; ?>" title="<?php echo $articles['name']; ?>" class="article-image" alt="<?php echo $articles['name']; ?>" /></a>
				<?php } ?>
				
				<?php if ($articles['description']) { ?>			
					<div class="description">
						<?php if($columns == 12) { echo $articles['description']; } else { echo utf8_substr( $articles['description'] , 0, 200 ); } ?>
					</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
	</div>
</div>

<script type="text/javascript"><!--
	$(document).ready(function() {
		$('img.article-image').each(function(index, element) {
     		var articleWidth = $(this).parent().parent().width() * 0.7;
     		var imageWidth = $(this).width() + 10;
     		if (imageWidth < articleWidth) {
     		     $(this).attr("align","left").css("margin-right", "20px");
     		}
		});
	});
//--></script>