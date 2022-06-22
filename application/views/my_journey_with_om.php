<?php include("header.php");?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
				<li class="breadcrumb-item active" aria-current="page">
					<?php 
					if(isset($fullname) && $fullname){
						echo $fullname.' - Your Journey With OM';
					}else{
						echo 'Your Journey With OM';
					}  ?>
				</li>
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
								<th>Batch Name</th>
								<th>Program Name</th>
								<th>Batch Location</th>
								<th>Start Date</th>
								<th>End Date</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if(isset($batchlist) && $batchlist){
								foreach ($batchlist as $batch){
									$batch_name='-';
									if(isset($batch->batch_name) && $batch->batch_name){
										$batch_name=$batch->batch_name;
									}
									$program_name='-';
									if(isset($batch->program_name) && $batch->program_name){
										$program_name=$batch->program_name;
									}
									$location='-';
									if(isset($batch->location) && $batch->location){
										$location=$batch->location;
									}
									$start_date='-';
									if(isset($batch->start_date) && $batch->start_date){
										$start_date=date('d-m-Y',strtotime($batch->start_date));
									}
									$end_date='-';
									if(isset($batch->end_date) && $batch->end_date){
										$end_date=date('d-m-Y',strtotime($batch->end_date));
									}
									echo '<tr><td>'.$batch_name.'</td><td>'.$program_name.'</td><td>'.$location.'</td><td>'.$start_date.'</td><td>'.$end_date.'</td></tr>';
								}
							}else{
								echo '<tr><td colspan="4">No Record Available</td></tr>';
							}
							?>
							<?php /* <tr>
								<td>FPW-ST-Guj-Gen4</td>
								<td>Freedom Parenting Workshop</td>
								<td>Shairu Gems</td>
								<td>29-02-2020,9:00AM</td>
								<td>18-06-2020,12:00AM</td>
							</tr>
							<tr>
								<td>L3T-2017-Guj-Opengroup2</td>
								<td>L3 Teen</td>
								<td>Oasis Valleys</td>
								<td>31-10-2017,9:00AM</td>
								<td>31-12-2020,9:00AM</td>
							</tr> */ ?>
						</tbody>
					</table>
				</div>
				<!-- table-responsive -->
			</div><!-- col end -->
		</div>
		<!-- row end -->
	</div>
<?php include("footer.php"); ?>