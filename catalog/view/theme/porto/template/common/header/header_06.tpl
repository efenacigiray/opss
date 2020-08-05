 <?php // Fixed header
 if($theme_options->get( 'fixed_header' ) == 1) { ?>
<header id="header2" class="header1 type6 fixed-header">
    <div id="header-inner">   
    	<div class="container"><div style="position: relative">
	    	<?php if ($logo) { ?>
	    	<!-- Logo -->
	    	<h1 class="logo"><a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a></h1>
	    	<?php } ?>
	    	
	    	<?php echo $cart; ?>
	    	                 
	        <?php 
	        $menu = $modules->getModules('menu');
	        if( count($menu) ) {
	        	foreach ($menu as $module) {
	        		echo $module;
	        	}
	        }
	        ?>
        </div></div>
    </div><!-- End #header-inner -->
</header><!-- End #header -->
 <?php } ?>

<header id="header" class="header55">
	<div class="left">
		<a class="mobile-toggle"><i class="fa fa-reorder"></i></a>
		<?php 
		$menu = $modules->getModules('menu');
		if( count($menu) ) {
			foreach ($menu as $module) {
				echo $module;
			}
		}
		?>
	</div>
	
	<?php if ($logo) { ?>
	<!-- Logo -->
	<h1 class="logo"><a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a></h1>
	<?php } ?>
	
	<div class="right">
		<ul class="top-links">
		    <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
		    <li><a href="<?php echo $shopping_cart; ?>"><?php echo $text_shopping_cart; ?></a></li>
		    <li><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></li>
		</ul>
		<?php echo $currency.$language.$cart; ?>
	</div>
</header><!-- End #header -->

<?php $slideshow = $modules->getModules('slideshow'); ?>
<?php  if(count($slideshow)) { ?>
<!-- Slider -->
<div id="slider">
	<div class="background-slider"></div>
	<div class="background">
		<div class="shadow"></div>
		<div class="pattern">
			<?php foreach($slideshow as $module) { ?>
			<?php echo $module; ?>
			<?php } ?>
		</div>
	</div>
</div>
<?php } ?>