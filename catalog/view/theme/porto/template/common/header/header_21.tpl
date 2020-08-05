            <?php if($theme_options->get( 'fixed_header' ) == 1) { ?><div class="header21-before"></div><?php } ?>
            <header class="header21 <?php if($theme_options->get( 'fixed_header' ) == 1) { echo 'with-fixed'; } ?>">
				<div class="container clearfix">
					<?php if ($logo) { ?>
					<!-- Logo -->
					<h1 class="logo">
						<a href="<?php echo $home; ?>">
							<img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" />
						</a>
					</h1>
					<?php } ?>
					
					<div class="cart-area">
						<a class="mobile-toggle"><i class="fa fa-reorder"></i></a>
						
						<?php 
						$menu = $modules->getModules('menu');
						if( count($menu) ) {
							foreach ($menu as $module) {
								echo $module;
							}
						}
						?>
						
						<div class="top-links-area">
							<div class="top-links-icon"><a href="javascript:void(0)"><?php if($theme_options->get( 'links_text', $config->get( 'config_language_id' ) ) != '') { echo html_entity_decode($theme_options->get( 'links_text', $config->get( 'config_language_id' ) )); } else { echo 'links'; } ?> <i class="fa fa-caret-down"></i></a></div>
							<ul class="links">
								<li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
								<li><a href="<?php echo $shopping_cart; ?>" title="<?php echo $text_shopping_cart; ?>"><?php echo $text_shopping_cart; ?></a></li>
								<li><a href="<?php echo $checkout; ?>" title="<?php echo $text_checkout; ?>"><?php echo $text_checkout; ?></a></li>
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
											
						<div class="switcher-area"><?php echo $currency.$language; ?></div>
						
						<div class="searchform-popup">
						    <a class="search-toggle"><i class="fa fa-search"></i></a>
						</div><!-- End .searchform -->
						
						<?php echo $cart; ?>
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