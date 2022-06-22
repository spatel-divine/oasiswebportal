<?php include("header.php");?>
<!-- app-content-->

                <!-- app-content-->
				<div class="container content-area">
					<div class="side-app">

						<!-- page-header -->
						<div class="page-header">
							<ol class="breadcrumb"><!-- breadcrumb -->
								<li class="breadcrumb-item"><a href="#">Role</a></li>
								<li class="breadcrumb-item active" aria-current="page">Manage Role</li>
							</ol><!-- End breadcrumb -->
						</div>
						<!-- End page-header -->
						<?php
						$role_id_edit = "";
						$role_name_edit = "";
						$action = 'Add';
						if(!empty($edit_data)) {
							 $role_id_edit = $edit_data[0]->id;
							 $role_name_edit = $edit_data[0]->role_name;
							 $action = 'Edit';
						}
						?>
						<!-- row -->
						<div class="row">

							<div class="col-md-6">
							<form method="post" action="<?php echo base_url('RoleMst/createRole');?>">
							<input type="hidden" name="role_id" value="<?php echo $role_id_edit;?>">

								<div class="card">
									<div class="card-body">
										<h4 class="breadcrumb-item"><?php echo $action;?> Role</h4>
									</div>
									<div class="card-body">
										<div class="form-group">
											<div class="row">	
												<div class="col-lg-12 col-md-12">
													<label>Role Name</label>
													<input type="text" class="form-control" name="role_name" value="<?php echo ($role_name_edit != "") ?  $role_name_edit : set_value('role_name');?>" placeholder="Enter Role Name">	
													<font color="red"><?=form_error("role_name");?></font>
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
										<h4 class="breadcrumb-item">View Role List</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example2" class="table table-striped table-bordered text-nowrap" >
												<thead>
													<tr>
														<th>Role Name</th>
														<th style="width:20px;">Action</th>
													</tr>
												</thead>
												<tbody>

												<?php if(count($data) > 0 ) {
													 foreach ($data as $item) { ?>      
													<tr>
														<td><?php echo $item->role_name;?></td>
														<td style="width:20px;">
														<?php 
														$roles_arr=explode(',',MAIN_ROLES_IDS);
														if(!in_array($item->id,$roles_arr)){ ?>
														<a class="btn btn-secondary btn-sm" href="<?php echo site_url('RoleMst/editRole/'.$item->id);?>"><i class="fa fa-edit"></i> Edit</a>
														<a class="btn btn-danger btn-sm" href="javascript:;" onclick="return delete_role(<?=$item->id; ?>)"><i class="fa fa-trash"></i> Delete</a>
														<?php } ?>
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
function delete_role(role_id){
	var result = confirm("Are you sure want to delete selected role?");
	if (result) {
		var post_data = { 'role_id': role_id };
		$.ajax({
			method: "POST",
			url: '<?php echo site_url('Master/delete_role/'); ?>',
			data: post_data,
			success: function(response)
			{
				if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
					window.location.assign(response.notvaliduserurl);
				}else if(response.hasOwnProperty('success') && response.success==1){
					alert("Successfully deleted selected role");
					location.reload();
				}
			}
		});

	}else{
		return false;
	}

}
</script>