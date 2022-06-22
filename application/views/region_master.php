<?php include("header.php");?>
<!-- app-content-->

                <!-- app-content-->
				<div class="container content-area">
					<div class="side-app">

						<!-- page-header -->
						<div class="page-header">
							<ol class="breadcrumb"><!-- breadcrumb -->
								<li class="breadcrumb-item"><a href="#">Region</a></li>
								<li class="breadcrumb-item active" aria-current="page">Manage Region</li>
							</ol><!-- End breadcrumb -->
						</div>
						<!-- End page-header -->
						<?php
						$region_id_edit = "";
						$region_name_edit = "";

						$action = 'Add';
						if(!empty($edit_data)) {
							 $region_id_edit = $edit_data[0]->id;
							 $region_name_edit = $edit_data[0]->region_name;
							 $state_id_edit = $edit_data[0]->state_id;
							 $action = 'Edit';
						}
						?>
						<!-- row -->
						<div class="row">
							<div class="col-md-6">

							<form method="post" action="<?php echo base_url('regionMst/createRegion');?>">
							<input type="hidden" name="region_id" value="<?php echo $region_id_edit;?>">

								<div class="card">
									<div class="card-body">
										<h4 class="breadcrumb-item"><?php echo $action;?> Region</h4>
									</div>
									<div class="card-body">
										<div class="form-group">
											<div class="row">	
												<div class="col-lg-6 col-md-12">
													<label>State Name</label>
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
													<label>Region Name</label>
													<input type="text" class="form-control" name="region_name" value="<?php echo $region_name_edit;?>" placeholder="Enter Region Name">	
													<font color="red"><?=form_error("region_name");?></font>
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
										<h4 class="breadcrumb-item">View Region List</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example2" class="table table-striped table-bordered text-nowrap" >
												<thead>
													<tr>
														<th>State Name</th>
														<th>Region Name</th>
														<th style="width:20px;">Action</th>
													</tr>
												</thead>
												<tbody>
												<?php if(count($data) > 0 ) {
													 foreach ($data as $item) { ?>  
													<tr>
														<td><?php echo $item->state_name; ?></td>
														<td><?php echo $item->region_name;?></td>
														<td style="width:20px;">
														<a class="btn btn-secondary btn-sm" href="<?php echo site_url('regionMst/editRegion/'.$item->id);?>"><i class="fa fa-edit"></i> Edit</a>
														<a class="btn btn-danger btn-sm" href="javascript:;" onclick="return delete_region(<?=$item->id; ?>)"><i class="fa fa-trash"></i> Delete</a>
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
function delete_region(id){
	var result = confirm("Are you sure want to delete selected region?");
	if (result) {
		var post_data = { 'region_id': id };
		$.ajax({
			method: "POST",
			url: '<?php echo site_url('Master/delete_region/'); ?>',
			data: post_data,
			success: function(response)
			{
				if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
					window.location.assign(response.notvaliduserurl);
				}else if(response.hasOwnProperty('success') && response.success==1){
					alert("Successfully deleted selected region");
					location.reload();
				}
			}
		});

	}else{
		return false;
	}

}
</script>