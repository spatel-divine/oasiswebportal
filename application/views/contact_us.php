<?php include("header.php"); 
$head_office_id='';
if(isset($head_office->id) && $head_office->id!='' && $head_office->id!=null){
	$head_office_id=base64_encode($head_office->id);
}
$head_office_address='';
if(isset($head_office->address) && $head_office->address!='' && $head_office->address!=null){
	$head_office_address=$head_office->address;
}
$head_office_phone='';
if(isset($head_office->phone) && $head_office->phone!='' && $head_office->phone!=null){
	$head_office_phone=$head_office->phone;
}
$head_office_email='';
if(isset($head_office->email) && $head_office->email!='' && $head_office->email!=null){
	$head_office_email=$head_office->email;
}
$valleys_institute_id='';
if(isset($valleys_institute->id) && $valleys_institute->id!='' && $valleys_institute->id!=null){
	$valleys_institute_id=base64_encode($valleys_institute->id);
}
$valleys_institute_address='';
if(isset($valleys_institute->address) && $valleys_institute->address!='' && $valleys_institute->address!=null){
	$valleys_institute_address=$valleys_institute->address;
}
$valleys_institute_phone='';
if(isset($valleys_institute->phone) && $valleys_institute->phone!='' && $valleys_institute->phone!=null){
	$valleys_institute_phone=$valleys_institute->phone;
}
$valleys_institute_email='';
if(isset($valleys_institute->email) && $valleys_institute->email!='' && $valleys_institute->email!=null){
	$valleys_institute_email=$valleys_institute->email;
}
?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Connect With OM</a></li>
				<li class="breadcrumb-item active" aria-current="page">Contact Us</li>
			</ol><!-- End breadcrumb -->
		</div>
		<!-- End page-header -->
								
		<div id="message_block"></div>
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<!-- row -->
						<div class="row">
							<div class="col-sm-12 col-md-12 col-lg-6 col-xl-4 ">
								<div id="head_office" class="card">
									<div class="card-body">
										<div class="item-box text-center">
											<div class="stamp text-center stamp-lg bg-dark mb-4 "><i class="fa fa-building-o"></i></div>
											<div class="item-box-wrap">
												<h4 class="mb-2 font-weight-semibold">Oasis Head Office:</h4>
												<address>
													Oasis Movement<br>
													<span id="head_office_address"><?php echo $head_office_address; ?></span><br>
													Phone: <span id="head_office_phone"><a href="tel:<?php echo $head_office_phone; ?>"><?php echo $head_office_phone; ?></a></span><br>
													Email: <span id="head_office_email"><a href="mailto:<?php echo $head_office_email; ?>"><?php echo $head_office_email; ?></a></span>
												</address>
											</div>
											<a href="javascript:void(0);" class="btn btn-primary btn-lg" onclick="openContactUs('head_office');"><i class="fa fa-edit"></i>&nbsp;Edit</a>
										</div>
									</div>
								</div>
								<form id="contact_us_head_office" name="contact_us_head_office"  method="post" action="<?php echo base_url('connectOM/ajax_update_contact_us'); ?>" class="contact_us_submitform" style="display:none;">
									<input type="hidden" id="type" name="type" value="Head Office">
									<input type="hidden" id="head_office_id" name="id" value="<?php echo $head_office_id; ?>">
									<div class="card">
										<div class="card-body">
											<div class="item-box text-center">
												<div class="stamp text-center stamp-lg bg-dark mb-4 "><i class="fa fa-building-o"></i></div>
												<div class="item-box-wrap">
													<h4 class="mb-2 font-weight-semibold">Oasis Head Office:</h4>
												</div>
											</div>
											<div class="form-group">
												<div class="row">
													<div class="col-lg-12 col-md-12">
														<label>Address <font color="red">*</font></label>
														<textarea id="contact_us_head_office_address" name="address" class="form-control" placeholder="Enter Head Office Address" required data-msg-required="Enter Address"><?php echo $head_office_address; ?></textarea>
														<label id="contact_us_head_office_address-error" class="error validationerror" for="contact_us_head_office_address"></label>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="row">
													<div class="col-lg-12 col-md-12">
														<label>Phone <font color="red">*</font></label>
														<input type="text" id="contact_us_head_office_phone" name="phone" class="form-control" placeholder="Enter Phone Number" required data-msg-required="Enter Phone Number" maxlength="15" data-msg-maxlength="Please Enter Valid Phone Number" value="<?php echo $head_office_phone; ?>">
														<label id="contact_us_head_office_phone-error" class="error validationerror" for="contact_us_head_office_phone"></label>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="row">
													<div class="col-lg-12 col-md-12">
														<label>Email <font color="red">*</font></label>
														<input type="email" id="contact_us_head_office_email" name="email" class="form-control" placeholder="Enter Email Address" required data-msg-required="Enter Email Address" data-msg-email="Please Enter Valid Email Address" value="<?php echo $head_office_email; ?>">
														<label id="contact_us_head_office_email-error" class="error validationerror" for="contact_us_head_office_email"></label>
													</div>
												</div>
											</div>
											<hr/>
											<div class="form-group"  style="float:right;">
												<div class="row">
													<input type="submit" name="submit" value="Submit" class="btn btn-app btn-primary mr-2 mt-1 mb-1">
													<input type="button" name="cancelbtn" value="Cancel" class="btn btn-app btn-primary mr-2 mt-1 mb-1" onclick="cancelContactUs('head_office');">
												</div>
											</div>	
										</div>
									</div>
								</form>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-6 col-xl-4">
								<div id="valleys_institute" class="card">
									<div class="card-body">
										<div class="item-box text-center">
											<div class="stamp text-center stamp-lg bg-dark mb-4"><i class="fa fa-institution"></i></div>
											<div class="item-box-wrap">
												<h4 class="mb-2 font-weight-semibold">Oasis Valleys Institute:</h4>
												<address>
													Oasis Valleys<br>
													<span id="valleys_institute_address"><?php echo $valleys_institute_address; ?></span><br>
													Phone: <span id="valleys_institute_phone"><a href="tel:<?php echo $valleys_institute_phone; ?>"><?php echo $valleys_institute_phone; ?></a></span><br>
													Email: <span id="valleys_institute_email"><a href="mailto:<?php echo $valleys_institute_email; ?>"><?php echo $valleys_institute_email; ?></a></span>
												</address>
											</div>
											<a href="javascript:void(0);" class="btn btn-primary btn-lg" onclick="openContactUs('valleys_institute');"><i class="fa fa-edit"></i>&nbsp;Edit</a>
										</div>
									</div>
								</div>
								<form id="contact_us_valleys_institute" name="contact_us_valleys_institute"  method="post" action="<?php echo base_url('connectOM/ajax_update_contact_us'); ?>" class="contact_us_submitform" style="display:none;">
									<input type="hidden" id="type" name="type" value="Valleys Institute">
									<input type="hidden" id="valleys_institute_id" name="id" value="<?php echo $valleys_institute_id; ?>">
									<div class="card">
										<div class="card-body">
											<div class="item-box text-center">
												<div class="stamp text-center stamp-lg bg-dark mb-4"><i class="fa fa-institution"></i></div>
												<div class="item-box-wrap">
													<h4 class="mb-2 font-weight-semibold">Oasis Valleys Institute:</h4>
												</div>
											</div>
											<div class="form-group">
												<div class="row">
													<div class="col-lg-12 col-md-12">
														<label>Address <font color="red">*</font></label>
														<textarea id="contact_us_valleys_institute_address" name="address" class="form-control" placeholder="Enter Head Office Address" required data-msg-required="Enter Address"><?php echo $valleys_institute_address; ?></textarea>
														<label id="contact_us_valleys_institute_address-error" class="error validationerror" for="contact_us_valleys_institute_address"></label>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="row">
													<div class="col-lg-12 col-md-12">
														<label>Phone <font color="red">*</font></label>
														<input type="text" id="contact_us_valleys_institute_phone" name="phone" class="form-control" placeholder="Enter Phone Number" required data-msg-required="Enter Phone Number" maxlength="15" data-msg-maxlength="Please Enter Valid Phone Number" value="<?php echo $valleys_institute_phone; ?>">
														<label id="contact_us_valleys_institute_phone-error" class="error validationerror" for="contact_us_valleys_institute_phone"></label>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="row">
													<div class="col-lg-12 col-md-12">
														<label>Email <font color="red">*</font></label>
														<input type="email" id="contact_us_valleys_institute_email" name="email" class="form-control" placeholder="Enter Email Address" required data-msg-required="Enter Email Address" data-msg-email="Please Enter Valid Email Address" value="<?php echo $valleys_institute_email; ?>">
														<label id="contact_us_valleys_institute_email-error" class="error validationerror" for="contact_us_valleys_institute_email"></label>
													</div>
												</div>
											</div>
											<hr/>
											<div class="form-group"  style="float:right;">
												<div class="row">
													<input type="submit" name="submit" value="Submit" class="btn btn-app btn-primary mr-2 mt-1 mb-1">
													<input type="button" name="cancelbtn" value="Cancel" class="btn btn-app btn-primary mr-2 mt-1 mb-1" onclick="cancelContactUs('valleys_institute');">
												</div>
											</div>	
										</div>
									</div>
								</form>
							</div>
							<div class="col-sm-12 col-md-12 col-lg-6 col-xl-4">
								<div class="card">
									<div class="card-body">
										<div class="item-box text-center">
											<div class="stamp text-center stamp-lg bg-dark mb-4"><i class="fa fa-align-center"></i></div>
											<div class="item-box-wrap">
												<h4 class="mb-2 font-weight-semibold">Oasis Regional Centres:</h4>								
												<div class="row">
													<form id="get_center" name="get_center" method="post" action="<?php echo base_url('connectOM/ajax_get_center');?>" class="submitform">
														<div class="col-md-12">
															<div class="form-group">
																<div class="row">
																	<div class="col-lg-5 col-md-12">
																		<label>State</label>
																		<select id="state_id" name="state_id" class="form-control" >
																			<option value="">--Select--</option>
																			<?php if(isset($statelist) && $statelist){
																				foreach($statelist as $state){ ?>
																				<option value="<?php echo $state->id; ?>" <?php if(isset($state_id) && $state_id==$state->id){ echo 'selected';} ?>><?php echo ucfirst($state->state_name); ?></option>
																			<?php }
																			} ?>
																		</select>
																	</div>
																	<div class="col-lg-5 col-md-12">
																		<label>Region</label>
																		<select id="region_id" name="region_id" class="form-control">	
																			<option value="">--Select--</option>
																			<?php if(isset($regionlist) && $regionlist){
																				foreach($regionlist as $region){ ?>
																				<option value="<?php echo $region->id; ?>" <?php if(isset($region_id) && $region_id==$region->id){ echo 'selected';} ?>><?php echo ucfirst($region->region_name); ?></option>
																			<?php }
																			} ?>
																		</select>
																	</div>
																	<div class="col-lg-1 col-md-12">
																		<input type="submit" name="submit" value="Filter" class="btn btn-app btn-primary" style="margin-top:28px;min-width:10px !important;">
																	</div>
																	<label id="region_id-error" class="error validationerror" for="region_id" style="margin-left:10px;"></label>	
																</div>
															</div>
														</div>
													</form>
												</div>
												<!-- row end -->
												<table id="centerlist" class="table text-left">
													<tr>
														<th class="font-weight-600">Center Name</th>
														<th class="font-weight-600">Contact No</th>
													</tr>
													<?php if(isset($centerlist) && $centerlist!='' && $centerlist!=null){ 
														foreach($centerlist as $center){ ?>
															<tr>
																<?php 
																if(isset($center->center_name) && $center->center_name!='' && $center->center_name!=null){ ?>
																	<td><?php echo $center->center_name; ?></td>
																<?php }else{ ?>
																	<td>-</td>
																<?php }
																if(isset($center->center_contact_no) && $center->center_contact_no!='' && $center->center_contact_no!=null){ ?>
																	<td><a href="tel:<?php echo $center->center_contact_no; ?>"><?php echo $center->center_contact_no; ?></a></td>
																<?php }else{ ?>
																	<td>-</td>
																<?php } ?>
															</tr>
													<?php } 
													} ?>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- row end -->
					</div>
				</div>
			</div>
		</div>
		<!-- row end -->
	</div>
<?php include("footer.php"); ?>
<script type="text/javascript">
$('#state_id').on('change',function(){
	var state_id=$(this).val();
	if(state_id){
		$.ajax({
			type:'POST',
			url:"<?php echo site_url('regionMst/ajax_get_region_by_state'); ?>",
			data:'state_id='+state_id,
			success:function(response){
				if(response.hasOwnProperty('regionlist') && response.regionlist){
					$('#region_id').html(response.regionlist);
				}
			}
		});
	}else{
		var regionlist='<option value="">--Select--</option>';
		$('#region_id').html(regionlist);
		$('#region_id').trigger('change');
	}
});
$('#search_batch').validate();
$(".submitform").on('submit',function(event){
	/* stop form from submitting normally */
	event.preventDefault();
	var state_id=$('#state_id').val();
	var region_id=$('#region_id').val();
	$('#region_id-error').html('');
	if(!(state_id) && !(region_id)){
		$('#region_id-error').html('Please Select State Or Region');
	}else{
		/* get the action attribute from the <form action=""> element */
		var form = $(this),
		url = form.attr('action');
		postData =form.serialize();
		$.ajax({
	        type: "post",
	        url: url,
	        data: postData,
	        success: function(response){
	        	if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
					$('#closebtn').trigger('click');
					window.location.assign(response.notvaliduserurl);
				}else if(response.hasOwnProperty('centerhtml')){
	            	$('#centerlist').html(response.centerhtml);
	            }
	        }
	    });
	}
});
function openContactUs(type){
	$('#'+type).fadeOut(0);
	$('#contact_us_'+type).fadeIn(0);
}
function cancelContactUs(type){
	$('#contact_us_'+type).fadeOut(0);
	$('#'+type).fadeIn(0);
}
$('#contact_us_head_office').validate();
$(".contact_us_submitform").on('submit',function(event){
	/* stop form from submitting normally */
	event.preventDefault();
	var type=$(this).find('#type').val();
	type=type.replace(" ", "_");
	type=type.toLowerCase();
	var form = $(this),
	url = form.attr('action');
	postData =form.serialize();
	$.ajax({
        type: "post",
        url: url,
        data: postData,
        success: function(response){
        	if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
				$('#closebtn').trigger('click');
				window.location.assign(response.notvaliduserurl);
			}else if(response.hasOwnProperty('success_message') && response.success_message){
				$('#message_block').html(response.success_message);
				cancelContactUs(type);
				$('#'+type+'_address').html(response.address);
				$('#'+type+'_phone').html(response.phone);
				$('#'+type+'_email').html(response.email);
			}else if(response.hasOwnProperty('error_message') && response.error_message){
				$('#message_block').html(response.error_message);
				cancelContactUs(type);
			}else{
				if(response.hasOwnProperty('address') && response.address){
					$('#contact_us_'+type+'_address-error').fadeIn(0);
					$('#contact_us_'+type+'_address-error').html(response.address);
				}
				if(response.hasOwnProperty('phone') && response.phone){
					$('#contact_us_'+type+'_phone-error').fadeIn(0);
					$('#contact_us_'+type+'_phone-error').html(response.phone);
				}
				if(response.hasOwnProperty('email') && response.email){
					$('#contact_us_'+type+'_email-error').fadeIn(0);
					$('#contact_us_'+type+'_email-error').html(response.email);
				}
			}
        }
    });
});
</script>