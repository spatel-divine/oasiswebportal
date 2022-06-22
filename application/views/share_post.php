<?php include("header.php"); 
if(isset($_POST['posttitle'])){
	$posttitle = set_value('posttitle');	
}else if(isset($share_post->posttitle) && $share_post->posttitle!='' && $share_post->posttitle!=null){
	$posttitle = $share_post->posttitle;
}
if(isset($_POST['category_id'])){
	$category_id = set_value('category_id');	
}else if(isset($share_post->category_id) && $share_post->category_id!='' && $share_post->category_id!=null){
	$category_id = $share_post->category_id;
}
if(isset($_POST['post_description'])){
	$post_description = set_value('post_description');	
}else if(isset($share_post->post_description) && $share_post->post_description!='' && $share_post->post_description!=null){
	$post_description = $share_post->post_description;
}
$featured_image='';
if(isset($share_post->featured_image) && $share_post->featured_image!='' && $share_post->featured_image!=null){ 
	$featured_image=$share_post->featured_image;
}
$share_post_id='';
$files_arr=array();	
if(isset($share_post->id) && $share_post->id!='' && $share_post->id!=null){
	$share_post_id=base64_encode($share_post->id);
	$files_arr=getSharePostUploadFileList($share_post->id);
}
?>
<style type="text/css">
	.imgfile{
		cursor:pointer;
		max-height: 100%;
		width: 300px;
    	height: 300px;
	}
</style>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Share With Us</a></li>
				<li class="breadcrumb-item active" aria-current="page">Share Post</li>
			</ol><!-- End breadcrumb -->
			<div class="ml-auto">
				<div class="input-group">
					<a href="<?php echo site_url('ConnectOM/view_shared_post_list/')?>" class="btn btn-secondary text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="View Data">
						<span>
							<i class="fa fa-eye"></i>&nbsp;View Shared Post List
						</span>
					</a>&nbsp;
				</div>
			</div>
		</div>
		<!-- End page-header -->
		<!-- row -->
		<?php
			if($this->session->flashdata('success_message')){
				echo '<div class="alert alert-success"><font color="white"><b><a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:#fff;">&times;</a>
					'.$this->session->flashdata("success_message").'
				</b></font></div>';
			}
		?>
		<?php
			if($this->session->flashdata('error_message')){
				echo '<div class="alert alert-danger"><font color="white"><b><a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:#fff;">&times;</a>
					'.$this->session->flashdata("error_message").'
				</b></font></div>';
			}
		?>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<form id="share_post" name="share_post" method="post" action="<?php echo base_url('connectOM/share_post');?>" enctype="multipart/form-data">
						<div class="card-body">
							<!--<p class="text-danger">Developer Note : Need to show category according to parent category selection</p>-->
							<div class="form-group">
								<div class="row">				
									<div class="col-lg-6 col-md-12">
										<label>Post Title <font color="red">*</font></label>
										<input type="text" class="form-control" id="posttitle" name="posttitle" value="<?php if(isset($posttitle) && $posttitle){ echo $posttitle; } ?>" placeholder="Enter Post Title" required data-msg-required="Enter Post Title">	
										<label id="posttitle-error" class="error validationerror" for="posttitle"><?=form_error("posttitle");?></label>
									</div>
									<?php /* <div class="col-lg-3 col-md-12">
										<label>Parent Category</label>
										<select name="parent_category" class="form-control">
											<option value="Share Stories">Share Stories</option>
											<option value="Contact Us">Contact Us</option>
											<option value="Download">Download</option>
										</select>
										<font color="red"><?=form_error("parent_category");?></font>
									</div> */ ?>
									<div class="col-lg-6 col-md-12">
										<label>Category <font color="red">*</font></label>
										<select id="category_id" name="category_id" class="form-control" required data-msg-required="Please Select Category">
											<option value="">--Select--</option>
											<?php if(isset($post_category_list) && $post_category_list!='' && $post_category_list!=null){
												foreach ($post_category_list as $post_category) { 
											?>
												<option value="<?php echo $post_category->id; ?>" <?php if(isset($category_id) && $category_id==$post_category->id){ echo 'selected'; } ?>><?php echo $post_category->category_name; ?></option>
											<?php } 
											} ?>
										</select>
										<label id="category_id-error" class="error validationerror" for="category_id"><?=form_error("category_id");?></label>
									</div>
								</div>
							</div>	
							<div class="form-group">
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<label>Post Description <font color="red">*</font></label>
										<textarea id="post_description" name="post_description" placeholder="Enter Post Description" class="form-control" required data-msg-required="Enter Post Description"><?php if(isset($post_description) && $post_description){ echo $post_description; } ?></textarea>
										<label id="post_description-error" class="error validationerror" for="post_description"><?=form_error("post_description");?></label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-8 col-md-12">
										<label>Featured Image <?php if($featured_image==''){ echo '<font color="red">*</font>'; }?></label>
										<input type="file" class="dropify" id="featured_image" name="featured_image"  class="dropify" value="" <?php if($featured_image==''){ echo 'required data-msg-required="Please Select Featured Image"'; }?> >
										<label id="featured_image-error" class="error validationerror" for="featured_image"><?php if(isset($featured_image_error) && $featured_image_error){ echo $featured_image_error; }else{ echo form_error("featured_image"); } ?></label>
										<input type="hidden" id="old_featured_image_name" name="old_featured_image_name" value="<?php echo $featured_image; ?>"/>
									</div>
									<div  class="col-lg-4 col-md-12">
										<label style="visibility:hidden">Featured Image View</label>
										<p>
										<?php 
										if($featured_image!=''){ 
											$filepath=base_url().'upload/featured_images/'.$featured_image;
											if(file_exists('upload/featured_images/'.$featured_image)){ ?>
												<a target="_blank" href="<?php echo $filepath; ?>"><img class="imgfile" src="<?php echo $filepath; ?>"/></a>
											<?php }
										} ?>
										</p>
									</div>
								</div>
							</div>
							<div id="success_message_block"></div>
							<div id="error_message_block"></div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-8 col-md-12">
										<label>Upload File <font id="lbl_upload_file_req" color="red"><?php if(empty($files_arr)){ echo '*'; } ?></font></label>
										<?php
										if($files_arr){ ?>
											<div id="file_upload_html" class="table-responsive">
												<table class="table table-striped table-bordered text-wrap text-center">
													<thead>
														<tr>
															<th class="wd-15p">SR No</th>
															<th class="wd-15p">Upload File</th>
															<th class="wd-15p">Delete</th>
														</tr>
													</thead>
													<tbody>
														<?php $i=1;
														foreach($files_arr as $file){ ?>
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
																		$filepath=base_url().'upload/upload_file/'.$file->upload_file;
																		if(file_exists('upload/upload_file/'.$file->upload_file)){ 
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
																<td style="width:20px;"><a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="deleteSharePostFileUpload('<?php echo base64_encode($file->id); ?>','<?php echo base64_encode($file->share_post_id); ?>');"><i class="fa fa-trash"></i> Delete</a></td>
															</tr>
														<?php	
															$i++;
														} ?>
													</tbody>
												</table>
											</div>
										<?php } ?>
										
									</div>
									<div <?php if(empty($files_arr)){ echo 'class="col-lg-8 col-md-12"'; }else{ echo 'class="col-lg-4 col-md-12"'; } ?>>
										<label style="visibility:hidden">Upload File View</label>
										<input type="file" class="dropify" name="upload_file[]" id="upload_file" class="dropify" value="" multiple <?php if(empty($files_arr)){ echo 'required'; } ?> data-msg-required="Please Select Upload File">
										<p class="text-danger">Allowed Upload Types are Audio,Video,Image,Pdf,Doc,PPT,Excel</p>
										<label id="upload_file-error" class="error validationerror" for="upload_file"><?php if(isset($upload_file_error) && $upload_file_error){ echo $upload_file_error; }else{ echo form_error("upload_file"); } ?></label>
									</div>
								</div>
							</div>											
							<hr/>
							<input type="hidden" id="share_post_id" name="share_post_id" value="<?php echo $share_post_id; ?>">
							<div class="form-group"  style="float:right;">
								<div class="row">
									<input type="submit" name="submit" value="Submit" class="btn btn-app btn-primary mr-2 mt-1 mb-1">
								</div>
							</div>		
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- row end -->
	</div>
<?php include("footer.php"); ?>
<script type="text/javascript">
	$('#share_post').validate();
	function deleteSharePostFileUpload(id,share_post_id){
		var res=confirm("Are you sure that you want to delete this file?");
		if(res){
			$('#success_message_block').html('');
			$('#error_message_block').html('');
			$.ajax({
				type:'POST',
				url:"<?php echo site_url('connectOM/ajax_delete_share_post_file_upload'); ?>",
				data:'id='+id+'&share_post_id='+share_post_id,
				success:function(response){
					if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
						window.location.assign(response.notvaliduserurl);
					}else if(response.hasOwnProperty('success_message') && response.success_message){
						$('#success_message_block').html(response.success_message);
						if(response.hasOwnProperty('file_upload_html') && response.file_upload_html){
							$('#file_upload_html').html(response.file_upload_html);
						}else{
							$('#file_upload_html').html('');
							$('#lbl_upload_file_req').html("*");
							$('#upload_file').addClass('required');
						}
					}else if(response.hasOwnProperty('error_message') && response.error_message){
						$('#error_message_block').html(response.error_message);
					}
				}
			});
		}
		return false;
	}
</script>