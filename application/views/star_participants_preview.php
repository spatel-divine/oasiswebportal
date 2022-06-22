<?php include("header.php");?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Review Form</a></li>
				<li class="breadcrumb-item active" aria-current="page">Star Participants (ONLY For Children/ Youth Camps/ sessions where participants are not added to batch)</li>
			</ol><!-- End breadcrumb -->
		</div>
		<!-- End page-header -->
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="form-group">
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<span class="text-red">Note: Next entry (till facilitator goes on adding, entry form will appear) <br/>Submit (once all star participant entry is done)</span>
								</div>	
							</div>
						</div>
						<div class="form-group">
							<div class="row">	
								<div class="col-lg-12 col-md-12">
									<label>Select Batch <font color="red">*</font></label>
									<select id="batch_name" name="batch_name" class="form-control basicdetails">
										<option value="">--Select--</option>
										<?php if(isset($batch_list) && $batch_list){ 
											foreach ($batch_list as $batch) { ?>
												<option value="<?php echo $batch->id; ?>" data-program='<?php echo $batch->program_name; ?>'><?php echo $batch->batch_name; ?></option>
										<?php }
										}
										?>
									</select>
									<label id="batch_name-error" class="error validationerror" for="batch_name ?>"><?=form_error("batch_name");?></label>
								</div>
								<?php /* <div class="col-lg-6 col-md-12">
									<label>Type Of User <font color="red">*</font></label>
									<select id="user_type" name="user_type" class="form-control basicdetails">
										<option value="">--Select--</option>
										<?php if(isset($user_types) && $user_types){ 
											foreach ($user_types as $user_type) { ?>
												<option value="<?php echo $user_type->id; ?>" ><?php echo $user_type->user_type; ?></option>
										<?php }
										}
										?>
									</select>	
									<label id="user_type-error" class="error validationerror" for="user_type ?>"><?=form_error("user_type");?></label>
								</div> */ ?>
							</div>
						</div>	
						<div id="reviewform">
						<?php
						if(isset($star_participant) && $star_participant){
							for($i=0;$i<count($star_participant);$i+=2){ ?>
								<div class="form-group">
									<div class="row">
										<?php for($j=$i;$j<$i+2;$j++){ 
										if(isset($star_participant[$j]) && $star_participant[$j]){
										?>
										<div class="col-lg-6 col-md-12">
											<?php
												$field_id='';
												if(isset($star_participant[$j]->id) && $star_participant[$j]->id){ 
													$field_id=$star_participant[$j]->id;
												}
												$label='';
												if(isset($star_participant[$j]->field_label) && $star_participant[$j]->field_label){ 
													$label=$star_participant[$j]->field_label;
												}
												$field_type='';
												if(isset($star_participant[$j]->field_type) && $star_participant[$j]->field_type){ 
													$field_type=$star_participant[$j]->field_type;
												}
												$field_name='';
												if(isset($star_participant[$j]->field_name) && $star_participant[$j]->field_name){ 
													$field_name=$star_participant[$j]->field_name;
												}
												$is_required=0;
												$is_required_field='';
												$is_required_msg='';
												$required_valid_msg='';
												if(isset($star_participant[$j]->is_required) && $star_participant[$j]->is_required==1){ 
													$is_required=1;
													$is_required_field='is_required_field';
													/* if($field_type=='dropdown'){
														$is_required_msg='required data-msg-required="Please Selectn'.$label.'"'; 
													}else{
														$is_required_msg='required data-msg-required="'.$label.' is required"'; 
													} */
													if($field_type=='dropdown' || $field_type=='date' || $field_type=='radio' || $field_type=='checkbox'){
														$required_valid_msg='Please Select '.$label; 
													}else{
														$required_valid_msg=$label.' is required'; 
													}
												}
												$placeholder='';
												if(isset($star_participant[$j]->placeholder) && $star_participant[$j]->placeholder){ 
													$placeholder=$star_participant[$j]->placeholder;
													
												}
												$comments='';
												if(isset($star_participant[$j]->comments) && $star_participant[$j]->comments){ 
													$comments=$star_participant[$j]->comments;
												}
												$max_upload=1;
												if(isset($star_participant[$j]->max_upload) && $star_participant[$j]->max_upload){ 
													$max_upload=$star_participant[$j]->max_upload;
												}
												$related_table_name='';
												if(isset($star_participant[$j]->related_table_name) && $star_participant[$j]->related_table_name){ 
													$related_table_name=$star_participant[$j]->related_table_name;
												}
												$special_feature='';
												if(isset($star_participant[$j]->special_feature) && $star_participant[$j]->special_feature){ 
													$special_feature=$star_participant[$j]->special_feature;
												}
												$is_readonly='';
												if(isset($star_participant[$j]->is_readonly) && $star_participant[$j]->is_readonly==1){ 
													$is_readonly='readonly';
												}
												$date_validation='alldate';
												if(isset($star_participant[$j]->date_validation) && $star_participant[$j]->date_validation){ 
													$date_validation=$star_participant[$j]->date_validation;
												}
											?>
											<label><?php echo $label; ?><?php if($is_required==1){ echo '&nbsp;<font color="red">*</font></label>'; }?></label>
											<input type="hidden" id="lbl_<?php echo $field_name; ?>" name="lbl_<?php echo $field_name; ?>" value="<?php echo $label; ?>"/>
											<?php if($field_type=='text'){ ?>
												<input type="text" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control <?php echo $is_required_field; ?>" value="<?php echo set_value($field_name);?>" placeholder="<?php echo $placeholder; ?>" <?php echo $is_required_msg;  ?> >
											<?php }else if($field_type=='dropdown'){ 
												if($special_feature=='rating'){ ?>
													<div class="card-body">
														<div class="box  box-example-1to10">
														  <div class="box-body">
															<select id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="example-1to10" autocomplete="off">
															  <option value="1">1</option>
															  <option value="2">2</option>
															  <option value="3">3</option>
															  <option value="4">4</option>
															  <option value="5">5</option>
															  <option value="6">6</option>
															  <option value="7">7</option>
															  <option value="8">8</option>
															  <option value="9">9</option>
															  <option value="10">10</option>
															</select>
														  </div>
														</div>
													</div>
												<?php }else if($special_feature=='multiple select2'){ 
													if($related_table_name && $related_table_name!='sessionmanagement'){
														$optionlist=getDynamicFieldOptionByRelatedTable($related_table_name);
													}else{
														$optionlist=getDynamicFieldOption('star_participant_form',$field_id,'dropdown');
													}
												?>
													<select class="form-control select2 <?php echo $is_required_field;  ?>"  id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" multiple <?php echo $is_required_msg;  ?> ><?php echo $optionlist; ?></select>
												<?php }else{
													$onchange='';
													if($related_table_name && $related_table_name!='sessionmanagement'){
														$optionlist=getDynamicFieldOptionByRelatedTable($related_table_name);
														if($related_table_name=='program_master'){
															$onchange='onchange="getSessionData(this);"';
														}else if($related_table_name=='states'){
															$onchange='onchange="getDistrictData(this);"';
														}else if($related_table_name=='districts'){
															$onchange='onchange="getCityData(this);"';
														}
													}else{
														$optionlist=getDynamicFieldOption('star_participant_form',$field_id,'dropdown');
													}
												?>
												<select id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control <?php echo $is_required_field;  ?>" <?php echo $is_required_msg;  ?> data-related-table-name='<?php echo $related_table_name; ?>' <?php echo $onchange; ?> ><?php echo $optionlist; ?></select>
												<?php } ?>
											<?php }else if($field_type=='textarea'){ ?>
												<textarea id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control <?php echo $is_required_field;  ?>" placeholder="<?php echo $placeholder; ?>"  <?php echo $is_required_msg;  ?>><?php echo set_value($field_name);?></textarea>	
											<?php }else if($field_type=='number'){ 
												$minstr='';
												if(isset($star_participant[$j]->min_number) && $star_participant[$j]->min_number!='' && $star_participant[$j]->min_number!=null){
													$minstr='min="'.$star_participant[$j]->min_number.'"';
												}
												$maxstr='';
												if(isset($star_participant[$j]->max_number) && $star_participant[$j]->max_number!='' && $star_participant[$j]->max_number!=null){
													$maxstr='max="'.$star_participant[$j]->max_number.'"';
												}
											?>
												<input type="number" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control <?php echo $is_required_field;  ?>" <?php echo $minstr;  ?> <?php echo $maxstr;  ?> value="<?php echo set_value($field_name);?>" placeholder="<?php echo $placeholder; ?>"  <?php echo $is_required_msg;  ?>>
											<?php }else if($field_type=='file'){ 
												if($max_upload==1){ ?>
													<input type="file" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="dropify"  value="<?php echo set_value($field_name);?>" <?php echo $is_required_msg;  ?>>	
												<?php }else{ ?>
													<input type="file" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" class="dropify"  value="<?php echo set_value($field_name);?>" multiple <?php echo $is_required_msg;  ?>>	
												<?php } ?>
											<?php }else if($field_type=='date'){
											 ?>
												<div class="wd-200 mg-b-30">
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
															</div>
														</div>
														<input type="text" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control <?php echo $date_validation; ?> <?php echo $is_required_field;  ?>" autocomplete="off" placeholder="<?php echo $placeholder; ?>" <?php echo $is_readonly; ?>>
													</div>
												</div>
											<?php }else if($field_type=='checkbox'){ 
												$optionlist=getDynamicFieldOption('star_participant_form',$field_id,'checkbox',$field_name);
												?>
												<br/>
												<?php echo $optionlist; ?>
												<br/>
											<?php }else if($field_type=='radio'){ 
												$optionlist=getDynamicFieldOption('star_participant_form',$field_id,'radio',$field_name);
											?>
												<br/>
												<?php echo $optionlist; ?>
												<br/>
											<?php } ?>
											<label id="<?php echo $field_name; ?>-error" class="error validationerror" for="<?php echo $field_name; ?>"><?php echo $required_valid_msg; ?></label>
											<?php if($comments){ ?>
												<p><span class="text-info"><?php echo $comments; ?></span></p>
											<?php } ?>
										</div>
										<?php }
										 } ?>
									</div>
								</div>
							<?php }
						} 
						?>	
						</div>		
						<?php /* <div class="form-group">
							<div class="row">
								<div class="col-lg-3 col-md-12">
									<label>Program Name</label>
									<select name="program_name" class="form-control">
										<option value="">Select Program</option>
										<option value="Life Camp">Life Camp</option>
										<option value="Dream India Camp">Dream India Camp</option>
									</select>	
									<font color="red"><?=form_error("program_name");?></font>
								</div>
								<div class="col-lg-3 col-md-12">
									<label>Session</label>
									<select name="session" class="form-control">
										<option value="">Select Session</option>
										<option value="Session 1">Session 1</option>
										<option value="Session 2">Session 2</option>
									</select>	
									<font color="red"><?=form_error("session");?></font>
									<span class="text-red">Note : Need to Show selected program batch name here</span>
								</div>
								<div class="col-lg-3 col-md-12">
									<label>First Name</label>
									<input type="text" name="first_name" class="form-control" placeholder="Enter First Name" value="<?php echo set_value('first_name');?>">
									<font color="red"><?=form_error("first_name");?></font>
								</div>
								<div class="col-lg-3 col-md-12">
									<label>Last Name</label>
									<input type="text" name="last_name" class="form-control" placeholder="Enter Last Name" value="<?php echo set_value('last_name');?>">
									<font color="red"><?=form_error("last_name");?></font>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">	
								<div class="col-lg-3 col-md-12">
									<label>Date of Birth</label>
									<div class="wd-200 mg-b-30">
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">
													<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
												</div>
											</div>
											<input class="form-control" id="datepicker0" autocomplete="off" placeholder="Enter Date of Birth" type="text" name="dob" value="<?php echo set_value('dob'); ?>">
										</div>
									</div>
									<font color="red"><?=form_error("dob");?></font> 
								</div>
								<div class="col-lg-3 col-md-12">
									<label>State</label>
									<select name="state" class="form-control">
										<option value="">Select State</option><option value="995"> Jammu &amp; Kashmir </option><option value="996"> Gujarat </option><option value="997"> Karnataka </option><option value="998"> Maharashtra </option><option value="999"> Delhi </option><option value="1098"> Ladakh </option><option value="1207"> Kerala </option><option value="1237"> Uttar Pradesh </option><option value="1245"> Odisha </option><option value="1269"> Bihar </option>
									</select>
									<font color="red"><?=form_error("state");?></font>
								</div>
								<div class="col-lg-3 col-md-12">
									<label>District</label>
									<select name="district" class="form-control">
										<option value="">Select District</option><option value="1036"> Jammu </option><option value="1037"> Srinagar </option><option value="1038"> Baramulla </option>
									</select>
									<font color="red"><?=form_error("district");?></font>
								</div>
								<div class="col-lg-3 col-md-12">
									<label>Village/City</label>
									<select name="village_city" class="form-control">
										<option value="">Select Village/City</option><option value="1036"> Ahmedabad </option><option value="1037"> Jamnagar </option><option value="1038"> Vadodara </option>
									</select>
									<font color="red"><?=form_error("village_city");?></font>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">													
								<div class="col-lg-6 col-md-12">
									<label>Qualities Observed</label>
									<select name="quality_observed[]" class="form-control quality_observed" multiple>
										<option value="Good Communication"> Good Communication </option><option value="Puctuality"> Puctuality </option><option value="Good Knowledge"> Good Knowledge </option><option value="Learning Ability"> Learning Ability </option>
									</select>
									<font color="red"><?=form_error("quality_observed");?></font>
								</div>
								<div class="col-lg-6 col-md-12">
									<label>Qualities - Other Observations</label>
									<input type="text" name="other_quality_observed" class="form-control" placeholder="Enter Qualities - Other Observations" value="<?php echo set_value('other_quality_observed');?>">
									<font color="red"><?=form_error("other_quality_observed");?></font>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">	
								<div class="col-lg-6 col-md-12">
									<label>Languages known</label>
									<textarea name="language_known" class="form-control" placeholder="Enter Languages known"><?php echo set_value('language_known');?></textarea>
									<font color="red"><?=form_error("language_known");?></font>
								</div>
								<div class="col-lg-6 col-md-12">
									<label>Education Qualification</label>
									<textarea name="education_qualification" class="form-control" placeholder="Enter Education Qualification"><?php echo set_value('education_qualification');?></textarea>
									<font color="red"><?=form_error("education_qualification");?></font>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">	
								<!--<div class="col-lg-6 col-md-12">
									<label>Next recommendation</label>
									<textarea name="next_recommendation" class="form-control" placeholder="Enter Next recommendation"><?php echo set_value('next_recommendation');?></textarea>
									<font color="red"><?=form_error("next_recommendation");?></font>
								</div>-->
								<div class="col-lg-3 col-md-12">
									<label>Next level Program</label>
									<select name="next_level_program[]" class="form-control next_level_program" multiple>
										<option value="Dream India Camp">Dream India Camp</option>
										<option value="Life Camp">Life Camp</option>
										<option value="Hakkal">Hakkal</option>
										<option value="L-L-L Camps">L-L-L Camps</option>
										<option value="AKT Sessions">AKT Sessions</option>
										<option value="Sunday Sessions">Sunday Sessions</option>
										<option value="Freedom Parenting Workshops">Freedom Parenting Workshops</option>
									</select>	
									<font color="red"><?=form_error("next_level_program");?></font>
								</div>
								<div class="col-lg-3 col-md-12">
									<label>Next level Role</label>
									<select name="next_level_role[]" class="form-control next_level_role" multiple>
										<!--Static Values-->
										<option value="Participant">Participant</option>
										<option value="Volunteer">Volunteer</option>
										<option value="Co-learner">Co-learner</option>
										<option value="Co-ordinator">Co-ordinator</option>
										<option value="Project Leader">Project Leader</option>
										<option value="Facilitator">Facilitator</option>
									</select>	
									<font color="red"><?=form_error("next_level_role");?></font>
								</div>
								<div class="col-lg-6 col-md-12">
									<label>Special note</label>
									<textarea name="special_note" class="form-control" placeholder="Enter Special note"><?php echo set_value('special_note');?></textarea>
									<font color="red"><?=form_error("special_note");?></font>
								</div>
							</div>
						</div> */ ?>
						<hr/>
						<div class="form-group"  style="float:right;">
							<div class="row">
								<input type="button" name="submit" value="Submit" class="btn btn-app btn-primary mr-2 mt-1 mb-1 tooltipcls" style="cursor:not-allowed;" title="Can not submit form as it is only preview.">
								<input type="button" name="next_form" value="Next" class="btn btn-app btn-primary mr-2 mt-1 mb-1 tooltipclsnext" style="cursor:not-allowed;" title="Can not go to next step as it is only preview.">
							</div>
						</div>		
					</div>
				</div>
			</div>
		</div>
		<!-- row end -->
	</div>
<?php include("footer.php"); ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#reviewform').fadeOut(0);
		$('.tooltipcls').tooltipster({
			position:'left'
      	});
      	$('.tooltipclsnext').tooltipster({
			position:'top'
      	});
      	$('.alldate').datepicker();
		$('.onlypast').datepicker({
			maxDate: new Date()
		});
		$('.onlyfuture').datepicker({
			minDate: 0
		});
		$('select.is_required_field').each(function(){
			var ele=$(this).parent().find(".select2-container").length;
			if(ele){
				$(this).parent().find(".select2-container").addClass("is_required_field_select2");
			}
		});
	});
	$('.basicdetails').on('change',function(){
		var batch_name=$('#batch_name').val();
		// var user_type=$('#user_type').val();
		// if(batch_name && user_type){
		if(batch_name){
			$('#reviewform').fadeIn(0);
			var program_name = $('select#batch_name').find(':selected').data('program');
			$('#program_name').val(program_name);
			getSessionData(program_name);
		}else{
			$('#reviewform').fadeOut(0);
		}
	});
	function getSessionData(program_name){
		if(program_name){
			$.ajax({
				type:'POST',
				url:"<?php echo site_url('management/ajax_get_sessionlist_by_program'); ?>",
				data:'program_name='+program_name,
				success:function(response){
					if(response.hasOwnProperty('sessionlist') && response.sessionlist){
						$("select[data-related-table-name='sessionmanagement']").html(response.sessionlist);
					}
				}
			});
		}else{
			var sessionlist='<option value="">--Select--</option>';
			$("select[data-related-table-name='sessionmanagement']").html(sessionlist);
		}
	}
	/* function getSessionData(ele){
		var id=$(ele).attr('id');
		var program_name=$("#"+id+" option:selected").text();
		if(program_name){
			$.ajax({
				type:'POST',
				url:"<?php //echo site_url('management/ajax_get_sessionlist_by_program'); ?>",
				data:'program_name='+program_name,
				success:function(response){
					if(response.hasOwnProperty('sessionlist') && response.sessionlist){
						$("select[data-related-table-name='sessionmanagement']").html(response.sessionlist);
					}
				}
			});
		}else{
			var sessionlist='<option value="">--Select--</option>';
			$("select[data-related-table-name='sessionmanagement']").html(sessionlist);
		}
	} */
	function getDistrictData(ele){
		var id=$(ele).attr('id');
		var state_id=$("#"+id+" option:selected").val();
		if(state_id){
			$.ajax({
				type:'POST',
				url:"<?php echo site_url('districtMst/ajax_get_district_by_state'); ?>",
				data:'state_id='+state_id,
				success:function(response){
					if(response.hasOwnProperty('districtlist') && response.districtlist){
						$("select[data-related-table-name='districts']").html(response.districtlist);
					}
				}
			});
		}else{
			var districtlist='<option value="">--Select--</option>';
			$("select[data-related-table-name='districts']").html(districtlist);
		}
	}
	function getCityData(ele){
		var id=$(ele).attr('id');
		var districtid=$("#"+id+" option:selected").val();
		if(districtid){
			$.ajax({
				type:'POST',
				url:"<?php echo site_url('cityMst/ajax_get_city_by_district'); ?>",
				data:'districtid='+districtid,
				success:function(response){
					if(response.hasOwnProperty('citylist') && response.citylist){
						$("select[data-related-table-name='city_town_villages']").html(response.citylist);
					}
				}
			});
		}else{
			var citylist='<option value="">--Select--</option>';
			$("select[data-related-table-name='city_town_villages']").html(citylist);
		}
	}
</script>