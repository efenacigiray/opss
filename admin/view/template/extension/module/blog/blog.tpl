<?php echo $header; ?><?php echo $column_left; ?>
<div id="content"><div class="container-fluid">
	<div class="page-header">
	    <h1><?php $text_blog_dashboard ?></h1>
	    <ul class="breadcrumb">
		     <?php foreach ($breadcrumbs as $breadcrumb) { ?>
		      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		      <?php } ?>
	    </ul>
	  </div>
    
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:600,500,400' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
	<link href="view/javascript/summernote/summernote.css" rel="stylesheet" />
	<script type="text/javascript" src="view/javascript/summernote/opencart.js"></script>  
	
	
	<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
	<?php } elseif ($success) {  ?>
		<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
	<?php } ?>
    
    <?php echo $handy_box; ?>
    
		<div class="set-size" id="blog">
			<div class="content">
                <div>
                    <div class="page-title"><?php echo $text_blog_dashboard ?></div>
                    <div class="dashboard">
                        <ul>
                            <li><a href="<?php echo $link_add_edit_categories ?>" class="icon-category"><?php echo $text_add_edit_categories?></a></li>
                            <li><a href="<?php echo $link_add_edit_articles ?>" class="icon-article"><?php echo $text_add_edit_articles?></a></li>
                            <li><a href="<?php echo $link_add_edit_authors ?>" class="icon-author"><?php echo $text_add_edit_authors?></a></li>
                            <li><a href="<?php echo $link_add_edit_comments ?>" class="icon-comment"><?php echo $text_add_edit_comments?></a></li>
                            <li><a href="<?php echo $link_general_settings ?>" class="icon-settings"><?php echo $text_general_settings?></a></li>
                        </ul>
                        
                    </div>
                    <div class="modules">
                        <div class="title"><?php echo $text_modules ?>:</div>
                        <ul>
                            <li><a target="_blank" href="<?php echo $link_blog_category ?>"><?php echo $text_blog_category ?></a></li>
                            <li><a target="_blank" href="<?php echo $link_blog_search ?>"><?php echo $text_blog_search ?></a></li>
                            <li><a target="_blank" href="<?php echo $link_blog_latest_post ?>"><?php echo $text_blog_latest_post ?></a></li>
                            <li><a target="_blank" href="<?php echo $link_blog_popular_post ?>"><?php echo $text_blog_popular_post ?></a></li>
                            <li><a target="_blank" href="<?php echo $link_blog_product_related_post ?>"><?php echo $text_blog_product_related_post ?></a></li>
                            <li><a target="_blank" href="<?php echo $link_blog_popular_tags ?>"><?php echo $text_blog_popular_tags ?></a></li>
                        </ul>
                    </div>
                    <div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <?php echo $text_blog_front_information; ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                </div>
            </div>
        </div>
</div>
<script type="text/javascript">
$(document).ready(function() {

});
</script>
<?php echo $footer; ?>