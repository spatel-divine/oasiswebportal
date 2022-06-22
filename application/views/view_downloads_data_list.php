<?php include("header.php"); ?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Download Management</a></li>
				<li class="breadcrumb-item active" aria-current="page">View Downloads List</li>
			</ol><!-- End breadcrumb -->
			<div class="ml-auto">
				<div class="input-group">
					<a href="<?php echo site_url('ConnectOM/add_download_data/')?>" class="btn btn-info text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add New">
						<span>
							<i class="fa fa-plus"></i>&nbsp;Add Data in Downloads
						</span>
					</a>
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
								<th>Download Title</th>
								<th>Category</th>
								<th style="width:20px;">View</th>
								<th style="width:20px;">Edit</th>
								<th style="width:20px;">Delete</th>
								<th style="width:20px;">Download</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if(isset($download_management_list) && $download_management_list){
								foreach ($download_management_list as $download_management){ 
									$category='';
									if(isset($download_management->category_id) && $download_management->category_id){
										$category=getDownloadCategoryById($download_management->category_id);
									}
									$download_management_id='';
									if(isset($download_management->id) && $download_management->id){
										$download_management_id=base64_encode($download_management->id);
									}
									?>
									<tr>
										<td><?php if(isset($download_management->downloadtitle) && $download_management->downloadtitle){ echo $download_management->downloadtitle; }else{ echo '-'; } ?></td>
										<td><?php if($category!=''){ echo $category; }else{  echo '-'; } ?></td>
										<th style="width:20px;"><a class="btn btn-info btn-sm" href="<?php echo site_url('ConnectOM/view_download_management/').$download_management_id; ?>"><i class="fa fa-eye"></i> View</a></th>	
										<td style="width:20px;"><a class="btn btn-secondary btn-sm" href="<?php echo site_url('ConnectOM/add_download_data/').$download_management_id; ?>"><i class="fa fa-edit"></i> Edit</a></td>
										<td style="width:20px;"><a class="btn btn-danger btn-sm" href="javascript:void(0);" onclick="deleteDownloadManagement('<?php echo $download_management_id; ?>');"><i class="fa fa-trash"></i> Delete</a></td>
										<td style="width:20px;"><a class="btn btn-success btn-sm" href="<?php echo site_url('ConnectOM/download_download_management/').$download_management_id; ?>"><i class="fa fa-download"></i> Download</a></td>		
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
<?php include("footer.php"); ?>
<script>
function deleteDownloadManagement(id){
	var res=confirm("Are you sure that you want to delete this record?");
	if(res){
		var url="<?php echo site_url('connectOM/delete_download_management/'); ?>"+id;
		window.location.assign(url);
	}
	return false;
}
</script>