<?php if (count($languages) > 1) { ?>
<!-- Language -->
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="currency_language_form language_form">
	<span class="separator hidden-xs hidden-sm">|</span>
	<ul class="view-switcher accordion-menu">
	    <li><a href="#"><?php foreach ($languages as $language) { ?><?php if ($language['code'] == $code) { ?><img src="catalog/language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?><?php } ?><?php } ?><i class="fa fa-caret-down"></i><span class="arrow"></span></a>
	        <ul>
	            <?php foreach ($languages as $language) { ?>
	            <li><a href="javascript:;" onclick="$('input[name=\'code\']').attr('value', '<?php echo $language['code']; ?>'); $('.language_form').submit();"><img src="catalog/language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
	            <?php } ?>
	        </ul>
	    </li>
	</ul>
	
	<input type="hidden" name="code" value="" />
	<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
</form>
<?php } ?>
