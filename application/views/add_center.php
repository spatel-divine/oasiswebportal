<?php include("header.php");?>
<!-- app-content-->
<?php					
	$action = 'add';
	$center_id = "";
	$center_name = set_value('center_name');
	$address = set_value('address');
	$city_id = set_value('city_id');
	$region_id = set_value('region_id');
	$state_id = set_value('state_id');
	$center_contact_no = set_value('center_contact_no');
	if(isset($CenterData) && count($CenterData) >0 ){
		$action  = 'edit';
		$center_id = $CenterData[0]->id;
		$center_name = $CenterData[0]->center_name;
		$address = $CenterData[0]->address;
		$city_id = $CenterData[0]->city_id;
		$region_id = $CenterData[0]->region_id;
		$state_id = $CenterData[0]->state_id;
		$center_contact_no = $CenterData[0]->center_contact_no;
	}
?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Center</a></li>
				<li class="breadcrumb-item active" aria-current="page"><?php echo ucfirst($action); ?> Center</li>
			</ol><!-- End breadcrumb -->
			<div class="ml-auto">
				<div class="input-group">
					<a href="<?php echo site_url('Management/view_centers_list/')?>" class="btn btn-secondary text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="View Data">
						<span>
							<i class="fa fa-eye"></i>&nbsp;View Center List
						</span>
					</a>
				</div>
			</div>
		</div>
		<!-- End page-header -->
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
			<form id="manage_center" name="manage_center"  method="post" action="<?php echo base_url('CenterMst/createCenter');?>">
				<input type="hidden" name="action" value="<?php echo $action; ?>">
				<input type="hidden" name="center_id" value="<?php echo $center_id; ?>">
				<div class="card">
					<div class="card-body">
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6 col-md-12">
									<label>Center Name <font color="red">*</font></label>
									<input type="text" id="center_name" name="center_name" class="form-control" value="<?php echo $center_name;?>" placeholder="Enter Center Name" required data-msg-required="Enter Center Name">
									<label id="center_name-error" class="error validationerror" for="center_name"><?=form_error("center_name");?></label>	
								</div>
								<div class="col-lg-6 col-md-12">
									<label>Address <font color="red">*</font></label>
									<textarea id="address" name="address" class="form-control" placeholder="Enter Center Address" required data-msg-required="Enter Address"><?php echo $address;?></textarea>
									<label id="address-error" class="error validationerror" for="address"><?=form_error("address");?></label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">	
								<div class="col-lg-3 col-md-12">
									<label>State <font color="red">*</font></label>
									<select id="state_id" name="state_id" class="form-control" onchange="return get_region_ajax(this.value);"  required data-msg-required="Please Select State">
										<option value="">Select State</option>
										<?php if(count($state_data) > 0) { 
												foreach($state_data as $item_state){
													$select_state = '';
													if($state_id == $item_state->id){
														  $select_state = 'selected';
													}
											?>
											<option value="<?=$item_state->id;?>" <?=$select_state;?> ><?=$item_state->state_name;?></option>
										<?php } 
										}?>
									</select>
									<label id="state_id-error" class="error validationerror" for="state_id"><?=form_error("state_id");?></label>
								</div>
								<div class="col-lg-3 col-md-12">
									<label>Region</label>
									<select  id="region_id" name="region_id" class="form-control" >
										<option value="">--Select--</option>
									</select>
									<label id="region_id-error" class="error validationerror" for="region_id"><?=form_error("region_id");?></label>	
								</div>
								<div class="col-lg-3 col-md-12">
									<label>City/Town <font color="red">*</font></label>
									<select id="city_id" name="city_id" class="form-control" required data-msg-required="Please Select City/Town">
										<option value="">--Select--</option>
									</select>
									<label id="city_id-error" class="error validationerror" for="city_id"><?=form_error("city_id");?></label>
								</div>
								<div class="col-lg-3 col-md-12">
									<label>Contact No <font color="red">*</font></label>
									<input type="number" id="center_contact_no" name="center_contact_no" class="form-control" value="<?php echo $center_contact_no;?>" placeholder="Enter Contact Number" required data-msg-required="Enter Contact Number" minlength="10" data-msg-minlength="Please Enter Valid Contact Number" maxlength="12" data-msg-maxlength="Please Enter Valid Contact Number">
									<label id="center_contact_no-error" class="error validationerror" for="center_contact_no"><?=form_error("center_contact_no");?></label>
								</div>
							</div>
						</div>
						<hr/>
						<div class="form-group"  style="float:right;">
							<div class="row">
								<input type="submit" name="submit" value="Submit" class="btn btn-app btn-primary mr-2 mt-1 mb-1">
							</div>
						</div>		
					</div>
				</div>
			</form>
			</div>
		</div>
		<!-- row end -->
	</div>
<?php include("footer.php");?>
<script>
$( document ).ready(function() {
<?php if( $state_id !="") {?>
	get_region_ajax(<?php echo $state_id;?>, <?php echo $region_id;?>);
<?php } ?>
});
//get the region
function get_region_ajax(state_id, sel_region_id=""){
	if(state_id){
		var post_data = { 'state_id': state_id, 'sel_region_id': sel_region_id};
		$.ajax({
			method: "POST",
			url: '<?php echo site_url('Management/get_region/'); ?>',
			data: post_data,
			success: function(response)
			{
				var $dist_sele_opt = $('#region_id');
				$dist_sele_opt.empty();				
				$dist_sele_opt.append(response );
				getCityByState(state_id, <?php echo $city_id;?>);
			}
		});
	}else{
		var list='<option value="">--Select--</option>';
		$('#region_id').html(list);
		$('#city_id').html(list);
	}
}
function getCityByState(state_id, sel_city_id=""){
	if(state_id){
		$.ajax({
			type:'POST',
			url:"<?php echo site_url('cityMst/ajax_get_city_by_state'); ?>",
			data:'state_id='+state_id+'&sel_city_id='+sel_city_id,
			success:function(response){
				if(response.hasOwnProperty('citylist') && response.citylist){
					$('#city_id').html(response.citylist);
				}
			}
		});
	}else{
		var citylist='<option value="">--Select--</option>';
		$('#city_id').html(citylist);
	}
}
$('#manage_center').validate();
</script>
