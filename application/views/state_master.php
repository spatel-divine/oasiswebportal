<?php include("header.php");?>
<!-- app-content-->

                <!-- app-content-->
				<div class="container content-area">
					<div class="side-app">

						<!-- page-header -->
						<div class="page-header">
							<ol class="breadcrumb"><!-- breadcrumb -->
								<li class="breadcrumb-item"><a href="#">State</a></li>
								<li class="breadcrumb-item active" aria-current="page">Manage State</li>
							</ol><!-- End breadcrumb -->
						</div>
						<!-- End page-header -->

						<?php
						$state_id_edit = "";
						$state_name_edit = "";
						$action = 'Add';
						if(!empty($edit_data)) {
							 $state_id_edit = $edit_data[0]->id;
							 $state_name_edit = $edit_data[0]->state_name;
							 $action = 'Edit';
						}
						?>
						<!-- row -->
						<div class="row">
							<div class="col-md-6">
							<form method="post" action="<?php echo base_url('StateMst/createState');?>">
							<input type="hidden" name="state_id" value="<?php echo $state_id_edit;?>">

								<div class="card">
									<div class="card-body">
										<h4 class="breadcrumb-item"><?php echo $action; ?> State</h4>
									</div>
									<div class="card-body">
										<div class="form-group">
											<div class="row">	
												<div class="col-lg-12 col-md-12">
													<label>State</label>
													<input type="text" class="form-control" name="state_name" value="<?php echo ($state_name_edit != "") ?  $state_name_edit : set_value('state_name') ?>" placeholder="Enter State Name">	
													<font color="red"><?=form_error("state_name");?></font>
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
										<h4 class="breadcrumb-item">View State List</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example2" class="table table-striped table-bordered text-nowrap" >
												<thead>
													<tr>
														<th>State</th>
														<th style="width:20px;">Action</th>
													</tr>
												</thead>
												<tbody>
												<?php if(count($data) > 0 ) {
													 foreach ($data as $item) { ?>      
													<tr>
														<td><?php echo $item->state_name; ?></td>
														<td style="width:20px;"><a class="btn btn-secondary btn-sm" href="<?php echo site_url('StateMst/editState/'.$item->id);?>"><i class="fa fa-edit"></i> Edit</a>
														<a class="btn btn-danger btn-sm" href="javascript:;" onclick="return delete_state(<?=$item->id; ?>)"><i class="fa fa-trash"></i> Delete</a>
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
function delete_state(state_id){
	var result = confirm("Are you sure want to delete selected state?");
	if (result) {
		var post_data = { 'state_id': state_id };
		$.ajax({
			method: "POST",
			url: '<?php echo site_url('Master/delete_state/'); ?>',
			data: post_data,
			success: function(response)
			{
				if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
					window.location.assign(response.notvaliduserurl);
				}else if(response.hasOwnProperty('success') && response.success==1){
					alert("Successfully deleted selected state");
					location.reload();
				}
			}
		});

	}else{
		return false;
	}

}
</script>