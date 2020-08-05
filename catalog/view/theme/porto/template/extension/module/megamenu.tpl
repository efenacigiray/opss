<?php if($registry->has('theme_options') == true) { 
$config = $registry->get('config');
$theme_options = $registry->get('theme_options');
$page_direction = $theme_options->get( 'page_direction' );
$id = rand(0, 5000)*rand(5000, 50000); ?>

<div id="megamenu_<?php echo $id; ?>" class="container-megamenu <?php if($ustawienia['full_width'] != '1') { echo 'container'; } ?> <?php if($ustawienia['orientation'] == 1) { echo 'vertical'; } else { echo 'horizontal'; } if($ustawienia['display_on_mobile'] == 1) { echo ' mobile-disabled'; } ?>">
	<?php if($ustawienia['orientation'] == 1) { ?>
	<div id="menuHeading">
		<div class="megamenuToogle-wrapper">
			<div class="megamenuToogle-pattern">
				<div class="container">
					<?php echo $navigation_text; ?>
				</div>
			</div>
		</div>
	</div>
	<?php } else { ?>
	<div class="megaMenuToggle">
		<div class="megamenuToogle-wrapper">
			<div class="megamenuToogle-pattern">
				<div class="container">
					<div><span></span><span></span><span></span></div>
					<?php echo $navigation_text; ?>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="megamenu-wrapper">
		<div class="megamenu-pattern">
			<div class="container">
				<ul class="megamenu <?php if($ustawienia['animation'] != '') { echo $ustawienia['animation']; } ?>">
					<?php if($ustawienia['home_item'] == 'icon' || $ustawienia['home_item'] == 'text') { ?>
					<li class="home"><a href="<?php echo $home; ?>"><?php if($ustawienia['home_item'] == 'icon') { ?><i class="fa fa-home"></i><?php } else { echo '<span><strong>'.$home_text.'</strong></span>'; } ?></a></li>
					<?php } ?>
					<?php if($ustawienia['search_bar'] == 1) { ?>
					<li class="search pull-right">
						<!-- Search -->
						<div class="search_form">
							<div class="button-search2"></div>
							<input type="text" class="input-block-level search-query" name="search2" placeholder="<?php echo $text_search; ?>" id="search_query2" value="<?php echo $search; ?>" />
							
							<?php if($theme_options->get( 'quick_search_autosuggest' ) != '0') { ?>
							<div id="autocomplete-results2" class="autocomplete-results"></div>
							
							<script type="text/javascript">
							$(document).ready(function() {
								$('#search_query2').autocomplete({
									delay: 0,
									appendTo: "#autocomplete-results2",
									source: function(request, response) {		
										$.ajax({
											url: 'index.php?route=search/autocomplete&filter_name=' +  encodeURIComponent(request.term),
											dataType: 'json',
											success: function(json) {
												response($.map(json, function(item) {
													return {
														label: item.name,
														value: item.product_id,
														href: item.href,
														thumb: item.thumb,
														desc: item.desc,
														price: item.price
													}
												}));
											}
										});
									},
									select: function(event, ui) {
										document.location.href = ui.item.href;
										
										return false;
									},
									focus: function(event, ui) {
								      	return false;
								   	},
								   	minLength: 2
								})
								.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
								  return $( "<li>" )
								    .append( "<a><img src='" + item.thumb + "' alt=''>" + item.label + "<br><span class='description'>" + item.desc + "</span><br><span class='price'>" + item.price + "</span></a>" )
								    .appendTo( ul );
								};
							});
							</script>
							<?php } ?>
						</div>
					</li>
					<?php } ?>
					<?php
						foreach($menu as $row) {
							$class = '';
							$class_link = 'clearfix';
							$title = false;
							$target = false;
							if($row['description'] != '') { $class_link .= ' description'; }
							if(is_array($row['submenu']) && !empty($row['submenu'])) { $class .= ' with-sub-menu'; if($row['submenu_type'] == 1) { $class .= ' click'; } else { $class .= ' hover'; } }
							if($row['display_on_mobile'] == 1) { $class .= ' mobile-disabled'; }
							if($row['position'] == 1) { $class .= ' pull-right'; }
							if($row['submenu_type'] == 2) { $title = 'title="hover-intent"'; }
							if($row['new_window'] == 1) { $target = 'target="_blank"'; }
							if(!isset($row['name'][$lang_id])) { $row['name'][$lang_id] = 'Set name'; }
							if($row['custom_class'] != '') { $class .= ' ' . $row['custom_class']; }
							$label = false;
							if($row['label'] != '') $label = '<span class="megamenu-label" style="background: ' . $row['label_background_color'] . ';color:  ' . $row['label_text_color'] . ';"><span style="background: ' . $row['label_background_color'] . ';color: ' . $row['label_background_color'] . '"></span>' . $row['label'] . '</span>';
							echo "<li class='".$class."' ".$title."><p class='close-menu'></p><p class='open-menu'></p>";
							echo "<a href='".$row['link']."' class='".$class_link."' ".$target."><span><strong>".$row['icon'].html_entity_decode($row['name'][$lang_id]).html_entity_decode($row['description']).$label."</strong></span></a>";
								if(is_array($row['submenu']) && !empty($row['submenu'])) {
									if($ustawienia['orientation'] == '1' && $row['submenu_width'] == '100%') { $row['submenu_width'] = '356%'; }
									$background_image = false;
									if($row['submenu_background'] != '') {
										$background_image = 'style="background-image:url(image/' . $row['submenu_background'] . ');background-position: ' . $row['submenu_background_position'] . ';background-repeat: ' . $row['submenu_background_repeat'] . ';"';
									}
									$superwidth = ''; if($row['submenu_width'] == '100%') { $superwidth = 'fullwidthmenu'; }
									echo '<div class="sub-menu ' . $superwidth . '" style="width:'.$row['submenu_width'].'">';
										echo '<div class="content" ' . $background_image . '><p class="arrow"></p>';
											echo '<div class="row">';
												$row_fluid = 0;
												foreach($row['submenu'] as $submenu) {
													if(($row_fluid+$submenu['content_width']) > 12) {
														$row_fluid = $submenu['content_width'];
														echo '</div><div class="border"></div><div class="row">';
													} else {
														$row_fluid = $row_fluid+$submenu['content_width'];
													}
													echo '<div class="col-sm-'.$submenu['content_width'].'  ' . ($submenu['display_on_mobile'] == '1' ? 'mobile-disabled' : 'mobile-enabled') . '">';
														if($submenu['content_type'] == '0') {
															echo $submenu['html'];
														} elseif($submenu['content_type'] == '1') {
															if(is_array($submenu['product'])) {
																echo '<div class="product">';
																	echo '<div class="image"><a href="'.$submenu['product']['link'].'"><img src="'.$submenu['product']['image'].'" alt=""></a></div>';
																	echo '<div class="name"><a href="'.$submenu['product']['link'].'">'.$submenu['product']['name'].'</a></div>';
																	echo '<div class="price">';
																		if (!$submenu['product']['special']) {
																			echo $submenu['product']['price'];
																		} else {
																			echo $submenu['product']['special'];
																		}
																	echo '</div>';
																echo '</div>';
															}
														} elseif($submenu['content_type'] == '2') {
															echo $submenu['categories'];
														} elseif($submenu['content_type'] == '3') {
															if(is_array($submenu['products'])) {
															     $id = rand(0, 5000)*rand(0, 5000); 
															     echo '<div class="products-carousel-overflow clearfix">';
															          echo '<div class="next" id="productsCarousel' . $id . '_next"><span></span></div>';
															          echo '<div class="prev" id="productsCarousel' . $id . '_prev"><span></span></div>';
															          if(!isset($submenu['heading'][$lang_id])) { $submenu['heading'][$lang_id] = 'Set name'; }
															          echo '<div class="box-heading">' . $submenu['heading'][$lang_id] . '</div>';
															          echo '<div class="strip-line"></div>';
															          echo '<div class="clear"></div>';
     															     echo '<div class="products-carousel owl-carousel" id="productsCarousel' . $id . '">';
     															     foreach($submenu['products'] as $product) {
          																echo '<div class="item"><div class="product">';
          																	echo '<div class="image">';
          																	if($product['special'] && $theme_options->get( 'display_text_sale' ) != '0') {
          																		$text_sale = 'Sale';
          																		if($theme_options->get( 'sale_text', $config->get( 'config_language_id' ) ) != '') {
          																			$text_sale = $theme_options->get( 'sale_text', $config->get( 'config_language_id' ) );
          																		}
          																		
          																		if($theme_options->get( 'type_sale' ) == '1') { 
          																			$product_detail = $theme_options->getDataProduct( $product['id'] );
          																			$roznica_ceny = $product_detail['price']-$product_detail['special'];
          																			$procent = ($roznica_ceny*100)/$product_detail['price']; 
          																			echo '<div class="sale">-' . round($procent) . '%</div>';
          																		} else {
          																			echo '<div class="sale">' . $text_sale . '</div>';
          																		}
          																	}
          																	echo '<a href="'.$product['link'].'"><img src="'.$product['image'].'" alt=""></a></div>';
          																	echo '<div class="name"><a href="'.$product['link'].'">'.$product['name'].'</a></div>';
          																	echo '<div class="price">';
          																		if (!$product['special']) {
          																			echo $product['price'];
          																		} else {
          																			echo $product['special'];
          																		}
          																	echo '</div>';
          																echo '</div></div>';
     																}
     																echo '</div>';
																echo '</div>'; ?>
																<script type="text/javascript">$(document).ready(function() {
																var owl<?php echo $id; ?> = $("#productsCarousel<?php echo $id; ?>");
																	
																$("#productsCarousel<?php echo $id; ?>_next").click(function(){
																    owl<?php echo $id; ?>.trigger('owl.next');
																    return false;
																  });
																  
																$("#productsCarousel<?php echo $id; ?>_prev").click(function(){
																    owl<?php echo $id; ?>.trigger('owl.prev');
																    return false;
																});
																
																<?php 
																
																     $one = 1;
																     $two = 1;
																     $three = 1;
																     $four = 1;
																     
																     if($submenu['column'] == 2) {
																          $two = 1;
																          $three = 2;
																          $four = 2;
																     }
																     
																     if($submenu['column'] == 3) {
																          $two = 1;
																          $three = 2;
																          $four = 3;
																     }
																     
																     if($submenu['column'] == 4) {
																          $one = 1;
																          $two = 2;
																          $three = 3;
																          $four = 4;
																     }
																     
																     if($submenu['column'] == 5) {
																          $one = 2;
																          $two = 3;
																          $three = 4;
																          $four = 5;
																     }
																     
																     if($submenu['column'] == 6) {
																          $one = 2;
																          $two = 3;
																          $three = 5;
																          $four = 6;
																     }
																?>
																  
																owl<?php echo $id; ?>.owlCarousel({
																	<?php if($page_direction[$config->get( 'config_language_id' )] == 'RTL'): ?>
																	rtl: true,
																	<?php endif; ?>
																	 itemsCustom : [ 
																	      [0, <?php echo $one; ?>], 
																	      [450, <?php echo $two; ?>], 
																	      [768, <?php echo $three; ?>], 
																	      [1200, <?php echo $four; ?>] 
																	 ],
																 });
																 });</script>
																 <?php
															}
														}
													echo '</div>';
												}
											echo '</div>';
										echo '</div>';
									echo '</div>';
								}
							echo "</li>";
							echo "\n";
						}
					?>
				</ul>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
	  $(window).load(function(){
	      var css_tpl = '<style type="text/css">';
	      css_tpl += '#megamenu_<?php echo $id; ?> ul.megamenu > li > .sub-menu > .content {';
	      css_tpl += '-webkit-transition: all <?php if($ustawienia['animation_time'] > 0 && $ustawienia['animation_time'] < 5000) { echo $ustawienia['animation_time']; } else { echo 300; } ?>ms ease-out !important;';
	      css_tpl += '-moz-transition: all <?php if($ustawienia['animation_time'] > 0 && $ustawienia['animation_time'] < 5000) { echo $ustawienia['animation_time']; } else { echo 300; } ?>ms ease-out !important;';
	      css_tpl += '-o-transition: all <?php if($ustawienia['animation_time'] > 0 && $ustawienia['animation_time'] < 5000) { echo $ustawienia['animation_time']; } else { echo 300; } ?>ms ease-out !important;';
	      css_tpl += '-ms-transition: all <?php if($ustawienia['animation_time'] > 0 && $ustawienia['animation_time'] < 5000) { echo $ustawienia['animation_time']; } else { echo 300; } ?>ms ease-out !important;';
	      css_tpl += 'transition: all <?php if($ustawienia['animation_time'] > 0 && $ustawienia['animation_time'] < 5000) { echo $ustawienia['animation_time']; } else { echo 300; } ?>ms ease-out !important;';
	      css_tpl += '}</style>'
	    $("head").append(css_tpl);
	  });
	</script>
</div>
<?php } ?>