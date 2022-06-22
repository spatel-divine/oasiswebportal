<?php include("header.php");?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Share With Us</a></li>
				<li class="breadcrumb-item active" aria-current="page">View Shared Post List</li>
			</ol><!-- End breadcrumb -->
			<div class="ml-auto">
				<div class="input-group">
					<a href="<?php echo site_url('ConnectOM/share_post/')?>" class="btn btn-info text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add New">
						<span>
							<i class="fa fa-plus"></i>&nbsp;Share Post
						</span>
					</a>&nbsp;
					<a href="<?php echo site_url('ConnectOM/view_downloads_data_list/')?>" class="btn btn-success text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Download">
						<span>
							<i class="fa fa-download"></i>&nbsp;Download Management
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
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="example2" class="table table-striped table-bordered text-wrap" >
						<thead>
							<tr>
								<th>Post Title</th>
								<!--<th>Parent Category</th>-->
								<th>Category</th>
								<th style="width:20px;">View</th>
								<th style="width:20px;">Edit</th>
								<th style="width:20px;">Delete</th>
								<th style="width:20px;">Download</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if(isset($share_post_list) && $share_post_list){
								foreach ($share_post_list as $share_post){ 
									$category='';
									if(isset($share_post->category_id) && $share_post->category_id){
										$category=getCategoryById($share_post->category_id);
									}
									$share_post_id='';
									if(isset($share_post->id) && $share_post->id){
										$share_post_id=base64_encode($share_post->id);
									}
									?>
									<tr>
										<td><?php if(isset($share_post->posttitle) && $share_post->posttitle){ echo $share_post->posttitle; }else{ echo '-'; } ?></td>
										<td><?php if($category!=''){ echo $category; }else{  echo '-'; } ?></td>
										<th style="width:20px;"><a class="btn btn-info btn-sm" href="<?php echo site_url('ConnectOM/view_share_post/').$share_post_id; ?>"><i class="fa fa-eye"></i> View</a></th>	
										<td style="width:20px;"><a class="btn btn-secondary btn-sm" href="<?php echo site_url('ConnectOM/share_post/').$share_post_id; ?>"><i class="fa fa-edit"></i> Edit</a></td>
										<td style="width:20px;"><a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="deleteSharePost('<?php echo $share_post_id; ?>');"><i class="fa fa-trash"></i> Delete</a></td>
										<td style="width:20px;"><a class="btn btn-success btn-sm" href="<?php echo site_url('ConnectOM/download_share_post/').$share_post_id; ?>"><i class="fa fa-download"></i> Download</a></td>		
									</tr>	
							<?php }
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
<?php include("footer.php");?>
<script>
function deleteSharePost(id){
	var res=confirm("Are you sure that you want to delete this record?");
	if(res){
		var url="<?php echo site_url('connectOM/delete_share_post/'); ?>"+id;
		window.location.assign(url);
	}
	return false;
}
</script>