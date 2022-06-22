<?php include("header.php"); ?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
				<li class="breadcrumb-item active" aria-current="page">Monitoring Facilitators</li>
			</ol><!-- End breadcrumb -->
		</div>
		<!-- End page-header -->
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<form id="monitroing_facilitators" name="monitroing_facilitators" method="post" class="submitform" action="<?php echo base_url('Dashboard/ajax_monitroing_facilitators'); ?>">
						<div class="card-body">
							<div class="form-group">
								<div class="row">	
									<div class="col-lg-3 col-md-12">
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
									<div class="col-lg-4 col-md-12">
										<label>Region</label>
										<select id="region_id" name="region_id" class="form-control">	<option value="">--Select--</option>
											<?php if(isset($regionlist) && $regionlist){
												foreach($regionlist as $region){ ?>
												<option value="<?php echo $region->id; ?>" ><?php echo ucfirst($region->region_name); ?></option>
											<?php }
											} ?>
										</select>
									</div>
									<div class="col-lg-4 col-md-12">
										<label>Center</label>
										<select id="center_id" name="center_id" class="form-control">	 <option value="">--Select--</option>
											<?php if(isset($centerlist) && $centerlist){
												foreach($centerlist as $center){ ?>
												<option value="<?php echo $center->id; ?>" ><?php echo ucfirst($center->center_name); ?></option>
											<?php }
											} ?>
										</select>
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
									<th>Project/Program</th>
									<th>Trainning Given</th>
									<th>Active</th>
									<th>Inactive</th>
									<th>Yearly Target Active Faci.</th>
									<th>Learners</th>
									<th>Achievement(in %)</th>
								</tr>
							</thead>
							<tbody id="monitoringfacilitatordetails">
								<?php /* <tr>
									<td>Life & Love Camps</td>
									<td>100</td>
									<td><input type="submit" class="btn btn-dark" data-toggle="modal" data-target="#active_faclitator" value="30"></td>
									<td><input type="submit" class="btn btn-secondary" data-toggle="modal" data-target="#inactive_faclitator" value="70"></td>
									<td>50</td>
									<td>25</td>
									<td></td>
								</tr>
								<tr>
									<td>Leadership Camps</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Dream India Camps</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>L3 for Students</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Saamarthya Project</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>SKAKT Sessions</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Oasis Sessions</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Misaal Project</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>MSLD Program</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>MHE Program</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Jyotirdhar Abhiyaan</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>L3 for Adults</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Freedom Parenting Workshops</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Retreats</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Book Camps</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Events & Rallies</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Special Workshops</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Others</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr> */ ?>
							</tbody>
						</table>
						<!-- Large Modal -->
								<div id="active_faclitator" class="modal fade">
									<div class="modal-dialog modal-lg" role="document">
										<div class="modal-content ">
											<div class="modal-header pd-x-20">
												<h4 class="modal-title"><b>Active Facilitators</b></h4>
												<input type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
											</div>
											<div class="modal-body pd-20">
												<div class="table-responsive">
										  		<table class="table card-table table-vcenter table-bordered table-striped text-center">
										  			<thead>
										  				<tr>
										  					<th>Name</th>
										  					<th>Gender</th>
										  					<th>Age</th>
										  					<th>State</th>
										  					<th>Region</th>
										  					<th>Center</th>
										  					<th>Active Since</th>
										  				</tr>
										  			</thead>
													<tbody id="active_faclitator_html">
														<?php /*
														<tr>
															<td>Rakesh Sharma</td>
															<td>Male</td>
															<td>40</td>
															<td>Gujarat</td>
															<td>Ahmedabad</td>
															<td>Urban Ahmedabad</td>
															<td>2010</td>
														</tr>
														<tr>
															<td>Jay Sharma</td>
															<td>Male</td>
															<td>35</td>
															<td>Jammu & Kashmir</td>
															<td>Leh</td>
															<td>Leh</td>
															<td>2012</td>
														</tr> */ ?>
													</tbody>
												</table>
											</div>	
											</div><!-- modal-body -->
										</div>
									</div><!-- modal-dialog -->
								</div><!-- modal -->
								<!-- Large Modal -->
								<div id="inactive_faclitator" class="modal fade">
									<div class="modal-dialog modal-lg" role="document">
										<div class="modal-content ">
											<div class="modal-header pd-x-20">
												<h4 class="modal-title"><b>Inactive Facilitators</b></h4>
												<input type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
											</div>
											<div class="modal-body pd-20">
												<div class="table-responsive">
										  		<table class="table card-table table-vcenter table-bordered table-striped text-center">
										  			<thead>
										  				<tr>
										  					<th>Name</th>
										  					<th>Gender</th>
										  					<th>Age</th>
										  					<th>State</th>
										  					<th>Region</th>
										  					<th>Center</th>
										  					<th>Inactive Since</th>
										  				</tr>
										  			</thead>
													<tbody id="inactive_faclitator_html">
														<?php /*
														<tr>
															<td>Manoj Sharma</td>
															<td>Male</td>
															<td>40</td>
															<td>Gujarat</td>
															<td>Ahmedabad</td>
															<td>Urban Ahmedabad</td>
															<td>2010</td>
														</tr>
														<tr>
															<td>Jay Sharma</td>
															<td>Male</td>
															<td>35</td>
															<td>Jammu & Kashmir</td>
															<td>Leh</td>
															<td>Leh</td>
															<td>2012</td>
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
		<!-- row -->
		<!--<div class="row active_users" style="display: none;">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="table-responsive">
						<table class="table card-table table-vcenter table-bordered text-center">
							<thead>
								<tr>
									<th>Active Facilitators</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Rakesh Sharma</td>
								</tr>
								<tr>
									<td>Pallavi</td>
								</tr>
							</tbody>
						</table>
					</div>
				
				</div>
			</div>
		</div>-->
		<!-- row end -->
		<!-- row --> 
		<!--<div class="row inactive_users" style="display: none;">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="table-responsive">
						<table class="table card-table table-vcenter table-bordered text-center">
							<thead>
								<tr>
									<th>Inactive Facilitators</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Vijay Dalal</td>
								</tr>
								<tr>
									<td>Usha Nayak</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>-->
		<!-- row end -->
	</div>
<?php include("footer.php"); ?>
<script type="text/javascript">
$(document).ready(function(){
	$(".submitform").submit();
	$('div .table-responsive').removeClass("wrapper");
  	$('table').removeAttr('myTable');
});
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
			}else if(response.hasOwnProperty('monitoringfacilitatorhtml')){
	            $('#monitoringfacilitatordetails').html(response.monitoringfacilitatorhtml);
	        }
        },
        complete: function(){
          	initResultDataTable();
        }
    });
});
function fetchActiveFacilitatorByUserIds(user_ids){
	$.ajax({
		type:'POST',
		url:"<?php echo site_url('dashboard/ajax_fetch_active_user_details_by_ids'); ?>",
		data:'user_ids='+user_ids,
		success:function(response){
			if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
				$('#closebtn').trigger('click');
				window.location.assign(response.notvaliduserurl);
			}else if(response.hasOwnProperty('active_faclitator_html') && response.active_faclitator_html){
				$('#active_faclitator_html').html(response.active_faclitator_html);
			}
		}
	});
}
function fetchInactiveFacilitatorByUserIds(user_ids){
	$.ajax({
		type:'POST',
		url:"<?php echo site_url('dashboard/ajax_fetch_inactive_user_details_by_ids'); ?>",
		data:'user_ids='+user_ids,
		success:function(response){
			if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
				$('#closebtn').trigger('click');
				window.location.assign(response.notvaliduserurl);
			}else if(response.hasOwnProperty('inactive_faclitator_html') && response.inactive_faclitator_html){
				$('#inactive_faclitator_html').html(response.inactive_faclitator_html);
			}
		}
	});
}
</script>
