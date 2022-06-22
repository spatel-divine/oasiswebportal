<?php include("header.php");?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Report</a></li>
				<li class="breadcrumb-item active" aria-current="page">User Summary Report</li>
			</ol><!-- End breadcrumb -->
		</div>
		<!-- End page-header -->
		<!-- row -->
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="table-responsive">
					<table class="table card-table table-vcenter table-bordered text-center">
						<thead>
							<tr>
								<th><b>Name</b></th>
								<th><b>Batches</b></th>
								<th><b>Programs</b></th>
								<th><b>As Facilitator</b></th>
								<th><b>As Co-Facilitator</b></th>
								<th><b>As Co-ordinator</b></th>
								<th><b>As Volunteer</b></th>
								<th><b>As Participant</b></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if(isset($usersummaryreport_list) && $usersummaryreport_list){
								foreach ($usersummaryreport_list as $usersummaryreport){
									$user_id='-';
									if(isset($usersummaryreport['user_id']) && $usersummaryreport['user_id']){
										$user_id=base64_encode($usersummaryreport['user_id']);
									}
									$fullname='-';
									if(isset($usersummaryreport['fullname']) && $usersummaryreport['fullname']){
										$fullname='<a class="btn btn-light" data-toggle="modal" data-target="#userDetails" href="javascript:void(0);" onclick="fetchUserDetailById(\''.$user_id.'\');">'.$usersummaryreport['fullname'].'</a>';
									}
									$total_batch='-';
									if(isset($usersummaryreport['total_batch']) && $usersummaryreport['total_batch']){
										$total_batch='<a class="btn btn-info" data-toggle="modal" data-target="#batchData" href="javascript:void(0);" onclick="fetchBatchlistByUserId(\''.$user_id.'\');">'.$usersummaryreport['total_batch'].'</a>';
									}
									$total_program='-';
									if(isset($usersummaryreport['total_program']) && $usersummaryreport['total_program']){
										$total_program=$usersummaryreport['total_program'];
									}
									$facilitator='-';
									if(isset($usersummaryreport['facilitator']) && $usersummaryreport['facilitator']){
										$facilitator='<a class="btn btn-dark" data-toggle="modal" data-target="#userTypeData" href="javascript:void(0);" onclick="fetchUserTypeBatchlistByUserIdNType(\'batch_facilitator\',\''.$user_id.'\');">'.$usersummaryreport['facilitator'].'</a>';
									}
									$co_facilitator='-';
									if(isset($usersummaryreport['co_facilitator']) && $usersummaryreport['co_facilitator']){
										$co_facilitator='<a class="btn btn-primary" data-toggle="modal" data-target="#userTypeData" href="javascript:void(0);" onclick="fetchUserTypeBatchlistByUserIdNType(\'batch_co_facilitator\',\''.$user_id.'\');">'.$usersummaryreport['co_facilitator'].'</a>';
									}
									$coordinator='-';
									if(isset($usersummaryreport['coordinator']) && $usersummaryreport['coordinator']){
										$coordinator='<a class="btn btn-warning" data-toggle="modal" data-target="#userTypeData" href="javascript:void(0);" onclick="fetchUserTypeBatchlistByUserIdNType(\'batch_coordinator\',\''.$user_id.'\');">'.$usersummaryreport['coordinator'].'</a>';
									}
									$volunteer='-';
									if(isset($usersummaryreport['volunteer']) && $usersummaryreport['volunteer']){
										$volunteer='<a class="btn btn-secondary" data-toggle="modal" data-target="#userTypeData" href="javascript:void(0);" onclick="fetchUserTypeBatchlistByUserIdNType(\'batch_volunteer\',\''.$user_id.'\');">'.$usersummaryreport['volunteer'].'</a>';
									}
									$participant='-';
									if(isset($usersummaryreport['participant']) && $usersummaryreport['participant']){
										$participant='<a class="btn btn-purple" data-toggle="modal" data-target="#userTypeData" href="javascript:void(0);" onclick="fetchUserTypeBatchlistByUserIdNType(\'batch_participant\',\''.$user_id.'\');">'.$usersummaryreport['participant'].'</a>';
									}
							?>
								<tr>
									<th><?php echo $fullname; ?></th>
									<td><?php echo $total_batch; ?></td>
									<td><?php echo $total_program; ?></td>
									<td><?php echo $facilitator; ?></td>
									<td><?php echo $co_facilitator; ?></td>
									<td><?php echo $coordinator; ?></td>
									<td><?php echo $volunteer; ?></td>
									<td><?php echo $participant; ?></td>
								</tr>	
							<?php }
							}
							?>
							<?php /* 
							<tr>
								<th><input type="submit" class="btn btn-light" data-toggle="modal" data-target="#facilitatorDetails" value="VINIT JAIN"></th>
								<td><input type="submit" class="btn btn-info" data-toggle="modal" data-target="#batchData" value="18"></td>
								<td>3</td>
								<td><input type="submit" class="btn btn-dark" data-toggle="modal" data-target="#asFacilitator" value="4"></td>
								<td><input type="submit" class="btn btn-primary" data-toggle="modal" data-target="#asCoFacilitator" value="5"></td>
								<td><input type="submit" class="btn btn-warning" data-toggle="modal" data-target="#asCoOrdinator" value="12"></td>
								<td><input type="submit" class="btn btn-secondary" data-toggle="modal" data-target="#asVolunteer" value="1"></td>
								<td><input type="submit" class="btn btn-purple" data-toggle="modal" data-target="#asParticipant" value="1"></td>
							</tr>
							<tr>
								<th>Pallavi Raulji</th>
								<td>16</td>
								<td>4</td>
								<td>14</td>
								<td>2</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
							</tr> */ ?>
						</tbody>
					</table>
					<!--FACILITATOR Details-->
					<div class="modal fade" id="userDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">USER DETAILS</h5>
								<input type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
							  </div>
							  <div class="modal-body">
							  	<div class="table-responsive">
							  		<table class="table card-table table-vcenter table-bordered">
										<tbody id="user_html">
											<?php /*
											<tr>
												<td><b>Name</b></td>
												<td>Vinit Jain</td>
											</tr>
											<tr>
												<td><b>Address</b></td>
												<td>Shyamal Cross Road,Stellite,Ahemedad-380015</td>
											</tr>
											<tr>
												<td><b>Mobile No</b></td>
												<td>1234567890</td>
											</tr>
											<tr>
												<td><b>Email Id</b></td>
												<td>abc@gmail.com</td>
											</tr>
											<tr>
												<td><b>DOB</b></td>
												<td>28-12-1997</td>
											</tr>
											<tr>
												<td><b>Languages Known</b></td>
												<td>Hindi,Emglish,Gujarati</td>
											</tr>
											<tr>
												<td><b>Educational Backgorund</b></td>
												<td>-</td>
											</tr>
											*/ ?>
										</tbody>
									</table>
								</div>
							  </div>
							</div>
						</div>
					</div>
					<!--FACILITATOR Details-->
					<!--BATCHES Details-->
					<div class="modal fade" id="batchData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">Batch Details<span id="batchusername"></span></h5>
								<input type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
							  </div>
							  <div class="modal-body">
							  	<div class="table-responsive">
							  		<table class="table card-table table-vcenter table-bordered">
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
					<!--BATCHES Details-->
					<!--UserType Details-->
					<div class="modal fade" id="userTypeData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle"><span id="usertypefullname"></span></h5>
								<input type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
							  </div>
							  <div class="modal-body">
							  	<div class="table-responsive">
							  		<table class="table card-table table-vcenter table-bordered">
										<thead>
											<tr>
												<th><b>Batch Name</b></th>
												<th><b>Program Name</b></th>
												<th><b>Batch Location</b></th>
												<th><b>Start Date</b></th>
												<th><b>End Date</b></th>
											</tr>
										</thead>
										<tbody id="usertype_html">
											<?php /*
											<tr>
												<th>L3T-M18-Guj-WinnersG5</th>
												<td>L3 Teen</td>
												<td>Oasis Valleys</td>
												<td>19-09-2018 , 09:00 AM</td>
												<td>31-12-2020 , 09:00 AM</td>
											</tr>
											<tr>
												<th>MSLDP-2020-B3</th>
												<td>MSLDP</td>
												<td>Oasis Valleys</td>
												<td>02-10-2020 , 11:18 AM</td>
												<td>15-10-2021 , 11:18 AM</td>
											</tr> */ ?>
										</tbody>
									</table>
								</div>
							  </div>
							</div>
						</div>
					</div>
					<!--UserType Details-->
					<?php /* <!--AS CO-FACILITATORS Details-->
					<div class="modal fade" id="asCoFacilitator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">Co-Facilitator Details - Vinit Jain</h5>
								<input type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
							  </div>
							  <div class="modal-body">
							  	<div class="table-responsive">
							  		<table class="table card-table table-vcenter table-bordered  text-center">
										<thead>
											<tr>
												<th><b>Batch Name</b></th>
												<th><b>Program Name</b></th>
												<th><b>Batch Location</b></th>
												<th><b>Start Date</b></th>
												<th><b>End Date</b></th>
											</tr>
										</thead>
										<tbody>

											<tr>
												<th>L3T-M17-Guj-Gujarati1</th>
												<td>L3 Teen</td>
												<td>Oasis Valleys</td>
												<td>27-10-2017 , 09:00 AM</td>
												<td>31-12-2020 , 09:00 AM</td>
											</tr>
											<tr>
												<th>L3T-M18-Guj-NV-Local</th>
												<td>MSLDP</td>
												<td>Navsari</td>
												<td>31-07-2018 , 09:00 AM</td>
												<td>31-12-2020 , 09:00 AM</td>
											</tr>
										</tbody>
									</table>
								</div>
							  </div>
							</div>
						</div>
					</div>
					<!--AS CO-FACILITATORS Details-->
					<!--AS CO-ORDINATORS Details-->
					<div class="modal fade" id="asCoOrdinator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">Co-Ordinators Details - Vinit Jain</h5>
								<input type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
							  </div>
							  <div class="modal-body">
							  	<div class="table-responsive">
							  		<table class="table card-table table-vcenter table-bordered  text-center">
										<thead>
											<tr>
												<th><b>Batch Name</b></th>
												<th><b>Program Name</b></th>
												<th><b>Batch Location</b></th>
												<th><b>Start Date</b></th>
												<th><b>End Date</b></th>
											</tr>
										</thead>
										<tbody>

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
											</tr>
										</tbody>
									</table>
								</div>
							  </div>
							</div>
						</div>
					</div>
					<!--AS CO-ORDINATORS Details-->
					<!--AS VOLUNTEERS Details-->
					<div class="modal fade" id="asVolunteer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">Volunteers Details - Vinit Jain</h5>
								<input type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
							  </div>
							  <div class="modal-body">
							  	<div class="table-responsive">
							  		<table class="table card-table table-vcenter table-bordered  text-center">
										<thead>
											<tr>
												<th><b>Batch Name</b></th>
												<th><b>Program Name</b></th>
												<th><b>Batch Location</b></th>
												<th><b>Start Date</b></th>
												<th><b>End Date</b></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th>L3T-M17-Guj-Gujarati1</th>
												<td>L3 Teen</td>
												<td>Oasis Valleys</td>
												<td>27-10-2017 , 09:00 AM</td>
												<td>31-12-2020 , 09:00 AM</td>
											</tr>
										</tbody>
									</table>
								</div>
							  </div>
							</div>
						</div>
					</div>
					<!--AS VOLUNTEERS Details-->
					<!--AS PARTICIPANTS Details-->
					<div class="modal fade" id="asParticipant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">Participant Details - Vinit Jain</h5>
								<input type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
							  </div>
							  <div class="modal-body">
							  	<div class="table-responsive">
							  		<table class="table card-table table-vcenter table-bordered  text-center">
										<thead>
											<tr>
												<th><b>Batch Name</b></th>
												<th><b>Program Name</b></th>
												<th><b>Batch Location</b></th>
												<th><b>Start Date</b></th>
												<th><b>End Date</b></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th>DIC-Super DIC-Diwali 2020</th>
												<td>Dream India Camps</td>
												<td>N/A</td>
												<td>21-11-2020 , 09:00 AM</td>
												<td>29-11-2020 , 09:00 AM</td>
											</tr>
										</tbody>
									</table>
								</div>
							  </div>
							</div>
						</div>
					</div>
					<!--AS PARTICIPANTS Details--> */ ?>
				</div>
				<!-- table-responsive -->
			</div><!-- col end -->
		</div>
		<!-- row end -->
	</div>
<?php include("footer.php"); ?>
<script type="text/javascript">
function fetchUserDetailById(user_id){
	$.ajax({
		type:'POST',
		url:"<?php echo site_url('programReport/ajax_fetch_user_details_by_id'); ?>",
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
	$.ajax({
		type:'POST',
		url:"<?php echo site_url('programReport/ajax_fetch_batch_list_by_userid'); ?>",
		data:'user_id='+user_id,
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
function fetchUserTypeBatchlistByUserIdNType(tablename,user_id){
	$('#usertypefullname').html('');
	$('#usertype_html').html('');
	$.ajax({
		type:'POST',
		url:"<?php echo site_url('programReport/ajax_fetch_user_type_batch_list_by_userid_type'); ?>",
		data:'tablename='+tablename+'&user_id='+user_id,
		success:function(response){
			if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
				$('#closebtn').trigger('click');
				window.location.assign(response.notvaliduserurl);
			}else if(response.hasOwnProperty('usertypehtml') && response.usertypehtml){
				if(response.hasOwnProperty('userfullname') && response.userfullname){
					var title='';
					if(tablename=='batch_facilitator'){
						title='Facilitator Details - ';
					}else if(tablename=='batch_co_facilitator'){
						title='Co-Facilitator Details - ';
					}else if(tablename=='batch_coordinator'){
						title='Co-Ordinator Details - ';
					}else if(tablename=='batch_volunteer'){
						title='Volunteer Details - ';
					}else if(tablename=='batch_participant'){
						title='Participant Details - ';
					}
					$('#usertypefullname').html(title+response.userfullname);
				}
				$('#usertype_html').html(response.usertypehtml);
			}
		}
	});
}
</script>