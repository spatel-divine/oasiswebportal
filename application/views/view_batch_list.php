<?php include("header.php");?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Batch</a></li>
				<li class="breadcrumb-item active" aria-current="page">View Batch List</li>
			</ol><!-- End breadcrumb -->
			<div class="ml-auto">
				<div class="input-group">
					<a href="<?php echo site_url('Management/add_batch/')?>" class="btn btn-secondary text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add New">
						<span>
							<i class="fa fa-plus"></i>&nbsp;Add New Batch
						</span>
					</a>
				</div>
			</div>
		</div>
		<!-- End page-header -->
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<?php
					if($this->session->flashdata('message')){
						echo '<div class="alert alert-success"><font color="white"><b><a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:#fff;">&times;</a>
							'.$this->session->flashdata("message").'
						</b></font></div>';
					}
				?>
				<div class="card">
					<form id="search_batch" name="search_batch" method="post" class="submitform" action="<?php echo base_url('management/ajax_get_batchlist_by_date');?>">
						<div class="card-body">
							<div class="form-group">
								<div class="row">	
									<div class="col-lg-5 col-md-12">
										<label>Start Date <font color="red">*</font></label>
										<div class="wd-200 mg-b-30">
											<div class="input-group">
												<div class="input-group-prepend">
														<div class="input-group-text">
															<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
														</div>
												</div>
												<input class="form-control" id="datepicker0" autocomplete="off" placeholder="Start Date" type="text" name="start_date" required data-msg-required="Please Select Start Date">

											</div>
										</div>
										<label id="datepicker0-error" class="error validationerror" for="datepicker0"><?=form_error("start_date");?></label>
									</div>
									<div class="col-lg-5 col-md-12">
										<label>End Date <font color="red">*</font></label>
										<div class="wd-200 mg-b-30">
											<div class="input-group">
												<div class="input-group-prepend">
														<div class="input-group-text">
															<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
														</div>
												</div>
												<input class="form-control" id="datepicker1" autocomplete="off" placeholder="End Date" type="text" name="end_date" value="<?php echo set_value('end_date'); ?>" required data-msg-required="Please Select End Date" data-rule-validEndDate>
											</div>
										</div>
										<label id="datepicker1-error" class="error validationerror" for="datepicker1"><?=form_error("end_date");?></label>
									</div>
									<div class="col-lg-2 col-md-12">
										<input type="submit" name="submit" value="Get Record" class="btn btn-app btn-primary" style="margin-top:28px;width:80%;">
									</div>	
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- row end -->
		<!-- row -->
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="example2" class="table table-striped table-bordered text-nowrap" >
						<thead>
							<tr>
								<th>Program Name</th>
								<th>Batch Name</th>
								<th>Batch Location</th>
								<th>Start Date</th>
								<th>End Date</th>
								<th style="width:20px;">Action</th>
							</tr>
						</thead>
						<tbody id="batchlistdiv">
							<?php if(isset($batch_list) && $batch_list){ 
								foreach ($batch_list as $batch){ ?>
									<tr>
										<td>
											<?php if(isset($batch->program_name) && $batch->program_name!='' && $batch->program_name!=null){ 
												echo ucfirst($batch->program_name);
											}else{
												echo 'N/A';
											} ?>
										</td>
										<td>
											<?php if(isset($batch->batch_name) && $batch->batch_name!='' && $batch->batch_name!=null){ 
												echo ucfirst($batch->batch_name);
											}else{
												echo 'N/A';
											} ?>
										</td>
										<td>
											<?php if(isset($batch->location) && $batch->location!='' && $batch->location!=null){ 
												echo $batch->location;
											}else{
												echo 'N/A';
											} ?>
										</td>
										<td>
											<?php if(isset($batch->start_date) && $batch->start_date!='' && $batch->start_date!=null){ 
												echo date('d-m-Y',strtotime($batch->start_date));
											}else{
												echo 'N/A';
											} ?>
										</td>
										<td>
											<?php if(isset($batch->end_date) && $batch->end_date!='' && $batch->end_date!=null){ 
												echo date('d-m-Y',strtotime($batch->end_date));
											}else{
												echo 'N/A';
											} ?>
										</td>
										<td  style="width:20px;">
											<a class="btn btn-secondary btn-sm" href="<?php echo site_url('management/add_batch/'.base64_encode($batch->id)); ?>"><i class="fa fa-edit"></i> Edit</a>&nbsp;
											<a class="btn btn-secondary btn-sm" onclick="deleteBatch('<?php echo base64_encode($batch->id); ?>');" href="javascript:void(0);"><i class="fa fa-delete"></i> Delete</a>
										</td>
									</tr>
							<?php }

							} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<script type="text/javascript">
	function deleteBatch(id){
		var res=confirm("Are you sure that you want to delete this record?");
		if(res){
			var url="<?php echo site_url('management/delete_batch/'); ?>"+id;
			window.location.assign(url);
		}
		return false;
	}
	$.validator.addMethod("validEndDate",function(value, element, param){
		var sdate = $("#datepicker0").val();
		var edate = $("#datepicker1").val();
		if(edate<sdate){
			return false;
		}
		return true;
	},"End Date must be greater than Start Date.");
	$('#search_batch').validate();
	$(".submitform").on('submit',function(event){
		/* stop form from submitting normally */
  		event.preventDefault();
  		/* get the action attribute from the <form action=""> element */
  		var form = $(this),
    	url = form.attr('action');
    	postData =form.serialize();
    	$.ajax({
            type: "post",
            url: url,
            data: postData,
            beforeSend: function(){
               	if ($.fn.DataTable.isDataTable('#example2')) {
                 	$('#example2').DataTable().destroy();
                }
            },
            success: function(response){
            	if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
					$('#closebtn').trigger('click');
					window.location.assign(response.notvaliduserurl);
				}else if(response.hasOwnProperty('batchlisthtml')){
                	$('#batchlistdiv').html(response.batchlisthtml);
                }
            },
            complete: function(){
              	initResultDataTable();
            }
        });
	});
</script>
<?php include("footer.php");?>