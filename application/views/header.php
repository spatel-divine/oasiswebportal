<!doctype html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<!-- Favicon -->
		<link rel="icon" href="<?=base_url();?>assets/images/brand/favicon.ico" type="image/x-icon"/>
		<link rel="shortcut icon" type="image/x-icon" href="<?=base_url();?>assets/images/brand/favicon.ico" />

		<!-- Title -->
		<title>Oasis Web Portal</title>

		<!--Bootstrap.min css-->
		<link rel="stylesheet" href="<?=base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

		<!-- Dashboard css -->
		<link href="<?=base_url();?>assets/css/style.css" rel="stylesheet" />
		<link href="<?=base_url();?>assets/css/boxed.css" rel="stylesheet" />

		<!-- Perfect scroll bar css-->
		<link href="<?=base_url();?>assets/plugins/pscrollbar/perfect-scrollbar.css" rel="stylesheet" />

		<!-- Horizontal-menu css -->
		<link href="<?=base_url();?>assets/plugins/horizontal-menu/dropdown-effects/fade-down.css" rel="stylesheet">
		<link href="<?=base_url();?>assets/plugins/horizontal-menu/horizontalmenu.css" rel="stylesheet">
		
		<!-- Date Picker css-->
		<link href="<?=base_url();?>assets/plugins/spectrum-date-picker/spectrum.css" rel="stylesheet" />

		<!--Daterangepicker css-->
		<link href="<?=base_url();?>assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />

		<!-- Sidebar Accordions css -->
		<link href="<?=base_url();?>assets/plugins/sidemenu-responsive-tabs/css/easy-responsive-tabs.css" rel="stylesheet">

		<!-- Rightsidebar css -->
		<link href="<?=base_url();?>assets/plugins/sidebar/sidebar.css" rel="stylesheet">

		<!-- Rating css-->
		<link rel="stylesheet" href="<?=base_url();?>assets/plugins/rating/css/examples.css">

		<!-- RatingThemes css-->
		<link rel="stylesheet" href="<?=base_url();?>assets/plugins/rating/dist/themes/bars-1to10.css">

		<!-- Data table css -->
		<link href="<?=base_url();?>assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />
		<link href="<?=base_url();?>assets/plugins/datatable/responsivebootstrap4.min.css" rel="stylesheet" />

		<!--File Upload Css-->
		<link href="<?=base_url();?>assets/plugins/fileuploads/css/dropify.css" rel="stylesheet" type="text/css" />

		<!--News ticker css -->
		<link href="<?=base_url();?>assets/plugins/newsticker/breaking-news-ticker.css" rel="stylesheet" />

		<!---Font icons css-->
		<link href="<?=base_url();?>assets/plugins/webfonts/plugin.css" rel="stylesheet" />
		<link href="<?=base_url();?>assets/plugins/webfonts/icons.css" rel="stylesheet" />
		<link  href="<?=base_url();?>assets/fonts/fonts/font-awesome.min.css" rel="stylesheet">

		<!-- WYSIWYG Editor css -->
		<link href="<?=base_url();?>assets/plugins/wysiwyag/richtext.css" rel="stylesheet" />
		<!--Summernote css-->
		<link rel="stylesheet" href="<?=base_url();?>assets/plugins/summernote/summernote-bs4.css">

		<!-- Color-skins css -->
		<link id="theme" rel="stylesheet" type="text/css" media="all" href="<?=base_url();?>assets/colors/color-skins/color.css" />
		<link rel="stylesheet" href="<?=base_url();?>assets/css/demo-styles.css"/>
		<link rel="stylesheet" href="<?=base_url();?>assets/css/tooltipster.bundle.css"/>
		<link href="https://cdn.jsdelivr.net/gh/hummingbird-dev/hummingbird-treeview@v3.0.0/hummingbird-treeview.min.css" rel="stylesheet">

		<style type="text/css">
			.header_setting{
				font-size: 25px !important;
			}
			.btn_default_style{
				border-color : #ffffff;
				background-color: #ffffff;
			}

			.app-header .btn_default_style::after {
				content: none;
			}	
			.scroll_menu{
				max-height: 350px;
			    overflow-y: auto;
			    overflow-x: hidden;
			}
			.program_hover:hover{
				transform: scale(1.2);
    			transition: 1s;
			}
			.label_for_modal{
				font-weight: bold !important;
			}
			.horizontalMenu>.horizontalMenu-list>li>ul.sub-menu>li>ul.sub-menu>li>ul.sub-menu>li>a{
				color : #000000;
			}
			.trait_survey{
				display: block !important;
				border:none !important;
			}
			.survey_line1{
				font-size:17px;
				font-weight: bolder;
			}
			.survey_line2{
				
				font-size:14px;
				margin-top: -34px;
			}
			.survey_line3{

				margin-top: -20px;

			}
			.survery_parameter{
				width: 40%;
			}
			.survey_topic{
				background: black !important;
    			color: white;
    			font-weight: bolder !important;
			}
			.table_content_height{
				height: 55px;
			}
			.content_value_align{
				vertical-align: middle !important;
			}
			.fluid_img{
				height: 180px;
    			width: 100%;
			}
			.custom-control-label{
				color:#000000;
			}
			/*.hummingbird-treeview, .hummingbird-treeview * {
			    font-size: 15px;
			}
			.ml-1rem{
               margin-left: 1rem;
			}
			.ml-3rem{
               margin-left: 3rem;
			}
			.ml-5rem{
               margin-left: 5rem;
			}*/
			.table_view_style{
				border: 1px solid;
			}
			.module_name_style{
				border: 1px solid;
				font-weight: 700;
			    background-color: #000000;
			    color: #ffffff;
			    font-size: 18px;
			}
			.nav_down_arr{
			   font-size: 22px;	
			}
			.wrapper{
				width: 100%;
				height: 350px;
				overflow-y: auto;
			}

			.wrapper table thead th{
                background: #eee;
                position: sticky;
                top: 0px;
			}
			/*div#myTable_wrapper table.dataTable{
				margin-top: 0px !important;
				margin-bottom: 0px !important;
			}*/
            .myTable{
            	margin-top: 0px !important;
				margin-bottom: 0px !important;
            }
			.ui-tooltip {
			    z-index: 10000;
			    background-color: #5FC8D6;
			    color: #ffffff;
			    max-width: 500px;
			    padding: 10px 15px;
			    border-radius: 5px;
			}
			.ui-helper-hidden-accessible{
				display: none;

			}
			
            .modal.show .modal-dialog{
				box-shadow: 1px 1px 8px 1px #6565656b;
			}
			.modal-open .modal{
				background-color: #0000008a;
			}
			.wrapper table thead th:nth-child(odd){
                background: #d4d4d4;
                font-weight: bold;
			}
			.wrapper table thead th:nth-child(even){
                background: #e0e0e0;
                font-weight: bold;
			}
			.breadcrumb-item{
                font-weight: 500;
			}
			.btn-primary{
				background :#86A937;
				border-color : #ffffff;
			}
			.btn-primary:hover{
				background :#666667;
				border-color : #ffffff;
			}
			.hor-menu .horizontalMenu>.horizontalMenu-list>li>a.active {
				background :#86A937;
			}
			.hor-menu .horizontalMenu>.horizontalMenu-list>li>a:hover:before {
			    border-bottom: 2px solid #86A937;
			}
			.br-theme-bars-1to10 .br-widget a.br-active, .br-theme-bars-1to10 .br-widget a.br-selected {
				background :#86A937;
			}
			.br-theme-bars-1to10 .br-widget .br-current-rating {
			    color :#86A937;
			}
			.thead-dark th {
			    color: #ffffff !important;
			    background-color: #000000 !important;
			}
			/*.horizontalMenu>.horizontalMenu-list>li>ul.sub-menu>li>a:hover {
				color :#86A937;
			}
			.horizontalMenu>.horizontalMenu-list>li>ul.sub-menu>li>ul.sub-menu>li>a:hover {
			    color :#86A937;
			}*/
			ul.sub-menu a:hover {
			    color: #86A937 !important;
			}
			.horizontal-main.hor-menu.clearfix>div>nav>ul>li>ul>li>a:before {
			content: '\e50'!important;
			font-size: 20px;
			}
			.btn-secondary{
				background-color: #69862a;
                border-color: #69862a;
			}
			.modal-width{
                width: 60%;
			}
			.validationerror{
				color: #ff0000 !important;
			}
			/* start ajax data table design issue after ajax call */
			table.dataTable{
				margin-left: 0px !important;
				width: 100% !important;
			}
			div.dataTables_scrollBody{
				max-height: 200px !important;
			}
			/* end ajax data table design issue after ajax call */
			.is_required_field{
				border: 1px solid red;
			}
			.is_required_field_select2{
				border: 1px solid red;
				border-radius: .25rem !important;
			}
			.txtlbl{
				margin-bottom: 5px;
			}
			.lbl-note{
				color:#ff0000;
			}
			.select2-container--default .select2-selection--multiple{
			    border-radius: .25rem !important;
			}
			.br-theme-bars-1to10 .br-widget a {
			    background-color: #cecece;
			}
			.highlight{
				color:#000000;
				background: rgba(204, 232, 181, 0.5);
			}
		</style>
		<!-- Jquery js-->
		<script src="<?=base_url();?>assets/js/vendors/jquery-3.2.1.min.js"></script>
		<script src="<?=base_url();?>assets/js/jquery.validate.min.js"></script>
	</head>
	<body>
	<?php 
	  if(!is_logged_in()) {
		redirect('login');
	  }else{
		$this->session_data = is_logged_in();
	  }
	?>
		<!--Global-Loader-->
		<div id="global-loader">
			<img src="<?=base_url();?>assets/images/brand/icon.png" alt="loader">
		</div>

		<div class="page">
			<div class="page-main">
				<!--app-header-->
				<div class="app-header header d-flex">
					<div class="container">
						<div class="d-flex">
						    <a class="header-brand" href="<?php echo site_url('home')?>">
								<img src="<?=base_url();?>assets/images/brand/logo.png" class="header-brand-img main-logo" alt="Oasis Movement Web Portal">
								<img src="<?=base_url();?>assets/images/brand/logo.png" class="header-brand-img icon-logo" alt="Oasis Movement Web Portal">
							</a><!-- logo-->
							<a id="horizontal-navtoggle" class="animated-arrow hor-toggle"><span></span></a>
							<a href="#" data-toggle="search" class="nav-link nav-link  navsearch"><i class="fa fa-search"></i></a><!-- search icon -->

							<div class="d-flex order-lg-2 ml-auto header-rightmenu">

								<div class="dropdown">
									<a  class="nav-link icon full-screen-link" id="fullscreen-button">
										<i class="fe fe-maximize-2"></i>
									</a>
								</div><!-- full-screen -->
								<div class="dropdown header-notify">
									<a class="nav-link icon" data-toggle="dropdown" aria-expanded="false">
										<i class="fe fe-bell "></i>
										<span class="pulse bg-success"></span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
										<a href="#" class="dropdown-item text-center">4 New Notifications</a>
										<div class="dropdown-divider"></div>
										<a href="#" class="dropdown-item d-flex pb-3">
											<div class="notifyimg bg-green">
												<i class="fe fe-mail"></i>
											</div>
											<div>
												<strong>Message Sent.</strong>
												<div class="small text-muted">12 mins ago</div>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex pb-3">
											<div class="notifyimg bg-pink">
												<i class="fe fe-shopping-cart"></i>
											</div>
											<div>
												<strong>Order Placed</strong>
												<div class="small text-muted">2  hour ago</div>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex pb-3">
											<div class="notifyimg bg-blue">
												<i class="fe fe-calendar"></i>
											</div>
											<div>
												<strong> Event Started</strong>
												<div class="small text-muted">1  hour ago</div>
											</div>
										</a>
										<a href="#" class="dropdown-item d-flex pb-3">
											<div class="notifyimg bg-orange">
												<i class="fe fe-monitor"></i>
											</div>
											<div>
												<strong>Your Admin Lanuch</strong>
												<div class="small text-muted">2  days ago</div>
											</div>
										</a>
										<div class="dropdown-divider"></div>
										<a href="#" class="dropdown-item text-center">View all Notifications</a>
									</div>


								</div><!-- notifications -->

								<div class="dropdown header-notify">
									<a class="nav-link icon" data-toggle="dropdown" aria-expanded="false">
										<i class="fa fa-cog "></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
										<?php 
										$sessionuser_id='';
										if(isset($_SESSION['id']) && $_SESSION['id']){
											$sessionuser_id=$this->session->userdata('id');
										}
										?>
										<a href="<?php echo site_url('Management/add_user/'.$sessionuser_id); ?>" class="dropdown-item text-center">Hello,<br/> <?php echo $this->session_data['first_name']. ' '.$this->session_data['last_name'];?></a>
										<div class="dropdown-divider"></div>
											<li><a href="<?php echo site_url('Management/add_user/'.$sessionuser_id); ?>"><i class="fa fa-user"></i>&nbsp;&nbsp;My Profile</a></li>
											<li><a href="<?php echo base_url().'Login/logout'; ?>"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Logout</a></li>
									
									</div>
								</div><!-- notifications -->
							</div>
						</div>
					</div>
				</div>
				<!--/app-header-->

				<!--News Ticker-->
				<div class="container bg-white news-ticker">
					<div class="bg-white">
						<div class="best-ticker" id="newsticker">
							<div class="bn-news">
								<ul>
									<li><span class="fa fa-users bg-danger-transparent text-danger mr-1"></span> NGOs are paying for data packs to ensure underprivileged kids can study online</li>
									<li><span class="fa fa-signal bg-info-transparent text-info mr-1"></span> Set up e-dashboard, SOPs, involve NGOs for Covid management: NDMA to states</li>
									<li><span class="fa fa-briefcase mr-1 bg-success-transparent text-success"></span> All NGOs, except one, allowed to open A/cs with SBI New Delhi branch under FCRA: MHA to HC</li>
									
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!--/News Ticker-->

<?php include('sidebar.php');?>