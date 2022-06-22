<?php include("header.php");?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Active/Deactive</a></li>
				<li class="breadcrumb-item active" aria-current="page">Active/Deactivate User</li>
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
					<form id="active_deactive_user" name="active_deactive_user" method="post" action="<?php echo base_url('management/active_deactive_user'); ?>">
						<div class="card-body">
							<div class="form-group">
								<div class="row">				
									<div class="col-lg-6 col-md-12">
										<label>User <font color="red">*</font></label>
										<select id="user" name="user" class="form-control select2" required data-msg-required="Please Select User">
										    <option value="">Select User</option>
											<?php
												if(isset($users) && $users){
													foreach ($users as $user){ ?>
														<option value="<?php echo $user->id; ?>" <?php if(isset($_POST['user']) && $_POST['user'] && $_POST['user']==$user->id){ echo 'selected'; } ?> ><?php echo $user->full_name; ?></option>
											<?php 	}
												} 
											?> 
										</select>
										<label id="user-error" class="error validationerror" for="user"><?=form_error("user");?></label>	
									</div>
									<div class="col-lg-6 col-md-12">
										<label>Date <font color="red">*</font></label>
										<div class="wd-200 mg-b-30">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">
														<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
													</div>
												</div>
												<input class="form-control" id="active_deactive_date" autocomplete="off" placeholder="Enter Date" type="text" name="active_deactive_date"  value="<?php echo date('d-m-Y'); ?>" required data-msg-required="Please Select Date" readonly>
											</div>
										</div>
										<label id="active_deactive_date-error" class="error validationerror" for="active_deactive_date"><?=form_error("active_deactive_date");?></label>
									</div>
								</div>
							</div>		
							<div class="form-group">
								<div class="row">				
									<div class="col-lg-6 col-md-12">
										<label>Reason Type <font color="red">*</font></label>
										<!--<select name="reason_type" class="form-control">
											<option value="">Select Reason Type</option>
											<option value="You are looking for a new challenge.">You are looking for a new challenge.</option>
											<option value="You Are Looking for Opportunities to Progress">You Are Looking for Opportunities to Progress</option>
										</select>-->
										<input type="text" id="active_deactive_reason_type" name="active_deactive_reason_type" class="form-control" placeholder="Enter Reason Type" value="<?php echo set_value('active_deactive_reason_type'); ?>" required data-msg-required="Enter Reason Type">
										<label id="active_deactive_reason_type-error" class="error validationerror" for="active_deactive_reason_type"><?=form_error("active_deactive_reason_type");?></label>
									</div>
									<div class="col-lg-6 col-md-12">
										<label>Reason <font color="red">*</font></label>
										<textarea id="active_deactive_reason" name="active_deactive_reason" class="form-control" placeholder="Enter Reason" required  data-msg-required="Enter Reason"><?php echo set_value('active_deactive_reason'); ?></textarea>
										<label id="active_deactive_reason-error" class="error validationerror" for="active_deactive_reason"><?=form_error("active_deactive_reason");?></label> 
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">				
									<div class="col-lg-12 col-md-12">
										<div class="form-group form-elements">
											<label>Active / Deactive <font color="red">*</font></label>
											<div class="custom-controls-stacked">
												<label class="custom-control custom-radio">
													<input type="radio" class="custom-control-input" name="is_active" value="1" required data-msg-required="Please Select Active/Deactive" <?php if(isset($_POST['is_active']) && $_POST['is_active']==1){ echo 'checked'; } ?>>
													<span class="custom-control-label text-dark">Active</span>
												</label>
												<label class="custom-control custom-radio">
													<input type="radio" class="custom-control-input" name="is_active" value="0" required data-msg-required="Please Select Active/Deactive" <?php if(isset($_POST['is_active']) && $_POST['is_active']==0){ echo 'checked'; } ?>>
													<span class="custom-control-label text-dark">Deactive</span>
												</label>
												<label class="custom-control custom-radio">
													<input type="radio" class="custom-control-input" name="is_active" value="2" required data-msg-required="Please Select Active/Deactive" <?php if(isset($_POST['is_active']) && $_POST['is_active']==2){ echo 'checked'; } ?>>
													<span class="custom-control-label text-dark">Delete</span>
												</label>
											</div>
										</div>
										<label id="is_active-error" class="error validationerror" for="is_active"><?=form_error("is_active");?></label>
									</div>
								</div>
								<label id="has_error" class="error validationerror"></label>
								<input type="hidden" id="old_is_active" name="old_is_active" />
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
		</div>
		<!-- row end -->
	</div>
	<script type="text/javascript">
		$('#user').on('change',function(){
			var user_id=$(this).val();
			if(user_id){
				$.ajax({
					type:'POST',
					url:"<?php echo site_url('usersMst/ajax_get_user_by_id'); ?>",
					data:'user_id='+user_id,
					success:function(response){
						if(response.hasOwnProperty('is_active') && response.is_active){
							$("input[name=is_active][value='"+response.is_active+"']").prop('checked', true);
							$("#old_is_active").val(response.is_active);
						}
					}
				});
			}else{
				$('input[name="is_active"]').prop('checked', false);
				$("#old_is_active").val('');
			}
		});
		$('#active_deactive_user').validate();
		$('#active_deactive_user').submit(function() {
			$('#has_error').text("");
			var old_is_active=$('#old_is_active').val();
			var is_active=$("input[name='is_active']:checked").val();
			if(old_is_active!='' && old_is_active==is_active){
				$('#has_error').fadeIn(0);
				$('#has_error').text("Sorry, can not update as 'Active / Deactive' status is same as previous.");
				return false; // return false to cancel form action
			}else{
				return true;
			}
		});
	</script>
<?php include("footer.php");?>