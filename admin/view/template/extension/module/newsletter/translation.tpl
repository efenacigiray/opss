<?php echo $header; ?><?php echo $column_left; ?>
<div id="content"><div class="container-fluid">
	<div class="page-header">
	    <h1>Newsletter</h1>
	    <ul class="breadcrumb">
		     <?php foreach ($breadcrumbs as $breadcrumb) { ?>
		      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		      <?php } ?>
	    </ul>
	  </div>
    
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:700,600,500,400' rel='stylesheet' type='text/css'>
	
	<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
	<?php } elseif ($success) {  ?>
		<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
	<?php } ?>

	<div class="set-size" id="newsletter">
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<!-- Content -->
			<div class="content">
				<div>
					<div class="bg-tabs clearfix">
						<div id="tabs">
							<a href="<?php echo $placement; ?>" id="placement"><span>Module placement</span></a>
							<a href="<?php echo $settings; ?>" id="existing" class="active"><span>Translation text</span></a>
							<a href="<?php echo $list_subscribed; ?>" id="subscribed"><span>List subscribers</span></a>
							<a href="<?php echo $send_mail; ?>" id="existing"><span>Send mail</span></a>
						</div>

						<div class="tab-content2">
							<h4>Translation text</h4>
							<div class="input clearfix">
								<p>Subscribe Message:</p>
								<div class="list-language">
									<?php foreach($languages as $language) { ?>
									<div class="language">
										<?php $language_id = $language['language_id']; ?>
										<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
										<input type="text" name="newsletter_settings[<?php echo $language_id; ?>][subscribe_message]" <?php if(isset($newsletter_settings[$language_id]['subscribe_message'])) { echo 'value="'.$newsletter_settings[$language_id]['subscribe_message'].'"'; } ?>>
									</div>
									<?php } ?>
								</div>
							</div>
							
							<div class="input clearfix">
								<p>Unsubscribe Message:</p>
								<div class="list-language">
									<?php foreach($languages as $language) { ?>
									<div class="language">
										<?php $language_id = $language['language_id']; ?>
										<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
										<input type="text" name="newsletter_settings[<?php echo $language_id; ?>][unsubscribe_message]" <?php if(isset($newsletter_settings[$language_id]['unsubscribe_message'])) { echo 'value="'.$newsletter_settings[$language_id]['unsubscribe_message'].'"'; } ?>>
									</div>
									<?php } ?>
								</div>
							</div>
							
							<div class="input clearfix">
								<p>Confirm Unsubscribe:</p>
								<div class="list-language">
									<?php foreach($languages as $language) { ?>
									<div class="language">
										<?php $language_id = $language['language_id']; ?>
										<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
										<input type="text" name="newsletter_settings[<?php echo $language_id; ?>][confirm_unsubscribe]" <?php if(isset($newsletter_settings[$language_id]['confirm_unsubscribe'])) { echo 'value="'.$newsletter_settings[$language_id]['confirm_unsubscribe'].'"'; } ?>>
									</div>
									<?php } ?>
								</div>
							</div>
							
							<div class="input clearfix">
								<p>Invalid Email Message:</p>
								<div class="list-language">
									<?php foreach($languages as $language) { ?>
									<div class="language">
										<?php $language_id = $language['language_id']; ?>
										<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
										<input type="text" name="newsletter_settings[<?php echo $language_id; ?>][invalid_email_message]" <?php if(isset($newsletter_settings[$language_id]['invalid_email_message'])) { echo 'value="'.$newsletter_settings[$language_id]['invalid_email_message'].'"'; } ?>>
									</div>
									<?php } ?>
								</div>
							</div>
							
							<div class="input clearfix">
								<p>Email not found:</p>
								<div class="list-language">
									<?php foreach($languages as $language) { ?>
									<div class="language">
										<?php $language_id = $language['language_id']; ?>
										<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" width="16px" height="11px" />
										<input type="text" name="newsletter_settings[<?php echo $language_id; ?>][email_not_found]" <?php if(isset($newsletter_settings[$language_id]['email_not_found'])) { echo 'value="'.$newsletter_settings[$language_id]['email_not_found'].'"'; } ?>>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					
					<div>
						<!-- Buttons -->
						<div class="buttons"><input type="submit" name="button-save" class="button-save" value=""></div>
					</div>
				</div>
			</div>		
		</form>
	</div>
</div>
<?php echo $footer; ?>