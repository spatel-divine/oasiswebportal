<?php include("header.php");?>
<!-- app-content-->

                <!-- app-content-->
				<div class="container content-area">
					<div class="side-app">

						<!-- page-header -->
						<div class="page-header">
							<ol class="breadcrumb"><!-- breadcrumb -->
								<li class="breadcrumb-item"><a href="#">Reason Type</a></li>
								<li class="breadcrumb-item active" aria-current="page">Manage Reason Type</li>
							</ol><!-- End breadcrumb -->
						</div>
						<!-- End page-header -->

						<!-- row -->
						<div class="row">
							<div class="col-md-6">
								<div class="card">
									<div class="card-body">
										<h4 class="breadcrumb-item">Add Reason Type</h4>
									</div>
									<div class="card-body">
										<div class="form-group">
											<div class="row">	
												<div class="col-lg-12 col-md-12">
													<label>Reason Type Name</label>
													<input type="text" class="form-control" name="reason_type" value="<?php echo set_value('reason_type');?>" placeholder="Enter Reason Type">	
													<font color="red"><?=form_error("reason_type");?></font>
												</div>
											</div>
										</div>
										<hr/>
										<div class="form-group"  style="float:right;">
												<div class="row">
													<input type="submit" name="submit" value="Submit" class="btn btn-app btn-primary mr-2 mt-1 mb-1">
												</div>

										</div>		

									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="card">
									<div class="card-body">
										<h4 class="breadcrumb-item">View Reason Type List</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example3" class="table table-striped table-bordered text-nowrap" >
												<thead>
													<tr>
														<th>Reason Type</th>
														<th style="width:20px;">Action</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>You are looking for a new challenge.</td>
														<td style="width:20px;"><a class="btn btn-secondary btn-sm" href="#"><i class="fa fa-edit"></i> Edit</a></td>									
													</tr>
													<tr>
														<td>You Are Looking for Opportunities to Progress</td>
														<td style="width:20px;"><a class="btn btn-secondary btn-sm" href="#"><i class="fa fa-edit"></i> Edit</a></td>									
													</tr>

												</tbody>
											</table>
										</div>	

									</div>
								</div>
							</div>
						</div>
						<!-- row end -->
					</div>
	

<?php include("footer.php");?>