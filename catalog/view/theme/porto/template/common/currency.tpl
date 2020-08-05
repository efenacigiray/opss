<?php if (count($currencies) > 1) { ?>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="currency_language_form currency_form">
	<ul class="currency-switcher accordion-menu">
	    <li><a href="#"><?php foreach ($currencies as $currency) { ?><?php if ($currency['code'] == $code) { ?><?php echo $currency['title']; ?><?php } ?><?php } ?><i class="fa fa-caret-down"></i><span class="arrow"></span></a>
	        <ul>
	            <?php foreach ($currencies as $currency) { ?>
	            <li><a href="javascript:;" onclick="$('input[name=\'code\']').attr('value', '<?php echo $currency['code']; ?>'); $('.currency_form').submit();"><?php echo $currency['title']; ?></a></li>
	            <?php } ?>
	        </ul>
	    </li>
	</ul>
    <input type="hidden" name="code" value="" />
    <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
</form>
<?php } ?>