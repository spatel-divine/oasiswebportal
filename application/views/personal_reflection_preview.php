<?php include("header.php");?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Review Form</a></li>
				<li class="breadcrumb-item active" aria-current="page">Personal Reflection (for Fc & CoFc only)</li>
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
									<span class="text-red">Note: After selecting Batch and type of user (F/CF) form will open with User’s name on top</span>
								</div>	
							</div>
						</div>		
						<div class="form-group">
							<div class="row">	
								<div class="col-lg-6 col-md-12">
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
								<div class="col-lg-6 col-md-12">
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
								</div>
							</div>
						</div>	
						<div id="reviewform">
						<?php
						if(isset($personal_learning) && $personal_learning){
							for($i=0;$i<count($personal_learning);$i+=2){ ?>
								<div class="form-group">
									<div class="row">
										<?php for($j=$i;$j<$i+2;$j++){ 
										if(isset($personal_learning[$j]) && $personal_learning[$j]){
										?>
										<div class="col-lg-6 col-md-12">
											<?php
												$field_id='';
												if(isset($personal_learning[$j]->id) && $personal_learning[$j]->id){ 
													$field_id=$personal_learning[$j]->id;
												}
												$label='';
												if(isset($personal_learning[$j]->field_label) && $personal_learning[$j]->field_label){ 
													$label=$personal_learning[$j]->field_label;
												}
												$field_type='';
												if(isset($personal_learning[$j]->field_type) && $personal_learning[$j]->field_type){ 
													$field_type=$personal_learning[$j]->field_type;
												}
												$field_name='';
												if(isset($personal_learning[$j]->field_name) && $personal_learning[$j]->field_name){ 
													$field_name=$personal_learning[$j]->field_name;
												}
												$is_required=0;
												$is_required_field='';
												$is_required_msg='';
												$required_valid_msg='';
												if(isset($personal_learning[$j]->is_required) && $personal_learning[$j]->is_required==1){ 
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
												if(isset($personal_learning[$j]->placeholder) && $personal_learning[$j]->placeholder){ 
													$placeholder=$personal_learning[$j]->placeholder;
													
												}
												$comments='';
												if(isset($personal_learning[$j]->comments) && $personal_learning[$j]->comments){ 
													$comments=$personal_learning[$j]->comments;
												}
												$max_upload=1;
												if(isset($personal_learning[$j]->max_upload) && $personal_learning[$j]->max_upload){ 
													$max_upload=$personal_learning[$j]->max_upload;
												}
												$related_table_name='';
												if(isset($personal_learning[$j]->related_table_name) && $personal_learning[$j]->related_table_name){ 
													$related_table_name=$personal_learning[$j]->related_table_name;
												}
												$special_feature='';
												if(isset($personal_learning[$j]->special_feature) && $personal_learning[$j]->special_feature){ 
													$special_feature=$personal_learning[$j]->special_feature;
												}
												$is_readonly='';
												if(isset($personal_learning[$j]->is_readonly) && $personal_learning[$j]->is_readonly==1){ 
													$is_readonly='readonly';
												}
												$date_validation='alldate';
												if(isset($personal_learning[$j]->date_validation) && $personal_learning[$j]->date_validation){ 
													$date_validation=$personal_learning[$j]->date_validation;
												}
											?>
											<label><?php echo $label; ?><?php if($is_required==1){ echo '&nbsp;<font color="red">*</font></label>'; }?></label>
											<input type="hidden" id="lbl_<?php echo $field_name; ?>" name="lbl_<?php echo $field_name; ?>" value="<?php echo $label; ?>"/>
											<?php if($field_type=='text'){ ?>
												<input type="text" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control <?php echo $is_required_field; ?>" value="<?php echo set_value($field_name);?>" placeholder="<?php echo $placeholder; ?>" <?php echo $is_required_msg;  ?> <?php echo $is_readonly ?>>
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
														$optionlist=getDynamicFieldOption('personal_learning_form',$field_id,'dropdown');
													}
												?>
													<select class="form-control select2 <?php echo $is_required_field;  ?>"  id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" multiple <?php echo $is_required_msg;  ?> ><?php echo $optionlist; ?></select>
												<?php }else{
													$optionlist=getDynamicFieldOption('personal_learning_form',$field_id,'dropdown');
												?>
												<select id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control <?php echo $is_required_field;  ?>" <?php echo $is_required_msg;  ?> data-related-table-name='<?php echo $related_table_name; ?>'><?php echo $optionlist; ?></select>
												<?php } ?>
											<?php }else if($field_type=='textarea'){ ?>
												<textarea id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control <?php echo $is_required_field;  ?>" placeholder="<?php echo $placeholder; ?>"  <?php echo $is_required_msg;  ?>><?php echo set_value($field_name);?></textarea>	
											<?php }else if($field_type=='number'){ 
												$minstr='';
												if(isset($personal_learning[$j]->min_number) && $personal_learning[$j]->min_number!='' && $personal_learning[$j]->min_number!=null){
													$minstr='min="'.$personal_learning[$j]->min_number.'"';
												}
												$maxstr='';
												if(isset($personal_learning[$j]->max_number) && $personal_learning[$j]->max_number!='' && $personal_learning[$j]->max_number!=null){
													$maxstr='max="'.$personal_learning[$j]->max_number.'"';
												}
											?>
												<input type="number" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control <?php echo $is_required_field;  ?>" <?php echo $minstr;  ?> <?php echo $maxstr;  ?> value="<?php echo set_value($field_name);?>" placeholder="<?php echo $placeholder; ?>"  <?php echo $is_required_msg;  ?>>
											<?php }else if($field_type=='file'){ 
												if($max_upload==1){ ?>
													<input type="file" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="dropify"  value="<?php echo set_value($field_name);?>" <?php echo $is_required_msg;  ?>>	
												<?php }else{ ?>
													<input type="file" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" class="dropify"  value="<?php echo set_value($field_name);?>" multiple <?php echo $is_required_msg;  ?>>	
												<?php } ?>
											<?php }else if($field_type=='date'){ ?>
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
												$optionlist=getDynamicFieldOption('personal_learning_form',$field_id,'checkbox',$field_name);
												?>
												<br/>
												<?php echo $optionlist; ?>
												<br/>
											<?php }else if($field_type=='radio'){ 
												$optionlist=getDynamicFieldOption('personal_learning_form',$field_id,'radio',$field_name);
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
							}  ?>
						</div>	
						<?php /*
						<div class="form-group">
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
								<div class="col-lg-6 col-md-12">
									<label>Personal Learning</label>
									<textarea name="personal_learning" class="form-control" placeholder="Enter Personal Learning"><?php echo set_value('personal_learning');?></textarea>
									<font color="red"><?=form_error("personal_learning");?></font>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">	
								<div class="col-lg-6 col-md-12">
									<label>Improvement area</label>
									<textarea name="improvement_area" class="form-control" placeholder="Enter Improvement area"><?php echo set_value('improvement_area');?></textarea>
									<font color="red"><?=form_error("improvement_area");?></font>
								</div>
								<div class="col-lg-6 col-md-12">
									<label>Suggestions for Program, Module, Venue</label>
									<textarea name="suggestions" class="form-control" placeholder="Enter Suggestions for Program, Module, Venue"><?php echo set_value('suggestions');?></textarea>
									<font color="red"><?=form_error("suggestions");?></font>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">	
								<div class="col-lg-6 col-md-12">
									<label>Reviews for Facilitator / Co-facilitator</label>
									<textarea name="user_review" class="form-control" placeholder="Enter Reviews for Facilitator / Co-facilitator"><?php echo set_value('user_review');?></textarea> 
									<font color="red"><?=form_error("user_review");?></font>
								</div>
								<div class="col-lg-6 col-md-12">
									<label>Any remark/ Note</label>
									<textarea name="remark_note" class="form-control" placeholder="Enter remark/ Note"><?php echo set_value('remark_note');?></textarea>
									<font color="red"><?=form_error("remark_note");?></font>
								</div>
							</div>
						</div> */ ?>
						<hr/>
						<div class="form-group"  style="float:right;">
							<div class="row">
								<input type="button" name="submit" value="Submit" class="btn btn-app btn-primary mr-2 mt-1 mb-1 tooltipcls" style="cursor:not-allowed;" title="Can not submit form as it is only preview.">
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
		var user_type=$('#user_type').val();
		if(batch_name && user_type){
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
</script>