<?php include("header.php");?>
                <!-- app-content-->
				<div class="container content-area">
					<div class="side-app">
					<?php
						if($this->session->flashdata('message')){
							echo '<div class="alert alert-success"><font color="white"><b><a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:#fff;">&times;</a>
								'.$this->session->flashdata("message").'
							</b></font></div>';
						}
					?>
					<?php
						if($this->session->flashdata('errors')){
							echo '<div class="alert alert-danger"><font color="white"><b><a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:#fff;">&times;</a>
								'.$this->session->flashdata("errors").'
							</b></font></div>';
						}
					?>
					<font color="red"><?=form_error("delete_success");?></font>

						<!-- page-header -->
						<div class="page-header">
							<ol class="breadcrumb"><!-- breadcrumb -->
								<li class="breadcrumb-item"><a href="#">User</a></li>
								<li class="breadcrumb-item active" aria-current="page">View User List</li>
							</ol><!-- End breadcrumb -->
							<div class="ml-auto">
								<div class="input-group">
									<a href="<?php echo site_url('Management/add_user/')?>" class="btn btn-info text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add New">
										<span>
											<i class="fa fa-plus"></i>&nbsp;Add New User
										</span>
									</a>&nbsp;

									<a href="<?=base_url();?>assets/uploads/documents/sampleuser.csv" class="btn btn-danger text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="EmpName|UserName|Password|RoleID|DOB|Gender|State|District|Village/City|MobileNo|AltMobileNo|Email">
										<span>
											<i class="fa fa-download"></i>&nbsp;Download Sample CSV file
										</span>
									</a>
								</div>
							</div>
						</div>
						<!-- End page-header -->

						<!-- row -->
						<div class="card">
							<div class="card-body">
								<div class="table-responsive">
									<table id="example2" class="table table-striped table-bordered text-nowrap" >
										<thead>
											<tr>
												<th>Name</th>
												<th>User Name</th>
												<th>State</th>
												<th>District</th>
												<th>Village/City</th>
												<th>Date of Birth</th>
												<th>Role Name</th>
												<th style="width:20px;">Action</th>
											</tr>
										</thead>
										<tbody>
										<?php 
										if(count($UserList) >0) {
											foreach ($UserList as $item) {
										?>
											<tr>
												<td><?php echo $item->first_name. ' '.$item->middle_name. ' '.$item->last_name; ?></td>
												<td><?php echo $item->user_name; ?></td>
												<td><?php echo $item->state_name; ?></td>
												<td><?php echo $item->district_name; ?></td>
												<td><?php echo $item->village_name; ?></td>
												<td><?php echo  date("d-m-Y", strtotime($item->birth_date)); ?></td>	
												<td><?php echo $item->role_name; ?></td>
											    <td style="width:20px;">
												<a class="btn btn-secondary btn-sm" href="<?php echo site_url('Management/add_user/'.$item->id);?>"><i class="fa fa-edit"></i> Edit</a>&nbsp;
												<?php if( strtoupper($item->role_name) !=  strtoupper('Admin') ) { ?>
												<a class="btn btn-danger btn-sm" href="javascript:;" onclick="return delete_user(<?=$item->id; ?>)"><i class="fa fa-trash"></i> Delete</a>
												<?php } ?>
											</td>												
											</tr>
											<?php 
											} 
										
										}?>
										</tbody>
									</table>
								</div>
							</div>
						</div>

					</div>

<?php include("footer.php");?>

<script>
function delete_user(user_id){
	var result = confirm("Are you sure want to delete selected user?");
	if (result) {
		var post_data = { 'user_id': user_id };
		$.ajax({
			method: "POST",
			url: '<?php echo site_url('Management/delete_user/'); ?>',
			data: post_data,
			success: function(response)
			{
				if(response ==1) {
					alert("Successfully deleted selected user");
					location.reload();
				}
			}
		});

	}else{
		return false;
	}

}
</script>