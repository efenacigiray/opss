<?php echo $header; ?><?php echo $column_left; ?>
<div id="content"><div class="container-fluid">
	<div class="page-header">
	    <h1>MegaMenu Manager Links</h1>
	    <ul class="breadcrumb">
		     <?php foreach ($breadcrumbs as $breadcrumb) { ?>
		      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		      <?php } ?>
	    </ul>
	  </div>
    
<link href='http://fonts.googleapis.com/css?family=Open+Sans:600,500,400' rel='stylesheet' type='text/css'>

	<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
	  <?php } else { ?>
	  <?php if ($success) { ?>
	  <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
	    <button type="button" class="close" data-dismiss="alert">&times;</button>
	  </div>
	  <?php } } ?>
	
	<!-- Camera slider -->
	<div class="set-size" id="megamenu-manager-links">		
			<!-- Content -->
			<div class="content">
				<div>
					<div class="bg-tabs clearfix">
						<div class="tab-content">
							<table id="module-placement">
								<thead>
									<tr>
										<td class="first" style="width:700px">Name</td>
										<td>Edit</td>
										<td>Delete</td>
									</tr>
								</thead>
								<tbody>
									<?php foreach($links as $link) { ?>
									<tr>
										<td class="first"><?php echo $link['name_for_autocomplete']; ?></td>
										<td><a href="<?php echo $link_url.'&link_id='.$link['id']; ?>">Edit</a></td>
										<td><a href="<?php echo $link_url.'&link_id='.$link['id'].'&delete=true'; ?>" onclick="return confirm('Are you sure you want to delete?')">Remove</a></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
					
					<div>
						<!-- Buttons -->
						<div class="buttons"><a href="<?php echo $link_url; ?>" class="button-add-link"></a></div>
					</div>
				</div>
			</div>		
	</div>
</div>

<?php echo $footer; ?>