<?php include("header.php");?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Review Form</a></li>
				<li class="breadcrumb-item active" aria-current="page">Program Feedback by Participants List</li>
			</ol><!-- End breadcrumb -->
			<div class="ml-auto">
				<div class="input-group">
					<a href="<?php echo site_url('Master/program_feedback_by_participant_form'); ?>" class="btn btn-secondary text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add New">
						<span>
							<i class="fa fa-plus"></i>&nbsp;Program Feedback by Participan
						</span>
					</a>
				</div>
			</div>
		</div>
		<!-- End page-header -->
		<!-- row -->
		<div id="success_message_block"></div>
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
				<label class="lbl-note">Note: Some fields are default. Those fields can not be editable or deletable.</label>
				<div class="table-responsive">
					<table id="example2" class="table table-striped table-bordered text-nowrap" >
						<thead>
							<tr>
								<th>Sequence No</th>
								<th>Field Label</th>
								<th>Field Type</th>
								<th>Is Required?</th>
								<th>Status</th>
								<th>Update At</th>
								<th style="width:20px;">Action</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							if($feedback_by_participants_list){
								foreach($feedback_by_participants_list as $feedback_by_participants){
						?>
							<tr id="row<?php echo base64_encode($feedback_by_participants->id); ?>">
								<td>
									<?php if(isset($feedback_by_participants->sequence_no) && $feedback_by_participants->sequence_no!='' && $feedback_by_participants->sequence_no!=null){ 
										echo $feedback_by_participants->sequence_no; 
									}else{ 
										echo 'N/A'; 
									} ?>
								</td>
								<td>
									<?php if(isset($feedback_by_participants->field_label) && $feedback_by_participants->field_label!='' && $feedback_by_participants->field_label!=null){ 
										echo $feedback_by_participants->field_label; 
									}else{ 
										echo 'N/A'; 
									} ?>
								</td>
								<td>
									<?php if(isset($feedback_by_participants->field_type) && $feedback_by_participants->field_type!='' && $feedback_by_participants->field_type!=null){ 
										echo ucfirst($feedback_by_participants->field_type); 
									}else{ 
										echo 'N/A'; 
									} ?>
								</td>
								<td>
									<?php if(isset($feedback_by_participants->is_required) && $feedback_by_participants->is_required==1){ 
										echo 'Yes'; 
									}else{ 
										echo 'No'; 
									} ?>
								</td>
								<td>
									<?php if(isset($feedback_by_participants->is_active) && $feedback_by_participants->is_active==1){ 
										echo 'Active'; 
									}else{ 
										echo 'Inactive'; 
									} ?>
								</td>
								<td>
									<?php if(isset($feedback_by_participants->updated_at) && $feedback_by_participants->updated_at!='' && $feedback_by_participants->updated_at!=null){ 
										echo date('d-m-Y',strtotime($feedback_by_participants->updated_at)); 
									}else{ 
										echo 'N/A'; 
									} ?>
								</td>
								<td style="width:20px;">
									<?php if(isset($feedback_by_participants->is_default) && $feedback_by_participants->is_default==1){  ?>
										<a class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#editField" href="javascript:void(0);" style="cursor:not-allowed;">No Action Needed</a>
									<?php }else{ ?>
										<a class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#editField" href="javascript:void(0);" onclick="getDynamicFormFieldData('<?php echo base64_encode($feedback_by_participants->id); ?>');"><i class="fa fa-edit"></i> Edit</a>&nbsp;
										<a class="btn btn-secondary btn-sm" onclick="deleteDynamicField('<?php echo base64_encode($feedback_by_participants->id); ?>');" href="javascript:void(0);"><i class="fa fa-delete"></i> Delete</a>
									<?php } ?>
								</td>										
							</tr>
						<?php 	}										
							}	?>											
						</tbody>
					</table>
					<div class="modal fade" id="editField" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
						<div class="modal-dialog modal-md" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLongTitle">Edit</h5>
									<input id="closebtn" type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
								</div>
								<div class="modal-body">
									<form id="edit_field_form" name="edit_field_form" method="post" action="<?php echo base_url('master/ajax_update_dynamic_field'); ?>" >
										<div class="card-body">
											<div class="form-group">
												<div class="row">
													<div class="col-lg-6 col-md-12">
														<label>Sequence No <font color="red">*</font></label>
														<input type="number" class="form-control" id="sequence_no" name="sequence_no" value="<?php if(isset($row->sequence_no) && $row->sequence_no!='' && $row->sequence_no!=null){ echo $row->sequence_no; } ?>" placeholder="Enter Sequence No" required data-msg-required="Enter Sequence No">
														<label id="sequence_no-error" class="error validationerror" for="sequence_no"><?=form_error("sequence_no");?></label>
													</div>
													<div class="col-lg-6 col-md-12">
														<label>Field Name <font color="red">*</font></label>
														<input type="text" class="form-control" id="field_name" name="field_name" value="<?php if(isset($row->field_name) && $row->field_name!='' && $row->field_name!=null){ echo $row->field_name; } ?>" placeholder="Enter Field Name" required data-msg-required="Enter Field Name">
														<label id="field_name-error" class="error validationerror" for="field_name"><?=form_error("field_name");?></label>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="row">
													<div class="col-lg-6 col-md-12">
														<label>Required or Not <font color="red">*</font></label>
														<select id="is_required" name="is_required" class="form-control" required data-msg-required="Please Select required or not">
															<option value="">--Select--</option>
															<option value="1" <?php if(isset($row->is_required) && $row->is_required==1){ echo 'selected';} ?>>Required</option>
															<option value="0" <?php if(isset($row->is_required) && $row->is_required==0){ echo 'selected';} ?>>Not Required</option>
														</select>
														<label id="is_required-error" class="error validationerror" for="is_required"><?=form_error("is_required");?></label>
													</div>
													<div class="col-lg-6 col-md-12">
														<label>Status <font color="red">*</font></label>
														<select id="is_active" name="is_active" class="form-control" required data-msg-required="Please Select Status">
															<option value="">--Select--</option>
															<option value="1" <?php if(isset($row->is_active) && $row->is_active==1){ echo 'selected';} ?>>Active</option>
															<option value="0" <?php if(isset($row->is_active) && $row->is_active==0){ echo 'selected';} ?>>Inactive</option>
														</select>
														<label id="is_active-error" class="error validationerror" for="is_active"><?=form_error("is_active");?></label>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="row">
													<div class="col-lg-6 col-md-12">
														<label>Add Note</label>
														<textarea id="comments" name="comments" class="form-control" placeholder="Enter Add Note"><?php if(isset($row->comments) && $row->comments!='' && $row->comments!=null){ echo $row->comments; } ?></textarea>
													</div>
												</div>
											</div>
											<input type="hidden" id="field_id" name="field_id" value="<?php if(isset($row->id) && $row->id!='' && $row->id!=null){ echo base64_encode($row->id); } ?>">
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
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	function deleteDynamicField(id){
		var res=confirm("Are you sure that you want to delete this record?");
		if(res){
			var url="<?php echo site_url('master/delete_dynamic_field/'); ?>program_feedback_by_participants_form/"+id+'/program_feedback_by_participants_list';
			window.location.assign(url);
		}
		return false;
	}
	function getDynamicFormFieldData(id){
		$.ajax({
			type:'POST',
			url:"<?php echo site_url('master/ajax_get_dynamic_form_field_by_id'); ?>",
			data:'tablename=program_feedback_by_participants_form&id='+id,
			success:function(response){
				if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
					$('#closebtn').trigger('click');
					window.location.assign(response.notvaliduserurl);
				}else if(response.hasOwnProperty('edit_field_html') && response.edit_field_html){
					$('#edit_field_form').html(response.edit_field_html);
					$('.select2').select2({
		    			placeholder: "--Select--",
		    		});
				}
			}
		});
	}
	$('#edit_field_form').validate();
	$('#edit_field_form').on('submit',function(e){
		$('#success_message_block').html('');
		e.preventDefault();
		var form=$(this);
		$.ajax({
			type:'POST',
			url:form.attr("action"),
			data:form.serialize(),
            beforeSend: function(){
               	if ($.fn.DataTable.isDataTable('#example2')){
                 	$('#example2').DataTable().destroy();
                }
            },
			success:function(response){
				if(response.hasOwnProperty('success_message') && response.success_message){
					$('#closebtn').trigger('click');
					$('.alert-success').fadeIn(0);
					$('#success_message_block').html(response.success_message);
					updateDataTableRow(response.rowid,response.updated_data);
				}else{
					if(response.hasOwnProperty('sequence_no') && response.sequence_no){
						$('#sequence_no-error').fadeIn(0);
						$('#sequence_no-error').html(response.sequence_no);
					}
					if(response.hasOwnProperty('field_name') && response.field_name){
						$('#field_name-error').fadeIn(0);
						$('#field_name-error').html(response.field_name);
					}
					if(response.hasOwnProperty('is_required') && response.is_required){
						$('#is_required-error').fadeIn(0);
						$('#is_required-error').html(response.is_required);
					}
					if(response.hasOwnProperty('is_active') && response.is_active){
						$('#is_active-error').fadeIn(0);
						$('#is_active-error').html(response.is_active);
					}
					if(response.hasOwnProperty('max_upload') && response.max_upload){
						$('#max_upload-error').fadeIn(0);
						$('#max_upload-error').html(response.max_upload);
					}
					if(response.hasOwnProperty('file_extension') && response.file_extension){
						$('#file_extension-error').fadeIn(0);
						$('#file_extension-error').html(response.file_extension);
					}
				}
			}
		});
	});
	</script>
<?php include("footer.php");?>