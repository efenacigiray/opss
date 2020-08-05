<?php
if($registry->has('theme_options') == false) { 
 header("location: themeinstall/index.php"); 
 exit; 
}
$theme_options = $registry->get('theme_options');
?>
<div class="box blog-module blog-search box-no-advanced">
    <div class="box-heading"><?php echo $heading_title; ?></div>
    <div class="strip-line"></div>
    <div class="box-content search-form">
        <input type="hidden" name="route" value="<?php echo urldecode('blog/blog') ?>"/>
        <div class="form-group required">
            <div class="row">
                <div class="col-sm-12">
                    <input type="text" name="search" value="" id="input-search" placeholder="<?php echo $text_enter_keywords ?>..." class="form-control">
                    <button  class="blog-button-search">
                        <span class="fa fa-search">
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        /* Search */
        $('.blog-button-search').bind('click', function() {
            url = $('base').attr('href') + 'index.php?route=blog/blog';

            var search = $('.search-form input[name=\'search\']').val();

            if (search) {
                url += '&search=' + encodeURIComponent(search);
            }
            location = url;
        });
        
        $('#input-search').bind("enterKey",function(e){
            $('.blog-button-search').trigger('click');
         });
         $('#input-search').keyup(function(e){
             if(e.keyCode == 13)
             {
                 $(this).trigger("enterKey");
             }
         });
    })
    
</script>