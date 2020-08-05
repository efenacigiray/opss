<?php
if($registry->has('theme_options') == true) {
	$theme_options = $registry->get('theme_options');
	$config = $registry->get('config');

	require_once( DIR_TEMPLATE.$config->get('theme_' . $config->get('config_theme') . '_directory')."/lib/module.php" );
	$modules = new Modules($registry); ?>

            <footer id="footer" <?php if($theme_options->get( 'footer_badge' ) == 1) { ?>class="footer-ribbon"<?php } ?>>
            	<?php
            	$customfooter_top = $modules->getModules('customfooter_top');
            	if( count($customfooter_top) ) {
            		foreach ($customfooter_top as $module) {
            			echo $module;
            		}
            	} ?>

            	<?php
            	$customfooter = $modules->getModules('customfooter');
            	if( count($customfooter) ) {
            		foreach ($customfooter as $module) {
            			echo $module;
            		}
            	} ?>

            	<?php
            	$customfooter_bottom = $modules->getModules('customfooter_bottom');
            	if( count($customfooter_bottom) ) {
            		foreach ($customfooter_bottom as $module) {
            			echo $module;
            		}
            	} ?>

                <div class="container">
                	<?php if($theme_options->get( 'footer_badge' ) == 1) { ?>
                    <div class="footer-ribbon">
                    	<?php $text = $theme_options->get( 'footer_badge_text' ); ?>
                    	<?php $language_id = $config->get( 'config_language_id' ); ?>
                        <a href="#"><?php echo $text[$language_id]; ?></a>
                    </div>
					<?php } ?>

					<?php
					$footer = $modules->getModules('footer');
					if( count($footer) ) {
						foreach ($footer as $module) {
							echo $module;
						}
					} ?>
                </div><!-- End .container -->

                <div id="footer-bottom">
                    <div class="container">

						<?php
						$bottom = $modules->getModules('bottom');
						if( count($bottom) ) {
							foreach ($bottom as $module) {
								echo $module;
							}
						} ?>

                    </div><!-- End .container -->
                </div><!-- End #footer-bottom -->
            </footer><!-- End #footer -->

        </div><!-- End #main-content -->

    </div><!-- End #wrapper -->
    <a href="#wrapper" id="scroll-top" title="Top"><i class="fa fa-chevron-up"></i></a>
	<!-- END -->

	<script type="text/javascript" src="catalog/view/theme/<?php echo $config->get('theme_' . $config->get('config_theme') . '_directory'); ?>/js/megamenu.js"></script>
<?php } ?>
</body>
</html>