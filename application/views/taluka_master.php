<?php include("header.php");?>
<!-- app-content-->

                <!-- app-content-->
				<div class="container content-area">
					<div class="side-app">

						<!-- page-header -->
						<div class="page-header">
							<ol class="breadcrumb"><!-- breadcrumb -->
								<li class="breadcrumb-item"><a href="#">Taluka</a></li>
								<li class="breadcrumb-item active" aria-current="page">Manage Taluka</li>
							</ol><!-- End breadcrumb -->
						</div>
						<!-- End page-header -->

						<!-- row -->
						<div class="row">
							<div class="col-md-6">
								<div class="card">
									<div class="card-body">
										<h4 class="breadcrumb-item">Add Taluka</h4>
									</div>
									<div class="card-body">
										<div class="form-group">
											<div class="row">	
												<div class="col-lg-6 col-md-12">
													<label>District Name</label>
													<!--Need to fetch dynamically-->
													<select name="district_name" class="form-control">
														<option value="">Select District</option>
														<option value="Vadodara">Vadodara</option>
														<option value="Ahmedabad">Ahmedabad</option>
													</select>
													<font color="red"><?=form_error("district_name");?></font>
												</div>
												<div class="col-lg-6 col-md-12">
													<label>Taluka Name</label>
													<input type="text" class="form-control" name="taluka_name" value="<?php echo set_value('taluka_name');?>" placeholder="Enter Taluka Name">	
													<font color="red"><?=form_error("taluka_name");?></font>
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
										<h4 class="breadcrumb-item">View Taluka List</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example3" class="table table-striped table-bordered text-nowrap" >
												<thead>
													<tr>
														<th>District Name</th>
														<th>Taluka Name</th>
														<th style="width:20px;">Action</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Vadodara</td>
														<td>Dabhoi</td>
														<td style="width:20px;"><a class="btn btn-secondary btn-sm" href="#"><i class="fa fa-edit"></i> Edit</a></td>									
													</tr>
													<tr>
														<td>Surat</td>
														<td>Bardoli</td>
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