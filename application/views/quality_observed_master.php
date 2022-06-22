<?php include("header.php");?>
<!-- app-content-->

                <!-- app-content-->
				<div class="container content-area">
					<div class="side-app">

						<!-- page-header -->
						<div class="page-header">
							<ol class="breadcrumb"><!-- breadcrumb -->
								<li class="breadcrumb-item"><a href="#">Quality Observed</a></li>
								<li class="breadcrumb-item active" aria-current="page">Manage Quality Observed</li>
							</ol><!-- End breadcrumb -->
						</div>
						<!-- End page-header -->

						<?php
						$quality_data_id_edit = "";
						$quality_name_edit = "";

						$action = 'Add';
						if(!empty($edit_data)) {
							 $quality_data_id_edit = $edit_data[0]->id;
							 $quality_name_edit = $edit_data[0]->quality_name;
							 $action = 'Edit';
						}
						?>


						<!-- row -->
						<div class="row">
							<div class="col-md-6">

							<form method="post" action="<?php echo base_url('QualityDataMst/createQualityData');?>">
								<input type="hidden" name="quality_data_id" value="<?php echo $quality_data_id_edit;?>">

								<div class="card">
									<div class="card-body">
										<h4 class="breadcrumb-item"><?php echo $action;?> Quality Data</h4>
									</div>
									<div class="card-body">

										<div class="form-group">
											<div class="row">	
												<div class="col-lg-12 col-md-12">
													<label>Quality</label>
													<input type="text" class="form-control" name="quality_name" value="<?php echo $quality_name_edit;?>" placeholder="Enter Quality">	
													<font color="red"><?=form_error("quality_name");?></font>
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
										<h4 class="breadcrumb-item">View Quality List</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example2" class="table table-striped table-bordered text-nowrap" >
												<thead>
													<tr>
														<th>Quality</th>
														<th style="width:20px;">Action</th>
													</tr>
												</thead>
												<tbody>

												<?php if(count($data) > 0 ) {
													 foreach ($data as $item) { ?>     
													<tr>
														<td><?php echo $item->quality_name;?></td>
														<td style="width:20px;"><a class="btn btn-secondary btn-sm" href="<?php echo site_url('QualityDataMst/editQualityData/'.$item->id);?>">
														<i class="fa fa-edit"></i> Edit</a>
														<a class="btn btn-danger btn-sm" href="javascript:;" onclick="return delete_quality_observed(<?=$item->id; ?>)"><i class="fa fa-trash"></i> Delete</a>
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
function delete_quality_observed(id){
	var result = confirm("Are you sure want to delete selected Quality?");
	if (result) {
		var post_data = { 'quality_id': id };
		$.ajax({
			method: "POST",
			url: '<?php echo site_url('Master/delete_quality_observed/'); ?>',
			data: post_data,
			success: function(response)
			{
				if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
					window.location.assign(response.notvaliduserurl);
				}else if(response.hasOwnProperty('success') && response.success==1){
					alert("Successfully deleted selected Quality");
					location.reload();
				}
			}
		});

	}else{
		return false;
	}

}
</script>