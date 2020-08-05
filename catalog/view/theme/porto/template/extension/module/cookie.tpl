<div id="cookie-<?php echo $module_id; ?>" class="cookie "
     style="position: fixed;
            width: 100%;
            z-index: 9999;
            <?php if($background_color != '') { echo 'background-color: ' . $background_color . ';'; } 
            if($background_image != '') {
               echo 'background-image: url(image/' . $background_image . '); 
                    background-position: ' . $background_image_position . ';
                    background-repeat: ' . $background_image_repeat . ';'; 
            } ?>
            <?php if($border_color != '') {
               echo 'border-'.($display_position != '' && $display_position == 'top' ? 'bottom' : 'top').': 1px solid '.$border_color.';';
            } ?>
            <?php if($display_position != '') {
               echo $display_position.': 0';
            }else{
               echo 'bottom: 0; top: auto';
            } ?>
     ">
     <div class="standard-body">
          <div class="full-width">
              <div class="container">
                  <div class="content" style="<?php if($text_color != '') { echo 'color: ' . $text_color . ';'; } ?>"><?php echo $text_cookie  ?></div>
          
                  <div class="operations">
                      <?php if($display_text_dont_show_again == 0):?>
                      <div class="dont-show-label">
                          <label>
                              <input type="checkbox" class="dont-show-me" />
                              <span style="<?php if($text_dont_show_again_color != '') { echo 'color: ' . $text_dont_show_again_color . ';'; }?>"><?php echo $text_dont_show_again; ?></span>
                          </label>
                      </div>
                      <?php endif ?>
          
                     <?php if($display_button == 0 ):?>
                     <div class="button"><?php echo  $text_button ?></div>
                     <?php endif; ?>
                  </div>
              </div>
          </div>
     </div>
</div>

<script type="text/javascript">
$(document).ready(function() {

     <?php if($display_text_dont_show_again == 0): ?>
          $('#cookie-<?php echo $module_id; ?> .button').click(function () {
               if ($('#cookie-<?php echo $module_id; ?> .dont-show-me').is(':checked')) {
                   var now = new Date();
                     var time = now.getTime();
                     time += 3600 * 24 * 1000 * 365;
                     now.setTime(time);
                   document.cookie = encodeURIComponent('cookie-module-<?php echo $module_id; ?>-accepted') + "=" + encodeURIComponent(1) + ';expires=' + now.toUTCString() + "; path=/";
               } 
               $('#cookie-<?php echo $module_id; ?>').fadeOut('slow');
          });
     <?php endif; ?>

});
</script>