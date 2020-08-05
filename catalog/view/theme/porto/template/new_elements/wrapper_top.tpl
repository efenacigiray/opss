<?php $grid_center = 12; 
if($column_left != '') $grid_center = $grid_center-3; 
if($column_right != '') $grid_center = $grid_center-3; 
$modules_old_opencart = new Modules($registry); ?>

<?php
$breadcrumb = $modules_old_opencart->getModules('breadcrumb');
if( count($breadcrumb) ) {
	foreach ($breadcrumb as $module) {
		echo $module;
	}
} ?>
	
<div class="page-top">
	<div class="container">
		<ol class="breadcrumb">
			<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<li><a href="<?php echo $breadcrumb['href']; ?>"><?php if($breadcrumb['text'] != '<i class="fa fa-home"></i>') { echo $breadcrumb['text']; } else { if($theme_options->get( 'home_text', $config->get( 'config_language_id' ) ) != '') { echo $theme_options->get( 'home_text', $config->get( 'config_language_id' ) ); } else { echo 'Home'; } } ?></a></li>
			<?php } ?>
		</ol>
	</div><!-- End .container -->
</div>
                
<!-- MAIN CONTENT
	================================================== -->
<div class="main-content <?php if($theme_options->get( 'content_layout' ) == 1) { echo 'full-width'; } else { echo 'fixed'; } ?> inner-page">
	<div class="background-content"></div>
	<div class="background">
		<div class="shadow"></div>
		<div class="pattern">
			<div class="container">
				<?php 
				$preface_left = $modules_old_opencart->getModules('preface_left');
				$preface_right = $modules_old_opencart->getModules('preface_right');
				?>
				<?php if( count($preface_left) || count($preface_right) ) { ?>
				<div class="row">
					<div class="col-sm-9">
						<?php
						if( count($preface_left) ) {
							foreach ($preface_left as $module) {
								echo $module;
							}
						} ?>
					</div>
					
					<div class="col-sm-3">
						<?php
						if( count($preface_right) ) {
							foreach ($preface_right as $module) {
								echo $module;
							}
						} ?>
					</div>
				</div>
				<?php } ?>
				
				<?php 
				$preface_fullwidth = $modules_old_opencart->getModules('preface_fullwidth');
				if( count($preface_fullwidth) ) {
					echo '<div class="row"><div class="col-sm-12">';
					foreach ($preface_fullwidth as $module) {
						echo $module;
					}
					echo '</div></div>';
				} ?>
				
				<div class="row">					
					<?php $columnleft = $modules_old_opencart->getModules('column_left'); $grid_center = 12; if( count($columnleft) ) { $grid_center = 9; } ?>
					<div class="col-md-<?php echo $grid_center; ?> pull-right">
						<?php 
						$content_big_column = $modules_old_opencart->getModules('content_big_column');
						if( count($content_big_column) ) { 
							foreach ($content_big_column as $module) {
								echo $module;
							}
						} ?>
						
						<?php 
						$content_top = $modules_old_opencart->getModules('content_top');
						if( count($content_top) ) { 
							foreach ($content_top as $module) {
								echo $module;
							}
						} ?>
						
						<div class="row">
							<?php 
							$grid_content_top = 12; 
							$grid_content_right = 3;
							$column_right = $modules_old_opencart->getModules('column_right'); 
							if( count($column_right) ) {
								if($grid_center == 9) {
									$grid_content_top = 8;
									$grid_content_right = 4;
								} else {
									$grid_content_top = 9;
									$grid_content_right = 3;
								}
							}
							?>
							<div class="col-md-<?php echo $grid_content_top; ?> center-column" id="content">

								<?php if (isset($error_warning)) { ?>
									<?php if ($error_warning) { ?>
									<div class="warning">
										<button type="button" class="close" data-dismiss="alert">&times;</button>
										<?php echo $error_warning; ?>
									</div>
									<?php } ?>
								<?php } ?>
								
								<?php if (isset($success)) { ?>
									<?php if ($success) { ?>
									<div class="success">
										<button type="button" class="close" data-dismiss="alert">&times;</button>
										<?php echo $success; ?>
									</div>
									<?php } ?>
								<?php } ?>