<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
	<div class="row">
		<div class="col-md-12 text-center">
			<h1><?php echo $this->lang->line("plants_title"); ?></h1>
			<br>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div id="search-box"></div>
			<div id="algolia"><img src="<?php echo base_url(); ?>assets/images/search-by-algolia.png"></div>
			<div id="hits"></div>
		</div>
	</div>
</div>
