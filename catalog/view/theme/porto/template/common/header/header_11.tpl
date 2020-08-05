 <?php // Fixed header
 if($theme_options->get( 'fixed_header' ) == 1) { ?>
<header id="header2" class="header1 header10 type11 fixed-header">
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
 
            <header id="header" class="header10">
                <div id="header-top" class="hidden-xs">
                    <div class="container">
                        <div class="header-left">
                            <div class="switcher-wrap">
                            	<?php echo $currency.$language; ?>
                            </div><!-- End .swticher-wrap -->
                            
                        </div><!-- End .header-left -->
                        <div class="header-right">
                            <span class="welcome-msg"><?php if($theme_options->get( 'welcome_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'welcome_text', $config->get( 'config_language_id' ) )); } else { echo 'WELCOME TO PORTO OPENCART'; } ?></span>
                            <span class="separator hidden-sm">|</span>
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
                        <div class="header-left">
                            <div class="searchform-popup">
                            	<?php
                            	$search_cats = $theme_options->getAllCategories();
                            	$category_id = $theme_options->getCurrentCategory();
                            	?>
                            	 
                                <a class="search-toggle"><i class="fa fa-search"></i></a>
                                <div class="searchform search_form">
                                    <fieldset>
                                        <span class="text">
                                            <input type="text" name="search" class="input-block-level search-query" placeholder="<?php echo $search; ?>" required>
                                        </span>
                                        <select name="category_id" class="cat">
                                          <option value="0"><?php echo $theme_options->get( 'all_categories_text', $config->get( 'config_language_id' ) ) != '' ? $theme_options->get( 'all_categories_text', $config->get( 'config_language_id' ) ) : 'All categories';  ?></option>
                                          <?php foreach ($search_cats as $category_1) { ?>
                                          <?php if ($category_1['category_id'] == $category_id) { ?>
                                          <option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
                                          <?php } else { ?>
                                          <option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
                                          <?php } ?>
                                          <?php foreach ($category_1['children'] as $category_2) { ?>
                                          <?php if ($category_2['category_id'] == $category_id) { ?>
                                          <option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
                                          <?php } else { ?>
                                          <option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
                                          <?php } ?>
                                          <?php foreach ($category_2['children'] as $category_3) { ?>
                                          <?php if ($category_3['category_id'] == $category_id) { ?>
                                          <option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
                                          <?php } else { ?>
                                          <option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
                                          <?php } ?>
                                          <?php } ?>
                                          <?php } ?>
                                          <?php } ?>
                                        </select>
                                        <span class="button-wrap">
                                            <button class="btn button-search" title="Search" type="submit">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </fieldset>
                                </div>
                            </div><!-- End .searchform -->
                            <a class="mobile-toggle"><i class="fa fa-reorder"></i></a>
                            
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
							<?php echo $cart; ?>
                        </div><!-- End .header-right -->
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