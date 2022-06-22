<?php include("header.php"); ?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
				<li class="breadcrumb-item active" aria-current="page">Monitoring Projects & Programs</li>
			</ol><!-- End breadcrumb -->
		</div>
		<!-- End page-header -->
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<form id="project_program" name="project_program" method="post" class="submitform" action="<?php echo base_url('Dashboard/ajax_get_monitoring_project_program'); ?>">
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
								<th>Project / Program</th>
								<th>Target this year</th>
								<th>Completed</th>
								<th>Pending</th>
								<th>Achievement(in %)</th>
							</tr>
						</thead>
						<tbody id="projectprogramdiv">
							<?php /*
							<tr>
								<td>Life & Love Camps</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Leadership Camps</td>
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
							</tr>
							<tr>
								<td>L3 for Students</td>
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
							</tr>
							<tr>
								<td>SKAKT Sessions</td>
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
							</tr>
							<tr>
								<td>Misaal Project</td>
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
							</tr>
							<tr>
								<td>MHE Program</td>
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
							</tr>
							<tr>
								<td>L3 for Adults</td>
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
							</tr>
							<tr>
								<td>Retreats</td>
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
							</tr>
							<tr>
								<td>Events & Rallies</td>
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
							</tr>
							<tr>
								<td>Others</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>Total</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							*/ ?>
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
			}else if(response.hasOwnProperty('projectprogramhtml')){
            	$('#projectprogramdiv').html(response.projectprogramhtml);
            }
        },
        complete: function(){
          	initResultDataTable();
        }
    });
});
</script>
