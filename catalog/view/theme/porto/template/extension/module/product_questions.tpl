<div class="clearfix"></div>
<a class="button btn-default button-product-question">
     <?php if($icon != '' && $icon_position == 'left') { echo '<img src="image/' . $icon. '" align="left" class="icon-enquiry" alt="Icon">'; } ?>
     <span class="text-enquiry"><?php echo $button_text; ?></span>
     <?php if($icon != '' && $icon_position == 'right') { echo '<img src="image/' . $icon. '" align="right" class="icon-enquiry" alt="Icon">'; } ?>
</a>

<div id="popup-product-question-<?php echo $module_id; ?>" class="popup mfp-hide">
     <?php 

        if($block_title != '') echo '<h4>' . $block_title . '</h4>'; ?>
        <form action="" method="post" enctype="multipart/form-data" id="contact" class="form-contact">
             <?php if(isset($product_id)) { ?>
             <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
             <?php } else if(isset($url)) { ?>
             <input type="hidden" name="url" value="<?php echo $url; ?>" />
             <?php } ?>

             <fieldset>
               <div class="contact-label">
                 <label for="input-name" class="required"> <?php echo $entry_name; ?></label>
                 <div>
                   <input type="text" name="name" value="" id="input-name" class="form-control" />
                 </div>
               </div>
               <div class="contact-label">
                 <label for="input-email" class="required"> <?php echo $entry_email; ?></label>
                 <div>
                   <input type="text" name="email" value="" id="input-email" class="form-control" />
                 </div>
               </div>
               <div class="contact-label">
                 <label for="input-enquiry" class="required"> <?php echo $entry_enquiry; ?></label>
                 <div>
                   <textarea name="enquiry" rows="7" id="input-enquiry" class="form-control"></textarea>
                 </div>
               </div>
             </fieldset>

            <input class="btn btn-primary" type="submit" value="<?php echo $button_submit; ?>" />
        </form>

        <script type="text/javascript">
             function IsEmail(email) {
                  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                  return regex.test(email);
             }

             $('#contact').bind('submit', function(){
                  var valid = true;
                
                  if($('#popup-product-question-<?php echo $module_id; ?> #input-name').val().length < 3 || $('#popup-product-question-<?php echo $module_id; ?> #input-name').val().length > 32){
                       $('#popup-product-question-<?php echo $module_id; ?> #input-name').addClass("error");
                       valid = false;
                  } else {
                       $('#popup-product-question-<?php echo $module_id; ?> #input-name').removeClass("error");

                  }

                  if(IsEmail($('#popup-product-question-<?php echo $module_id; ?> #input-email').val())) {
                       $('#popup-product-question-<?php echo $module_id; ?> #input-email').removeClass("error");
                  } else {
                       $('#popup-product-question-<?php echo $module_id; ?> #input-email').addClass("error");
                       valid = false;
                  }
                 

                  if($('#popup-product-question-<?php echo $module_id; ?> #input-enquiry').val().length < 10 || $('#popup-product-question-<?php echo $module_id; ?> #input-enquiry').val().length > 3000){
                       $('#popup-product-question-<?php echo $module_id; ?> #input-enquiry').addClass("error");
                       valid = false;
                  } else {
                       $('#popup-product-question-<?php echo $module_id; ?> #input-enquiry').removeClass("error");
                  }

                  if(valid) {
                       $.ajax({
                              type: "POST",
                              url: "<?php echo $contact_url; ?>",
                              data: $("#popup-product-question-<?php echo $module_id; ?> #contact").serialize(), // serializes the form's elements.
                              success: function(data)
                              {
                                  alert(data); // show response from the php script.
                                  $.magnificPopup.close();
                              }
                            });

                       return false;
                  } else {
                       return false;
                  }
             });
        </script>

</div>

<script>
    $(function(){
        $('.button-product-question').click(function(e){
            $.magnificPopup.open({
                items: {
                    src: '#popup-product-question-<?php echo $module_id; ?>',
                    type: 'inline'
                },
                tLoading: '',
                mainClass: 'popup-module mfp-with-zoom',
                removalDelay: 200,
            });
            
            return false;
            
        })
    })
</script>
