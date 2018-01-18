<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
	<br><br><br>
	<div class="row">
		<div class="col-md-4 offset-md-4">
			<div class="card text-center">
				<div class="card-header">
					<h4 class="card-title"><?php echo $this->lang->line('user_title_login'); ?></h4>
				</div>
				<div class="card-body">
					<?php if(isset($error)): ?>
						<?php if($error): ?>
							<div class="alert alert-danger"><?php echo $error; ?></div>
						<?php endif; ?>
					<?php endif; ?>

					<form method="post" action="login">
						<div class="input-group">
							<div class="input-group-addon"><i class="fa fa-at" aria-hidden="true"></i></div>
							<input type="email" name="email" class="form-control" required placeholder="<?php echo $this->lang->line('user_input_email'); ?>">
						</div>
						<br>
						<div class="input-group">
							<div class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></div>
							<input type="password" name="password" class="form-control" required placeholder="<?php echo $this->lang->line('user_input_password'); ?>">
						</div>
						<br>
						<div class="form-check">
							<div class="press">
								<input type="checkbox" id="unchecked" name="remember" class="cbx hidden form-check-input" checked/>
								<label for="unchecked" class="lbl"></label>
								<span><?php echo $this->lang->line('user_input_remember'); ?></span>
							</div>
						</div>
						<button type="submit" class="btn btn-primary btn-block"><?php echo $this->lang->line('user_input_submit'); ?></button>
					</form>
				</div>
				<div class="card-footer text-muted">
					<?php echo anchor('/register', $this->lang->line('user_link_register')); ?> - <?php echo anchor('/forgot', $this->lang->line('user_link_forgot')); ?>
				</div>
			</div>
		</div>
	</div>
</div>
