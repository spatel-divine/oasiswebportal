<?php include("header.php"); ?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
				<li class="breadcrumb-item active" aria-current="page">Monitoring Leaders & Team</li>
			</ol><!-- End breadcrumb -->
		</div>
		<!-- End page-header -->
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<form id="monitoring_leaders_team" name="monitoring_leaders_team" method="post" class="submitform" action="<?php echo base_url('Dashboard/ajax_get_monitoring_leaders_team'); ?>">
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
										<select id="region_id" name="region_id" class="form-control">	
											<option value="">--Select--</option>
											<?php if(isset($regionlist) && $regionlist){
												foreach($regionlist as $region){ ?>
												<option value="<?php echo $region->id; ?>" ><?php echo ucfirst($region->region_name); ?></option>
											<?php }
											} ?>
										</select>
									</div>
									<div class="col-lg-4 col-md-12">
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
									<th>Name</th>
									<th>Role</th>
									<th>Active Since</th>
									<th>Program Attended</th>
								</tr>
							</thead>
							<tbody id="leaderprofiledetails">
								<?php /* 
								<tr>
									<td>State Synergist</td>
									<td><input type="submit" class="btn btn-dark" data-toggle="modal" data-target="#largeModal" value="Rakesh Sharma"></td>
									<td>28-06-2020</td>
									<td><input type="submit" class="btn btn-info" data-toggle="modal" data-target="#programDetails" value="5"></td>
								</tr>
								<tr>
									<td>Participant</td>
									<td>Rishi Mehra</td>
									<td>20-06-2021</td>
									<td>1</td>
								</tr> 
								*/ 
								?>
							</tbody>
						</table>
						<!-- Large Modal -->
						<div id="largeModal" class="modal fade">
							<div class="modal-dialog modal-lg modal-width" role="document">
								<div class="modal-content ">
									<div class="modal-header pd-x-20">
										<h4 class="modal-title"><b>LEADER/TEAM PROFILE DETAILS</b></h4>
										<input type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
									</div>
									<div class="modal-body pd-20">
										<div class="table-responsive">
								  		<table class="table card-table table-vcenter table-bordered table-striped text-center">
											<tbody id="user_html">
												<tr>
													<td><b>Name</b></td>
													<td>Rakesh Sharma</td>
												</tr>
												<tr>
													<td><b>DOB</b></td>
													<td>28-10-1980</td>
												</tr>
												<tr>
													<td><b>Gender</b></td>
													<td>Male</td>
												</tr>
												<tr>
													<td><b>Address</b></td>
													<td>Ahmedabad,Gujarat</td>
												</tr>
												<tr>
													<td><b>Mobile No:</b></td>
													<td>1234567890</td>
												</tr>
												<tr>
													<td><b>Email ID:</b></td>
													<td>rakeshsharma@oasismovement.in</td>
												</tr>
												<tr>
													<td><b>Education:</b></td>
													<td>Bsc</td>
												</tr>
												<tr>
													<td><b>Occupation:</b></td>
													<td>Project Co-ordinator</td>
												</tr>
												<tr>
													<td><b>Langauage Known:</b></td>
													<td>Hindi,English,Gujarati</td>
												</tr>
												<tr>
													<td><b>Martial Status:</b></td>
													<td>Married</td>
												</tr>
											</tbody>
										</table>
									</div>	
									</div><!-- modal-body -->
								</div>
							</div><!-- modal-dialog -->
						</div><!-- modal -->
						<!--FACILITATOR Details-->
						<div class="modal fade" id="programDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="exampleModalLongTitle">Batch Details<span id="batchusername"></span></h5>
									<input type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
								  </div>
								  <div class="modal-body">
								  	<div class="table-responsive">
								  		<table class="table card-table table-vcenter table-bordered table-striped text-center">
											<thead>
												<tr>
													<th><b>Batch Name</b></th>
													<th><b>Program Name</b></th>
													<th><b>Batch Location</b></th>
													<th><b>Start Date</b></th>
													<th><b>End Date</b></th>
												</tr>
											</thead>
											<tbody id="batch_html">
												<?php /*
												<tr>
													<th>L3T-2016-Guj-Leaders3.1</th>
													<td>L3 Teen</td>
													<td>Oasis Valleys</td>
													<td>03-03-2017 , 09:00 AM</td>
													<td>31-12-2020 , 09:00 AM</td>
												</tr>
												<tr>
													<th>L3T-M17-Guj-Gujarati1</th>
													<td>L3 Teen</td>
													<td>Oasis Valleys</td>
													<td>27-10-2017 , 09:00 AM</td>
													<td>31-12-2020 , 09:00 AM</td>
												</tr> */ ?>
											</tbody>
										</table>
									</div>
								  </div>
								</div>
							</div>
						</div>
						<!--FACILITATOR Details-->
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
	$('div .table-responsive').removeClass("wrapper");
  $('table').removeAttr('myTable');
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
					}else if(response.hasOwnProperty('leaderprofilehtml')){
            $('#leaderprofiledetails').html(response.leaderprofilehtml);
          }
        },
        complete: function(){
          	initResultDataTable();
        }
    });
});
function fetchUserDetailById(user_id){
	$.ajax({
		type:'POST',
		url:"<?php echo site_url('dashboard/ajax_fetch_user_details_by_id'); ?>",
		data:'user_id='+user_id,
		success:function(response){
			if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
				$('#closebtn').trigger('click');
				window.location.assign(response.notvaliduserurl);
			}else if(response.hasOwnProperty('user_html') && response.user_html){
				$('#user_html').html(response.user_html);
			}
		}
	});
}
function fetchBatchlistByUserId(user_id){
	$('#batchusername').html('');
	$('#batch_html').html('');
	var state_id=$('#state_id').val();
	var region_id=$('#region_id').val();
	var center_id=$('#center_id').val();
	$.ajax({
		type:'POST',
		url:"<?php echo site_url('dashboard/ajax_fetch_batch_list_by_userid'); ?>",
		data:'user_id='+user_id+'&state_id='+state_id+'&region_id='+region_id+'&center_id='+center_id,
		success:function(response){
			if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
				$('#closebtn').trigger('click');
				window.location.assign(response.notvaliduserurl);
			}else if(response.hasOwnProperty('batch_html') && response.batch_html){
				if(response.hasOwnProperty('userfullname') && response.userfullname){
					$('#batchusername').html(' - '+response.userfullname);
				}
				$('#batch_html').html(response.batch_html);
			}
		}
	});
}
</script>
