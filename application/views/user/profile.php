<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
	<div class="row">
		<div class="col-md-12 text-center">
			<h1><?php echo $this->lang->line('user_title_account'); ?></h1>
			
			<br>
			<div class="well"><?php echo $this->lang->line("user_sensor_list"); ?></div>
			<hr>
		</div>
	</div>
	<div class="row">
		<?php if(isset($sensors) && count($sensors) > 0): ?>
			<?php foreach($sensors as $sensor): ?>
				<a class="col-md-3 sensor-box" href="<?php echo base_url() . 'data/' . $sensor->id ?>">
						<?php echo $this->lang->line('user_sensor') . ' : ' . $sensor->id; ?><br>
						<?php echo $this->lang->line('user_plant') . ' : ' . $sensor->plant; ?>

						<img class="img-plant" alt="Plante" src="<?php echo base_url() . 'assets/images/plant.png' ?>">
				</a>
			<?php endforeach; ?>
		<?php else: ?>
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-info"><?php echo $this->lang->line('user_no_sensor'); ?></div>
			</div>
		</div>
		<?php endif; ?>
		<div class="col-md-3">
			<?php echo anchor('/add-sensor', '+', 'class="btn btn-addsensor"'); ?>
		</div>
	</div>
</div>
<div class="row">
<div class="col-8"></div>
<a href="http://samet.nelva.fr/option"><i class="fa fa-cog fa-5x" aria-hidden="true"></i></a>
</div></div>
