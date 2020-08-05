<header class="header_10">
	<div class="overflow">
		<?php echo $currency.$language.$cart; ?>
		
		<?php if ($logo) { ?>
		<!-- Logo -->
		<h1 class="logo"><a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a></h1>
		<?php } ?>
		
		<?php 
		$menu = $modules->getModules('menu');
		if( count($menu) ) {
			foreach ($menu as $module) {
				echo $module;
			}
		}
		?>
		
		<div class="searchform-popup">
		    <a class="search-toggle"><i class="fa fa-search"></i></a>
		    <div class="searchform search_form">
		        <fieldset>
		            <span class="text">
		                <input type="text" name="search" class="input-block-level search-query" placeholder="<?php echo $search; ?>" required>
		            </span>
		            <span class="button-wrap">
		                <button class="button-search" title="Search" type="submit">
		                    <i class="fa fa-search"></i>
		                </button>
		            </span>
		        </fieldset>
		    </div>
		</div><!-- End .searchform -->
		<a class="mobile-toggle"><i class="fa fa-reorder"></i></a>
		
		<ul class="top-links">
		    <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
		    <li><a href="<?php echo $shopping_cart; ?>"><?php echo $text_shopping_cart; ?></a></li>
		    <li><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></li>
		    <?php if ($logged) { ?>
		    <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
		    <?php } else { ?>
		    <li><a href="<?php echo $login; ?>"><?php echo $text_login; ?></a></li>
		    <?php } ?>
		</ul>
		
		<?php 
		$top_block = $modules->getModules('top_block');
		if( count($top_block) ) { 
		 foreach ($top_block as $module) {
		  echo $module;
		 }
		} ?>
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