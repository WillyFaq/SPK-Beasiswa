
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login - Aplikasi SPK Seleksi Penerimaan Beasiswa Siswa Berprestasi</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png'); ?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/vendor/bootstrap-4/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('<?= base_url('assets/img/bg-01.jpg'); ?>');">
			<div class="wrap-login100">
				<?= form_open($form, array("class" => "login100-form validate-form") );?>
					<span class="login100-form-logo">
						<!-- <i class="zmdi zmdi-landscape"></i>
						 -->
						<img src="<?= base_url('assets/img/logo.png'); ?>" style="width:100px" alt="Logo">
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						Log in
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>


<?php 
	$msg = $this->session->flashdata("msg");
	$msg_status = $this->session->flashdata("msg_status");
	$msg_title = $this->session->flashdata("msg_title");
	if(isset($msg)): 
?>
	<div class="alert <?= $msg_status; ?> alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		<h4 id="omg-error-txt"><?= $msg_title; ?><a class="anchorjs-link" href="#omg-error-txt"><span class="anchorjs-icon"></span></a></h4>
		<p><?php echo $msg; ?></p>
	</div>
<?php endif; ?>

	
<!--===============================================================================================-->
	<script src="<?= base_url('assets'); ?>/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= base_url('assets'); ?>/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= base_url('assets'); ?>/vendor/bootstrap-4/js/popper.js"></script>
	<script src="<?= base_url('assets'); ?>/vendor/bootstrap-4/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= base_url('assets'); ?>/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?= base_url('assets'); ?>/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?= base_url('assets'); ?>/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="<?= base_url('assets'); ?>/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="<?= base_url('assets'); ?>/js/main.js"></script>
</body>
</html>