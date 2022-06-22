<?php include("header.php");?>

                <!-- app-content-->
				<div class="container content-area">
					<div class="side-app">

						<!-- page-header -->
						<div class="page-header">
							<ol class="breadcrumb"><!-- breadcrumb -->
								<li class="breadcrumb-item"><a href="#">Center</a></li>
								<li class="breadcrumb-item active" aria-current="page">View Centers List</li>
							</ol><!-- End breadcrumb -->
							<div class="ml-auto">
								<div class="input-group">
									<a href="<?php echo site_url('Management/add_center/')?>" class="btn btn-info text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add New">
										<span>
											<i class="fa fa-plus"></i>&nbsp;Add New Center
										</span>
									</a>&nbsp;

								</div>
							</div>
						</div>
						<!-- End page-header -->
						<?php
							if($this->session->flashdata('message')){
								echo '<div class="alert alert-success"><font color="white"><b><a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:#fff;">&times;</a>
									'.$this->session->flashdata("message").'
								</b></font></div>';
							}
						?>
						<!-- row -->
						<div class="card">
							<div class="card-body">
								<div class="table-responsive">
									<table id="example2" class="table table-striped table-bordered" >
										<thead>
											<tr>
												<th>Center Name</th>
												<th>Address</th>
												<th>City/Town</th>
												<th>Region</th>
												<th>State</th>
												<th>Contact No.</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>

										<?php
										if(count($CenterList) > 0) {
											foreach($CenterList as $item){
										?>
											<tr>
												<td><?=$item->center_name; ?></td>
												<td><?=$item->address; ?></td>
												<td><?=$item->village_name; ?></td>
												<td><?=$item->region_name; ?></td>
												<td><?=$item->state_name; ?></td>
												<td><?=$item->center_contact_no; ?></td>
												<td><a class="btn btn-secondary btn-sm" href="<?php echo site_url('Management/add_center/'.$item->id);?>">
													<i class="fa fa-edit"></i> Edit</a></td>
											</tr>
											<?php }										
										}?>
										</tbody>
									</table>
								</div>
							</div>
						</div>

					</div>

<?php include("footer.php");?>