<?php $config = $registry->get('config'); ?>
<link rel="stylesheet" type="text/css" href="system/config/revslider/rs-plugin/css/settings.css" property='stylesheet'/>
<link rel="stylesheet" type="text/css" href="system/config/revslider/rs-plugin/css/static-captions.css" property='stylesheet'/>
<link rel="stylesheet" type="text/css" href="system/config/revslider/rs-plugin/css/dynamic-captions.css" property='stylesheet'/>
<link rel="stylesheet" type="text/css" href="system/config/revslider/rs-plugin/css/captions.css" property='stylesheet'/>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $config->get('theme_' . $config->get('config_theme') . '_directory'); ?>/css/slider.css" property='stylesheet'/>
<script type="text/javascript" src="system/config/revslider/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
<script type="text/javascript" src="system/config/revslider/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<?php echo $rev_content; ?>