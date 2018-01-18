<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container">
	<br><br><br>
	<div class="row">
		<div class="col-md-4 offset-md-4">
			<div class="card text-center">
				<div class="card-header">
					<h4 class="card-title"><?php echo $this->lang->line('user_title_register'); ?></h4>
				</div>
				<div class="card-body">
					<?php if(isset($error)): ?>
						<?php if($error): ?>
							<div class="alert alert-danger"><?php echo $error; ?></div>
						<?php else: ?>
							<div class="alert alert-success"><?php echo $this->lang->line('user_output_register_success'); ?></div>
						<?php endif; ?>
					<?php endif; ?>

					<form method="post" action="register">
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
						<div class="input-group">
							<div class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></div>
							<input type="password" name="password_confirm" class="form-control" id="inputPasswordConfirm" required placeholder="<?php echo $this->lang->line('user_input_confirm_pwd'); ?>">
						</div>
						<br>
						<div class="g-recaptcha" data-sitekey="6LcCdRQUAAAAADzBRBrDz_FRtq5aYz9OKZxw1bV_"></div>
						<br>
						<button type="submit" class="btn btn-primary btn-block"><?php echo $this->lang->line('user_input_submit'); ?></button>
					</form>
				</div>
				<div class="card-footer text-muted">
					<?php echo anchor('/login', $this->lang->line('user_link_login')); ?> - <?php echo anchor('/forgot', $this->lang->line('user_link_forgot')); ?>
				</div>
			</div>
		</div>
	</div>
</div>
