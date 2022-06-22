<?php include("header.php"); ?>
<?php
if(isset($_POST['program_id'])){
	$program_id = set_value('program_id');	
}else if(isset($batchdetails->program_id) && $batchdetails->program_id!='' && $batchdetails->program_id!=null){
	$program_id = $batchdetails->program_id;
}
if(isset($_POST['batch_name'])){
	$batch_name = set_value('batch_name');		
}else if(isset($batchdetails->batch_name) && $batchdetails->batch_name!='' && $batchdetails->batch_name!=null){
	$batch_name = $batchdetails->batch_name;
}
if(isset($_POST['start_date'])){
	$start_date = set_value('start_date');		
}else if(isset($batchdetails->start_date) && $batchdetails->start_date!='' && $batchdetails->start_date!=null){
	$start_date = $batchdetails->start_date;
}
if(isset($_POST['end_date'])){
	$end_date = set_value('end_date');		
}else if(isset($batchdetails->end_date) && $batchdetails->end_date!='' && $batchdetails->end_date!=null){
	$end_date = $batchdetails->end_date;
}
if(isset($_POST['location'])){
	$location = set_value('location');		
}else if(isset($batchdetails->location) && $batchdetails->location!='' && $batchdetails->location!=null){
	$location = $batchdetails->location;
}
if(isset($_POST['no_of_participant_registered'])){
	$no_of_participant_registered = set_value('no_of_participant_registered');		
}else if(isset($batchdetails->no_of_participant_registered) && $batchdetails->no_of_participant_registered!='' && $batchdetails->no_of_participant_registered!=null){
	$no_of_participant_registered = $batchdetails->no_of_participant_registered;
}
if(isset($_POST['group_id'])){
	$group_id = set_value('group_id');		
}else if(isset($batchdetails->group_id) && $batchdetails->group_id!='' && $batchdetails->group_id!=null){
	$group_id = $batchdetails->group_id;
}
if(isset($_POST['group_name'])){
	$group_name = set_value('group_name');		
}else if(isset($batchdetails->group_name) && $batchdetails->group_name!='' && $batchdetails->group_name!=null){
	$group_name = $batchdetails->group_name;
}
?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Batch</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php if(isset($batchdetails->id) && $batchdetails->id!='' && $batchdetails->id!=null){ echo 'Edit'; }else{ echo 'Add'; } ?> Batch</li>
			</ol><!-- End breadcrumb -->
			<div class="ml-auto">
				<div class="input-group">
					<a href="<?php echo site_url('Management/view_batch_list/')?>" class="btn btn-info text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="View Data">
						<span>
							<i class="fa fa-eye"></i>&nbsp;View Batch List
						</span>
					</a>
				</div>
			</div>
		</div>
		<!-- End page-header -->
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<form id="batch_management" name="batch_management" method="post" action="<?php echo base_url('management/add_batch');?>">
						<div class="card-body">
							<div class="form-group">
								<div class="row">				
									<div class="col-lg-3 col-md-12">
										<label>State <font color="red">*</font></label>
										<select id="state_id" name="state_id" class="form-control" required data-msg-required="Please Select State">
											<option value="">--Select--</option>
											<?php if(isset($statelist) && $statelist){
												foreach($statelist as $state){ ?>
												<option value="<?php echo $state->id; ?>" <?php if(isset($state_id) && $state_id==$state->id){ echo 'selected';} ?>><?php echo ucfirst($state->state_name); ?></option>
											<?php }
											} ?>
										</select>
										<label id="state_id-error" class="error validationerror" for="state_id"><?=form_error("state_id");?></label>
									</div>
									<div class="col-lg-3 col-md-12">
										<label>Region <font color="red">*</font></label>
										<select id="region_id" name="region_id" class="form-control" required data-msg-required="Please Select Region">
											<?php
											if(isset($regionlist) && $regionlist!='' && $regionlist!=null){
												echo $regionlist;
											}else{
												echo '<option value="">--Select--</option>';
											}
											?>
										</select>
										<label id="region_id-error" class="error validationerror" for="region_id"><?=form_error("region_id");?></label>
									</div>
									<div class="col-lg-3 col-md-12">
										<label>Center <font color="red">*</font></label>
										<select id="center_id" name="center_id" class="form-control" required data-msg-required="Please Select Center">
											<?php
											if(isset($centerlist) && $centerlist!='' && $centerlist!=null){
												echo $centerlist;
											}else{
												echo '<option value="">--Select--</option>';
											}
											?>
										</select>
										<label id="center_id-error" class="error validationerror" for="center_id"><?=form_error("center_id");?></label>
									</div>
									<div class="col-lg-3 col-md-12">
										<label>Program <font color="red">*</font></label>
										<select id="program_id" name="program_id" class="form-control" required data-msg-required="Please Select Program">
											<option value="">--Select--</option>
											<?php 
												if(isset($programlist) && $programlist){ 
													foreach($programlist as $program){ ?>
														<option value="<?php echo $program->id; ?>" <?php if(isset($program_id) && $program_id==$program->id){ echo 'selected';} ?>><?php echo ucfirst($program->program_name); ?></option>
											<?php 	}
												} 
											?>
										</select>
										<label id="program_id-error" class="error validationerror" for="program_id"><?=form_error("program_id");?></label>
									</div>
								</div>
							</div>	
							<div class="form-group">
								<div class="row">				
									<div class="col-lg-3 col-md-12">
										<label>Batch Name <font color="red">*</font></label>
										<input type="text" id="batch_name" name="batch_name" class="form-control" value="<?php if(isset($batch_name) && $batch_name!='' && $batch_name!=null){ echo $batch_name; } ?>" placeholder="Enter Batch Name" required data-msg-required="Enter Batch Name">
										<label id="batch_name-error" class="error validationerror" for="batch_name"><?=form_error("batch_name");?></label>
									</div>
									<div class="col-lg-3 col-md-12">
										<label>Start Date <font color="red">*</font></label>
										<div class="wd-200 mg-b-30">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">
														<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
													</div>
												</div>
												<input class="form-control datepicker" id="datepicker0" name="start_date" autocomplete="off" placeholder="Batch Start Date" type="text"  required data-msg-required="Please Select Start Date" value="<?php if(isset($start_date) && $start_date!='' && $start_date!=null){ echo date('d-m-Y',strtotime($start_date)); } ?>">
											</div>
										</div>
										<label id="datepicker0-error" class="error validationerror" for="datepicker0"><?=form_error("start_date");?></label>
									</div>
									<div class="col-lg-3 col-md-12">
										<label>End Date <font color="red">*</font></label>
										<div class="wd-200 mg-b-30">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">
														<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
													</div>
												</div>
												<input class="form-control datepicker" id="datepicker1" name="end_date" autocomplete="off" placeholder="Batch End Date" type="text" required data-msg-required="Please Select End Date" value="<?php if(isset($end_date) && $end_date!='' && $end_date!=null){ echo date('d-m-Y',strtotime($end_date)); } ?>" data-rule-validEndDate>
											</div>
										</div>
										<label id="datepicker1-error" class="error validationerror" for="datepicker1"><?=form_error("end_date");?></label>
									</div>
									<div class="col-lg-3 col-md-12">
										<label>Location <font color="red">*</font></label>
										<input type="text" id="location" name="location" class="form-control" value="<?php if(isset($location) && $location!='' && $location!=null){ echo $location; } ?>" placeholder="Enter Batch Location"  required data-msg-required="Enter Batch Location">
										<label id="location-error" class="error validationerror" for="location"><?=form_error("location");?></label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">				
									<div class="col-lg-6 col-md-12">
										<label>No. of Participant Registered <font color="red">*</font></label>
										<input type="number"  id="no_of_participant_registered" name="no_of_participant_registered" class="form-control" placeholder="Enter No. of Participant Registered" min = 0 required data-msg-required="Enter No. of Participant Registered" value="<?php if(isset($no_of_participant_registered) && $no_of_participant_registered!='' && $no_of_participant_registered!=null){ echo $no_of_participant_registered; } ?>">
										<label id="no_of_participant_registered-error" class="error validationerror" for="no_of_participant_registered"><?=form_error("location");?></label>
									</div>
									<div class="col-lg-3 col-md-12">
										<label>Group Type <font color="red">*</font></label>
										<select id="group_id" name="group_id" class="form-control" required data-msg-required="Please Select Group">
											<option value="">--Select--</option>
											<?php 
												if(isset($grouptypelist) && $grouptypelist){ 
													foreach ($grouptypelist as $grouptype){ ?>
														<option value="<?php echo $grouptype->id; ?>" <?php if(isset($group_id) && $group_id==$grouptype->id){ echo 'selected';} ?>><?php echo ucfirst($grouptype->group_type_name); ?></option>
											<?php 	}
												}
											?>
										</select>
										<label id="group_id-error" class="error validationerror" for="group_id"><?=form_error("group_id");?></label>
									</div>
									<div class="col-lg-3 col-md-12">
										<label>Group Name <font color="red">*</font></label>
										<input type="text" id="group_name" name="group_name" class="form-control" placeholder="Enter Group Name" required data-msg-required="Enter Group Name" value="<?php if(isset($group_name) && $group_name!='' && $group_name!=null){ echo $group_name; } ?>"> 
										<label id="group_name-error" class="error validationerror" for="group_name"><?=form_error("group_name");?></label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">				
									<div class="col-lg-6 col-md-12">
										<label>Select Facilitator <font color="red">*</font></label>
										<select class="form-control facilitator_search" id="facilitator" name="facilitator[]" multiple required data-msg-required="Please Select Facilitator">
											<?php 
												if(isset($facilitatorlist) && $facilitatorlist){
													foreach($facilitatorlist as $facilitator){
														$selected="";
														if(isset($batchfacilitator) && $batchfacilitator && in_array($facilitator->id,$batchfacilitator)){
															$selected="selected";
														}
													?>
														<option value="<?php echo $facilitator->id; ?>" <?php echo $selected; ?>><?php echo $facilitator->user_full_name; ?></option>
											<?php   }
												}
											?> 
										</select>
										<label id="facilitator-error" class="error validationerror" for="facilitator"><?=form_error("facilitator");?></label>
									</div>
									<div class="col-lg-6 col-md-12">
										<label>Select Co-Facilitator <font color="red">*</font></label>
										<select class="form-control cofacilitator_search" id="co_facilitator" name="co_facilitator[]" multiple required data-msg-required="Please Select Co-Facilitator">
											<?php 
												if(isset($cofacilitatorlist) && $cofacilitatorlist){
													foreach($cofacilitatorlist as $cofacilitator){ 
														$selected="";
														if(isset($batchcofacilitator) && $batchcofacilitator && in_array($cofacilitator->id,$batchcofacilitator)){
															$selected="selected";
														}
													?>
														<option value="<?php echo $cofacilitator->id; ?>" <?php echo $selected; ?>><?php echo $cofacilitator->user_full_name; ?></option>
											<?php   }
												}
											?>
										</select>
										<label id="co_facilitator-error" class="error validationerror" for="co_facilitator"><?=form_error("co_facilitator");?></label>
									</div>
								</div>
							</div>		
							<div class="form-group">
								<div class="row">				
									<div class="col-lg-6 col-md-12">
										<label>Select Co-Ordinator <font color="red">*</font></label>
										<select class="form-control coordinator_search" id="coordinator" name="coordinator[]" multiple required data-msg-required="Please Select Co-Ordinator">
											<?php 
												if(isset($coordinatorlist) && $coordinatorlist){
													foreach($coordinatorlist as $coordinator){ 
														$selected="";
														if(isset($batchcoordinator) && $batchcoordinator && in_array($coordinator->id,$batchcoordinator)){
															$selected="selected";
														}
													?>
														<option value="<?php echo $coordinator->id; ?>" <?php echo $selected; ?>><?php echo $coordinator->user_full_name; ?></option>
											<?php   }
												}
											?>
										</select>
										<label id="coordinator-error" class="error validationerror" for="coordinator"><?=form_error("coordinator");?></label>
									</div>
									<div class="col-lg-6 col-md-12">
										<label>Select Volunteer <font color="red">*</font></label>
										<select class="form-control volunteer_search" id="volunteer" name="volunteer[]" multiple required data-msg-required="Please Select Volunteer">
											<?php 
												if(isset($volunteerlist) && $volunteerlist){
													foreach($volunteerlist as $volunteer){ 
														$selected="";
														if(isset($batchvolunteer) && $batchvolunteer && in_array($volunteer->id,$batchvolunteer)){
															$selected="selected";
														}
													?>
														<option value="<?php echo $volunteer->id; ?>" <?php echo $selected; ?>><?php echo $volunteer->user_full_name; ?></option>
											<?php   }
												}
											?>
										</select>
										<label id="volunteer-error" class="error validationerror" for="volunteer"><?=form_error("volunteer");?></label>
									</div>
								</div>
							</div>			
							<div class="form-group">
								<div class="row">				
									<div class="col-lg-6 col-md-12">
										<label>Select Participant <font color="red">*</font></label>
										<select class="form-control participant_search" id="participant" name="participant[]" multiple required data-msg-required="Please Select Participant">
											<?php 
												if(isset($participantlist) && $participantlist){
													foreach($participantlist as $participant){
														$selected="";
														if(isset($batchparticipant) && $batchparticipant && in_array($participant->id,$batchparticipant)){
															$selected="selected";
														}
													?>
														<option value="<?php echo $participant->id; ?>" <?php echo $selected; ?>><?php echo $participant->user_full_name; ?></option>
											<?php   }
												}
											?>
										</select>
										<label id="participant-error" class="error validationerror" for="participant"><?=form_error("participant");?></label>
									</div>
								</div>
							</div>			
							<?php /* 
							<div class="form-group">
								<div class="row">				
									<div class="col-lg-3 col-md-12">
										<label>Facilitator search</label>
										<input type="text" name="faclitator_search" class="form-control" value="<?php echo set_value('faclitator_search');?>" placeholder="Search Facilitator Name">
										<font color="red"><?=form_error("faclitator_search");?></font>
									</div>
									<div class="col-lg-3 col-md-12">
										<label>Search Result</label>
										<select name="search_result" class="form-control" multiple>
										</select>
										<font color="red"><?=form_error("search_result");?></font>
									</div>
									<div class="col-lg-1 col-md-12">
										<label style="visibility: hidden;">Add / Remove Button</label>
										<button class="form-control btn btn-warning" name="add">Add</button>
										</div>
										<div class="col-lg-1 col-md-12">
										<label style="visibility: hidden;">Add / Remove Button</label>
										<button class="form-control btn btn-danger" name="remove">Remove</button>
									</div>
									<div class="col-lg-3 col-md-12">
										<label>Selected Facilitator</label>
										<select name="selected_faclitator" class="form-control" multiple>
										</select>
										<font color="red"><?=form_error("selected_faclitator");?></font>
									</div>
									<div class="col-lg-1 col-md-12">
										<label style="visibility: hidden;">Search</label>
										
										<button class="form-control btn btn-primary" name="search">Search</button>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">				
									<div class="col-lg-3 col-md-12">
										<label>Co-facilitator search</label>
										<input type="text" name="cofaclitator_search" class="form-control" value="<?php echo set_value('cofaclitator_search');?>" placeholder="Search Co-Facilitator Name">
										<font color="red"><?=form_error("cofaclitator_search");?></font>
									</div>
									<div class="col-lg-3 col-md-12">
										<label>Search Result</label>
										<select name="cofacilitatorsearch_result" class="form-control" multiple>
										</select>
										<font color="red"><?=form_error("cofacilitatorsearch_result");?></font>
									</div>
									<div class="col-lg-1 col-md-12">
										<label style="visibility: hidden;">Add / Remove Button</label>
										<button class="form-control btn btn-warning" name="cofac_add">Add</button>
										</div>
										<div class="col-lg-1 col-md-12">
										<label style="visibility: hidden;">Add / Remove Button</label>
										<button class="form-control btn btn-danger" name="cofac_remove">Remove</button>
									</div>
									<div class="col-lg-3 col-md-12">
										<label>Selected Co-Facilitator</label>
										<select name="selected_cofaclitator" class="form-control" multiple>
										</select>
										<font color="red"><?=form_error("selected_cofaclitator");?></font>
									</div>
									<div class="col-lg-1 col-md-12">
										<label style="visibility: hidden;">Search</label>
										<button class="form-control btn btn-primary" name="cofac_search">Search</button>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">				
									<div class="col-lg-3 col-md-12">
										<label>Co-ordinator search</label>
										<input type="text" name="coordinator_search" class="form-control" value="<?php echo set_value('coordinator_search');?>" placeholder="Search Co-ordinator Name">
										<font color="red"><?=form_error("coordinator_search");?></font>
									</div>
									<div class="col-lg-3 col-md-12">
										<label>Search Result</label>
										<select name="coordinatorsearch_result" class="form-control" multiple>
										</select>
										<font color="red"><?=form_error("coordinatorsearch_result");?></font>
									</div>
									<div class="col-lg-1 col-md-12">
										<label style="visibility: hidden;">Add / Remove Button</label>
										<button class="form-control btn btn-warning" name="coordinator_add">Add</button>
										</div>
										<div class="col-lg-1 col-md-12">
										<label style="visibility: hidden;">Add / Remove Button</label>
										<button class="form-control btn btn-danger" name="coordinator_remove">Remove</button>
									</div>
									<div class="col-lg-3 col-md-12">
										<label>Selected Co-ordinator</label>
										<select name="selected_coordinator" class="form-control" multiple>
										</select>
										<font color="red"><?=form_error("selected_coordinator");?></font>
									</div>
									<div class="col-lg-1 col-md-12">
										<label style="visibility: hidden;">Search</label>
										<button class="form-control btn btn-primary" name="coordinator_search">Search</button>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">				
									<div class="col-lg-3 col-md-12">
										<label>Volunteer search</label>
										<input type="text" name="volunteer_search" class="form-control" value="<?php echo set_value('volunteer_search');?>" placeholder="Search Volunteer Name">
										<font color="red"><?=form_error("volunteer_search");?></font>
									</div>
									<div class="col-lg-3 col-md-12">
										<label>Search Result</label>
										<select name="volunteersearch_result" class="form-control" multiple>
										</select>
										<font color="red"><?=form_error("volunteersearch_result");?></font>
									</div>
									<div class="col-lg-1 col-md-12">
										<label style="visibility: hidden;">Add / Remove Button</label>
										<button class="form-control btn btn-warning" name="volunteer_add">Add</button>
										</div>
										<div class="col-lg-1 col-md-12">
										<label style="visibility: hidden;">Add / Remove Button</label>
										<button class="form-control btn btn-danger" name="volunteer_remove">Remove</button>
									</div>
									<div class="col-lg-3 col-md-12">
										<label>Selected Volunteer</label>
										<select name="selected_volunteer" class="form-control" multiple>
										</select>
										<font color="red"><?=form_error("selected_volunteer");?></font>
									</div>
									<div class="col-lg-1 col-md-12">
										<label style="visibility: hidden;">Search</label>
										<button class="form-control btn btn-primary" name="volunteer_search">Search</button>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">				
									<div class="col-lg-3 col-md-12">
										<label>Participants search</label>
										<input type="text" name="participants_search" class="form-control" value="<?php echo set_value('participants_search');?>" placeholder="Search Participants Name">
										<font color="red"><?=form_error("participants_search");?></font>
									</div>
									<div class="col-lg-3 col-md-12">
										<label>Search Result</label>
										<select name="participantssearch_result" class="form-control" multiple>
										</select>
										<font color="red"><?=form_error("participantssearch_result");?></font>
									</div>
									<div class="col-lg-1 col-md-12">
										<label style="visibility: hidden;">Add / Remove Button</label>
										<button class="form-control btn btn-warning" name="participants_add">Add</button>
										</div>
										<div class="col-lg-1 col-md-12">
										<label style="visibility: hidden;">Add / Remove Button</label>
										<button class="form-control btn btn-danger" name="participants_remove">Remove</button>
									</div>
									<div class="col-lg-3 col-md-12">
										<label>Selected Participants</label>
										<select name="selected_participants" class="form-control" multiple>
										</select>
										<font color="red"><?=form_error("selected_participants");?></font>
									</div>
									<div class="col-lg-1 col-md-12">
										<label style="visibility: hidden;">Search</label>
										<button class="form-control btn btn-primary" name="participants_search">Search</button>
									</div>
								</div>
							</div> */ ?>
							<input type="hidden" id="batch_id" name="batch_id" value="<?php if(isset($batchdetails->id) && $batchdetails->id!='' && $batchdetails->id!=null){ echo base64_encode($batchdetails->id); } ?>">
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
		</div>
		<!-- row end -->
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".datepicker").datepicker({ 
				minDate: new Date(),
				dateFormat: 'd-m-yy'
			});
		});
		$('#state_id').on('change',function(){
			var state_id=$(this).val();
			if(state_id){
				$.ajax({
					type:'POST',
					url:"<?php echo site_url('regionMst/ajax_get_region_by_state'); ?>",
					data:'state_id='+state_id,
					success:function(response){
						if(response.hasOwnProperty('regionlist') && response.regionlist){
							$('#region_id').html(response.regionlist);
						}
					}
				});
			}else{
				var regionlist='<option value="">--Select--</option>';
				$('#region_id').html(regionlist);
				$('#region_id').trigger('change');
			}
		});
		$('#region_id').on('change',function(){
			var region_id=$(this).val();
			if(region_id){
				$.ajax({
					type:'POST',
					url:"<?php echo site_url('centerMst/ajax_get_center_by_region'); ?>",
					data:'region_id='+region_id,
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
		});
		$("#batch_management").validate();
		$.validator.addMethod("validEndDate",function(value, element, param){
			var sdate = $("#datepicker0").val();
			var edate = $("#datepicker1").val();
			if(edate<sdate){
				return false;
			}
			return true;
		},"End Date must be greater than Start Date.");
	</script>
<?php include("footer.php");?>