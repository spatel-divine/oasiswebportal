<?php include("header.php"); 
if(isset($_POST['assign_rights_type'])){
	$assign_rights_type = set_value('assign_rights_type');	
}
if(isset($_POST['user_id'])){
	$user_id = set_value('user_id');	
}
if(isset($_POST['role_id'])){
	$role_id = set_value('role_id');	
}
$rights_arr=array();
if(isset($_POST['rights'])){
	$rights_arr = $_POST['rights'];	
}
?>
<style type="text/css">
	table.dataTable{
		margin-top: 0px !important;
		margin-bottom: 0px !important;
	}
	table{
		text-align: center;
	}
</style>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Management</a></li>
				<li class="breadcrumb-item active" aria-current="page">Assign/Edit Rights</li>
			</ol><!-- End breadcrumb -->
		</div>
		<!-- End page-header -->
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
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
					<div class="card-header pb-0">
						<h3 class="mb-0 card-title">Assign/Edit Rights User/Role Wise</h3>
					</div>
					<form id="assign_rights" name="assign_rights" method="post" action="<?php echo base_url('management/assign_rights'); ?>">
						<div class="card-body">
							<div class="form-group">
								<div class="row">				
									<div class="col-lg-6 col-md-12">
										<label>Assign Rights Type</label>
										<select id="assign_rights_type" name="assign_rights_type" class="form-control">
											<option value="User" <?php if(isset($assign_rights_type) && $assign_rights_type=='User'){ echo 'selected'; } ?>>User</option>
											<option value="Role" <?php if(isset($assign_rights_type) && $assign_rights_type=='Role'){ echo 'selected'; } ?>>Role</option>
										</select>
										<font color="red"><?=form_error("assign_rights_type");?></font>
									</div>
									<div class="col-lg-6 col-md-12">
										<div id="select_user">
											<label>Select User <font color="red">*</font></label>
											<select id="user_id" name="user_id" class="form-control select2" required data-msg-required="Please Select User">
												<option value="">--Select--</option>
												<?php 
												if(isset($users) && $users){
													foreach ($users as $user){ ?>
													<option value="<?php echo $user->id; ?>" <?php if(isset($user_id) && $user_id==$user->id){ echo 'selected'; } ?> ><?php echo $user->full_name; ?></option>		
												<?php }
												}
												?>
											</select>
											<label id="user_id-error" class="error validationerror" for="user_id"><?=form_error("user_id");?></label>	
										</div>
										<div style="display: none;"  id="select_role">
											<label>Select Role <font color="red">*</font></label>
											<select id="role_id" name="role_id" class="form-control select2"  data-msg-required="Please Select Role">
												<<option value="">--Select--</option>
												<?php 
												if(isset($roles) && $roles){
													foreach ($roles as $role){ ?>
													<option value="<?php echo $role->id; ?>" <?php if(isset($role_id) && $role_id==$role->id){ echo 'selected'; } ?>><?php echo $role->role_name; ?></option>		
												<?php }
												}
												?>
											</select>
											<label id="role_id-error" class="error validationerror" for="role_id"><?=form_error("role_id");?></label>
										</div>
									</div>
								</div>
							</div>	
							<label class="error validationerror"><?=form_error("rights[]");?></label>
							<div class="form-group">
								<div class="table-responsive wrapper">
									<table id="myTable" class="table table-vcenter text-wrap  align-items-center table_view_style myTable">
										<thead class="thead-dark">
											<tr>
												<th>Menu</th>
												<th>Sections/Pages</th>
												<th>Assign Rights <input type="checkbox" id="checkall" name="checkall"></th>
											</tr>
										</thead>
										<tbody id="assign_rights_list">
											<?php 
											$assign_rights_html=getAssignRightsHtml($assign_rights_list,$rights_arr);
											echo $assign_rights_html;
											?>
										</tbody>
										<?php 
										/* <thead class="thead-dark">
											<tr>
												<th>Menu</th>
												<th>Sections/Pages</th>
												<th>Add</th>
												<th>Edit</th>
												<th>Delete</th>
												<th>View/Download</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td rowspan="5" class="module_name_style">Dashboard</td>
												<td class="text-sm font-weight-600">OM Projects/ Program Overview</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td><input type="checkbox" name="access[1]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Monitoring Projects/ Programs</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td><input type="checkbox" name="access[2]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Monitoring Leaders & Team</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td><input type="checkbox" name="access[3]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Monitoring Facilitators</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td><input type="checkbox" name="access[4]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">My Journey with OM</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td><input type="checkbox" name="access[5]"></td>
											</tr>
											<tr>
												<td class="module_name_style">Reports &nbsp;<i class="fa fa-arrow-circle-right nav_down_arr"></i> &nbsp;Summary Report</td>
												<td class="text-sm font-weight-600">Program Summary Report</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td><input type="checkbox" name="access[6]"></td>
											</tr>
											<tr>
												<td rowspan="12" class="module_name_style">Masters<br/><i class="fa fa-arrow-circle-down nav_down_arr"></i> <br/>Common Master</td>
												<td class="text-sm font-weight-600">User Type</td>
												<td><input type="checkbox" name="access[7]"></td>
												<td><input type="checkbox" name="access[8]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[9]"></td>
											</tr>
											<tr>
												
												<td class="text-sm font-weight-600">Role Master</td>
												<td><input type="checkbox" name="access[10]"></td>
												<td><input type="checkbox" name="access[11]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[12]"></td>
											</tr>
											<tr>
												
												<td class="text-sm font-weight-600">State</td>
												<td><input type="checkbox" name="access[13]"></td>
												<td><input type="checkbox" name="access[14]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[15]"></td>
											</tr>
											<tr>
												
												<td class="text-sm font-weight-600">District</td>
												<td><input type="checkbox" name="access[16]"></td>
												<td><input type="checkbox" name="access[17]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[18]"></td>
											</tr>
											<tr>
												
												<td class="text-sm font-weight-600">City/Town/Village</td>
												<td><input type="checkbox" name="access[19]"></td>
												<td><input type="checkbox" name="access[20]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[21]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Region</td>
												<td><input type="checkbox" name="access[22]"></td>
												<td><input type="checkbox" name="access[23]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[24]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Group Type Master</td>
												<td><input type="checkbox" name="access[25]"></td>
												<td><input type="checkbox" name="access[26]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[27]"></td>
											</tr>

											<tr>
												<td class="text-sm font-weight-600">Quality Observed</td>
												<td><input type="checkbox" name="access[28]"></td>
												<td><input type="checkbox" name="access[29]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[30]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Post Category</td>
												<td><input type="checkbox" name="access[31]"></td>
												<td><input type="checkbox" name="access[32]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[33]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Manage Download Category</td>
												<td><input type="checkbox" name="access[34]"></td>
												<td><input type="checkbox" name="access[35]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[36]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Related To Master</td>
												<td><input type="checkbox" name="access[37]"></td>
												<td><input type="checkbox" name="access[38]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[39]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Program Type Master</td>
												<td><input type="checkbox" name="access[40]"></td>
												<td><input type="checkbox" name="access[41]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[42]"></td>
											</tr>
											<tr>
												<td class="module_name_style" rowspan="4">Master <br/><i class="fa fa-arrow-circle-down nav_down_arr"></i> <br/> Dynamic Forms Master <br/><i class="fa fa-arrow-circle-down nav_down_arr"></i>  <br/> Feedback & Reflections</td>
												<td class="text-sm font-weight-600">Program Feedback</td>
												<td>-</td>
												<td><input type="checkbox" name="access[43]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[44]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Personal Learning</td>
												<td>-</td>
												<td><input type="checkbox" name="access[45]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[46]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Feedback For Participants</td>
												<td>-</td>
												<td><input type="checkbox" name="access[47]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[48]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Program Feedback By Participants</td>
												<td>-</td>
												<td><input type="checkbox" name="access[49]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[50]"></td>
											</tr>
											<tr>
												<td class="module_name_style" rowspan="2">Master <br/><i class="fa fa-arrow-circle-down nav_down_arr"></i> <br/> Dynamic Forms Master <br/><i class="fa fa-arrow-circle-down nav_down_arr"></i>  <br/> Submissions</td>
												<td class="text-sm font-weight-600">Star Participants</td>
												<td>-</td>
												<td><input type="checkbox" name="access[51]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[52]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Impact on Character Traits</td>
												<td>-</td>
												<td><input type="checkbox" name="access[53]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[54]"></td>
											</tr>
											<tr>
												<td class="module_name_style" rowspan="2">Management <br/><i class="fa fa-arrow-circle-down nav_down_arr"></i> <br/> Batch Master</td>
												<td class="text-sm font-weight-600">Add New Batch List</td>
												<td><input type="checkbox" name="access[55]"></td>
												<td>-</td>
												<td>-</td>
												<td><input type="checkbox" name="access[56]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">View Batch List</td>
												<td><input type="checkbox" name="access[57]"></td>
												<td><input type="checkbox" name="access[58]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[59]"></td>
											</tr>

											<tr>
												<td class="module_name_style" rowspan="3">Management <br/><i class="fa fa-arrow-circle-down nav_down_arr"></i> <br/> User Master</td>
												<td class="text-sm font-weight-600">Add New User</td>
												<td><input type="checkbox" name="access[60]"></td>
												<td>-</td>
												<td>-</td>
												<td><input type="checkbox" name="access[61]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">View User List</td>
												<td><input type="checkbox" name="access[62]"></td>
												<td><input type="checkbox" name="access[63]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[64]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Reset Username/Password</td>
												<td>-</td>
												<td><input type="checkbox" name="access[65]"></td>
												<td>-</td>
												<td>-</td>
											</tr>
											<tr>
												<td class="module_name_style" rowspan="2">Management <br/><i class="fa fa-arrow-circle-down nav_down_arr"></i> <br/> Active-deactive</td>
												<td class="text-sm font-weight-600">Active-deactivate Center</td>
												<td><input type="checkbox" name="access[66]"></td>
												<td><input type="checkbox" name="access[67]"></td>
												<td><input type="checkbox" name="access[68]"></td>
												<td>-</td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Reset Active-deactivate User</td>
												<td><input type="checkbox" name="access[69]"></td>
												<td><input type="checkbox" name="access[70]"></td>
												<td><input type="checkbox" name="access[71]"></td>
												<td><input type="checkbox" name="access[72]"></td>
											</tr>
											<tr>
												<td class="module_name_style" rowspan="2">Management <br/><i class="fa fa-arrow-circle-down nav_down_arr"></i> <br/> Program Master</td>
												<td class="text-sm font-weight-600">Add New Program</td>
												<td><input type="checkbox" name="access[73]"></td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">View Program List</td>
												<td><input type="checkbox" name="access[74]"></td>
												<td><input type="checkbox" name="access[75]"></td>
												<td>-</td>
												<td>-</td>
											</tr>
											<tr>
												<td class="module_name_style" rowspan="2">Management <br/><i class="fa fa-arrow-circle-down nav_down_arr"></i> <br/> Role Management</td>
												<td class="text-sm font-weight-600">Assign Rights</td>
												<td><input type="checkbox" name="access[76]"></td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">View Rights List</td>
												<td><input type="checkbox" name="access[77]"></td>
												<td><input type="checkbox" name="access[78]"></td>
												<td><input type="checkbox" name="access[79]"></td>
												<td>-</td>
											</tr>
											<tr>
												<td class="module_name_style" rowspan="3">Management <br/><i class="fa fa-arrow-circle-down nav_down_arr"></i> <br/> Manage Center</td>
												<td class="text-sm font-weight-600">Add New Center</td>
												<td><input type="checkbox" name="access[80]"></td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">View Center List</td>
												<td><input type="checkbox" name="access[81]"></td>
												<td><input type="checkbox" name="access[82]"></td>
												<td>-</td>
												<td>-</td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Assign Center</td>
												<td><input type="checkbox" name="access[83]"></td>
												<td><input type="checkbox" name="access[84]"></td>
												<td><input type="checkbox" name="access[85]"></td>
												<td>-</td>
											</tr>
											<tr>
												<td class="module_name_style">Management &nbsp;<i class="fa fa-arrow-circle-right nav_down_arr"></i> &nbsp;Calender</td>
												<td class="text-sm font-weight-600">Oasis Calender</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td><input type="checkbox" name="access[86]"></td>
											</tr>
	                                        <tr>
												<td class="module_name_style" rowspan="4">Reviews <br/><i class="fa fa-arrow-circle-down nav_down_arr"></i> <br/> Feedback & Reflections</td>
												<td class="text-sm font-weight-600">Program Feedback</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td><input type="checkbox" name="access[87]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Personal Learning</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td><input type="checkbox" name="access[88]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Feedback For Participants</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td><input type="checkbox" name="access[89]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Program Feedback By Participants</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td><input type="checkbox" name="access[90]"></td>
											</tr>
											<tr>
												<td class="module_name_style" rowspan="2">Reviews <br/><i class="fa fa-arrow-circle-down nav_down_arr"></i> <br/> Submissions</td>
												<td class="text-sm font-weight-600">Star Participants</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td><input type="checkbox" name="access[91]"></td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">Impact on Character Traits</td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
												<td><input type="checkbox" name="access[92]"></td>
											</tr>
											 <tr>
												<td class="module_name_style">Connect With OM</td>
												<td class="text-sm font-weight-600">Contact Us</td>
												<td>-</td>
												<td><input type="checkbox" name="access[93]"></td>
												<td>-</td>
												<td><input type="checkbox" name="access[94]"></td>
											</tr>
											 <tr>
												<td class="module_name_style" rowspan="2">Connect With OM <br/><i class="fa fa-arrow-circle-down nav_down_arr"></i> <br/> Share With Us</td>
												<td class="text-sm font-weight-600">Share Post</td>
												<td><input type="checkbox" name="access[95]"></td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">View Shared Post List</td>
												<td><input type="checkbox" name="access[96]"></td>
												<td><input type="checkbox" name="access[97]"></td>
												<td><input type="checkbox" name="access[98]"></td>
												<td><input type="checkbox" name="access[99]"></td>
											</tr>
											<tr>
												<td class="module_name_style">Connect With OM</td>
												<td class="text-sm font-weight-600">Ask Us</td>
												<td><input type="checkbox" name="access[100]"></td>
												<td>-</td>
												<td>-</td>
												<td><input type="checkbox" name="access[101]"></td>
											</tr>
											 <tr>
												<td class="module_name_style" rowspan="2">Connect With OM <br/><i class="fa fa-arrow-circle-down nav_down_arr"></i> <br/> Download Management</td>
												<td class="text-sm font-weight-600">Add Data in Downloads</td>
												<td><input type="checkbox" name="access[102]"></td>
												<td>-</td>
												<td>-</td>
												<td>-</td>
											</tr>
											<tr>
												<td class="text-sm font-weight-600">View Downloads List</td>
												<td><input type="checkbox" name="access[103]"></td>
												<td><input type="checkbox" name="access[104]"></td>
												<td><input type="checkbox" name="access[105]"></td>
												<td><input type="checkbox" name="access[106]"></td>
											</tr>
										</tbody> */ ?>
									</table>
								</div>
							</div>								
							<hr/>
							<label id="rights[]-error" class="error validationerror" for="rights[]"></label>
	                        <input type="submit" class="btn btn-primary float-right" value="Submit" name="submit" id="submit">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include("footer.php");?>
<script type="text/javascript">
var pageload=0;
$(function(){  
	$("#treeview").hummingbird();
});
$(document).ready(function(){
	$("#assign_rights_type").trigger('change');
});
$("#assign_rights_type").on("change", function(){
	var rights_type = $('#assign_rights_type option:selected').html();
	if(rights_type === 'User'){
		if(pageload==1){
			$('#role_id').val('');
			$('#role_id').trigger('change');
		}
		$("#select_role").css("display", "none");
		$("#select_user").css("display", "block");
	}
	if(rights_type === 'Role'){
		if(pageload==1){
			$('#user_id').val('');
			$('#user_id').trigger('change');
		}
		$("#select_role").css("display", "block");
		$("#select_user").css("display", "none");
	}
	pageload=1;
});	
$('#user_id').on('change',function(){
	$('#checkall').prop('checked',false);
	var user_id=$(this).val();
	$.ajax({
		type:'POST',
		url:"<?php echo site_url('management/ajax_get_assign_rights_by_user'); ?>",
		data:'user_id='+user_id,
		success:function(response){
			if(response.hasOwnProperty('assign_rights_html') && response.assign_rights_html){
				$('#assign_rights_list').html(response.assign_rights_html);
			}
		}
	});
});
$('#role_id').on('change',function(){
	$('#checkall').prop('checked',false);
	var role_id=$(this).val();
	$.ajax({
		type:'POST',
		url:"<?php echo site_url('management/ajax_get_assign_rights_by_role'); ?>",
		data:'role_id='+role_id,
		success:function(response){
			if(response.hasOwnProperty('assign_rights_html') && response.assign_rights_html){
				$('#assign_rights_list').html(response.assign_rights_html);
			}
		}
	});
});
$('#checkall').on('change',function(){
	if($(this).prop('checked')==true){
		$('.assignrights').prop('checked',true);
	}else{
		$('.assignrights').prop('checked',false);
	}
});
function updateAllcheck(ele){
	if($(ele).prop('checked')==false && $('#checkall').prop('checked')==true){
		$('#checkall').prop('checked',false);
	}
}
$('#assign_rights').validate();
</script>	