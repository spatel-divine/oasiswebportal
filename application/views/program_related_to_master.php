<?php include("header.php");?>
<!-- app-content-->

                <!-- app-content-->
				<div class="container content-area">
					<div class="side-app">

						<!-- page-header -->
						<div class="page-header">
							<ol class="breadcrumb"><!-- breadcrumb -->
								<li class="breadcrumb-item"><a href="#">Program Related To</a></li>
								<li class="breadcrumb-item active" aria-current="page">Manage Program Related To Master</li>
							</ol><!-- End breadcrumb -->
						</div>
						<!-- End page-header -->

						<?php
						$program_related_id_edit = "";
						$program_related_to_name_edit = "";

						$action = 'Add';
						if(!empty($edit_data)) {
							 $program_related_id_edit = $edit_data[0]->id;
							 $program_related_to_name_edit = $edit_data[0]->program_related_to_name;
							 $action = 'Edit';
						}
						?>

						<!-- row -->
						<div class="row">
							<div class="col-md-6">

							<form method="post" action="<?php echo base_url('ProgramRelatedMst/createProgramRelated');?>">
								<input type="hidden" name="program_related_id" value="<?php echo $program_related_id_edit;?>">

								<div class="card">
									<div class="card-body">
										<h4 class="breadcrumb-item"><?php echo $action;?> Program Related To</h4>
									</div>
									<div class="card-body">
										<div class="form-group">
											<div class="row">	
												<div class="col-lg-12 col-md-12">
													<label>Program Related To</label>
													<input type="text" class="form-control" name="program_related_to_name" value="<?php echo $program_related_to_name_edit;?>" placeholder="Enter Program Related To">	
													<font color="red"><?=form_error("program_related_to_name");?></font>
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
										<h4 class="breadcrumb-item">View Program Related To List</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example2" class="table table-striped table-bordered text-nowrap" >
												<thead>
													<tr>
														<th>Program Related To</th>
														<th style="width:20px;">Action</th>
													</tr>
												</thead>
												<tbody>
												<?php if(count($data) > 0 ) {
													 	foreach ($data as $item) { 
														 ?> 
													<tr>
														<td><?php echo $item->program_related_to_name;?></td>
														<td style="width:20px;">
														<a class="btn btn-secondary btn-sm" href="<?php echo site_url('ProgramRelatedMst/editProgramRelated/'.$item->id);?>">
															<i class="fa fa-edit"></i> Edit</a>
															<a class="btn btn-danger btn-sm" href="javascript:;" onclick="return delete_program_related(<?=$item->id; ?>)"><i class="fa fa-trash"></i> Delete</a>
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
function delete_program_related(id){
	var result = confirm("Are you sure want to delete selected Program Related?");
	if (result) {
		var post_data = { 'program_related_id': id };
		$.ajax({
			method: "POST",
			url: '<?php echo site_url('Master/delete_program_related/'); ?>',
			data: post_data,
			success: function(response)
			{
				if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
					window.location.assign(response.notvaliduserurl);
				}else if(response.hasOwnProperty('success') && response.success==1){
					alert("Successfully deleted selected Program Related");
					location.reload();
				}
			}
		});

	}else{
		return false;
	}

}
</script>

