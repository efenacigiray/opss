							</div>
							
							<?php if( count($column_right) ) { ?> 
							<div class="col-md-<?php echo $grid_content_right; ?> columnleftright" id="column-right">
								<?php foreach ($column_right as $module) {
									echo $module;
								} ?>
							</div>
							<?php } ?>
						</div>
					</div>
					
					<?php 
					$columnleft = $modules_old_opencart->getModules('column_left');
					if( count($columnleft) ) { ?>
					<div class="col-md-3 columnleftright" id="column-left">
						<?php
						foreach ($columnleft as $module) {
							echo $module;
						}
						?>
					</div>
					<?php } ?>
				</div>
				
				<div class="row">	
					<div class="col-sm-12">	
						<?php 
						$contentbottom = $modules_old_opencart->getModules('content_bottom');
						if( count($contentbottom) ) { ?>
							<?php
							foreach ($contentbottom as $module) {
								echo $module;
							}
							?>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>				  
</div>