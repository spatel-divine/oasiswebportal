<?php include("header.php"); ?>
<style type="text/css">
	.fieldlbl{
		color: #212529 !important;
		font-weight: bold !important;
	}
	.fieldvalue{
		text-align: left !important;
		width:100% !important;
	}
	.imgfile{
		cursor:pointer;
		max-height: 100%;
		width: 300px;
    	height: 300px;
	}
	p.imgcontainer{
		display: inline-block;
	}
	p.doccontainer a{
		color: #000 !important;
	}
</style>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<?php 
				$tname='';
				if(isset($tablename) && $tablename){
					$tname=ucwords(str_replace('_', ' ', $tablename));
				} ?>
				<li class="breadcrumb-item"><a href="#">Report</a></li>
				<li class="breadcrumb-item active" aria-current="page">View <?php echo $tname; ?></li>
			</ol><!-- End breadcrumb -->
		</div>
		<!-- End page-header -->
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<?php
							if(isset($reviewdetails) && $reviewdetails){
								foreach($reviewdetails as $key => $value){ ?>
									<div class="form-group">
										<div class="row">				
											<div class="col-lg-4 col-md-12 ">
												<label class="fieldlbl"><?php echo ucwords(str_replace('_',' ',$key)); ?></label>
											</div>
											<div class="col-lg-6 col-md-12">
												<label class="btn btn-info text-white fieldvalue btn-primary">
													<?php 
													$ddlarr=array('batch_name','user_type','session','state','district','villageorcity','qualities_observed','next_level_program','next_level_role','which_first_program_did_you_attend_at_oasis');
													if(in_array($key,$ddlarr)){
														echo getDDLOptionByRelatedFieldName($key,$value);
													}else{
														echo $value;
													}
													?>
												</label>
											</div>
										</div>
									</div>
							<?php }
							} 
						?>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-10 col-md-12">
									<div class="table-responsive">
										<table class="table table-striped table-bordered text-wrap text-center">
											<thead>
												<tr>
													<th class="wd-15p">SR No</th>
													<th class="wd-15p">Label</th>
													<th class="wd-15p">File</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												if($reviews_files){
													$i=1;
													foreach ($reviews_files as $file){
														?>
														<tr>
															<td><?php echo $i; ?></td>
															<td><?php echo ucwords(str_replace('_',' ',$file->field_name)); ?></td>
															<td>
																<?php
																if(isset($file->upload_file) && $file->upload_file!='' && $file->upload_file!=null){ 
																	$filename_arr=explode(".",basename($file->upload_file));
						                							$ext=strtolower(end($filename_arr));
																	$imgfile=array('jpg','jpeg','png','bmp');
																	$audiofile=array('ogg','mp3');
																	$videofile=array('mp4');
																	$otherfile=array('doc','docx','pdf','xls','xlsx','ppt','ppsx');
																	if($tablename=='personal_learning_review'){
																		$foldername='personal_reflection_review';
																	}else{
																		$foldername=$tablename;
																	}
																	$filepath=base_url().'upload/'.$foldername.'/'.$file->upload_file;
																	if(file_exists('upload/'.$foldername.'/'.$file->upload_file)){ 
																		if(in_array($ext,$imgfile)){ ?>
																			<p class='imgcontainer'><a target="_blank" href="<?php echo $filepath; ?>"><img class="imgfile" src="<?php echo $filepath; ?>"/></a></p>
																  <?php }else if(in_array($ext,$otherfile)){ ?>
																  			<p class='doccontainer'><a target="_blank" href="<?php echo $filepath; ?>"><span><?php echo $file->upload_file; ?></span></a></p>
																  <?php }else if(in_array($ext,$audiofile)){ ?>
																  			<p class='audiocontainer'>
																  				<audio controls>
																  					<?php if($ext=='opp'){ ?>
																				  		<source src="<?php echo $filepath; ?>" type="audio/ogg">
																				  	<?php }else{ ?>
																				  		<source src="<?php echo $filepath; ?>" type="audio/mpeg">
																				  	<?php } ?>
																					Your browser does not support the audio element.
																				</audio>
																			</p>
																  <?php }else if(in_array($ext,$videofile)){ ?>
																  			<p class='videocontainer'>
																  				<video width="320" height="240" controls>
																				  <source src="<?php echo $filepath; ?>" type="video/mp4">
																					Your browser does not support the video tag.
																				</video>
																			</p>
																  <?php }
																	}else{
																		echo 'Sorry, File Not Exists';
																	}
																} ?>
															</td>
														</tr>
													<?php	
														$i++;
													}
												}else{ ?>
													<tr>
														<td colspan="3">No Record Available.</td>
													</tr>
												<?php }
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>
		<!-- row end -->
	</div>
<?php include("footer.php"); ?>