<?php include("header.php");?>
<style type="text/css">
	.table th, .text-wrap table th {
	     text-transform: none; 
	}
</style>
<!-- app-content-->

                <!-- app-content-->
				<div class="container content-area">
					<div class="side-app">

						<!-- page-header -->
						<div class="page-header">
							<ol class="breadcrumb"><!-- breadcrumb -->
								<li class="breadcrumb-item"><a href="#">City/Town/Village</a></li>
								<li class="breadcrumb-item active" aria-current="page">Manage City/Town/Village</li>
							</ol><!-- End breadcrumb -->
						</div>
						<!-- End page-header -->

						<?php
						$village_id_edit = "";
						$village_name_edit = "";
						$dist_id_edit = "";

						$action = 'Add';
						if(!empty($edit_data)) {
							 $village_id_edit = $edit_data[0]->id;
							 $village_name_edit = $edit_data[0]->village_name;
							 $dist_id_edit = $edit_data[0]->district_id;
							 $action = 'Edit';
						}
						?>

						<!-- row -->
						<div class="row">
							<div class="col-md-6">
								<div class="card">
									<div class="card-body">
										<h4 class="breadcrumb-item"><?php echo $action;?> City/Town/Village</h4>
									</div>

								<form method="post" action="<?php echo base_url('CityMst/createCity');?>">
									<input type="hidden" name="village_id" value="<?php echo $village_id_edit;?>">

									<div class="card-body">
										<div class="form-group">
											<div class="row">	
												<div class="col-lg-6 col-md-12">
													<label>District Name</label>
													<!--Need to fetch dynamically-->
													<select name="district_id" class="form-control">
														<option value="">Select District</option>

														<?php if(count($district_data) > 0 ) {
																foreach($district_data as $item ){
																	$dist_select = "";
																	if($dist_id_edit == $item->id) {
																		$dist_select = 'selected';
																	}
															?>
															<option value="<?php echo $item->id;?>" <?php echo $dist_select;?>><?php echo $item->district_name;?></option>
														<?php }
														}?>
													</select>
													<font color="red"><?=form_error("district_id");?></font>
												</div>
												<div class="col-lg-6 col-md-12">
													<label>City/Town/Village Name</label>
													<input type="text" class="form-control" name="village_name" value="<?php echo $village_name_edit;?>" placeholder="Enter City/Town/Village Name">	
													<font color="red"><?=form_error("village_name");?></font>
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
							<div class="col-md-6">
								<div class="card">
									<div class="card-body">
										<h4 class="breadcrumb-item">View City/Town/Village List</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example2" class="table table-striped table-bordered text-nowrap" >
												<thead>
													<tr>
														<th>District Name</th>
														<th>City/Town/Village Name</th>
														<th style="width:20px;">Action</th>
													</tr>
												</thead>
												<tbody>
												
												<?php if(count($data) > 0 ) {
													 foreach ($data as $item) { ?>      	
													<tr>
														<td><?php echo $item->district_name; ?></td>
														<td><?php echo $item->village_name;  ?></td>
														<td style="width:20px;">
														<a class="btn btn-secondary btn-sm" href="<?php echo site_url('CityMst/editCity/'.$item->id);?>"><i class="fa fa-edit"></i> Edit</a>
														<a class="btn btn-danger btn-sm" href="javascript:;" onclick="return delete_city_town_villages(<?=$item->id; ?>)"><i class="fa fa-trash"></i> Delete</a>
													</td>									
													</tr>
												<?php }
												} ?>
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
function delete_city_town_villages(id){
	var result = confirm("Are you sure want to delete selected village/city?");
	if (result) {
		var post_data = { 'city_id': id };
		$.ajax({
			method: "POST",
			url: '<?php echo site_url('Master/delete_city_town_villages/'); ?>',
			data: post_data,
			success: function(response)
			{
				if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
					window.location.assign(response.notvaliduserurl);
				}else if(response.hasOwnProperty('success') && response.success==1){
					alert("Successfully deleted selected village/city");
					location.reload();
				}
			}
		});

	}else{
		return false;
	}

}
</script>

