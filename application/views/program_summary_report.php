<?php include("header.php"); ?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Report</a></li>
				<li class="breadcrumb-item active" aria-current="page">Program Summary Report</li>
			</ol><!-- End breadcrumb -->
		</div>
		<!-- End page-header -->
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<form id="program_summary_report" name="program_summary_report" method="post" class="submitform" action="<?php echo base_url('programReport/ajax_get_program_summary_report');?>">
						<div class="card-body">
							<div class="form-group">
								<div class="row">
									<div class="col-lg-2 col-md-12">
										<label>State</label>
										<select id="state_id" name="state_id" class="form-control" >
											<option value="">--Select--</option>
											<?php if(isset($statelist) && $statelist){
												foreach($statelist as $state){ ?>
												<option value="<?php echo $state->id; ?>"><?php echo ucfirst($state->state_name); ?></option>
											<?php }
											} ?>
										</select> 
									</div>
									<div class="col-lg-2 col-md-12">
										<label>Region</label>
										<select id="region_id" name="region_id" class="form-control">	
											<option value="">--Select--</option>
											<?php if(isset($regionlist) && $regionlist){
												foreach($regionlist as $region){ ?>
												<option value="<?php echo $region->id; ?>" ><?php echo ucfirst($region->region_name); ?></option>
											<?php }
											} ?>
										</select>
									</div>
									<div class="col-lg-3 col-md-12">
										<label>Center</label>
										<select id="center_id" name="center_id" class="form-control">	
											<option value="">--Select--</option>
											<?php if(isset($centerlist) && $centerlist){
												foreach($centerlist as $center){ ?>
												<option value="<?php echo $center->id; ?>" ><?php echo ucfirst($center->center_name); ?></option>
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
								<th>No. of Programs/Batches</th>
								<th>Participants</th>
								<th>Star Participants</th>
								<th>Facilitators</th>
								<th>Co-facilitators</th>
								<th>Co-ordinators</th>
								<th>Volunteers</th>
							</tr>
						</thead>
						<tbody id="programsummaryreportlistdiv">
							<?php /* 
							<tr>
								<th>Life & Love Camp</th>
								<td><a href="<?php echo site_url('Dashboard/batch_summary_report/')?>" target="_blank"  style="color:unset;" class="btn btn-dark text-white">3</a></td>
								<td><a href="<?php echo site_url('Dashboard/user_summary_report/')?>" target="_blank"  style="color:unset;" class="btn btn-danger text-white">60</a></td>
								<!--<td><a href="<?php echo site_url('Dashboard/user_summary_report/')?>" target="_blank"  style="color:unset;" class="btn btn-purple text-white">10</a></td>-->
								<td><input type="submit" style="color:unset;" class="btn btn-purple text-white" data-toggle="modal" data-target="#largeModal" value="10"></td>
								<td><a href="<?php echo site_url('Dashboard/user_summary_report/')?>" target="_blank"  style="color:unset;" class="btn btn-info text-white">4</a></td>
								<td><a href="<?php echo site_url('Dashboard/user_summary_report/')?>" target="_blank"  style="color:unset;" class="btn btn-secondary text-white">2</a></td>
								<td><a href="<?php echo site_url('Dashboard/user_summary_report/')?>" target="_blank"  style="color:unset;" class="btn btn-primary text-white">4</a></td>
								<td><a href="<?php echo site_url('Dashboard/user_summary_report/')?>" target="_blank"  style="color:unset;" class="btn btn-warning text-white">15</a></td>
							</tr>
							<tr>
								<th>Leadership Camps</th>
								<td>1</td>
								<td>24</td>
								<td>15</td>
								<td>1</td>
								<td>1</td>
								<td>1</td>
								<td>-</td>
							</tr>
							<tr>
								<th>Dream India Camps</th>
								<td>4</td>
								<td>50</td>
								<td>15</td>
								<td>3</td>
								<td>2</td>
								<td>2</td>
								<td>15</td>
							</tr>
							<tr>
								<th>L3 For Students</th>
								<td>1</td>
								<td>17</td>
								<td>7</td>
								<td>1</td>
								<td>1</td>
								<td>1</td>
								<td>-</td>
							</tr>
							<tr>
								<th>.. <br/><br/> ..</th>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<th>Total</th>
								<td>50</td>
								<td>150</td>
								<td>40</td>
								<td>6</td>
								<td>4</td>
								<td>3</td>
								<td>25</td>
							</tr> */ ?>
						</tbody>
					</table>
					<div id="largeModal" class="modal fade">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content ">
								<div class="modal-header pd-x-20">
									<h4 class="modal-title"><b>STAR PARTICIPANTS DETAILS</b></h4>
									<input type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
								</div>
								<div class="modal-body pd-20">
									<div class="table-responsive">
							  		<table class="table card-table table-vcenter table-bordered table-striped text-center">
							  			<thead>
							  				<tr>
							  					<th>First Name</th>
							  					<th>Last Name</th>
							  					<th>DOB</th>
							  					<th>State</th>
							  					<th>District</th>
							  					<th>Village/City</th>
							  					<th>Qualities Observed</th>
							  				</tr>
							  			</thead>
										<tbody id="star_participants_html">
											<?php /* 
											<tr>
												<td>Rakesh</td>
												<td>Sharma</td>
												<td>28-10-1980</td>
												<td>Gujarat</td>
												<td>Vadodara</td>
												<td>Vadodara</td>
												<td>Communication Skills,Learning Ability</td>
											</tr>
											<tr>
												<td>Rakesh</td>
												<td>Sharma</td>
												<td>28-10-1980</td>
												<td>Gujarat</td>
												<td>Vadodara</td>
												<td>Vadodara</td>
												<td>Communication Skills,Learning Ability</td>
											</tr>
											<tr>
												<td>Rakesh</td>
												<td>Sharma</td>
												<td>28-10-1980</td>
												<td>Gujarat</td>
												<td>Vadodara</td>
												<td>Vadodara</td>
												<td>Communication Skills,Learning Ability</td>
											</tr>
											<tr>
												<td>Rakesh</td>
												<td>Sharma</td>
												<td>28-10-1980</td>
												<td>Gujarat</td>
												<td>Vadodara</td>
												<td>Vadodara</td>
												<td>Communication Skills,Learning Ability</td>
											</tr>
											<tr>
												<td>Rakesh</td>
												<td>Sharma</td>
												<td>28-10-1980</td>
												<td>Gujarat</td>
												<td>Vadodara</td>
												<td>Vadodara</td>
												<td>Communication Skills,Learning Ability</td>
											</tr>
											<tr>
												<td>Rakesh</td>
												<td>Sharma</td>
												<td>28-10-1980</td>
												<td>Gujarat</td>
												<td>Vadodara</td>
												<td>Vadodara</td>
												<td>Communication Skills,Learning Ability</td>
											</tr>
											<tr>
												<td>Rakesh</td>
												<td>Sharma</td>
												<td>28-10-1980</td>
												<td>Gujarat</td>
												<td>Vadodara</td>
												<td>Vadodara</td>
												<td>Communication Skills,Learning Ability</td>
											</tr> */ ?>
										</tbody>
									</table>
								</div>	
								</div><!-- modal-body -->
							</div>
						</div><!-- modal-dialog -->
					</div><!-- modal -->
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
})
$('#state_id').on('change',function(){
	var state_id=$(this).val();
	$.ajax({
		type:'POST',
		url:"<?php echo site_url('regionMst/ajax_get_region_by_state'); ?>",
		data:'state_id='+state_id,
		success:function(response){
			if(response.hasOwnProperty('regionlist') && response.regionlist){
				$('#region_id').html(response.regionlist);
				$('#region_id').trigger('change');
			}
		}
	});
});
$('#region_id').on('change',function(){
	var state_id=$('#state_id').val();
	var region_id=$(this).val();
	$.ajax({
		type:'POST',
		url:"<?php echo site_url('centerMst/ajax_get_center_by_state_or_region'); ?>",
		data:'state_id='+state_id+'&region_id='+region_id,
		success:function(response){
			if(response.hasOwnProperty('centerlist') && response.centerlist){
				$('#center_id').html(response.centerlist);
			}
		}
	});
});
$("#program_summary_report").validate();
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
				}else if(response.hasOwnProperty('programsummaryreportlisthtml')){
	            	$('#programsummaryreportlistdiv').html(response.programsummaryreportlisthtml);
	            }
	        },
	        complete: function(){
	          	initResultDataTable();
	        }
	    });
	}
});
function fetchStarParticipantsByProgramId(program_id){
	var state_id=$('#state_id').val();
	var region_id=$('#region_id').val();
	var center_id=$('#center_id').val();
	var start_date=$('#datepicker0').val();
	var end_date=$('#datepicker1').val();
	$.ajax({
		type:'POST',
		url:"<?php echo site_url('programReport/ajax_fetch_star_participants_by_program_id'); ?>",
		data:'program_id='+program_id+'&state_id='+state_id+'&region_id='+region_id+'&center_id='+center_id+'&start_date='+start_date+'&end_date='+end_date,
		success:function(response){
			if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
				$('#closebtn').trigger('click');
				window.location.assign(response.notvaliduserurl);
			}else if(response.hasOwnProperty('star_participants_html') && response.star_participants_html){
				$('#star_participants_html').html(response.star_participants_html);
			}
		}
	});
}
function fetchUserSummaryReportByProgramId(url){
	var state_id=$('#state_id').val();
	var region_id=$('#region_id').val();
	var center_id=$('#center_id').val();
	var start_date=$('#datepicker0').val();
	var end_date=$('#datepicker1').val();
	url=url+'&state_id='+state_id+'&region_id='+region_id+'&center_id='+center_id+'&start_date='+start_date+'&end_date='+end_date;
	window.open(url,'_blank');
}
</script>