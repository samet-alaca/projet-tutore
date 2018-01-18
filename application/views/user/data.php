<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
	<div class="row">
		<div class="col-md-12 text-center">
			<h1><?php echo $this->lang->line("user_sensor"); ?></h1>
			<br>
			<hr>
		</div>
	</div>
	<div class="row">
		<?php if(isset($data) && count($data) > 0): ?>
			<div class="well">OK</div>
		<?php else: ?>
			<div class="row">
				<div class="col-md-12">
					<!--<div class="alert alert-info"><?php echo $this->lang->line('user_no_sensor'); ?></div>-->
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1 id="plant" class="text-center"><?php echo $sensor->plant; ?></h1>

			<div class="container">
				<canvas id="myLineChart" class="chartjs-render-monitor" width="400" height="400"></canvas>
			</div>
		</div>
	</div>
</div>
