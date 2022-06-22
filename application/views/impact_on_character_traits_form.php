<?php include("header.php");?>
<style type="text/css">
	table{
		text-align: center !important;
	}
	.zindex{
		z-index: 1;
	}
</style>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item">
					<a href="#">Review Form</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Impact on Character Traits (for Participants)</li>
			</ol><!-- End breadcrumb -->
			<div class="ml-auto">
				<div class="input-group">
					<a href="<?php echo site_url('Master/impact_on_character_traits_list'); ?>" class="btn btn-info text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add New">
						<span>
							<i class="fa fa-eye"></i>&nbsp;Impact on Character Traits List
						</span>
					</a>&nbsp;&nbsp;
					<a href="javascript:void(0);" class="btn btn-secondary text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add New Fields" onclick="AddNewField();">
						<span>
							<i class="fa fa-plus"></i>&nbsp;Add New Fields
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
					<div class="card-body">
						<?php /* <div class="form-group">
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<span class="text-red">Note: Select Batch and form will appear</span>
								</div>	
							</div>
						</div>	*/ ?>
						<div id="reviewform">
							<?php
							if(isset($impact_on_character_traits) && $impact_on_character_traits){
								for($i=0;$i<count($impact_on_character_traits);$i+=2){ ?>
									<div class="form-group">
										<div class="row">
											<?php for($j=$i;$j<$i+2;$j++){ 
											if(isset($impact_on_character_traits[$j]) && $impact_on_character_traits[$j]){
											?>
											<div class="col-lg-6 col-md-12">
												<?php
													$field_id='';
													if(isset($impact_on_character_traits[$j]->id) && $impact_on_character_traits[$j]->id){ 
														$field_id=$impact_on_character_traits[$j]->id;
													}
													$label='';
													if(isset($impact_on_character_traits[$j]->field_label) && $impact_on_character_traits[$j]->field_label){ 
														$label=$impact_on_character_traits[$j]->field_label;
													}
													$field_type='';
													if(isset($impact_on_character_traits[$j]->field_type) && $impact_on_character_traits[$j]->field_type){ 
														$field_type=$impact_on_character_traits[$j]->field_type;
													}
													$field_name='';
													if(isset($impact_on_character_traits[$j]->field_name) && $impact_on_character_traits[$j]->field_name){ 
														$field_name=$impact_on_character_traits[$j]->field_name;
													}
													$is_required=0;
													$is_required_field='';
													$is_required_msg='';
													$required_valid_msg='';
													if(isset($impact_on_character_traits[$j]->is_required) && $impact_on_character_traits[$j]->is_required==1){ 
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
													if(isset($impact_on_character_traits[$j]->placeholder) && $impact_on_character_traits[$j]->placeholder){ 
														$placeholder=$impact_on_character_traits[$j]->placeholder;
														
													}
													$comments='';
													if(isset($impact_on_character_traits[$j]->comments) && $impact_on_character_traits[$j]->comments){ 
														$comments=$impact_on_character_traits[$j]->comments;
													}
													$max_upload=1;
													if(isset($impact_on_character_traits[$j]->max_upload) && $impact_on_character_traits[$j]->max_upload){ 
														$max_upload=$impact_on_character_traits[$j]->max_upload;
													}
													$related_table_name='';
													if(isset($impact_on_character_traits[$j]->related_table_name) && $impact_on_character_traits[$j]->related_table_name){ 
														$related_table_name=$impact_on_character_traits[$j]->related_table_name;
													}
													$special_feature='';
													if(isset($impact_on_character_traits[$j]->special_feature) && $impact_on_character_traits[$j]->special_feature){ 
														$special_feature=$impact_on_character_traits[$j]->special_feature;
													}
													$is_readonly='';
													if(isset($impact_on_character_traits[$j]->is_readonly) && $impact_on_character_traits[$j]->is_readonly==1){ 
														$is_readonly='readonly';
													}
													$date_validation='alldate';
													if(isset($impact_on_character_traits[$j]->date_validation) && $impact_on_character_traits[$j]->date_validation){ 
														$date_validation=$impact_on_character_traits[$j]->date_validation;
													}
												?>
												<label><?php echo $label; ?><?php if($is_required==1){ echo '&nbsp;<font color="red">*</font></label>'; }?></label>
												<input type="hidden" id="lbl_<?php echo $field_name; ?>" name="lbl_<?php echo $field_name; ?>" value="<?php echo $label; ?>"/>
												<?php if($field_type=='text'){ ?>
													<input type="text" id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control <?php echo $is_required_field; ?> <?php if($special_feature=='monthyear'){ echo 'monthyear'; } ?>"  value="<?php echo set_value($field_name);?>" placeholder="<?php echo $placeholder; ?>" <?php echo $is_required_msg;  ?> >
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
															$optionlist=getDynamicFieldOption('impact_on_character_traits_form',$field_id,'dropdown');
														}
													?>
														<select class="form-control select2 <?php echo $is_required_field;  ?>"  id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>[]" multiple <?php echo $is_required_msg;  ?> ><?php echo $optionlist; ?></select>
													<?php }else{
														if($related_table_name && $related_table_name!='sessionmanagement'){
															$optionlist=getDynamicFieldOptionByRelatedTable($related_table_name);
														}else{
															$optionlist=getDynamicFieldOption('impact_on_character_traits_form',$field_id,'dropdown');
														}
													?>
													<select id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control <?php echo $is_required_field;  ?>" <?php echo $is_required_msg;  ?> data-related-table-name='<?php echo $related_table_name; ?>'><?php echo $optionlist; ?></select>
													<?php } ?>
												<?php }else if($field_type=='textarea'){ ?>
													<textarea id="<?php echo $field_name; ?>" name="<?php echo $field_name; ?>" class="form-control <?php echo $is_required_field;  ?>" placeholder="<?php echo $placeholder; ?>"  <?php echo $is_required_msg;  ?>><?php echo set_value($field_name);?></textarea>	
												<?php }else if($field_type=='number'){ 
													$minstr='';
													if(isset($impact_on_character_traits[$j]->min_number) && $impact_on_character_traits[$j]->min_number!='' && $impact_on_character_traits[$j]->min_number!=null){
														$minstr='min="'.$impact_on_character_traits[$j]->min_number.'"';
													}
													$maxstr='';
													if(isset($impact_on_character_traits[$j]->max_number) && $impact_on_character_traits[$j]->max_number!='' && $impact_on_character_traits[$j]->max_number!=null){
														$maxstr='max="'.$impact_on_character_traits[$j]->max_number.'"';
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
													$optionlist=getDynamicFieldOption('impact_on_character_traits_form',$field_id,'checkbox',$field_name);
													?>
													<br/>
													<?php echo $optionlist; ?>
													<br/>
												<?php }else if($field_type=='radio'){ 
													$optionlist=getDynamicFieldOption('impact_on_character_traits_form',$field_id,'radio',$field_name);
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
							if(isset($parameter_or_characteristics_list) && $parameter_or_characteristics_list){ ?>
								<div class="form-group">
									<div class="row">	
										<div class="col-lg-12 col-md-12">
									 		<p  class="btn btn-primary col-lg-12"><b>Evaluation:</b> Read Parameters for Evaluation along with its description and related questions. Rate each parameter by writing a figure between 1 & 10 against it. 1 indicates the characteristics at<br/> lowest level while 10 indicates it at highest level. Please write proportionate figure between 2 to 9 as per intermediate stage.</p>
										</div>	
									</div>
								</div>
								<div class="form-group">
									<div class="row">	
										<div class="col-lg-12 col-md-12">
									 		<div class="table-responsive">
												<table class="table table-striped table-bordered text-center myTable" >
													<thead>
														<tr><th colspan="4" class="survey_topic">Rating of Parameters</th></tr>
														<tr class="table_content_height">
															<th class="content_value_align">Sr No</th>
															<th class="content_value_align">Parameter / Characteristics</th>
															<th class="content_value_align zindex">Brfore Oasis Program</th>
															<th class="content_value_align zindex">Status at Present</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														$type='';
														foreach($parameter_or_characteristics_list as $parameter_or_characteristics){
															if($type!=$parameter_or_characteristics->type){ 
																$type=$parameter_or_characteristics->type;
															?>
																<tr>
																	<th colspan="4" class="survey_topic"><?php echo $type; ?></th>
																</tr>
															<?php } ?>
															<tr>
																<td><?php echo $parameter_or_characteristics->sequence_no; ?>
																	<input type="hidden" id="parameter_or_characteristics_id" name="parameter_or_characteristics_id[]" value="<?php echo base64_encode( $parameter_or_characteristics->id); ?>">
																</td>
																<td class="survery_parameter">
																	<table class="text-wrap">
																		<tr>
																			<td class="trait_survey">
																				<p class="survey_line1"><?php echo $parameter_or_characteristics->name; ?></p>
																			</td>
																			<td class="trait_survey">
																				<p class="survey_line2"><?php echo $parameter_or_characteristics->characteristics; ?></p>
																			</td>
																			<td class="trait_survey">
																				<p class="survey_line3"><?php echo $parameter_or_characteristics->description; ?></p>
																			</td>
																		</tr>
																	</table>
																</td>
																<td>
																	<div class="card-body">
																		<div class="box  box-example-1to10">
																		  <div class="box-body">
																			<select id="before_oasis_program_<?php echo base64_encode($parameter_or_characteristics->id); ?>"  name="before_oasis_program[]" class="example-1to10 before_oasis_cls" autocomplete="off" onchange="getBeforeOasisTotal();" required data-msg-required="Please Select Before Oasis Program">
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
																			<br/>
																			<label id="before_oasis_program_before_oasis_program_<?php echo base64_encode($parameter_or_characteristics->id); ?>-error" class="error validationerror" for="before_oasis_program_before_oasis_program_<?php echo base64_encode($parameter_or_characteristics->id); ?>" style="margin-top: 10px;"></label>
																		  </div>
																		</div>
																	</div>
																</td>
																<td>
																	<div class="card-body">
																		<div class="box  box-example-1to10">
																		  <div class="box-body">
																			<select id="status_at_present_<?php echo base64_encode($parameter_or_characteristics->id); ?>"  name="status_at_present[]" class="example-1to10 status_at_present_cls" autocomplete="off"  onchange="getStatusAtPresentTotal();" required data-msg-required="Please Select Status At Present">
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
																			<br/>
																			<label id="status_at_present_<?php echo base64_encode($parameter_or_characteristics->id); ?>-error" class="error validationerror" for="status_at_present_<?php echo base64_encode($parameter_or_characteristics->id); ?>" style="margin-top: 10px;"></label>
																		  </div>
																		</div>
																	</div>
																</td>
															</tr>
														<?php } ?>
														<tr>
															<td></td>
															<td class="survey_line1">TOTAL</td>
															<td id="total_before_oasis">10/120</td>
															<td id="total_status_at_present">10/120</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>	
						<?php /* 
						<div class="form-group">
							<div class="row">	
								<div class="col-lg-12 col-md-12">
									<label contenteditable="true" class="form-control">Select Batch</label>
									<select name="batch_name" class="form-control">
										<option value="">Select Batch</option>
										<option value="Batch 1">Batch 1</option>
										<option value="Batch 2">Batch 2</option>
									</select>	
									<font color="red"><?=form_error("batch_name");?></font>
								</div>
							</div>
						</div>		
						<div class="form-group">
							<div class="row">	
								<div class="col-lg-6 col-md-12">
									<label contenteditable="true" class="form-control">Program Name</label>
									<select name="program_name" class="form-control">
										<option value="">Select Program</option>
										<option value="Life Camp">Life Camp</option>
										<option value="Dream India Camp">Dream India Camp</option>
									</select>	
									<font color="red"><?=form_error("program_name");?></font>
								</div>
								<div class="col-lg-6 col-md-12">
									<label contenteditable="true" class="form-control">Session</label>
									<select name="session" class="form-control">
										<option value="">Select Session</option>
										<option value="Session 1">Session 1</option>
										<option value="Session 2">Session 2</option>
									</select>	
									<font color="red"><?=form_error("session");?></font>
									<span class="text-red">Note : Need to Show selected program batch name here</span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">	
								<div class="col-lg-3 col-md-12">
									<label contenteditable="true" class="form-control">Name</label>
									<input type="text" name="name" class="form-control" placeholder="Enter Name" value="<?php echo set_value('name');?>">
									<font color="red"><?=form_error("name");?></font>
								</div>
								<div class="col-lg-3 col-md-12">
									<label contenteditable="true" class="form-control">Age</label>
									<input type="number" name="age" class="form-control" placeholder="Enter Age" value="<?php echo set_value('age');?>" min="1">
									<font color="red"><?=form_error("age");?></font>
								</div>
								<div class="col-lg-6 col-md-12">
									<label contenteditable="true" class="form-control">Occupation (School/College/Profession)</label>
									<textarea name="occupation" class="form-control" placeholder="Enter Occupation (School/College/Profession)"><?php echo set_value('occupation');?></textarea>
									<font color="red"><?=form_error("occupation");?></font>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">	
								<div class="col-lg-4 col-md-12">
									<label contenteditable="true" class="form-control">Which first program did you attend at Oasis</label>
									<select name="first_program" class="form-control program_list">
										<option></option>
										<option value="Dream India Camp">Dream India Camp</option>
										<option value="Life Camp">Life Camp</option>
										<option value="Hakkal">Hakkal</option>
										<option value="L-L-L Camps">L-L-L Camps</option>
										<option value="AKT Sessions">AKT Sessions</option>
										<option value="Sunday Sessions">Sunday Sessions</option>
										<option value="Freedom Parenting Workshops">Freedom Parenting Workshops</option>
									</select>	
									<font color="red"><?=form_error("first_program");?></font>
								</div>
								<div class="col-lg-4 col-md-12">
									<label contenteditable="true" class="form-control">When (Month, Year)</label>
									<input type="text" name="when" class="form-control" placeholder="Enter When (Month, Year)" value="<?php echo set_value('when');?>">
									<font color="red"><?=form_error("when");?></font>
								</div>
								<div class="col-lg-4 col-md-12">
									<label contenteditable="true" class="form-control">Total number of Oasis programs attended so far</label>
									<input type="number" name="programs_attended" class="form-control" placeholder="Enter Total number of Oasis programs attended so far" value="<?php echo set_value('programs_attended');?>" min="0">
									<font color="red"><?=form_error("programs_attended");?></font>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">	
								<div class="col-lg-12 col-md-12">
									<label contenteditable="true" class="form-control">Give Details of Programs</label>
									<textarea name="program_detail" class="form-control" placeholder="Enter Give Details of Programs"><?php echo set_value('program_detail');?></textarea>
									<font color="red"><?=form_error("program_detail");?></font>
								</div>
							</div>
						</div> 
						<div class="form-group">
							<div class="row">	
								<div class="col-lg-12 col-md-12">
							 		<p  class="btn btn-primary col-lg-12"><b>Evaluation:</b> Read Parameters for Evaluation along with its description and related questions. Rate each parameter by writing a figure between 1 & 10 against it. 1 indicates the characteristics at<br/> lowest level while 10 indicates it at highest level. Please write proportionate figure between 2 to 9 as per intermediate stage.</p>
								</div>	
							</div>
						</div>	
						<!--Table Content-->
						<div class="form-group">
							<div class="row">	
								<div class="col-lg-12 col-md-12">
							 		<div class="table-responsive">
										<table class="table table-striped table-bordered text-center myTable" >
											<thead>
												<tr><th colspan="4" class="survey_topic">Rating of Parameters</th></tr>
												<tr class="table_content_height">
													<th class="content_value_align">Sr No</th>
													<th class="content_value_align">Parameter / Characteristics</th>
													<th class="content_value_align">Brfore Oasis Program</th>
													<th class="content_value_align">Status at Present</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<th colspan="4" class="survey_topic">A Personal</th>
												</tr>	
												<tr>
													<td>1</td>
													<td class="survery_parameter">
														<table class="text-wrap">
															<tr>
																<td class="trait_survey"><p class="survey_line1">Self Confidence</p></td>
																<td class="trait_survey"><p class="survey_line2">(Expressions, Courage, Enthusiasm)</p></td>
																<td class="trait_survey"><p class="survey_line3">Has your self confidence increased by becoming become more courageous,enthusiastic and expressive in life?</p></td>
															</tr>
														</table>
													</td>
													<td><input type="text" class="form-control" name="self_conf_program" value="<?php echo set_value('self_conf_program');?>" placeholder="Enter Before Oasis programs"></td>
													<td><input type="text" class="form-control" name="self_conf_status" value="<?php echo set_value('self_conf_status');?>" placeholder="Status at present"></td>
												</tr>
												<tr>
													<td>2</td>
													<td class="survery_parameter">
														<table class="text-wrap">
															<tr>
																<td class="trait_survey"><p class="survey_line1">Happiness</p></td>
																<td class="trait_survey"><p class="survey_line2">(Responsibility, Gratitude, Forgiveness)</p></td>
																<td class="trait_survey"><p class="survey_line3">Are you generally more happy because of accepting more responsibility of life, being more grateful and forgiving?</p></td>
															</tr>
														</table>
													</td>
													<td><input type="text" class="form-control" name="happiness_program" value="<?php echo set_value('happiness_program');?>" placeholder="Enter Before Oasis programs"></td>
													<td><input type="text" class="form-control" name="happiness_status" value="<?php echo set_value('happiness_status');?>" placeholder="Status at present"></td>									
												</tr>
												<tr>
													<td>3</td>
													<td class="survery_parameter">
														<table class="text-wrap">
															<tr>
																<td class="trait_survey"><p class="survey_line1">Idealism</p></td>
																<td class="trait_survey"><p class="survey_line2">(Thoughts/Values, Habits, Optimism)</p></td>
																<td class="trait_survey"><p class="survey_line3">Have you become more positive and idealistic in life that is reflected in your daily habits and life choices?</p></td>
															</tr>
														</table>
													</td>
													<td><input type="text" class="form-control" name="idealisam_program" value="<?php echo set_value('idealisam_program');?>" placeholder="Enter Before Oasis programs"></td>
													<td><input type="text" class="form-control" name="idealisam_status" value="<?php echo set_value('idealisam_status');?>" placeholder="Status at present"></td>	
												</tr>
												<tr>
													<td>4</td>
													<td class="survery_parameter">
														<table class="text-wrap">
															<tr>
																<td class="trait_survey"><p class="survey_line1">Learning</p></td>
																<td class="trait_survey"><p class="survey_line2">(Inquisitive, Perspectives, Humility)</p></td>
																<td class="trait_survey"><p class="survey_line3">Do you try to ask questions, always try to understand other perspectives and eager to learn continuously?</p></td>
															</tr>
														</table>
													</td>
													<td><input type="text" class="form-control" name="learning_program" value="<?php echo set_value('learning_program');?>" placeholder="Enter Before Oasis programs"></td>
												</tr>
												<tr>
													<th colspan="4" class="survey_topic">B Academic/Professional</th>
												</tr>	
												<tr>
													<td>5</td>
													<td class="survery_parameter">
														<table class="text-wrap">
															<tr>
																<td class="trait_survey"><p class="survey_line1">Grit</p></td>
																<td class="trait_survey"><p class="survey_line2">(Mistakes, Failures, Perseverance)</p></td>
																<td class="trait_survey"><p class="survey_line3">Has your persistence and attitude towards mistake and failures improved?</p></td>
															</tr>
														</table>
													</td>
													<td><input type="text" class="form-control" name="grit_program" value="<?php echo set_value('grit_program');?>" placeholder="Enter Before Oasis programs"></td>
													<td><input type="text" class="form-control" name="grit_status" value="<?php echo set_value('grit_status');?>" placeholder="Status at present"></td>	
												</tr>
												<tr>
													<td>6</td>
													<td class="survery_parameter">
														<table class="text-wrap">
															<tr>
																<td class="trait_survey"><p class="survey_line1">Giving</p></td>
																<td class="trait_survey"><p class="survey_line2">(Self-reliance, Service, Contribution)</p></td>
																<td class="trait_survey"><p class="survey_line3">Have you become more independent and more interested in giving back to the world with the spirit of service?</p></td>
															</tr>
														</table>
													</td>
													<td><input type="text" class="form-control" name="giving_program" value="<?php echo set_value('giving_program');?>" placeholder="Enter Before Oasis programs"></td>
													<td><input type="text" class="form-control" name="giving_status" value="<?php echo set_value('giving_status');?>" placeholder="Status at present"></td>	
												</tr>
												<tr>
													<td>7</td>
													<td class="survery_parameter">
														<table class="text-wrap">
															<tr>
																<td class="trait_survey"><p class="survey_line1">Dreams</p></td>
																<td class="trait_survey"><p class="survey_line2">(Awareness, Aspirations, Goals)</p></td>
																<td class="trait_survey"><p class="survey_line3">Have you found your dreams in line with your talents and strengths and do you feel inspired to achieve them?</p></td>
															</tr>
														</table>
													</td>
													<td><input type="text" class="form-control" name="dreams_program" value="<?php echo set_value('dreams_program');?>" placeholder="Enter Before Oasis programs"></td>
													<td><input type="text" class="form-control" name="dreams_status" value="<?php echo set_value('dreams_status');?>" placeholder="Status at present"></td>	
												</tr>
												<tr>
													<td>8</td>
													<td class="survery_parameter">
														<table class="text-wrap">
															<tr>
																<td class="trait_survey"><p class="survey_line1">Leadership</p></td>
																<td class="trait_survey"><p class="survey_line2">(Conscientious, Citizen, Solutions)</p></td>
																<td class="trait_survey"><p class="survey_line3">Do you think what is right thing to do more often, interested in finding solutions and being responsible citizen?</p></td>
															</tr>
														</table>
													</td>
													<td><input type="text" class="form-control" name="leadership_program" value="<?php echo set_value('leadership_program');?>" placeholder="Enter Before Oasis programs"></td>
													<td><input type="text" class="form-control" name="leadership_status" value="<?php echo set_value('leadership_status');?>" placeholder="Status at present"></td>
												</tr>
												<tr>
													<th colspan="4" class="survey_topic">C Relationships</th>
												</tr>	
												<tr>
													<td>9</td>
													<td class="survery_parameter">
														<table class="text-wrap">
															<tr>
																<td class="trait_survey"><p class="survey_line1">Trustworthiness</p></td>
																<td class="trait_survey"><p class="survey_line2">(Sensitive, Honesty, Integrity)</p></td>
																<td class="trait_survey"><p class="survey_line3">Do people in your relationship perceive you as more sensitive and trustworthy person?</p></td>
															</tr>
														</table>
													</td>
													<td><input type="text" class="form-control" name="trustworth_program" value="<?php echo set_value('trustworth_program');?>" placeholder="Enter Before Oasis programs"></td>
													<td><input type="text" class="form-control" name="trustworth_status" value="<?php echo set_value('trustworth_status');?>" placeholder="Status at present"></td>	
												</tr>
												<tr>
													<td>10</td>
													<td class="survery_parameter">
														<table class="text-wrap">
															<tr>
																<td class="trait_survey"><p class="survey_line1">Love</p></td>
																<td class="trait_survey"><p class="survey_line2">(Being, Evolution, Friendship)</p></td>
																<td class="trait_survey"><p class="survey_line3">Have you become a more loving, respecting and growing as a human being?</p></td>
															</tr>
														</table>
													</td>
													<td><input type="text" class="form-control" name="love_program" value="<?php echo set_value('love_program');?>" placeholder="Enter Before Oasis programs"></td>
													<td><input type="text" class="form-control" name="love_status" value="<?php echo set_value('love_status');?>" placeholder="Status at present"></td>		
												</tr>
												<tr>
													<td>11</td>
													<td class="survery_parameter">
														<table class="text-wrap">
															<tr>
																<td class="trait_survey"><p class="survey_line1">Compassion</p></td>
																<td class="trait_survey"><p class="survey_line2">(Listening, Understanding, Kindness)</p></td>
																<td class="trait_survey"><p class="survey_line3">In your interactions, do you listen and understand people more than before and are you more kind to them?</p></td>
															</tr>
														</table>
													</td>
													<td><input type="text" class="form-control" name="compassion_program" value="<?php echo set_value('compassion_program');?>" placeholder="Enter Before Oasis programs"></td>
													<td><input type="text" class="form-control" name="compassion_status" value="<?php echo set_value('compassion_status');?>" placeholder="Status at present"></td>	
												</tr>
												<tr>
													<td>12</td>
													<td class="survery_parameter">
														<table class="text-wrap">
															<tr>
																<td class="trait_survey"><p class="survey_line1">Cooperation</p></td>
																<td class="trait_survey"><p class="survey_line2">(Helping, Sacrificing, Synergistic)</p></td>
																<td class="trait_survey"><p class="survey_line3">When working with others and in team, do you think of how to help, respect strengths of others and if necessary, sacrifice for the cause?</p></td>
															</tr>
														</table>
													</td>
													<td><input type="text" class="form-control" name="cooperation_program" value="<?php echo set_value('cooperation_program');?>" placeholder="Enter Before Oasis programs"></td>
													<td><input type="text" class="form-control" name="cooperation_status" value="<?php echo set_value('cooperation_status');?>" placeholder="Status at present"></td>	
												</tr>
												<tr>
													<td></td>
													<td class="survey_line1">TOTAL</td>
													<td></td>
													<td></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>	
							</div>
						</div>	
						<?php /* include('dynamic_field_generation.php');?>
						<hr/>
						<div class="form-group"  style="float:right;">
							<div class="row">
								<input type="submit" name="submit" value="Submit" class="btn btn-app btn-primary mr-2 mt-1 mb-1">
							</div>
						</div> */ ?>
						<div id="add_fields_form" style="display:none;">
							<form id="impact_on_character_traits_form" name="impact_on_character_traits_form" method="post" action="<?php echo base_url('master/impact_on_character_traits_form');?>">
	                           <?php //include('dynamic_field_generation.php');?>
	                           	<div id="dynamic_form_fields"></div>
								<div class="form-group"  style="float:right;">
									<div class="row">
										<input type="submit" name="submit" value="Submit" class="btn btn-app btn-primary mr-2 mt-1 mb-1">
										<input type="button" name="cancel" value="Cancel" class="btn btn-app btn-primary mr-2 mt-1 mb-1" onclick="cancelAddNew();">
									</div>
								</div>	
							</form>
						</div>
						<input type="button" name="add_new_field" value="Add New Fields" class="btn btn-app btn-primary mr-2 mt-1 mb-1" onclick="AddNewField();" />	
					</div>
				</div>
			</div>
		</div>
		<!-- row end -->
	</div>
	<div id="file_extension" style="display:none;"><?php echo getFileExtensionOptions(); ?></div>
<?php include("footer.php"); ?>
<?php include("add_dynamic_field_form.php"); ?>
<script type="text/javascript">
	var total_characteristics='<?php echo count($parameter_or_characteristics_list); ?>';
	$(document).ready(function(){
		$('.monthyear').mask("99, 9999");
		getBeforeOasisTotal();
		getStatusAtPresentTotal();
	});
	function getBeforeOasisTotal(){
		var total=0;
		$('.before_oasis_cls').each(function(){
			total=parseInt(total)+parseInt($(this).val());
		});
		$('#total_before_oasis').html(total+'/'+(total_characteristics*10));
	}
	function getStatusAtPresentTotal(){
		var total=0;
		$('.status_at_present_cls').each(function(){
			total=parseInt(total)+parseInt($(this).val());
		});
		$('#total_status_at_present').html(total+'/'+(total_characteristics*10));
	}
	$('#impact_on_character_traits_form').validate();
</script>