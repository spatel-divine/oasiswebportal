<?php include("header.php");?>

                <!-- app-content-->
				<div class="container content-area">
					<div class="side-app">

						<!-- page-header -->
						<div class="page-header">
							<ol class="breadcrumb"><!-- breadcrumb -->
								<li class="breadcrumb-item"><a href="#">Program</a></li>
								<li class="breadcrumb-item active" aria-current="page">View Program List</li>
							</ol><!-- End breadcrumb -->
							<div class="ml-auto">
								<div class="input-group">
									<a href="<?php echo site_url('Management/add_program/')?>" class="btn btn-info text-white btn-sm" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add New">
										<span>
											<i class="fa fa-plus"></i>&nbsp;Add New Program
										</span>
									</a>&nbsp;

								</div>
							</div>
						</div>
						<!-- End page-header -->

						<!-- row -->
						<?php
							if($this->session->flashdata('message'))
							{
								echo '<div class="alert alert-success"><font color="white"><b>
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
												<th>Program Name</th>
												<th>Related To</th>
												<th>Program Type</th>
												<th>Number Of Days</th>
												<th>Sessions</th>
												<th style="width:20px;">Action</th>
											</tr>
										</thead>
										<tbody>
										<?php 
											if(count($program_data_list) >0) {
												foreach($program_data_list as $item){
										?>
											<tr>
												<td><?=$item->program_name;?></td>
												<td><?=$item->program_related_to_name;?></td>
												<td><?=$item->program_type_name;?></td>
												<td><?=$item->number_of_days;?></td>
												<td><?=$item->session_name;?></td>
												<td style="width:20px;">
												<a class="btn btn-secondary btn-sm" href="<?=site_url('Management/add_program/'.$item->id); ?>">
													<i class="fa fa-edit"></i> Edit
												</a>


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

<?php include("footer.php");?>