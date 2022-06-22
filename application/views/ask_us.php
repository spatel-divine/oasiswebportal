<?php include("header.php");?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Ask Us</a></li>
				<li class="breadcrumb-item active" aria-current="page">View Queries/Suggestions List</li>
			</ol><!-- End breadcrumb -->
		</div>
		<!-- End page-header -->
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
		<!-- row -->
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="example2" class="table table-striped table-bordered text-wrap" >
						<thead>
							<tr>
								<th>Name</th>
								<th>Queries</th>
								<th>Suggestions</th>
								<th>Opinions</th>
								<th>Time Contribution For</th>
								<th>Request Date</th>
								<th>Response Date</th>
								<th style="width:20px;">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if(isset($requestlist) && $requestlist){
								foreach($requestlist as $request){ 
									$id="";
									$rowid="row";
									if(isset($request->id) && $request->id!='' && $request->id!=null){
										$id.=base64_encode($request->id);
										$rowid.=base64_encode($request->id);
									}
								?>
								<tr id="<?php echo $rowid; ?>">
									<td>
										<?php if(isset($request->fullname) && $request->fullname!='' && $request->fullname!=null){
											echo $request->fullname;
										}else{
											echo '-';
										} ?>
									</td>
									<td>
										<?php if(isset($request->queries) && $request->queries!='' && $request->queries!=null){
											echo $request->queries;
										}else{
											echo '-';
										} ?>
									</td>
									<td>
										<?php if(isset($request->opinion) && $request->opinion!='' && $request->opinion!=null){
											echo $request->opinion;
										}else{
											echo '-';
										} ?>
									</td>
									<td>
										<?php if(isset($request->suggestions) && $request->suggestions!='' && $request->suggestions!=null){
											echo $request->suggestions;
										}else{
											echo '-';
										} ?>
									</td>
									<td>
										<?php if(isset($request->time_contribution_for) && $request->time_contribution_for!='' && $request->time_contribution_for!=null){
											echo $request->time_contribution_for;
										}else{
											echo '-';
										} ?>
									</td>
									<td>
										<?php if(isset($request->request_date) && $request->request_date!='' && $request->request_date!=null){
											echo date('d-m-Y',strtotime($request->request_date));
										}else{
											echo '-';
										} ?>
									</td>
									<td>
										<?php if(isset($request->response_date) && $request->response_date!='' && $request->response_date!=null){
											echo date('d-m-Y',strtotime($request->response_date));
										}else{
											echo '-';
										} ?>
									</td>	
									<td >
										<?php if(isset($request->response_date) && $request->response_date!='' && $request->response_date!=null){ ?>
											<input type="button" class="fa fa-edit btn btn-primary" data-toggle="modal" data-target="#viewResponseModel" value="View Response" onclick="viewRequest('<?php echo $id; ?>');">
										<?php }else{ ?>
											<input type="button" class="fa fa-edit btn btn-primary" data-toggle="modal" data-target="#giveResponseModel" value="Give Response" onclick="fetchRequest('<?php echo $id; ?>');">
										<?php } ?>
									</td>								
								</tr>
							<?php }
							}else{
								echo '<tr><td colspan=7>No Record Available</td></tr>';
							}
							?>
							<!-- Give Response Modal -->
							<div id="giveResponseModel" class="modal fade">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content ">
										<div class="modal-header pd-x-20">
											<h4 class="modal-title"><b>Give Response</b></h4>
											<input type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
										</div>
										<div class="modal-body pd-20">
											<form id="request_form" name="request_form" method="post" action="<?php echo base_url('connectOM/ask_us'); ?>" >
												<?php /* <div class="form-group">
													<div class="row">
														<div class="col-lg-6 col-md-12">
															<label>Name</label>
															<input type="text" class="form-control" value="<?php echo set_value('name');?>" readonly>
														</div>
														<div class="col-lg-6 col-md-12">
															<label>Date Received</label>
															<input type="text" class="form-control" value="<?php echo set_value('date_received');?>" readonly>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-lg-4 col-md-12">
															<label>Queries</label>
															<textarea class="form-control" readonly><?php echo set_value('question');?></textarea>
														</div>
														<div class="col-lg-4 col-md-12">
															<label>Opinion</label>
															<textarea class="form-control" readonly><?php echo set_value('opinion');?></textarea>
														</div>
														<div class="col-lg-4 col-md-12">
															<label>Suggestions</label>
															<textarea class="form-control" readonly><?php echo set_value('suggestions');?></textarea>
														</div>
													</div>
												</div> */ ?>
												<?php /* <div class="form-group">
													<div class="row">
														<div class="col-lg-6 col-md-12">
															<label>Name</label>
															<input type="text" class="form-control" value="" readonly>
														</div>
														<div class="col-lg-6 col-md-12">
															<label>Date Received</label>
															<input type="text" class="form-control" value="" readonly>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-lg-4 col-md-12">
															<label>Queries</label>
															<textarea class="form-control" readonly></textarea>
														</div>
														<div class="col-lg-4 col-md-12">
															<label>Opinion</label>
															<textarea class="form-control" readonly></textarea>
														</div>
														<div class="col-lg-4 col-md-12">
															<label>Suggestions</label>
															<textarea class="form-control" readonly></textarea>
														</div>
													</div>
												</div>
												<div class="form-group">
													<div class="row">
														<div class="col-lg-12 col-md-12">
															<label>Give Response</label>
															<textarea class="form-control" name="response_data" placeholder="Enter Your Response"><?php echo set_value('response_data');?></textarea>
														</div>
													</div>
												</div>	
												<hr/>
												<div class="form-group"  style="float:right;">
													<div class="row">
														<input type="submit" name="submit" value="Submit" class="btn btn-app btn-primary mr-2 mt-1 mb-1" >
													</div>
												</div> */ ?>
											</form>	
										</div><!-- modal-body -->
									</div>
								</div><!-- modal-dialog -->
							</div><!-- modal -->
							<!-- View Response Modal -->
							<div id="viewResponseModel" class="modal fade">
								<div class="modal-dialog modal-lg" role="document">
									<div class="modal-content ">
										<div class="modal-header pd-x-20">
											<h4 class="modal-title"><b>View Response</b></h4>
											<input type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
										</div>
										<div id="view_request_html" class="modal-body pd-20">
										</div><!-- modal-body -->
									</div>
								</div><!-- modal-dialog -->
							</div><!-- modal -->
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php include("footer.php"); ?>
<script type="text/javascript">
	function fetchRequest(id){
		$.ajax({
			type:'POST',
			url:"<?php echo site_url('connectOM/ajax_fetch_request_by_id'); ?>",
			data:'id='+id,
			success:function(response){
				if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
					window.location.assign(response.notvaliduserurl);
				}else if(response.hasOwnProperty('request_html') && response.request_html){
					$('#request_form').html(response.request_html);
				}
			}
		});
	}
	function viewRequest(id){
		$.ajax({
			type:'POST',
			url:"<?php echo site_url('connectOM/ajax_view_request_by_id'); ?>",
			data:'id='+id,
			success:function(response){
				if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
					window.location.assign(response.notvaliduserurl);
				}else if(response.hasOwnProperty('view_request_html') && response.view_request_html){
					$('#view_request_html').html(response.view_request_html);
				}
			}
		});
	}
	$('#request_form').validate();
</script>