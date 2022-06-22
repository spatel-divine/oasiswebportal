<?php include("header.php"); ?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
				<li class="breadcrumb-item active" aria-current="page">OM Project & Programs Overview</li>
			</ol><!-- End breadcrumb -->
		</div>
		<!-- End page-header -->
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<form id="program_overview" name="program_overview" method="post" class="submitform" action="<?php echo base_url('Dashboard/ajax_get_program_overview');?>">
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
									<div class="col-lg-3 col-md-12">
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
										<label>Year</label>
										<select id="year" name="year" class="form-control">
											<option value="">--Select--</option>
											<?php if(isset($yearlist) && $yearlist){
												$current_year=date('Y');
												foreach ($yearlist as $key => $value) {
											?>
												<option value="<?php echo $key; ?>" <?php if($current_year==$key){ echo 'selected'; } ?> ><?php echo $value; ?></option>
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
					<table class="table table-fixed card-table table-vcenter table-bordered text-center">
						<thead>
							<tr>
								<th>Project / Program</th>
								<th>Total OM Programs (Till date)</th>
								<th>Total OM Beneficiaries (Till date)</th>
								<th>Programs <br/>this Year</th>
								<th>Beneficiaries this Year</th>
								<th>Beneficiaries this year (Children & Youths)</th>
								<th>Beneficiaries this year (Adults)</th>
							</tr>
						</thead>
						<tbody id="programoverviewdiv">
							<?php /*
							<tr>
								<td><b>Life & Love Camps</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>Leadership Camps</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>Dream India Camps</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>L3 for Students</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>Saamarthya Project</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>SKAKT Sessions</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>Oasis Sessions</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>Misaal Project</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>MSLD Program</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>MHE Program</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>Jyotirdhar Abhiyaan</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>L3 for Adults</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>Freedom Parenting Workshops</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>Retreats</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>Book Camps</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>Events & Rallies</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>Special Workshops</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td><b>Others</b></td>
								<td></td>
								<td></td>
								<td></td>
								<th></th>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td class="text-right"><b>Total</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
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
			}else if(response.hasOwnProperty('programoverviewhtml')){
            	$('#programoverviewdiv').html(response.programoverviewhtml);
            }
        },
        complete: function(){
          	initResultDataTable();
        }
    });
});
</script>
