 <?php // Fixed header
 if($theme_options->get( 'fixed_header' ) == 1) { ?>
<header id="header2" class="header1 type17 header18 fixed-header">
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
 
            <header id="header" class="header18">
                <div id="header-top">
                    <div class="container">
                        <div class="header-left">
                            <div class="switcher-wrap">	
                            	<a class="mobile-toggle"><i class="fa fa-reorder"></i></a>
                            	<div class="searchform-popup">
                            	    <a class="search-toggle"><i class="fa fa-search"></i></a>
                            	</div><!-- End .searchform -->
                            	<span class="separator hidden-xs hidden-sm">|</span>
                            	<div class="overflow-currency-language"><?php echo $currency.$language; ?></div>
                            </div><!-- End .swticher-wrap -->
                            
                        </div><!-- End .header-left -->
                        <div class="header-right">
                        	<?php 
                        	$top_block = $modules->getModules('top_block');
                        	if( count($top_block) ) { 
                        	 foreach ($top_block as $module) {
                        	  echo $module;
                        	 }
                        	} ?>
                            <ul class="top-links">
                                <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
                                <li><a href="<?php echo $shopping_cart; ?>"><?php echo $text_shopping_cart; ?></a></li>
                                <li><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></li>
                            </ul>
                            <span class="separator hidden-xs hidden-sm" style="margin: 0px 3px">|</span>
                            <?php echo $cart; ?>
                        </div><!-- End .header-left -->
                    </div><!-- end .container -->
                </div><!-- End #header-top -->
                
                <div id="header-inner">
                    <div class="container">
                        <div class="header-left">
                        	<?php if ($logo) { ?>
                        	<!-- Logo -->
                        	<h1 class="logo"><a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a></h1>
                        	<?php } ?>
                        </div><!-- End .header-left -->
                    </div><!-- End .container -->
                    
                    <?php 
                    $menu = $modules->getModules('menu');
                    if( count($menu) ) {
                    	foreach ($menu as $module) {
                    		echo $module;
                    	}
                    }
                    ?>
                </div><!-- End #header-inner -->
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