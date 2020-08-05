<div class="standard-body<?php if($disable_on_desktop == 1) { echo ' hidden-lg hidden-md'; } ?> <?php if($disable_on_mobile == 1) { echo ' hidden-sm hidden-xs'; } ?>" id="header-notice-<?php echo $id; ?>">
     <div class="header-notice full-width clearfix">
          <a href="#" class="close-notice"></a>
          <div class="container">
               <p><?php echo $text; ?></p>
          </div>
     </div>
</div>

<style type="text/css">
     <?php if($background_color != '') { ?>
     #header-notice-<?php echo $id; ?> .header-notice {
          background: <?php echo $background_color; ?>;
     }
     <?php } ?>
     
     <?php if($text_color != '') { ?>
     #header-notice-<?php echo $id; ?> .header-notice,
     #header-notice-<?php echo $id; ?> .header-notice a {
          color: <?php echo $text_color; ?>;
     }
     <?php } ?>
     
     <?php if($text_link_hover_color != '') { ?>
     #header-notice-<?php echo $id; ?> .header-notice a:hover {
          color: <?php echo $text_link_hover_color; ?>;
     }
     <?php } ?>
     
     <?php if($close_button_background_color != '') { ?>
     #header-notice-<?php echo $id; ?> .header-notice a.close-notice {
          background: <?php echo $close_button_background_color; ?>;
     }
     <?php } ?>
     
     <?php if($close_button_hover_background_color != '') { ?>
     #header-notice-<?php echo $id; ?> .header-notice a.close-notice:hover {
          background: <?php echo $close_button_hover_background_color; ?>;
     }
     <?php } ?>
     
     <?php if($close_button_text_color != '') { ?>
     #header-notice-<?php echo $id; ?> .header-notice a.close-notice {
          color: <?php echo $close_button_text_color; ?>;
     }
     <?php } ?>
     
     <?php if($close_button_hover_text_color != '') { ?>
     #header-notice-<?php echo $id; ?> .header-notice a.close-notice:hover {
          color: <?php echo $close_button_hover_text_color; ?>;
     }
     <?php } ?>
</style>

<script type="text/javascript">
     <?php if($show_only_once == 1) { ?>
     if (localStorage.getItem('displayNotice') != 'yes') {
     <?php } ?>
     
     $("#header-notice-<?php echo $id; ?> .header-notice").show();
     
     $('#header-notice-<?php echo $id; ?> .close-notice').on('click', function () {
          <?php if($show_only_once == 1) { ?>
          localStorage.setItem('displayNotice', 'yes');
          <?php } ?>
          $("#header-notice-<?php echo $id; ?> .header-notice").hide();
          return false;
     });
     
     <?php if($show_only_once == 1) { ?>
     } 
     <?php } ?>
</script>