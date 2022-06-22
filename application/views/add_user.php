<?php include("header.php");?>
<!-- app-content-->

                <!-- app-content-->
				<div class="container content-area">
					<div class="side-app">

						<!-- page-header -->
						<div class="page-header">
							<ol class="breadcrumb"><!-- breadcrumb -->
								<li class="breadcrumb-item"><a href="#">User</a></li>
								<li class="breadcrumb-item active" aria-current="page">Add User</li>
							</ol><!-- End breadcrumb -->
							<div class="ml-auto">
								<div class="input-group">
									<a href="<?php echo site_url('Management/view_user_list/')?>" class="btn btn-secondary text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="View Data">
										<span>
											<i class="fa fa-eye"></i>&nbsp;View User List
										</span>
									</a>&nbsp;

									<a href="<?=base_url();?>assets/uploads/documents/samplebulkuser.csv" class="btn btn-danger text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="EmpName|UserName|Password|RoleID|DOB|Gender|State|District|Village/City|MobileNo|AltMobileNo|Email">
										<span>
											<i class="fa fa-download"></i>&nbsp;Download Sample CSV file
										</span>
									</a>

								</div>
							</div>
						</div>
						<!-- End page-header -->

						<?php
						 $action = 'add';
						 $user_id = "";
						 $first_name = set_value('first_name');
						 $middle_name = set_value('middle_name');
						 $last_name = set_value('last_name');
						 $user_name = set_value('user_name');
						 $password = 'emp@123';
						 $dob = set_value('dob');
						 $role_id = '';
						 $gender = '';
						 $blood_group = '';
						 $user_type_id_edit = '';
						 $mobile_number = set_value('mobile_number');
						 $alternate_mobile_no = set_value('alternate_mobile_no');
						 $occupation = set_value('occupation');
						 $marital_status = set_value('marital_status');
						 $email = set_value('email');
						 $languages_known = set_value('languages_known');
						 $edu_qualification = set_value('edu_qualification');
						 $state_id = "";
						 $district_id = "";
						 $city_id = "";
						 $address = set_value('address');
						 $zip_code = set_value('zip_code');

						// print_r($UsersData);

						if(isset($UsersData) && count($UsersData) >0 ){
						 	 $action  = 'edit';
							 $user_id = $UsersData[0]->id;
							 $first_name = $UsersData[0]->first_name;
							 $middle_name = $UsersData[0]->middle_name;
							 $last_name = $UsersData[0]->last_name;
							 $user_name = $UsersData[0]->user_name;
							 $password = $UsersData[0]->password;
							 $role_id = $UsersData[0]->role_id;
							 $gender = $UsersData[0]->gender;
							 $blood_group = $UsersData[0]->blood_group;
							 if($UsersData[0]->birth_date!='' && $UsersData[0]->birth_date!='0000-00-00' && $UsersData[0]->birth_date!=null){
							 	$dob = date("d-m-Y", strtotime($UsersData[0]->birth_date) );
							 }
							 $user_type_id_edit = $UsersData[0]->user_type_id;
							 $mobile_number = $UsersData[0]->mobile_number;
							 $alternate_mobile_no = $UsersData[0]->alternate_mobile;
							 $occupation = $UsersData[0]->occupation;
							 $marital_status =  $UsersData[0]->marital_status;
							 $email = $UsersData[0]->email;
							 $languages_known = $UsersData[0]->languages_known;
							 $edu_qualification = $UsersData[0]->edu_qualification;
							 $state_id = $UsersData[0]->state_id;
							 $district_id = $UsersData[0]->district_id;
							 $city_id = $UsersData[0]->city_id;
							 $address = $UsersData[0]->address;
							 $zip_code = $UsersData[0]->zip_code;
						}
						
						?>
						<!-- row -->
						<form method="post" action="<?php echo base_url('userCreate');?>" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-12">	
								<div class="card">
									<div class="card-body">
										<div class="form-group">
										<?php
											if($this->session->flashdata('errors')){
												echo '<div class="alert alert-danger"><font color="white"><b><a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:#fff;">&times;</a>
													'.$this->session->flashdata("errors").'
												</b></font></div>';
											}
										?>
										<?php if($action == 'add') {?>
										<div class="row">
											<div class="col-lg-4 col-md-12">
												<input type="checkbox" value="1" id="chk_bulk_upload" name="chk_bulk_upload">	
												<label for="chk_bulk_upload">Bulk Upload</label>
												<font color="red"><?=form_error("bulk_upload");?></font>
												<?php /* <font color="red"><?= form_error("bluk_upload");?></font> */ ?>
											</div>
										</div>
										<?php } ?>
										<div id="single_group">	
											<div class="form-group">
												<div class="row">		
													<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
													<input type="hidden" name="action" value="<?php echo $action; ?>">	

													<div class="col-lg-4 col-md-12">
														<label>First Name</label>
														<input type="text" class="form-control" name="first_name" value="<?php echo $first_name;?>" placeholder="Enter First Name">	
														<font color="red"><?=form_error("first_name");?></font>

													</div>
													<div class="col-lg-4 col-md-12">
														<label>Middle Name</label>
														<input type="text" class="form-control" name="middle_name" value="<?php echo $middle_name;?>" placeholder="Enter Middle Name">	
														<font color="red"><?=form_error("middle_name");?></font>
													</div>

													<div class="col-lg-4 col-md-12">
														<label>Last Name</label>
														<input type="text" class="form-control" name="last_name" value="<?php echo $last_name;?>" placeholder="Enter Last Name">	
														<font color="red"><?=form_error("last_name");?></font>
													</div>
												</div>
											</div>	
											<div class="form-group">
												<div class="row">	
													<div class="col-lg-4 col-md-12">
														<label>Username</label>
														<input type="text" class="form-control" name="user_name" value="<?php echo $user_name;?>" placeholder="Enter Username" <?php if($action == 'edit') { echo 'readonly'; }?> >	
														<font color="red"><?=form_error("user_name");?></font>
														<font color="red"><?=form_error("user_name_valid");?></font>
													</div>

													<div class="col-lg-4 col-md-12">
														<label>Password</label>
														<!--if blank, default pw-->
														<input type="password" class="form-control" name="password" value="<?php echo $password;?>" placeholder="Enter Password">
														<input type="hidden" class="form-control" name="oldpassword" value="<?php echo @$UsersData[0]->password;?>">
														<small class="form-text text-muted">Default Password is emp@123</small>
														<font color="red"><?=form_error("password");?></font>
													</div>
													
													<div class="col-lg-4 col-md-12">
														<label>Role</label>
														<select name="role_id" class="form-control">
															<option value="">Select Role</option>
														<?php if(count($role_data) > 0 ) {
																foreach($role_data as $role_data_value) {
																	
																	$select_role = '';
																	if($role_id == $role_data_value->id){
																		  $select_role = 'selected';
																	}
															?>
															<option value="<?php echo $role_data_value->id; ?>" <?php echo $select_role ;?>><?php echo $role_data_value->role_name;?></option>
														
													 	<?php }  }?>
														</select>
														<font color="red"><?=form_error("role_id");?></font>
													</div>
												</div>
											</div>

											<div class="form-group">
												<div class="row">				
													<div class="col-lg-4 col-md-12">
														<label>Date of Birth</label>
														<div class="wd-200 mg-b-30">
															<div class="input-group">
																<div class="input-group-prepend">
																		<div class="input-group-text">
																			<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
																		</div>
																</div>
																<input class="form-control" id="datepicker0" autocomplete="off" placeholder="Enter Date of Birth" type="text" name="dob" value="<?php echo $dob; ?>">
															</div>
														</div>
														<font color="red"><?=form_error("dob");?></font> 

													</div>
													<div class="col-lg-4 col-md-12">
														<label>Gender</label>
														<select name="gender" class="form-control">
															
															<option value="">Select Gender</option>
															<option value="Female" <?php echo ($gender == 'Female')?  'selected' : '';?>>Female</option>
															<option value="Male" <?php echo ($gender == 'Male')?  'selected' : '';?>>Male</option>
															<option value="Transgender" <?php echo ($gender == 'Transgender')?  'selected' : '';?>>Transgender</option>
														</select>
														<font color="red"><?=form_error("gender");?></font>
													</div>

													<div class="col-lg-2 col-md-12">
														<label>Blood Group</label>
															<select name="blood_group" class="form-control">
														 		<option value="">Select Blood Group</option>
	                                                            <option value="A+" <?php echo ($blood_group == 'A+')?  'selected' : '';?> >A+</option>
	                                                            <option value="A-" <?php echo ($blood_group == 'A-')?  'selected' : '';?>>A-</option>
	                                                            <option value="B+" <?php echo ($blood_group == 'B+')?  'selected' : '';?>>B+</option>
	                                                            <option value="B-" <?php echo ($blood_group == 'B-')?  'selected' : '';?>>B-</option>
	                                                            <option value="O+" <?php echo ($blood_group == 'O+')?  'selected' : '';?>>O+</option>
	                                                            <option value="O-" <?php echo ($blood_group == 'O-')?  'selected' : '';?>>O-</option>
	                                                            <option value="AB+" <?php echo ($blood_group == 'AB+')?  'selected' : '';?>>AB+</option>
	                                                            <option value="AB-" <?php echo ($blood_group == 'AB-')?  'selected' : '';?>>AB-</option>
	                                                        </select>
														<font color="red"><?=form_error("blood_group");?></font>
													</div>
													<div class="col-lg-2 col-md-12">
														<label>User Type</label>
														<!--Need to Fetch Dynamically-->
														<select name="user_type_id" class="form-control">
															<option value="">Select User Type</option> 
															<?php
															if(count($UserTypeData) >0) {
																foreach ($UserTypeData as $item_user_type) {
																	$select_user_type = '';
																	if($user_type_id_edit == $item_user_type->id){
																		  $select_user_type = 'selected';
																	}

																?><option value="<?php echo $item_user_type->id;?>" <?php echo $select_user_type;?> ><?php echo  $item_user_type->user_type;?></option> <?php
																} 
															}?>
														</select>
														<font color="red"><?=form_error("user_type");?></font>
													</div>
												</div>
											</div>

											<div class="form-group">
												<div class="row">				
													<div class="col-lg-2 col-md-12">
														<label>Mobile No</label>
														<input type="text" class="form-control" name="mobile_number" value="<?php echo $mobile_number;?>" placeholder="Enter Mobile No">	
														<font color="red"><?=form_error("mobile_number");?></font>
													</div>

													<div class="col-lg-2 col-md-12">
														<label>Alternate Mobile No</label>
														<input type="text" class="form-control" name="alternate_mobile_no" value="<?php echo $alternate_mobile_no;?>" placeholder="Enter Alertnate Mobile No">	
														<font color="red"><?=form_error("alternate_mobile_no");?></font>
													</div>

													<div class="col-lg-4 col-md-12">
														<label>Occupation</label>
														<input type="text" class="form-control" name="occupation" value="<?php echo $occupation;?>" placeholder="Enter Occupation">	
														<font color="red"><?=form_error("occupation");?></font>
													</div>

													<div class="col-lg-4 col-md-12">
														<label>Marital Status</label>
														<select name="marital_status" class="form-control">
															<option value="">Choose Marital Status</option>
															<option value="Single" <?php echo ($marital_status == 'Single')?  'selected' : '';?> >Single</option>
															<option value="Married" <?php echo ($marital_status == 'Married')?  'selected' : '';?>>Married</option>
															<option value="Sepereated" <?php echo ($marital_status == 'Sepereated')?  'selected' : '';?>>Seperated</option>
															<option value="Widowed" <?php echo ($marital_status == 'Widowed')?  'selected' : '';?>>Widowed</option>
														</select>	
														<font color="red"><?=form_error("marital_status");?></font>
													</div>
													
												</div>
											</div>


											<div class="form-group">
												<div class="row">
													<div class="col-lg-4 col-md-12">
														<label>Email</label>
														<!--check validity-->
														<input type="email" class="form-control" name="email" value="<?php echo $email;?>" placeholder="Enter Valid Email">	
														<font color="red"><?=form_error("email");?></font>
													</div>
													

													<div class="col-lg-4 col-md-12">
														<label>Languages Known</label>
														<input type="text" name="language_known" class="form-control" value="<?php echo $languages_known;?>" placeholder="Enter Known Languages">
														<font color="red"><?=form_error("language_known");?></font>

													</div>
													<div class="col-lg-4 col-md-12">
														<label>Education Qualification</label>
														<input type="text" name="education_qualification" class="form-control" value="<?php echo $edu_qualification;?>" placeholder="Enter Education Qualification">
														<font color="red"><?=form_error("education_qualification");?></font>
													</div>
												</div>
											</div>

											<div class="form-group">
												<div class="row">
													<div class="col-lg-4 col-md-12">
														<label>State</label>

														<?php //print_r($state_data); ?>
														<select name="state" id="state_id" onchange="return get_district(this.value);" class="form-control">
															<option value="">Select State</option>
															<?php 
															
															if( count($state_data) > 0) { 
																	foreach($state_data as $state_value){
																		
																	$select_state = '';
																	if($state_id == $state_value->id){
																		  $select_state = 'selected';
																	}
																	?>														
																<option value="<?php echo $state_value->id;?>" <?php echo $select_state;?>> <?php echo $state_value->state_name;?></option>
															<?php } 
														}?>
															
														</select>
														<font color="red"><?=form_error("state");?></font>
													</div>
					
													<div class="col-lg-4 col-md-12">
														<label>District</label>
														<select name="district" id="district_id" class="form-control" onchange="return get_city_ajax(this.value);">
															<option value="">Select District</option>
														</select>
														<font color="red"><?=form_error("district");?></font>
													</div>
													<div class="col-lg-4 col-md-12">
														<label>City/Village</label>
														<select name="city_village" id="city_village" class="form-control">
															<option value="">Select City/Village</option>

														</select>
														<font color="red"><?=form_error("city_village");?></font>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="row">
													<div class="col-lg-8 col-md-12">
														<label>Address</label>
															<textarea name="address" class="form-control" placeholder="Enter Address"><?php echo $address;?></textarea>
														<font color="red"><?=form_error("address");?></font>
													</div>

													<div class="col-lg-4 col-md-12">
														<label>Pin</label>
														<input type="number" name="pin" class="form-control" value="<?php echo $zip_code;?>" placeholder="Enter Pin" min=0>
														<font color="red"><?=form_error("pin");?></font>
													</div>

												</div>
											</div>
										</div>
										<?php if($action == 'add') {?>
										<div class="form-group" id="bulk_upload_group" style="display:none;">
											<div class="row">
												<div class="col-lg-12 col-md-12">
													<label>Bluk Upload: Select CSV File</label>
													<input type="file" class="dropify" name="bulk_upload" id="bulk_upload" value="<?php echo set_value('bulk_upload');?>">
													<input type="hidden" id="bulkaction" name="bulkaction" value="0">
													<input type="hidden" name="action" value="<?php echo $action; ?>">
													<font color="red"><?=form_error("bulk_upload");?></font>
												</div>
											</div>
										</div>
										<?php } ?>

										<hr/>
										<div class="form-group"  style="float:right;">
												<div class="row">
													<input type="submit" name="submit" value="Submit" class="btn btn-app btn-primary mr-2 mt-1 mb-1">
												</div>

										</div>		

									</div>
								</div>
							</div>
						</div>
					</form>
						<!-- row end -->

					</div>
					
<?php include("footer.php");?>
<script>
$( document ).ready(function() {

    <?php if( $state_id !="") {?>
		get_district(<?php echo $state_id;?>, <?php echo $district_id;?>);
	<?php } ?>

	<?php if( $district_id !="") {?>
		get_city_ajax(<?php echo $district_id;?>, <?php echo $city_id;?>)
	<?php } ?>


	//check for bulk upload..
	$("#chk_bulk_upload").click(function(){
		var chk_status = $('#chk_bulk_upload').is(":checked");
		if(chk_status == true){
			//enabled the bulkupload group and disable the single.
			$('#bulkaction').val(1);
			$("#bulk_upload_group").css("display","block");
			$("#single_group").css("display","none");
		}else{
			$("#bulk_upload_group").css("display","none");
			$("#single_group").css("display","block");
			$('#bulkaction').val(0);
		}
    });


});

//get the district
function get_district(state_id, sel_dist_id=""){

		var post_data = { 'state_id': state_id, 'sel_dist_id': sel_dist_id};
         $.ajax({
            method: "POST",
            url: '<?php echo site_url('Management/get_district/'); ?>',
            data: post_data,
            success: function(response)
            {
				var $dist_sele_opt = $('#district_id');
				$dist_sele_opt.empty();				
				$dist_sele_opt.append(response );
            }
            
         });

}

//get the city/village and load it in ajax..

function get_city_ajax(dist_id, sel_city_id=""){

var post_data = { 'dist_id': dist_id, 'sel_city_id':sel_city_id };
 $.ajax({
	method: "POST",
	url: '<?php echo site_url('Management/get_city_ajax_controller/'); ?>',
	data: post_data,
	success: function(response)
	{
		var $sele_opt = $('#city_village');
		$sele_opt.empty();				
		$sele_opt.append(response);
	}
	
 });

}

</script>