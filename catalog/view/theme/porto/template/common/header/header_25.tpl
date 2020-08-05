 <?php // Fixed header
 if($theme_options->get( 'fixed_header' ) == 1) { ?>
<header id="header2" class="header1 header25 fixed-header">
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
 
            <header id="header" class="header25">
                <div id="header-top" class="hidden-xs">
                    <div class="container">
                        <div class="header-left">
                            <span class="welcome-msg"><?php if($theme_options->get( 'welcome_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'welcome_text', $config->get( 'config_language_id' ) )); } else { echo 'WELCOME TO PORTO OPENCART'; } ?></span>
                        </div><!-- End .header-left -->
                        <div class="header-right">
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
                        </div><!-- End .header-left -->
                    </div><!-- end .container -->
                </div><!-- End #header-top -->
                
                <div id="header-inner">
                    <div class="container">
                    	<div style="position: relative !important;display: block !important">
	                        <div class="header-left">
	                            <div class="switcher-wrap">
	                            	<?php echo $currency.$language; ?>
	                            </div><!-- End .swticher-wrap -->
	                        </div><!-- End .header-left -->
	                        
	                        <div class="header-center">
	                        	<?php if ($logo) { ?>
	                        	<!-- Logo -->
	                        	<h1 class="logo"><a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a></h1>
	                        	<?php } ?>
	                        </div><!-- End .header-center -->
	
	                        <div class="header-right">
	                        	<?php 
	                        	$top_block = $modules->getModules('top_block');
	                        	if( count($top_block) ) { 
	                        	 foreach ($top_block as $module) {
	                        	  echo $module;
	                        	 }
	                        	} ?>
								
								<div class="searchform-popup">
								    <a class="search-toggle"><i class="fa fa-search"></i></a>
								    <div class="searchform search_form">
								        <fieldset>
								            <span class="text">
								                <input type="text" name="search" class="input-block-level search-query" placeholder="<?php echo $search; ?>" required>
								            </span>
								            <span class="button-wrap">
								                <button class="btn button-search" title="Search" type="submit">
								                    <i class="fa fa-search"></i>
								                </button>
								            </span>
								        </fieldset>
								    </div>
								</div><!-- End .searchform -->
	                        </div><!-- End .header-right -->
                        </div>
                    </div><!-- End .container -->
                </div><!-- End #header-inner -->
                
                
                <div class="overflow-menu">
                	<div class="container clearfix">
                		<?php echo $cart; ?>
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