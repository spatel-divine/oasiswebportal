<!doctype html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		
		<!-- Favicon -->
		<link rel="icon" href="<?=base_url();?>assets/images/brand/favicon.ico" type="image/x-icon"/>
		<link rel="shortcut icon" type="image/x-icon" href="<?=base_url();?>assets/images/brand/favicon.ico" />

		<!-- Title -->
		<title>Oasis Movement Web Portal</title>

		<!--Bootstrap.min css-->
		<link rel="stylesheet" href="<?=base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css">

		<!-- Dashboard css -->
		<link href="<?=base_url();?>assets/css/style.css" rel="stylesheet" />

		<!-- Perfect scroll bar css-->
		<link href="<?=base_url();?>assets/plugins/pscrollbar/perfect-scrollbar.css" rel="stylesheet" />

		<!-- Sidemenu css -->
		<link rel="stylesheet" href="<?=base_url();?>assets/plugins/side-menu/sidemenu-1/closed-sidemenu.css">

		<!--Daterangepicker css-->
		<link href="<?=base_url();?>assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />

		<!-- Sidebar Accordions css -->
		<link href="<?=base_url();?>assets/plugins/sidemenu-responsive-tabs/css/easy-responsive-tabs.css" rel="stylesheet">

		<!-- Rightsidebar css -->
		<link href="<?=base_url();?>assets/plugins/sidebar/sidebar.css" rel="stylesheet">

		<!---Font icons css-->
		<link href="<?=base_url();?>assets/plugins/webfonts/plugin.css" rel="stylesheet" />
		<link href="<?=base_url();?>assets/plugins/webfonts/icons.css" rel="stylesheet" />
		<link  href="<?=base_url();?>assets/fonts/fonts/font-awesome.min.css" rel="stylesheet">

		<!-- Color-skins css -->
		<link id="theme" rel="stylesheet" type="text/css" media="all" href="<?=base_url();?>assets/colors/color-skins/color.css" />
		<link rel="stylesheet" href="<?=base_url();?>assets/css/demo-styles.css"/>

	</head>
	<body class="bg-account">
	    <!-- page -->
		<div class="page">

			<!-- page-content -->
			<div class="page-content">
				<div class="container text-center text-dark">
					<div class="row">
						<div class="col-lg-4 d-block mx-auto">
							<div class="row">
								<div class="col-xl-12 col-md-12 col-md-12">
									<div class="card">
										<?php
										if(isset($_SESSION['message']) && $this->session->flashdata('message'))
										{
											echo '<div class="alert alert-danger"><font color="white"><b>
												'.$this->session->flashdata("message").'
											</b></font></div>';
										}
										?>
										<div class="card-body">
										<form method="post" action="<?php echo base_url('userLogin');?>">
											<div class="text-center mb-6">
												<img src="<?=base_url();?>assets/images/brand/logo.png" class="" alt="">
											</div>
											<h3>Login</h3>
											<p class="text-muted">Sign In to your account</p>
											<div class="input-group mb-3">
												<span class="input-group-addon bg-white"><i class="fa fa-user"></i></span>
												<input type="text" class="form-control" name="user_name" placeholder="Username">
											</div>
											<div class="input-group mb-4"><font color="red"><?=form_error("user_name");?></font></div>
											<div class="input-group mb-4">
												<span class="input-group-addon bg-white"><i class="fa fa-unlock-alt"></i></span>
												<input type="password" class="form-control" name="password" placeholder="Password">

											</div>
											<div class="input-group mb-4"><font color="red"><?=form_error("password");?></font></div>

											<div class="row">
												<div class="col-12">
													<button type="submit" class="btn btn-primary btn-block">Login</button>
													<!-- <a href="<?php echo base_url('Home');?>" class="btn btn-primary btn-block">Login</a> -->
												</div>
												
											</div>
										</form>
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<!-- page-content end -->
		</div>
		<!-- page End-->

		<!-- Jquery js-->
		<script src="<?=base_url();?>assets/js/vendors/jquery-3.2.1.min.js"></script>

		<!--Bootstrap.min js-->
		<script src="<?=base_url();?>assets/plugins/bootstrap/popper.min.js"></script>
		<script src="<?=base_url();?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>

		<!--Jquery Sparkline js-->
		<script src="<?=base_url();?>assets/js/vendors/jquery.sparkline.min.js"></script>

		<!-- Chart Circle js-->
		<script src="<?=base_url();?>assets/js/vendors/circle-progress.min.js"></script>

		<!-- Star Rating js-->
		<script src="<?=base_url();?>assets/plugins/rating/jquery.rating-stars.js"></script>

		<!-- Sidebar Accordions js -->
		<script src="<?=base_url();?>assets/plugins/sidemenu-responsive-tabs/js/easyResponsiveTabs.js"></script>

		<!--Moment js-->
		<script src="<?=base_url();?>assets/plugins/moment/moment.min.js"></script>

		<!-- Daterangepicker js-->
		<script src="<?=base_url();?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>

		<!-- Perfect scroll bar js-->
		<script src="<?=base_url();?>assets/plugins/pscrollbar/perfect-scrollbar.js"></script>
		<script src="<?=base_url();?>assets/plugins/pscrollbar/p-scroll.js"></script>

		<!-- Custom js-->
		<script src="<?=base_url();?>assets/js/custom.js"></script>

	</body>
</html>