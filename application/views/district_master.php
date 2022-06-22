<?php include("header.php");?>
<!-- app-content-->

                <!-- app-content-->
				<div class="container content-area">
					<div class="side-app">

						<!-- page-header -->
						<div class="page-header">
							<ol class="breadcrumb"><!-- breadcrumb -->
								<li class="breadcrumb-item"><a href="#">District</a></li>
								<li class="breadcrumb-item active" aria-current="page">Manage District</li>
							</ol><!-- End breadcrumb -->
						</div>
						<!-- End page-header -->
						<?php
						$district_id_edit = "";
						$district_name_edit = "";

						$action = 'Add';
						if(!empty($edit_data)) {
							 $district_id_edit = $edit_data[0]->id;
							 $district_name_edit = $edit_data[0]->district_name;
							 $state_id_edit = $edit_data[0]->state_id;
							 $action = 'Edit';
						}
						?>
						<!-- row -->
						<div class="row">
							<div class="col-md-6">

							<form method="post" action="<?php echo base_url('DistrictMst/createDistrict');?>">
							<input type="hidden" name="district_id" value="<?php echo $district_id_edit;?>">

								<div class="card">
									<div class="card-body">
										<h4 class="breadcrumb-item"><?php echo $action;?> District</h4>
									</div>
									<div class="card-body">
										<div class="form-group">
											<div class="row">	
												<div class="col-lg-6 col-md-12">
													<label>State Name</label>
													<?php //print_r($state_data); ?>
													<!--Need to fetch dynamically-->
													<select name="state_id" class="form-control">
														<option value="">Select State</option>
														<?php if(count($state_data) > 0 ) {
																foreach($state_data as $item ){
																	$state_select = "";

																	if($state_id_edit == $item->id) {
																		$state_select = 'selected';
																	}
															?>
															<option value="<?php echo $item->id;?>" <?php echo $state_select;?>><?php echo $item->state_name;?></option>
														<?php }
															}?>
														
													</select>
													<font color="red"><?=form_error("state_id");?></font>
												</div>
												<div class="col-lg-6 col-md-12">
													<label>District</label>
													<input type="text" class="form-control" name="district_name" value="<?php echo $district_name_edit;?>" placeholder="Enter District Name">	
													<font color="red"><?=form_error("district_name");?></font>
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
							</form>									

							</div>
							<div class="col-md-6">
								<div class="card">
									<div class="card-body">
										<h4 class="breadcrumb-item">View District List</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example2" class="table table-striped table-bordered text-nowrap" >
												<thead>
													<tr>
														<th>State Name</th>
														<th>District</th>
														<th style="width:20px;">Action</th>
													</tr>
												</thead>
												<tbody>

												<?php if(count($data) > 0 ) {
													 foreach ($data as $item) { ?>      	
													<tr>
														<td><?php echo $item->state_name;?></td>
														<td><?php echo $item->district_name;?></td>
														<td style="width:20px;">
															<a class="btn btn-secondary btn-sm" href="<?php echo site_url('DistrictMst/editDistrict/'.$item->id);?>"><i class="fa fa-edit"></i> Edit</a>
															<a class="btn btn-danger btn-sm" href="javascript:;" onclick="return delete_district(<?=$item->id; ?>)"><i class="fa fa-trash"></i> Delete</a>
														</td>									
													</tr>

													<?php }
												}?>

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

<script>
function delete_district(id){
	var result = confirm("Are you sure want to delete selected district?");
	if (result) {
		var post_data = { 'district_id': id };
		$.ajax({
			method: "POST",
			url: '<?php echo site_url('Master/delete_district/'); ?>',
			data: post_data,
			success: function(response)
			{
				if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
					window.location.assign(response.notvaliduserurl);
				}else if(response.hasOwnProperty('success') && response.success==1){
					alert("Successfully deleted selected district");
					location.reload();
				}
			}
		});
	}else{
		return false;
	}

}
</script>