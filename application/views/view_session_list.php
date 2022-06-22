<?php include("header.php");?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Program</a></li>
				<li class="breadcrumb-item active" aria-current="page">Session Management</li>
			</ol><!-- End breadcrumb -->
			<div class="ml-auto">
				<div class="input-group">
					<a href="<?php echo site_url('Management/program_session')?>" class="btn btn-info text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add New">
						<span>
							<i class="fa fa-plus"></i>&nbsp;Add New Session
						</span>
					</a>
				</div>
			</div>
		</div>
		<!-- End page-header -->

		<!-- row -->
		<?php
			if($this->session->flashdata('message')){
				echo '<div class="alert alert-success"><font color="white"><b><a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:#fff;">&times;</a>
					'.$this->session->flashdata("message").'
				</b></font></div>';
			}
		?>
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="example2" class="table table-striped table-bordered text-nowrap" >
						<thead>
							<tr>
								<th>Name</th>
								<th>Program Name</th>
								<th>Status</th>
								<th>Created At</th>
								<th>Update At</th>
								<th style="width:20px;">Action</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							if($program_session_list){
								foreach($program_session_list as $session){
						?>
							<tr>
								<td>
									<?php if(isset($session->session_name) && $session->session_name!='' && $session->session_name!=null){ 
										echo $session->session_name; 
									}else{ 
										echo 'N/A'; 
									} ?>
								</td>
								<td>
									<?php if(isset($session->program_name) && $session->program_name!='' && $session->program_name!=null){ 
										echo $session->program_name; 
									}else{ 
										echo 'N/A'; 
									} ?>
								</td>
								<td>
									<?php if(isset($session->status) && $session->status==1){ 
										echo 'Active'; 
									}else{ 
										echo 'Inactive'; 
									} ?>
								</td>
								<td>
									<?php if(isset($session->created_at) && $session->created_at!='' && $session->created_at!=null){ 
										echo date('d-m-Y',strtotime($session->created_at)); 
									}else{ 
										echo 'N/A'; 
									} ?>
								</td>
								<td>
									<?php if(isset($session->updated_at) && $session->updated_at!='' && $session->updated_at!=null){ 
										echo date('d-m-Y',strtotime($session->updated_at)); 
									}else{ 
										echo 'N/A'; 
									} ?>
								</td>
								<td style="width:20px;">
									<a class="btn btn-secondary btn-sm" href="<?php echo site_url('management/program_session/'.base64_encode($session->id)); ?>"><i class="fa fa-edit"></i> Edit</a>&nbsp;
									<a class="btn btn-secondary btn-sm" onclick="deleteSession('<?php echo base64_encode($session->id); ?>');" href="javascript:void(0);"><i class="fa fa-delete"></i> Delete</a>
								</td>										
							</tr>
						<?php 	}										
							}	?>											
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	function deleteSession(id){
		var res=confirm("Are you sure that you want to delete this record?");
		if(res){
			var url="<?php echo site_url('management/delete_program_session/'); ?>"+id;
			window.location.assign(url);
		}
		return false;
	}
	</script>
<?php include("footer.php");?>