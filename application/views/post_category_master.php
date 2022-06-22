<?php include("header.php");?>
<!-- app-content-->

                <!-- app-content-->
				<div class="container content-area">
					<div class="side-app">

						<!-- page-header -->
						<div class="page-header">
							<ol class="breadcrumb"><!-- breadcrumb -->
								<li class="breadcrumb-item"><a href="#">Post Category</a></li>
								<li class="breadcrumb-item active" aria-current="page">Manage Post Category</li>
							</ol><!-- End breadcrumb -->
						</div>
						<!-- End page-header -->
						<?php
						$post_category_id_edit = "";
						$category_name_edit = "";

						$action = 'Add';
						if(!empty($edit_data)) {
							 $post_category_id_edit = $edit_data[0]->id;
							 $category_name_edit = $edit_data[0]->category_name;
							 $action = 'Edit';
						}
						?>
						<!-- row -->
						<div class="row">
							<div class="col-md-5">

							<form method="post" action="<?php echo base_url('PostCategoryMst/createPostCategory');?>">
								<input type="hidden" name="post_category_id" value="<?php echo $post_category_id_edit;?>">

								<div class="card">
									<div class="card-body">
										<h4 class="breadcrumb-item"><?php echo  $action ;?> Post Category</h4>
									</div>
									<div class="card-body">
										<div class="form-group">
											<div class="row">	
												<div class="col-lg-12 col-md-12">
													<label>Category</label>
													<input type="text" class="form-control" name="category_name" value="<?php echo $category_name_edit;?>" placeholder="Enter Post Category">	
													<font color="red"><?=form_error("category_name");?></font>
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
							<div class="col-md-7">
								<div class="card">
									<div class="card-body">
										<h4 class="breadcrumb-item">View Post Category List</h4>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example2" class="table table-striped table-bordered text-wrap" >
												<thead>
													<tr>
														<th>Category Name</th>
														<th style="width:20px;">Action</th>
													</tr>
												</thead>
												<tbody>

												<?php if(count($data) > 0 ) {
													 foreach ($data as $item) { ?>  
													<tr>
														<td><?php echo $item->category_name;?></td>
														<td style="width:190px !important;"><a class="btn btn-secondary btn-sm" href="<?php echo site_url('PostCategoryMst/editPostCategory/'.$item->id);?>">
															<i class="fa fa-edit"></i> Edit</a>
															<a class="btn btn-danger btn-sm" href="javascript:;" onclick="return delete_post_category(<?=$item->id; ?>)"><i class="fa fa-trash"></i> Delete</a>
														</td>									
													</tr>
													<?php }
												}?>

												</tbody>
											</table>
										</div>	

									</div>
								</div>
							</div>
						
						<!-- row end -->

						<!-- row -->
						<div class="row">
						
						<!-- row end -->
					</div>
	

<?php include("footer.php");?>

<script>
function delete_post_category(id){
	var result = confirm("Are you sure want to delete selected Post Category?");
	if (result) {
		var post_data = { 'post_categorie_id': id };
		$.ajax({
			method: "POST",
			url: '<?php echo site_url('Master/delete_post_category/'); ?>',
			data: post_data,
			success: function(response)
			{
				if(response.hasOwnProperty('notvaliduserurl') && response.notvaliduserurl){
					window.location.assign(response.notvaliduserurl);
				}else if(response.hasOwnProperty('success') && response.success==1){
					alert("Successfully deleted selected Post Category");
					location.reload();
				}
			}
		});
	}else{
		return false;
	}
}
</script>