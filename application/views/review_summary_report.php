<?php include("header.php"); ?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Report</a></li>
				<li class="breadcrumb-item active" aria-current="page">Review Summary Report</li>
			</ol><!-- End breadcrumb -->
		</div>
		<!-- End page-header -->
		<!-- row -->
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="table-responsive">
					<table class="table card-table table-vcenter table-bordered text-center">
						<thead>
							<tr>
								<th>Name Of Review</th>
								<th>No. of Reviews</th>
							</tr>
						</thead>
						<tbody>
							<?php if(isset($reviewlist) && $reviewlist){
								foreach($reviewlist as $review){ ?>
									<tr>
										<td><?php echo $review->name_of_review; ?></td>
										<td>
											<?php 
											$url=site_url('ReviewReport/get_review_report_list').'?tablename='.$review->tablename;
											if($review->no_of_reviews>0){
											?>
											<a class="btn btn-primary text-white" href="<?php echo $url; ?>"><?php echo $review->no_of_reviews; ?></a>
											<? }else{
												echo '-';
											} ?>
										</td>
									</tr>
							<?php }
							}?>
						</tbody>
					</table>
				</div>
				<!-- table-responsive -->
			</div><!-- col end -->
		</div>
		<!-- row end -->
	</div>
<?php include("footer.php"); ?>