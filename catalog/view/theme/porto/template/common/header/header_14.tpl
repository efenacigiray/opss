 <?php // Fixed header
 if($theme_options->get( 'fixed_header' ) == 1) { ?>
<header id="header2" class="header1 header13 type14 fixed-header">
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
  
            <header id="header" class="header2 header13">
                <div id="header-inner">
                    <div class="container" style="display: block">
                        <div class="container" style="display: table;width: 100% !important;padding: 0px;position: relative">
	                        <div class="header-left">
	                        	<?php if ($logo) { ?>
	                        	<!-- Logo -->
	                        	<h1 class="logo"><a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a></h1>
	                        	<?php } ?>
	                        </div><!-- End .header-left -->
							
							<div class="header-center">
								
								<?php 
								$menu = $modules->getModules('menu');
								if( count($menu) ) {
									foreach ($menu as $module) {
										echo $module;
									}
								}
								?>
							</div>
							
	                        <div class="header-right">
	                            <div class="header-minicart-inline">
	                                <a class="mobile-toggle"><i class="fa fa-reorder"></i></a>
	                                <div class="block-nowrap">
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
	                                    <div class="searchform-popup">
	                                        <a class="search-toggle"><i class="fa fa-search"></i></a>
	                                    </div><!-- End .searchform -->
	                                </div>
	                                <br class="hidden-xs">
	
	                                <div class="switcher-wrap hidden-xs">
	                                    <?php echo $currency.$language; ?>
	                                </div><!-- End .swticher-wrap -->
	                                
	                                <?php echo $cart; ?>
	                            
	                            </div><!-- End .header-mini-cart -->
	                            
	                        </div><!-- End .header-right -->
                        </div>
                    </div><!-- End .container -->
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