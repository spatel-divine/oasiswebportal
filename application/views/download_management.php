<?php include("header.php");?>

                <!-- app-content-->
				<div class="container content-area">
					<div class="side-app">

						<!-- page-header -->
						<div class="page-header">
							<ol class="breadcrumb"><!-- breadcrumb -->
								<li class="breadcrumb-item"><a href="#">Share With Us</a></li>
								<li class="breadcrumb-item active" aria-current="page">Download Management</li>
							</ol><!-- End breadcrumb -->
							<div class="ml-auto">
								<div class="input-group">
									<a href="<?php echo site_url('ConnectOM/share_post/')?>" class="btn btn-info text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add New">
										<span>
											<i class="fa fa-plus"></i>&nbsp;Share Post
										</span>
									</a>&nbsp;

									<a href="<?php echo site_url('ConnectOM/view_shared_post_list/')?>" class="btn btn-success text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="View All">
										<span>
											<i class="fa fa-eye"></i>&nbsp;Manage Posts
										</span>
									</a>&nbsp;

								</div>
							</div>
						</div>
						<!-- End page-header -->

						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-body">
										<div class="form-group">
											<div class="row">				
												<div class="col-lg-10 col-md-12">
													<label>Category</label>
													<select name="category" class="form-control">
														<option value="Touching Stories">Touching Stories</option>
														<option value="Share Stories">Share Stories</option>
													</select>
													<font color="red"><?=form_error("category");?></font>
												</div>
												<div class="col-lg-2 col-md-12">

													<input type="submit" class="btn btn-primary" value="Filter" id="btn-filter" name="filter" style="margin-top:24px;width:100px;">
														
														<a class="btn btn-primary" href="<?php echo base_url('ConnectOM/download_management');?>" style="margin-top:24px;width:100px;">Reset</a>	

												</div>
												
											</div>
										</div>	
									</div>
								</div>
							</div>
						</div>					

						<!-- row -->
						<div class="row row-cards">
							<div class="col-lg-12 col-xl-12">
								<div class="row">
									<div class="col-lg-4 col-xl-4">
										<div class="card item-card ">
											<div class="card-body">
												<div class="product">
													<div class="text-center product-img">
														<img src="<?=base_url();?>assets/uploads/oasislandingpage.jpg" alt="img" class="fluid_img">
													</div>
													<div class="text-center mt-4">
														<a href="#"><h3 class="mb-0 mt-2">L3T-M18-Blr-Winners-Local</h3></a>
														<div class="price mt-3 h4 mb-0 ">
															<h4 class="text-muted mr-4">Share Stories, Touching Stories</h4>
														</div>
													</div>
													<div class="text-center mt-4">
														<a href="#" class="btn btn-primary">View Post</a>
														<a href="#" class="btn btn-primary">Download</a>
													</div>
												</div>
											</div>
									    </div>
									</div>
									<div class="col-lg-4 col-xl-4">
										<div class="card item-card ">
											<div class="card-body">
												<div class="product">
													<div class="text-center product-img">
														<img src="<?=base_url();?>assets/uploads/oasislandingpage.jpg" alt="img" class="fluid_img">
													</div>
													<div class="text-center mt-4">
														<a href="#"><h3 class="mb-0 mt-2">M18 L3 Love 2 Bangalore</h3></a>
														<div class="price mt-3 h4 mb-0 ">
															<h4 class="text-muted mr-4">Share Stories, Touching Stories</h4>
														</div>
													</div>
													<div class="text-center mt-4">
														<a href="#" class="btn btn-primary">View Post</a>
														<a href="#" class="btn btn-primary">Download</a>
													</div>
												</div>
											</div>
									    </div>
									</div>
								</div><!-- row end -->
							</div>
							<!-- row end -->
						</div>
						<!-- row end -->

					</div>

<?php include("footer.php");?>