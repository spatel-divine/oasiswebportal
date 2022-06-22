<?php include("header.php");?>
<!-- app-content-->
<?php					
	$action = 'add';
	$program_master_id = "";
	$program_name = set_value('program_name');
	$program_related_id = set_value('program_related_id');
	$program_type_id = set_value('program_type_id');
	$number_of_days = set_value('number_of_days');
	$session_name = set_value('session_name');

	if(isset($program_data) && count($program_data) >0 ){
		$action  = 'edit';
		
		$program_master_id = $program_data[0]->id;
		$program_name = $program_data[0]->program_name;
		$program_related_id = $program_data[0]->program_related_id;
		$program_type_id = $program_data[0]->program_type_id;
		$number_of_days = $program_data[0]->number_of_days;
		$session_name = $program_data[0]->session_name;
	

	}
	
?>
                <!-- app-content-->
				<div class="container content-area">
					<div class="side-app">

						<!-- page-header -->
						<div class="page-header">
							<ol class="breadcrumb"><!-- breadcrumb -->
								<li class="breadcrumb-item"><a href="#">Program</a></li>
								<li class="breadcrumb-item active" aria-current="page"><?=ucfirst($action);?> Program</li>
							</ol><!-- End breadcrumb -->
							<div class="ml-auto">
								<div class="input-group">
									<a href="<?php echo site_url('Management/view_program_list/')?>" class="btn btn-secondary text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="View Data">
										<span>
											<i class="fa fa-eye"></i>&nbsp;View Program List
										</span>
									</a>
								</div>
							</div>
						</div>
						<!-- End page-header -->

						<!-- row -->
						<div class="row">
							<div class="col-md-12">
								<div class="card">
								<form method="post" action="<?php echo base_url('Management/add_program');?>">
									<div class="card-body">
										<div class="form-group">
											<div class="row">
												<input type="hidden" name="program_master_id" value="<?php echo $program_master_id; ?>">
												<input type="hidden" name="action" value="<?php echo $action; ?>">
												<div class="col-lg-6 col-md-12">
													<label>Program Name</label>
													<input type="text" class="form-control" name="program_name" value="<?php echo $program_name;?>" placeholder="Enter Program Name" required>	
													<font color="red"><?=form_error("program_name");?></font>
												</div>

												<div class="col-lg-6 col-md-12">
													<label>Related To</label>
													<select name="program_related_id" class="form-control" required>
														<option value="">Select Related To</option>
														<?php if(count($data_program_related) > 0) { 
																foreach($data_program_related as $item_related) {	
														?>
															<option value="<?php echo $item_related->id;?>" <?php echo ($program_related_id == $item_related->id)?" selected=' selected'":""?> ><?php echo $item_related->program_related_to_name;?></option>
														<?php }
														} ?>
													</select>
													<font color="red"><?=form_error("program_related_id");?></font>
												</div>
												
											</div>
										</div>

										<div class="form-group">
											<div class="row">	
												<div class="col-lg-4 col-md-12">
													<label>Program Type</label>
													<select name="program_type_id" class="form-control" required>
															<option value="">Select Program Type</option>
															<?php if(count($data_program_type) >0 ) { 
																foreach($data_program_type as $item_program_type){	
															?>
															<option value="<?php echo $item_program_type->id;?>" <?php echo ($program_type_id == $item_program_type->id)?" selected=' selected'":""?> ><?php echo $item_program_type->program_type_name;?></option>
															<?php } 
															}?>
													</select>
													<font color="red"><?=form_error("program_type_id");?></font>
												</div>

												<div class="col-lg-4 col-md-12">
													<label>Number of Days</label>
													<input type="text" class="form-control" name="number_of_days" value="<?php echo $number_of_days;?>" placeholder="Enter Number Of Days">	
													<font color="red"><?=form_error("number_of_days");?></font>
												</div>

												<div class="col-lg-4 col-md-12">
													<label>Sessions</label>
													<input type="text" class="form-control" name="session_name" value="<?php echo $session_name;?>" placeholder="Enter Sessions">
													<font color="red"><?=form_error("session_name");?></font>
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

								</form>


								</div>
							</div>
						</div>
						<!-- row end -->

					</div>
	

<?php include("footer.php");?>