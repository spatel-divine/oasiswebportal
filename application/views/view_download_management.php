<?php include("header.php"); ?>
<style type="text/css">
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
				<li class="breadcrumb-item"><a href="#">Download Management</a></li>
				<li class="breadcrumb-item active" aria-current="page">View Download Management</li>
			</ol><!-- End breadcrumb -->
			<div class="ml-auto">
				<div class="input-group">
					<a href="<?php echo site_url('ConnectOM/view_downloads_data_list/')?>" class="btn btn-secondary text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="View Data">
						<span>
							<i class="fa fa-eye"></i>&nbsp;View Downloads List
						</span>
					</a>&nbsp;
				</div>
			</div>
		</div>
		<!-- End page-header -->
		<!-- row -->
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<!--<p class="text-danger">Developer Note : Need to show category according to parent category selection</p>-->
						<div class="form-group">
							<div class="row">				
								<div class="col-lg-6 col-md-12">
									<label>Download Title</label>
									<input type="text" class="form-control" id="downloadtitle" name="downloadtitle" value="<?php if(isset($download_management->downloadtitle) && $download_management->downloadtitle!='' && $download_management->downloadtitle!=null){ echo $download_management->downloadtitle; }else{ echo 'N/A'; } ?>" readonly>	
								</div>
								<div class="col-lg-6 col-md-12">
									<label>Category</label>
									<?php 
									$category='';
									if(isset($download_management->category_id) && $download_management->category_id){
										$category=getDownloadCategoryById($download_management->category_id);
									}
									?>
									<input type="text" class="form-control" id="category_id" name="category_id" value="<?php if($category!=''){ echo $category; }else{ echo 'N/A'; } ?>" readonly>
								</div>
							</div>
						</div>	
						<div class="form-group">
							<div class="row">
								<div class="col-lg-8 col-md-12">
									<label>Upload File</label>
									<div class="table-responsive">
										<table class="table table-striped table-bordered text-wrap text-center">
											<thead>
												<tr>
													<th class="wd-15p">SR No</th>
													<th class="wd-15p">Upload File</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												$files_arr=array();
												if(isset($download_management->id) && $download_management->id){
													$files_arr=getDownloadManagementUploadFileList($download_management->id);
												}
												if($files_arr){
													$i=1;
													foreach ($files_arr as $file){
														?>
														<tr>
															<td><?php echo $i; ?></td>
															<td>
																<?php
																if(isset($file->upload_file) && $file->upload_file!='' && $file->upload_file!=null){ 
																	$filename_arr=explode(".",basename($file->upload_file));
						                							$ext=strtolower(end($filename_arr));
																	$imgfile=array('jpg','jpeg','png','bmp');
																	$audiofile=array('ogg','mp3');
																	$videofile=array('mp4');
																	$otherfile=array('doc','docx','pdf','xls','xlsx','ppt','ppsx');
																	$filepath=base_url().'upload/download_management_upload_file/'.$file->upload_file;
																	if(file_exists('upload/download_management_upload_file/'.$file->upload_file)){ 
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
																	}
																} ?>
															</td>
														</tr>
													<?php	
														$i++;
													}
												}else{ ?>
													<tr>
														<td colspan="2">No Record Available.</td>
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