<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
	<br><br><br>
	<div class="row">
		<div class="col-md-6 offset-md-3">
			<?php if(isset($sensor)): ?>
				<div class="card text-center">
					<div class="card-header">
						<h4 class="card-title"><?php echo $this->lang->line('sensor_title_addPlant'); ?></h4>
					</div>
					<div class="card-body">
						<?php if(isset($error)): ?>
							<?php if($error): ?>
								<div class="alert alert-danger"><?php echo $error; ?></div>
							<?php endif; ?>
						<?php endif; ?>
						<input type="hidden" name="sensor" value="<?php echo $sensor->sensor; ?>">
						<input type="hidden" name="owner" value="<?php echo $sensor->owner; ?>">
						<div id="search-box"></div>
						<br>
						<div class="plant-list" id="hits"></div>
						<br><hr><br>
						<button id="submitPlant" class="btn btn-primary btn-block disabled"><?php echo $this->lang->line('sensor_validate_plant'); ?></button>
					</div>
				</div>


			<?php else: ?>
				<div class="card text-center">
					<div class="card-header">
						<h4 class="card-title"><?php echo $this->lang->line('sensor_title_add'); ?></h4>
					</div>
					<div class="card-body">
						<?php if(isset($error)): ?>
							<?php if($error): ?>
								<div class="alert alert-danger"><?php echo $error; ?></div>
							<?php endif; ?>
						<?php endif; ?>
						<form method="post" action="">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-id-card" aria-hidden="true"></i></div>
								<input type="number" name="sensor" class="form-control" required placeholder="<?php echo $this->lang->line('sensor_input_id'); ?>">
							</div>
							<br>
							<button type="submit" class="btn btn-primary btn-block"><?php echo $this->lang->line('sensor_validate_id'); ?></button>
						</form>
					</div>
					<div class="card-footer text-muted">
						<div class="well"><?php echo $this->lang->line('sensor_addsensor_help'); ?></div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
