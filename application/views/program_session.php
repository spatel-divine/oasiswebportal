<?php include("header.php"); ?>
<?php	
	if(isset($_POST['program_id'])){
		$program_id = set_value('program_id');	
	}else if(isset($sessiondetails->program_id) && $sessiondetails->program_id!='' && $sessiondetails->program_id!=null){
		$program_id = $sessiondetails->program_id;
	}
	if(isset($_POST['session_name'])){
		$session_name = set_value('session_name');	
	}else if(isset($sessiondetails->session_name) && $sessiondetails->session_name!='' && $sessiondetails->session_name!=null){
		$session_name = $sessiondetails->session_name;
	}
	if(isset($_POST['status'])){
		$status = set_value('status');	
	}else if(isset($sessiondetails->status) && $sessiondetails->status!='' && $sessiondetails->status!=null){
		$status = $sessiondetails->status;
	}
	
?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Program</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php if(isset($sessiondetails->id) && $sessiondetails->id!='' && $sessiondetails->id!=null){ echo 'Edit'; }else{ echo 'Add'; } ?> Session</li>
			</ol><!-- End breadcrumb -->
			<div class="ml-auto">
				<div class="input-group">
					<a href="<?php echo site_url('management/view_session_list')?>" class="btn btn-secondary text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="View Data">
						<span>
							<i class="fa fa-eye"></i>&nbsp;View Session List
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
				<form id="program_session" name="program_session" method="post" action="<?php echo base_url('management/program_session');?>">
					<div class="card-body">
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6 col-md-12">
									<label>Program <font color="red">*</font></label>
									<select id="program_id" name="program_id" class="form-control" required  data-msg-required="Please Select Program">
										<option value="">--Select--</option>
										<?php 
											if($program_list){ 
												foreach($program_list as $program){	
										?>
											<option value="<?php echo $program->id; ?>" <?php if(isset($program_id) && $program_id==$program->id){ echo 'selected';} ?> ><?php echo $program->program_name;?></option>
										<?php }
										} 
										?>
									</select>
									<label id="program_id-error" class="error validationerror" for="program_id"><?=form_error("program_id");?></label>
								</div>
								<div class="col-lg-6 col-md-12">
									<label>Session Name <font color="red">*</font></label>
									<input type="text" class="form-control" id="session_name" name="session_name" value="<?php if(isset($session_name) && $session_name!='' && $session_name!=null){ echo $session_name; } ?>" placeholder="Enter Session Name" required data-msg-required="Enter Session Name">
									<label id="session_name-error" class="error validationerror" for="session_name"><?=form_error("session_name");?></label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-4 col-md-12">
									<label>Status <font color="red">*</font></label>
									<select id="status" name="status" class="form-control" required data-msg-required="Please Select Status">
										<option value="">--Select--</option>
										<option value="1" <?php if(isset($status) && $status!="" && $status==1){ echo 'selected';} ?>>Active</option>
										<option value="0" <?php if(isset($status) && $status!="" && $status==0){ echo 'selected';} ?>>Inactive</option>
									</select>
									<label id="status-error" class="error validationerror" for="status"><?=form_error("status");?></label>
								</div>
							</div>
						</div>
						<input type="hidden" id="session_id" name="session_id" value="<?php if(isset($sessiondetails->id) && $sessiondetails->id!='' && $sessiondetails->id!=null){ echo base64_encode($sessiondetails->id); } ?>">
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
	$("#program_session").validate();
</script>
<?php include("footer.php");?>
