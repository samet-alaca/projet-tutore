<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<?php if(isset($page['meta_description'])): ?>
		<meta name="description" content="<?php echo $page['meta_description'] ?>">
	<?php endif; ?>

	<title><?php echo $page['title']; ?></title>

	<link rel="icon" href="<?php echo base_url() . 'assets/favicon.png' ?>"/>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.4/cookieconsent.min.css">
	<link rel="stylesheet" href="<?php echo base_url() . 'assets/app.css'; ?>">

	<?php if(isset($page['links'])): ?>
		<?php foreach($page['links'] as $link): ?>
			<link rel="stylesheet" type="text/css" href="<?php echo $link; ?>"/>
		<?php endforeach; ?>
	<?php endif; ?>

	<script defer src="https://code.jquery.com/jquery-latest.min.js"></script>
	<script defer src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
	<script defer src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
	<script defer src="https://cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.4/cookieconsent.min.js"></script>
	<script defer src="<?php echo base_url() . 'assets/app.js'; ?>"></script>

	<?php if(isset($page['scripts'])): ?>
		<?php foreach($page['scripts'] as $script): ?>
			<script defer src="<?php echo $script; ?>"></script>
		<?php endforeach; ?>
	<?php endif; ?>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-navbar">
		<?php echo anchor('', 'Trust-ePot', 'class="navbar-brand"'); ?>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<?php $class = ($this->uri->segment(1) == '') ? "nav-item active" : "nav-item"; ?>
				<li class="<?php echo $class; ?>">
					<?php echo anchor('', $this->lang->line('navbar_item_home'), 'class="nav-link"'); ?>
				</li>

				<?php $class = ($this->uri->segment(1) == 'plants') ? "nav-item active" : "nav-item"; ?>
				<li class="<?php echo $class; ?>">
					<?php echo anchor('plants', $this->lang->line('navbar_item_plants'), 'class="nav-link"'); ?>
				</li>

			</ul>

			<ul class="navbar-nav ml-auto">
				<?php $user = $this->session->user; ?>

				<?php if(isset($user)): ?>
					<?php $class = ($this->uri->segment(1) == 'profil') ? "nav-item active" : "nav-item"; ?>
					<li class="<?php echo $class; ?>">
						<?php echo anchor('/profile', $this->lang->line('navbar_item_account'), 'class="nav-link"'); ?>
					</li>

					<?php $class = "nav-item"; ?>
					<li class="<?php echo $class; ?>">
						<?php echo anchor('/logout', $this->lang->line('navbar_item_logout'), 'class="nav-link"'); ?>
					</li>
				<?php else: ?>
					<?php $class = ($this->uri->segment(1) == 'login') ? "nav-item active" : "nav-item"; ?>
					<li class="<?php echo $class; ?>">
						<?php echo anchor('/login', $this->lang->line('navbar_item_login'), 'class="nav-link"'); ?>
					</li>

					<?php $class = ($this->uri->segment(1) == 'register') ? "nav-item active" : "nav-item"; ?>
					<li class="<?php echo $class; ?>">
						<?php echo anchor('/register', $this->lang->line('navbar_item_register'), 'class="nav-link"'); ?>
					</li>
				<?php endif; ?>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-language" aria-hidden="true"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
						<a class="dropdown-item setLanguage" data-lang="english" href="#"><img class="img-responsive country-flag" src="<?php echo base_url() . 'assets/images/uk.png'; ?>"></a>
						<a class="dropdown-item setLanguage" data-lang="french" href="#"><img class="img-responsive country-flag" src="<?php echo base_url() . 'assets/images/france.png'; ?>"></a>
					</div>
				</li>
			</ul>
		</div>
	</nav>
	<br>
