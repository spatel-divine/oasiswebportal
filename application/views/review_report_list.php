<?php include("header.php"); ?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Report</a></li>
				<?php 
				$tname='';
				if(isset($tablename) && $tablename){
					$tname=ucwords(str_replace('_', ' ', $tablename));
				} ?>
				<li class="breadcrumb-item active" aria-current="page"><?php echo $tname; ?> Summary Report</li>
			</ol><!-- End breadcrumb -->
			<div class="ml-auto">
				<div class="input-group">
					<a href="<?php echo site_url('ReviewReport/review_summary_report')?>" class="btn btn-primary text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add New">
						<span>
							<i class="fa fa-arrow-left"></i>&nbsp;Review Summary Report
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
					<form id="review_summary_report" name="review_summary_report" method="post" class="submitform" action="<?php echo base_url('reviewReport/ajax_get_review_summary_report'); ?>" >
						<div class="card-body">
							<div class="form-group">
								<div class="row">
									<div class="col-lg-4 col-md-12">
										<label>Program</label>
										<select id="program_name" name="program_name" class="form-control" >
											<option value="">--Select--</option>
											<?php if(isset($programlist) && $programlist){
												foreach($programlist as $program){ ?>
												<option value="<?php echo $program->program_name; ?>"><?php echo ucfirst($program->program_name); ?></option>
											<?php }
											} ?>
										</select> 
									</div>
									<div class="col-lg-3 col-md-12">
										<label>Session</label>
										<select id="session_id" name="session_id" class="form-control" >
											<option value="">--Select--</option>
											<?php if(isset($sessionlist) && $sessionlist){
												foreach($sessionlist as $session){ ?>
												<option value="<?php echo $session->id; ?>"><?php echo ucfirst($session->session_name); ?></option>
											<?php }
											} ?>
										</select> 
									</div>
									<div class="col-lg-2 col-md-12">
										<label>Start Date</label>
										<div class="wd-200 mg-b-30">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">
														<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
													</div>
												</div>
												<input class="form-control datepicker" id="datepicker0" name="start_date" autocomplete="off" placeholder="Start Date" type="text"  value="">
											</div>
										</div>
									</div>
									<div class="col-lg-2 col-md-12">
										<label>End Date</label>
										<div class="wd-200 mg-b-30">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">
														<i class="fa fa-calendar tx-16 lh-0 op-6"></i>
													</div>
												</div>
												<input class="form-control datepicker" id="datepicker1" name="end_date" autocomplete="off" placeholder="End Date" type="text" value="" data-rule-validEndDate>
												<label id="datepicker1-error" class="error validationerror" for="datepicker1"><?=form_error("end_date");?></label>
											</div>
										</div>
									</div>
									<input type="hidden" id="tablename" name="tablename" value="<?php echo $tablename; ?>">
									<div class="col-lg-1 col-md-12">
										<input type="submit" name="submit" value="Get Record" class="btn btn-app btn-primary" style="margin-top:28px;">
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
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="table-responsive">
					<table class="table card-table table-vcenter table-bordered text-center">
						<thead>
							<tr>
								<th>Program</th>
								<th>Batch</th>
								<th>Session</th>
								<th>Review Date</th>
								<th>View</th>
							</tr>
						</thead>
						<tbody id="reviewsummaryreportlistdiv">
						</tbody>
					</table>
				</div>
				<!-- table-responsive -->
			</div><!-- col end -->
		</div>
		<!-- row end -->
	</div>
<?php include("footer.php"); ?>
<script type="text/javascript">
$(document).ready(function(){
	$(".submitform").submit();
});
$('#program_name').on('change',function(){
	var program_name=$(this).val();
	$.ajax({
		type:'POST',
		url:"<?php echo site_url('management/ajax_get_sessionlist_by_program'); ?>",
		data:'program_name='+program_name,
		success:function(response){
			if(response.hasOwnProperty('sessionlist') && response.sessionlist){
				$('#session_id').html(response.sessionlist);
			}
		}
	});
});
$("#review_summary_report").validate();
$.validator.addMethod("validEndDate",function(value, element, param){
	var sdate = $("#datepicker0").val();
	var edate = $("#datepicker1").val();
	if(sdate && edate && edate<sdate){
		return false;
	}
	return true;
},"End Date must be greater than Start Date.");
$(".submitform").on('submit',function(event){
	/* stop form from submitting normally */
	event.preventDefault();
	/* get the action attribute from the <form action=""> element */
	var error=$('#datepicker1-error').html();
	if(error==''){
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
				}else if(response.hasOwnProperty('reviewsummaryreportlisthtml')){
	            	$('#reviewsummaryreportlistdiv').html(response.reviewsummaryreportlisthtml);
	            }
	        },
	        complete: function(){
	          	initResultDataTable();
	          	$('.tooltipcls').tooltipster({
					position:'right'
		      	});
	        }
	    });
	}
});
</script>