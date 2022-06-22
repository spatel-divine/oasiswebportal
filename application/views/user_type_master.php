<?php include("header.php");?>
<!-- app-content-->
                <!-- app-content-->
				<div class="container content-area">
					<div class="side-app">

						<!-- page-header -->
						<div class="page-header">
							<ol class="breadcrumb"><!-- breadcrumb -->
								<li class="breadcrumb-item"><a href="#">User Type</a></li>
								<li class="breadcrumb-item active" aria-current="page">Manage User Type</li>
							</ol><!-- End breadcrumb -->
						</div>
						<!-- End page-header -->
						<?php 
						$user_type_id_edit = "";
						$user_type_edit = "";
						if(!empty($edit_data)) {
							 $user_type_id_edit = $edit_data[0]->id;
							 $user_type_edit = $edit_data[0]->user_type;
						}
						?>
						<!-- row -->
						<div class="row">
							<div class="col-md-6">
							<form method="post" action="<?php echo base_url('userTypeCreate');?>">

								<input type="hidden" name="user_type_id" value="<?php echo $user_type_id_edit;?>" placeholder="Enter User Type">
								<div class="card">
									<div class="card-body">
										<h4 class="breadcrumb-item">Add User Type</h4>
									</div>
									<div class="card-body">
										<div class="form-group">
											<div class="row">	
												<div class="col-lg-12 col-md-12">
													<label>User Type</label>
													<input type="text" class="form-control" name="user_type" value="<?php echo $user_type_edit;?>" placeholder="Enter User Type">	
													<font color="red"><?=form_error("user_type");?></font>
												</div>
											</div>
										</div>
										<hr/>
										<div class="form-group"  style="float:right;">
												<div class="row">
													<input type="submit" name="submit" value="Submit" class="btn btn-app btn-primary mr-2 mt-1 mb-1">
												</div>

										</div>		
										</form>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="card">
									<div class="card-body">
										<h4 class="breadcrumb-item">View User Type List</h4>

										
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example2" class="table table-striped table-bordered text-nowrap" >
												<thead>
													<tr>
														<th>User Type</th>
														<th style="width:20px;">Action</th>
													</tr>
												</thead>
												<tbody>

												<?php foreach ($data as $item) { ?>      
													<tr>
														<td><?php echo $item->user_type;?></td>
														<td style="width:20px;">
														<a class="btn btn-secondary btn-sm" href="<?php echo site_url('UserType/editUserType/'.$item->id);?>"><i class="fa fa-edit"></i> Edit</a>
														<?php /* <a class="btn btn-danger btn-sm" href="javascript:;" onclick="return delete_user_type(<?=$item->id; ?>)"><i class="fa fa-trash"></i> Delete</a> */ ?>
														</td>									
													</tr>
												<?php } ?>

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
function delete_user_type(user_type_id){
	var result = confirm("Are you sure want to delete selected user type?");
	if (result) {
		var post_data = { 'user_type_id': user_type_id };
		$.ajax({

			method: "POST",
			url: '<?php echo site_url('Master/delete_user_type/'); ?>',
			data: post_data,
			async : true,
			success: function(response)
			{
				if(response ==1) {
					alert("Successfully deleted selected user type");
					location.reload();
				}
			}
		});
	}else{
		return false;
	}

}

</script>