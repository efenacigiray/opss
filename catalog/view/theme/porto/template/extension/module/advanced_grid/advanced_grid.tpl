<?php 
if($registry->has('theme_options') == false) { 
	header("location: themeinstall/index.php"); 
	exit; 
} 

$theme_options = $registry->get('theme_options');
$config = $registry->get('config');
$page_direction = $theme_options->get( 'page_direction' );
$advanced_id = $id; ?>

     <div class="advanced-grid advanced-grid-<?php echo $advanced_id; ?> <?php echo $custom_class; ?> <?php if($disable_on_mobile == 1) echo 'hidden-xs hidden-sm'; ?>" style="margin-top: <?php echo $margin_top; ?>px;<?php if($force_full_width != 1) { ?>margin-left: <?php echo $margin_left; ?>px;margin-right: <?php echo $margin_right; ?>px;<?php } ?>margin-bottom: <?php echo $margin_bottom; ?>px;">
          <?php if($background_image_type == 2) { ?><div class="parallax-window" style="<?php if($background_color != '') { echo 'background-color: ' . $background_color . ';'; } if($background_image != '') { echo 'background-image: url(image/' . $background_image . ');'; } ?>" data-velocity="-0.7"><?php } ?>
          <?php if($background_image_type == 1) { ?><div style="<?php if($background_color != '') { echo 'background-color: ' . $background_color . ';'; } if($background_image != '') { echo 'background-image: url(image/' . $background_image . ');'; } echo 'background-position: ' . $background_image_position . ';background-repeat: ' . $background_image_repeat . ';background-attachment: ' . $background_image_attachment . ';'; ?>"><?php } ?>
          <?php if($background_image_type == 0) { ?><div style="<?php if($background_color != '') { echo 'background-color: ' . $background_color . ';'; } ?>"><?php } ?>
               <div class="container">
                    <div style="padding-top: <?php echo $padding_top; ?>px;padding-left: <?php echo $padding_left; ?>px;padding-bottom: <?php echo $padding_bottom; ?>px;padding-right: <?php echo $padding_right; ?>px;">
                         <div class="row">
                              <?php $row = 0; ?>
                              <?php foreach($columns as $column) { ?>
                                   <?php 
                                        if($column['width'] == 'advanced') {
                                             
                                             if($column['width_lg'] != 'hidden') {
                                                  $row = $row+$column['width_lg'];
                                                  if($row > 12) { echo '</div><div class="row">'; $row = $column['width_lg']; }
                                             }
                                             
                                             $column_width = 'col-lg-' . $column['width_lg'] . ' col-md-' . $column['width_md'] . ' col-sm-' . $column['width_sm'] . ' col-xs-' . $column['width_xs'] . '';
                                             if($column['width_lg'] == 'hidden') $column_width .= ' hidden-lg';
                                             if($column['width_md'] == 'hidden') $column_width .= ' hidden-md';
                                             if($column['width_sm'] == 'hidden') $column_width .= ' hidden-sm';
                                             if($column['width_xs'] == 'hidden') $column_width .= ' hidden-xs';
                                        } else {
                                             $row = $row+$column['width'];
                                             $column_width = 'col-sm-' . $column['width'];
                                             if($column['disable_on_mobile'] == '1') $column_width .= ' hidden-xs';
                                             if($row > 12) { echo '</div><div class="row">'; $row = $column['width']; }
                                        }
                                   ?>
                                   <div class="<?php echo $column_width; ?>">
                                        <?php foreach($column['modules'] as $module) { ?>
                                             <?php if($module['type'] == 'load_module') { ?>
                                                  <?php echo $module['content']['module']; ?>
                                             <?php } else if($module['type'] == 'html') { ?>
                                                  <?php echo $module['content']['html']; ?>
                                             <?php } else if($module['type'] == 'box') { 
                                                       if($position == 'footer_bottom' || $position == 'footer' || $position == 'footer_top' || $position == 'footer_left' || $position == 'footer_right' || $position == 'customfooter_top' || $position == 'customfooter_bottom' || $position == 'customfooter') {
                                                       	echo '<h4>'.$module['content']['title'].'</h4>';
                                                       	echo '<div class="strip-line"></div>';
                                                       	echo '<div class="clearfix" style="clear:both">' . $module['content']['text'] . '</div>';
                                                       } else {
                                                       	echo '<div class="box">';
                                                       		echo '<div class="box-heading">';
                                                       			echo $module['content']['title'];
                                                       		echo '</div>';
                                                       		echo '<div class="strip-line"></div>';
                                                       		echo '<div class="box-content">';
                                                       			echo $module['content']['text'];
                                                       		echo '</div>';
                                                       	echo '</div>';	
                                                       } ?>	
                                             <?php } else if($module['type'] == 'links') { 
                                                  if(file_exists('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/extension/module/advanced_grid/links/' . $module['content']['module_template'] . '')) {
                                                       include('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/extension/module/advanced_grid/links/' . $module['content']['module_template'] . '');
                                                  } else {
                                                       echo 'Module template doesn\'t found!';
                                                  } ?>	
                                             <?php } else if($module['type'] == 'newsletter') { 
                                                  if(file_exists('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/extension/module/advanced_grid/newsletter/' . $module['content']['module_template'] . '')) {
                                                       include('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/extension/module/advanced_grid/newsletter/' . $module['content']['module_template'] . '');
                                                  } else {
                                                       echo 'Module template doesn\'t found!';
                                                  } ?>	
                                             <?php } else if($module['type'] == 'latest_blogs') { 
                                                  if(file_exists('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/extension/module/advanced_grid/latest_blogs/' . $module['content']['module_template'] . '')) {
                                                       include('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/extension/module/advanced_grid/latest_blogs/' . $module['content']['module_template'] . '');
                                                  } else {
                                                       echo 'Module template doesn\'t found!';
                                                  } ?>	
                                             <?php } else if($module['type'] == 'products') { 
                                                  if(file_exists('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/extension/module/advanced_grid/products/' . $module['content']['module_template'] . '')) {
                                                       include('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/extension/module/advanced_grid/products/' . $module['content']['module_template'] . '');
                                                  } else {
                                                       echo 'Module template doesn\'t found!';
                                                  } ?>	
                                             <?php } else if($module['type'] == 'products_tabs') { 
                                                  if(file_exists('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/extension/module/advanced_grid/products_tabs/' . $module['content']['module_template'] . '')) {
                                                       include('catalog/view/theme/' . $config->get('theme_' . $config->get('config_theme') . '_directory') . '/template/extension/module/advanced_grid/products_tabs/' . $module['content']['module_template'] . '');
                                                  } else {
                                                       echo 'Module template doesn\'t found!';
                                                  } ?>	
                                             <?php } else { ?>
                                                  Unknown error.
                                             <?php } ?>
                                        <?php } ?>
                                   </div>
                              <?php } ?>
                         </div>
                    </div>
               </div>
          </div>
          
          <?php if($background_image_type == 2) { ?>
          <script type="text/javascript" src="catalog/view/theme/<?php echo $config->get('theme_' . $config->get('config_theme') . '_directory'); ?>/js/jquery.scrolly.js"></script>
          <script>
              $(document).ready(function(){
                 $('.advanced-grid-<?php echo $advanced_id; ?> .parallax-window').scrolly({bgParallax: true});
              });
          </script>
          <?php } ?>
     </div>

<?php if($force_full_width == 1) { ?>
<script type="text/javascript">
     function force_full_width_<?php echo $advanced_id; ?>() {
          var p = $(".advanced-grid-<?php echo $advanced_id; ?>");
          
          <?php if($page_direction[$config->get( 'config_language_id' )] != 'RTL'): ?>
          if(p.size() > 0) {
               p.width($('body').width());
               p.css("margin-left", "0px");
               var position = p.offset();
               p.css("margin-left", "-" + position.left + "px");
               p.find(".container").css("padding-left", position.left);
               p.find(".container").css("padding-right", position.left);
               
          }
          <?php else: ?>
          if(p.size() > 0) {
               p.width($('body').width());
               p.css("margin-right", "0px");
               var position = p.offset();
               p.css("margin-right", "-" + position.left * -1 + "px");
               p.find(".container").css("padding-left", position.left * -1);
               p.find(".container").css("padding-right", position.left * -1);
          }
          <?php endif; ?>     }
     
     force_full_width_<?php echo $advanced_id; ?>();
     
     $(window).resize(function() {
          force_full_width_<?php echo $advanced_id; ?>();
     });
</script>
<?php } ?>