<?php include("header.php");?>
<!-- app-content-->
<?php
	$action='Add';
	$user_center_id = "";
	$user_id = set_value('user_id');
	$center_id = set_value('center_id');
	$state_id = set_value('state_id');
	$region_id = set_value('region_id');
	$is_active = set_value('is_active');
	if(isset($_POST) && !($_POST) && isset($usercenter->id) && $usercenter->id){
		$user_id = $usercenter->user_id;
		$center_id = $usercenter->center_id;
		$state_id = $usercenter->state_id;
		$region_id = $usercenter->region_id;
		$is_active = $usercenter->is_active;
	}
	if(isset($usercenter->id) && $usercenter->id){
		$action="Edit";
		$user_center_id = base64_encode($usercenter->id);
	}
?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Center</a></li>
				<li class="breadcrumb-item active" aria-current="page">Assign Center</li>
			</ol><!-- End breadcrumb -->
		</div>
		<!-- End page-header -->
		<!-- row -->
		<div class="row">
			<div class="col-md-3">
				<?php
					if($this->session->flashdata('success_message')){
						echo '<div class="alert alert-success"><font color="white"><b><a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:#fff;">&times;</a>
							'.$this->session->flashdata("success_message").'
						</b></font></div>';
					}
				?>
				<?php
					if($this->session->flashdata('error_message')){
						echo '<div class="alert alert-danger"><font color="white"><b><a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:#fff;">&times;</a>
							'.$this->session->flashdata("error_message").'
						</b></font></div>';
					}
				?>
				<div class="card">
					<div class="card-body">
						<h4 class="breadcrumb-item"><?php echo $action; ?> Assign Center</h4>
					</div>
					<form id="assign_center" name="assign_center" method="post" action="<?php echo base_url('AssignCenterMst/createAssignCenter'); ?>" >
						<input type="hidden" id="user_center_id" name="user_center_id" value="<?php echo $user_center_id; ?>">
						<div class="card-body">
							<div class="form-group">
								<div class="row">	
									<div class="col-lg-12 col-md-12">
										<label>User <font color="red">*</font></label>
										<select id="user_id" name="user_id" class="form-control select2" required data-msg-required="Please Select User">
											<option></option>
											<?php if(count($users) >0 ) {
												foreach($users as $user){
													$select_user = '';
													if($user_id == $user->id){
														  $select_user = 'selected';
													}
											?>
										    <option value="<?php echo $user->id;?>" <?php echo $select_user;?>><?php echo $user->full_name;?></option>
										    <?php }
											}
											?>
										</select>	
										<label id="user_id-error" class="error validationerror" for="user_id"><?=form_error("user_id");?></label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">	
									<div class="col-lg-12 col-md-12">
										<label>State <font color="red">*</font></label>
										<select id="state_id" name="state_id" class="form-control select2" onchange="return get_region_ajax(this.value);"  required data-msg-required="Please Select State">
											<option value="">Select State</option>
											<?php if(count($state_data) > 0) { 
													foreach($state_data as $item_state){
														$select_state = '';
														if($state_id == $item_state->id){
															  $select_state = 'selected';
														}
												?>
												<option value="<?=$item_state->id;?>" <?=$select_state;?> ><?=$item_state->state_name;?></option>
											<?php } 
											}?>
										</select>
										<label id="state_id-error" class="error validationerror" for="state_id"><?=form_error("state_id");?></label>
									</div>
								</div>
							</div>		
							<div class="form-group">
								<div class="row">	
									<div class="col-lg-12 col-md-12">
										<label>Region <font color="red">*</font></label>
										<select id="region_id" name="region_id" class="form-control select2" required data-msg-required="Please Select Region">
											<option value="">--Select--</option>
										</select>
										<label id="region_id-error" class="error validationerror" for="region_id"><?=form_error("region_id"); ?></label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">	
									<div class="col-lg-12 col-md-12">
										<label>Center <font color="red">*</font></label>
										<select id="center_id" name="center_id" class="form-control select2" required data-msg-required="Please Select Center">
											<option value="">--Select--</option>	
										</select>
										<label id="center_id-error" class="error validationerror" for="center_id"><?=form_error("center_id"); ?></label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">	
									<div class="col-lg-12 col-md-12">
										<label>Status <font color="red">*</font></label>
										<select id="is_active" name="is_active" class="form-control" required data-msg-required="Please Select Status">
											<option value="">--Select--</option>
											<option value="1" <?php if(isset($is_active) && $is_active=='1'){ echo 'selected'; } ?>>Active</option>	
											<option value="0" <?php if(isset($is_active) && $is_active=='0'){ echo 'selected'; } ?>>Deactive</option>	
										</select>
										<label id="is_active-error" class="error validationerror" for="is_active"><?=form_error("is_active"); ?></label>
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
			<div class="col-md-9">
				<div class="card">
					<div class="card-body">
						<h4 class="breadcrumb-item">View Assigned Center List</h4>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered text-nowrap" >
								<thead>
									<tr>
										<th>User</th>
										<th>State</th>
										<th>Region</th>
										<th>Center</th>
										<th style="width:20px;">Action</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								if(isset($usercenterlist) && $usercenterlist){ 
									foreach ($usercenterlist as $usercenter){ ?>
									<tr>
										<td>
											<?php 
											if(isset($usercenter->user_fullname) && $usercenter->user_fullname){
												echo $usercenter->user_fullname;
											}else{
												echo 'N/A';
											}
											?>
										</td>
										<td>
											<?php 
											if(isset($usercenter->state_name) && $usercenter->state_name){
												echo $usercenter->state_name;
											}else{
												echo 'N/A';
											}
											?>
										</td>
										<td>
											<?php 
											if(isset($usercenter->region_name) && $usercenter->region_name){
												echo $usercenter->region_name;
											}else{
												echo 'N/A';
											}
											?>
										</td>
										<td>
											<?php 
											if(isset($usercenter->center_name) && $usercenter->center_name){
												echo $usercenter->center_name;
											}else{
												echo 'N/A';
											}
											?>
										</td>
										<td style="width:20px;">
											<a class="btn btn-secondary btn-sm" href="<?php echo site_url('management/assign_center/'.base64_encode($usercenter->id)); ?>"><i class="fa fa-edit"></i> Edit</a>&nbsp;
											<a class="btn btn-secondary btn-sm" onclick="deleteUserCenter('<?php echo base64_encode($usercenter->id); ?>');" href="javascript:void(0);"><i class="fa fa-delete"></i> Delete</a>
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
$( document ).ready(function() {
<?php if( $state_id !="") {?>
	get_region_ajax(<?php echo $state_id;?>, <?php echo $region_id;?>);
<?php } ?>
<?php if( $region_id !="") {?>
	ajax_get_center_by_region(<?php echo $region_id;?>, <?php echo $center_id;?>)
<?php } ?>
});
//get the region
function get_region_ajax(state_id, sel_region_id=""){
	if(state_id){
		var post_data = { 'state_id': state_id, 'sel_region_id': sel_region_id};
		$.ajax({
			method: "POST",
			url: '<?php echo site_url('Management/get_region/'); ?>',
			data: post_data,
			success: function(response){
				var $dist_sele_opt = $('#region_id');
				$dist_sele_opt.empty();				
				$dist_sele_opt.append(response );
			}
		});
	}else{
		var list='<option value="">--Select--</option>';
		$('#region_id').html(list);
	}
}
$('#region_id').on('change',function(){
	region_id=$(this).val();
	ajax_get_center_by_region(region_id);
});
function ajax_get_center_by_region(region_id,center_id=''){
	if(region_id){
		$.ajax({
			type:'POST',
			url:"<?php echo site_url('centerMst/ajax_get_center_by_region'); ?>",
			data:'region_id='+region_id+'&center_id='+center_id,
			success:function(response){
				if(response.hasOwnProperty('centerlist') && response.centerlist){
					$('#center_id').html(response.centerlist);
				}
			}
		});
	}else{
		var centerlist='<option value="">--Select--</option>';
		$('#center_id').html(centerlist);
	}
}
// Get the center
$('#assign_center').validate();
function deleteUserCenter(id){
	var res=confirm("Are you sure that you want to delete this record?");
	if(res){
		var url="<?php echo site_url('AssignCenterMst/delete_user_center/'); ?>"+id;
		window.location.assign(url);
	}
	return false;
}
</script>