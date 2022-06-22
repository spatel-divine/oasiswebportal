<?php include("header.php");?>
<!-- app-content-->

                <!-- app-content-->
				<div class="container content-area">
					<div class="side-app">

						<!-- page-header -->
						<div class="page-header">
							<ol class="breadcrumb"><!-- breadcrumb -->
								<li class="breadcrumb-item"><a href="#">User</a></li>
								<li class="breadcrumb-item active" aria-current="page">Change Password</li>
							</ol><!-- End breadcrumb -->
						</div>
						<!-- End page-header -->

						<?php if($this->session->flashdata('success')): ?>
							<font color="green"><?php echo $this->session->flashdata('success'); ?></font>
						<?php endif; ?>
						<!-- row -->
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-body">
									<form method="post" action="<?php echo base_url('Management/PasswordChange');?>">
										<div class="form-group">
											<div class="row">	
												<div class="col-lg-6 col-md-12">
													<label>User</label>
													<select class="form-control select2" name="user_id">
														    <option value=""></option>
															<?php if(count($UsersData) > 0 ) {
																foreach($UsersData as $user_data){
																?>
														    	<option value="<?php echo $user_data->id;?>"><?php echo $user_data->user_name;?></option> 
															<?php } 
															}?>
													</select>
													<font color="red"><?=form_error("user");?></font>
												</div>
												<div class="col-lg-6 col-md-12">
													<label>New Password</label>
													<input type="password" class="form-control" name="password" value="<?php echo set_value('search_user');?>" placeholder="Enter New Password">	
													<font color="red"><?=form_error("password");?></font>
												</div>
												
											</div>
										</div>
										<hr/>
										<div class="form-group"  style="float:right;">
												<div class="row">
													<input type="submit" name="submit" value="Submit" class="btn btn-app btn-primary mr-2 mt-1 mb-1">
												</div>

										</div>
										
									</form>

									</div>
								</div>
							</div>
						</div>
						<!-- row end -->

					</div>
	

<?php include("footer.php");?>
