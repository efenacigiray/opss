<?php 
$theme_options = $registry->get('theme_options');
$config = $registry->get('config');
$class = 3; 
$id = rand(0, 5000)*rand(5000, 50000);
$all = $cols*$itemsperpage; 
$row = $itemsperpage; 

if($itemsperpage == 1) $class = 12;
if($itemsperpage == 2) $class = 6;
if($itemsperpage == 3) $class = 4;
if($itemsperpage == 4) $class = 3;
if($itemsperpage == 5) $class = 25;
if($itemsperpage == 6) $class = 2;
$page_direction = $theme_options->get( 'page_direction' );

if(count($tabs) > 1 ) { ?>
<div class="tabs-container">
    <!-- Nav tabs -->
    <div class="title-group">
        <ul class="nav nav-tabs nav-links">
        	<?php $i = 0; foreach($tabs as $tab) {
        		echo '<li'.($i == 0 ? ' class="active"' : '').' role="presentation"><a href="#'.$tab['title'].'-'.$id.'-'.$i.'" aria-controls="'.$tab['title'].'-'.$id.'-'.$i.'" role="tab" data-toggle="tab">'.$tab['heading'].'</a></li>';
        	$i++; } ?>
        </ul>
        <span class="line"></span>
    </div><!-- End .title-group -->

	<div class="tab-content clearfix">
		<?php if($carousel != 0) { ?>
			<?php $s = 0; foreach($tabs as $tab) { ?>
			<script type="text/javascript">
			$(document).ready(function() {
			  var owl<?php echo $id; ?> = $("#myCarousel<?php echo $id.'-'.$s; ?>");
			  owl<?php echo $id; ?>.owlCarousel({
			  	  loop:false,
			  	  margin:16,
			  	  responsiveClass:true,
			  	  nav:true,
			  	  navText: ['<i class="fa fa-chevron-left">', '<i class="fa fa-chevron-right">'],
			  	  autoplay: true,
			  	  autoplayTimeout: 10000,
			  	  <?php if($page_direction[$config->get( 'config_language_id' )] == 'RTL'): ?>
			  	  rtl: true,
			  	  <?php endif; ?>
			  	  responsive:{
			  	  	0:{
			  	  		items:1
			  	  	},
			  	  	480: {
			  	  		items:2
			  	  	},
			  	  	768:{
			  	  		items:<?php echo $itemsperpage; ?>
			  	  	}
			  	  }
			   });
			});
			</script>
			<div class="tab-pane <?php if($s == 0) { echo 'active'; } ?>" id="<?php echo $tab['title'].'-'.$id.'-'.$s; ?>">
				<div class="box-product">
					<div id="myCarousel<?php echo $id.'-'.$s; ?>" class="owl-carousel slide">
						<?php $i = 0; $row_fluid = 0; foreach ($tab['products'] as $product) { ?>
			    			<?php include('catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/template/new_elements/product.tpl'); ?>
						<?php $i++; } ?>
					</div>
				</div>
			</div>
			<?php $s++; } ?>
		<?php } else { ?>
			<?php $s = 0; foreach($tabs as $tab) { ?>
			<div class="tab-pane <?php if($s == 0) { echo 'active'; } ?>" id="<?php echo $tab['title'].'-'.$id.'-'.$s; ?>">
				<div style="position: relative;margin-bottom: -30px">
					  <?php $i = 0; $row_fluid = 0; $item = 0; foreach ($tab['products'] as $product) { $row_fluid++; ?>
					  	<?php if($i == 0) { $item++; echo '<div class="active item"><div class="product-grid"><div class="row">'; } ?>
					  	<?php $r=$row_fluid-floor($row_fluid/$all)*$all; if($row_fluid>$all && $r == 1) { if($carousel != '0') { echo '</div></div></div><div class="item"><div class="product-grid"><div class="row">'; $item++; } else { echo '</div><div class="row">'; } } else { $r=$row_fluid-floor($row_fluid/$row)*$row; if($row_fluid>$row && $r == 1) { echo '</div><div class="row">'; } } ?>
					  	<div style="padding-bottom: 30px" class="col-sm-<?php echo $class; ?> col-xs-6 <?php if($class == 2) { echo 'col-md-25 col-lg-2 col-sm-3 '; } if($class == 2 && $r == 0) { echo 'hidden-md hidden-sm'; } if($class == 2 && $r == 5) { echo 'hidden-sm'; } ?> <?php if($class == 25) { echo 'col-md-25 col-lg-25 col-sm-3 '; } if($class == 25 && $r == 0) { echo 'hidden-sm'; } ?>">
					  		<?php include('catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/template/new_elements/product.tpl'); ?>
					  	</div>
					  <?php $i++; } ?>
					  <?php if($i > 0) { echo '</div></div></div>'; } ?>
				</div>
			</div>
			<?php $s++; } ?>
		<?php } ?>
	</div>
</div>
 
<script type="text/javascript">
$('#tab<?php echo $id; ?> a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
})
</script>
<?php } else { ?>
<?php foreach($tabs as $tab) { ?>
  <?php if($carousel != 0) { ?>
	  <script type="text/javascript">
	  $(document).ready(function() {
	    var owl<?php echo $id; ?> = $("#myCarousel<?php echo $id; ?>");
	    owl<?php echo $id; ?>.owlCarousel({
	    	  loop:false,
	    	  margin:16,
	    	  responsiveClass:true,
	    	  nav:true,
	    	  navText: ['<i class="fa fa-chevron-left">', '<i class="fa fa-chevron-right">'],
	    	  autoplay: true,
	    	  autoplayTimeout: 10000,
	    	  <?php if($page_direction[$config->get( 'config_language_id' )] == 'RTL'): ?>
	    	  rtl: true,
	    	  <?php endif; ?>
	    	  responsive:{
	    	  	0:{
	    	  		items:1
	    	  	},
	    	  	480: {
	    	  		items:2
	    	  	},
	    	  	768:{
	    	  		items:<?php echo $itemsperpage; ?>
	    	  	}
	    	  }
	     });
	  });
	  </script>
		<div class="carousel-wrapper clearfix <?php if($itemsperpage == 6) { echo ' six-products'; } ?>">
		  <h2 class="slider-title">
		  	<span class="inline-title"><?php echo $tab['heading']; ?></span>
		  	<span class="line"></span>
		  </h2>
		  <div class="owl-carousel home-products-carousel" id="myCarousel<?php echo $id; ?>">
		    	<?php $i = 0; $row_fluid = 0; $item = 0; foreach ($tab['products'] as $product) { ?>
			    	<?php include('catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/template/new_elements/product.tpl'); ?>
			    <?php } ?>
		  </div>
		</div>
	<?php } else { ?>
		<div class="carousel-wrapper">
		  <h2 class="slider-title">
		  	<span class="inline-title"><?php echo $tab['heading']; ?></span>
		  	<span class="line"></span>
		  </h2>
		  <div style="position: relative;margin-bottom: -30px">
			  <?php $i = 0; $row_fluid = 0; $item = 0; foreach ($tab['products'] as $product) { $row_fluid++; ?>
			  	<?php if($i == 0) { $item++; echo '<div class="active item"><div class="product-grid"><div class="row">'; } ?>
			  	<?php $r=$row_fluid-floor($row_fluid/$all)*$all; if($row_fluid>$all && $r == 1) { if($carousel != '0') { echo '</div></div></div><div class="item"><div class="product-grid"><div class="row">'; $item++; } else { echo '</div><div class="row">'; } } else { $r=$row_fluid-floor($row_fluid/$row)*$row; if($row_fluid>$row && $r == 1) { echo '</div><div class="row">'; } } ?>
			  	<div style="padding-bottom: 30px" class="col-sm-<?php echo $class; ?> col-xs-6 <?php if($class == 2) { echo 'col-md-25 col-lg-2 col-sm-3 '; } if($class == 2 && $r == 0) { echo 'hidden-md hidden-sm'; } if($class == 2 && $r == 5) { echo 'hidden-sm'; } ?> <?php if($class == 25) { echo 'col-md-25 col-lg-25 col-sm-3 '; } if($class == 25 && $r == 0) { echo 'hidden-sm'; } ?>">
			  		<?php include('catalog/view/theme/'.$config->get('theme_' . $config->get('config_theme') . '_directory').'/template/new_elements/product.tpl'); ?>
			  	</div>
			  <?php $i++; } ?>
			  <?php if($i > 0) { echo '</div></div></div>'; } ?>
		  </div>
		</div>
	<?php } ?>
<?php } ?>
<?php } ?>