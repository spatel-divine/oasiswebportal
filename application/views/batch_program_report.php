<?php include("header.php"); ?>
<!-- app-content-->
<div class="container content-area">
	<div class="side-app">
		<!-- page-header -->
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item"><a href="#">Report</a></li>
				<li class="breadcrumb-item active" aria-current="page">Batch Summary Report</li>
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
								<th><b>Batch Name</b></th>
								<th><b>Sessions</b></th>
								<th><b>Program Review(Facilitator/ Cofacilitator/ Volunteer)</b></th>
								<th><b>Star Participants</b></th>
								<th><b>Program Review by participant</b></th>
								<th><b>Participant Review By Facilitator</b></th>
								<th><b>Personal review(Facilitator/Co-<br/>facilitator/Volunteer)</b></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							if(isset($batchsummaryreport_list) && $batchsummaryreport_list){
								foreach ($batchsummaryreport_list as $batchsummaryreport){ 
									$batch_name='-';
									if(isset($batchsummaryreport->batch_name) && $batchsummaryreport->batch_name){
										$batch_name=$batchsummaryreport->batch_name;
									}
								?>
									<tr>
										<th><?php echo $batch_name; ?></th>
										<td>Love Camp</td>
										<td><input type="submit" class="btn btn-info" data-toggle="modal" data-target="#programReviewByWorker" value="3"></td>
										<td><input type="submit" class="btn btn-primary" data-toggle="modal" data-target="#starParticipants" value="5"></td>
										<td><input type="submit" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalLong" value="25"></td>
										<td><input type="submit" class="btn btn-warning" data-toggle="modal" data-target="#participantReviewbyFacilitator" value="2"></td>
										<td><input type="submit" class="btn btn-dark" data-toggle="modal" data-target="#personalReview" value="1"></td>
									</tr>
							<?php	}
							}
							?>
							<?php /* 
							<tr>
								<th>L&L2021-OVVDRB2</th>
								<td>Love Camp</td>
								<td><input type="submit" class="btn btn-info" data-toggle="modal" data-target="#programReviewByWorker" value="3"></td>
								<td><input type="submit" class="btn btn-primary" data-toggle="modal" data-target="#starParticipants" value="5"></td>
								<td><input type="submit" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModalLong" value="25"></td>
								<td><input type="submit" class="btn btn-warning" data-toggle="modal" data-target="#participantReviewbyFacilitator" value="2"></td>
								<td><input type="submit" class="btn btn-dark" data-toggle="modal" data-target="#personalReview" value="1"></td>
							</tr>
							<tr>
								<th>L&L2021-BLRBLR-B1</th>
								<td>Life Camp</td>
								<td>2</td>
								<td>2</td>
								<td>13</td>
								<td>13</td>
								<td>1</td>
							</tr>
							<tr>
								<th>.. <br/><br/> ..</th>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr> */ 
							?>
						</tbody>
					</table>
					<!--PROGRAM REVIEW BY PARTICIPANT-->
					<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">PROGRAM REVIEW BY PARTICIPANT</h5>
								<input type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
							  </div>
							  <div class="modal-body">
							  	<div class="table-responsive">
							  		<table class="table card-table table-vcenter table-bordered">
										<thead>
											<tr>
												<th><b>Name</b></th>
												<th><b>Feeling For Program</b></th>
												<th><b>Liked And Useful</b></th>
												<th><b>Did Not Like And Why</b></th>
												<th><b>Reflection For Facilitator</b></th>
												<th><b>Program Rating</b></th>
												<th><b>Facilitator Rating</b></th>
												<th><b>Venue Rating</b></th>
												<th><b>Low Before Program</b></th>
												<th><b>High After Program</b></th>
												<th><b>Remark</b></th>
											</tr>
										</thead>
										<tbody>

											<tr>
												<th>Jay Anjaria</th>
												<td><a href="#"
											     data-toggle="tooltip" title="We are accustomed to making our reactions to the situation that arises in life. But, this workshop has given a life lesson on how to react with awareness and understanding in response to a situation.">We are accustomed to making our reactions to...</a></td>
											     <td><a href="#"
											     data-toggle="tooltip" title="Thus the place, the food and all the learning activities are very much liked and very useful. The approach of bringing a person out of his comfort zone and living with the realities of life is the achievement of this workshop.">Thus the place, the food...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="So there is nothing to dislike but when some participants do not respect the time of the session, it is felt that they have lost something in a short time.">So there is nothing to dislike...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="Each of the facilitators of the workshop has in-depth study and experience of the subject matter. Mehulbhai is a personality who has cultivated resilience in life and has a unique art of teaching participants with a smiling face.">Each of the facilitators of the workshop...</a></td>
												<td>10</td>
												<td>10</td>
												<td>10</td>
												<td><a href="#"
											     data-toggle="tooltip" title="Self Confidence, Happiness, Dream, Leadership, Idealism">Self Confidence, Happiness...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="Self Confidence, Happiness, Idealism, Learning, Giving, Grit, Dream, Leadership, Trustworthiness, Love, Cooperation, Compassion">Self Confidence, Happiness...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="The only suggestion is that even if the meal is oil free, it can be done with some innovation, such as adding various salads, vegetable soups, etc.">The only suggestion is that even...</a></td>
											</tr>
										</tbody>
									</table>
								</div>
							  </div>
							</div>
						</div>
					</div>
					<!--PROGRAM REVIEW BY PARTICIPANT End-->
					<!--PROGRAM REVIEW(FACILITATOR/ COFACILITATOR/ VOLUNTEER)-->
					<div class="modal fade" id="programReviewByWorker" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">PROGRAM REVIEW(FACILITATOR/ COFACILITATOR/ VOLUNTEER)</h5>
								<input type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
							  </div>
							  <div class="modal-body">
							  		<div class="table-responsive">
							  		<table class="table card-table table-vcenter table-bordered">
										<thead>
											<tr>
												<th><b>Name</b></th>
												<th><b>Feeling For Program</b></th>
												<th><b>Liked And Useful</b></th>
												<th><b>Did Not Like And Why</b></th>
												<th><b>Reflection For Facilitator</b></th>
												<th><b>Program Rating</b></th>
												<th><b>Facilitator Rating</b></th>
												<th><b>Venue Rating</b></th>
												<th><b>Low Before Program</b></th>
												<th><b>High After Program</b></th>
												<th><b>Remark</b></th>
											</tr>
										</thead>
										<tbody>

											<tr>
												<th>Jay Anjaria</th>
												<td><a href="#"
											     data-toggle="tooltip" title="We are accustomed to making our reactions to the situation that arises in life. But, this workshop has given a life lesson on how to react with awareness and understanding in response to a situation.">We are accustomed to making our reactions to...</a></td>
											     <td><a href="#"
											     data-toggle="tooltip" title="Thus the place, the food and all the learning activities are very much liked and very useful. The approach of bringing a person out of his comfort zone and living with the realities of life is the achievement of this workshop.">Thus the place, the food...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="So there is nothing to dislike but when some participants do not respect the time of the session, it is felt that they have lost something in a short time.">So there is nothing to dislike...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="Each of the facilitators of the workshop has in-depth study and experience of the subject matter. Mehulbhai is a personality who has cultivated resilience in life and has a unique art of teaching participants with a smiling face.">Each of the facilitators of the workshop...</a></td>
												<td>10</td>
												<td>10</td>
												<td>10</td>
												<td><a href="#"
											     data-toggle="tooltip" title="Self Confidence, Happiness, Dream, Leadership, Idealism">Self Confidence, Happiness...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="Self Confidence, Happiness, Idealism, Learning, Giving, Grit, Dream, Leadership, Trustworthiness, Love, Cooperation, Compassion">Self Confidence, Happiness...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="The only suggestion is that even if the meal is oil free, it can be done with some innovation, such as adding various salads, vegetable soups, etc.">The only suggestion is that even...</a></td>
											</tr>
										</tbody>
									</table>
								</div>
							  </div>
							</div>
						</div>
					</div>
					<!--PROGRAM REVIEW(FACILITATOR/ COFACILITATOR/ VOLUNTEER) End-->
					<!--STAR PARTICIPANTS-->
					<div class="modal fade" id="starParticipants" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">STAR PARTICIPANTS</h5>
								<input type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
							  </div>
							  <div class="modal-body">
							  		<div class="table-responsive">
							  		<table class="table card-table table-vcenter table-bordered">
										<thead>
											<tr>
												<th><b>Name</b></th>
												<th><b>Feeling For Program</b></th>
												<th><b>Liked And Useful</b></th>
												<th><b>Did Not Like And Why</b></th>
												<th><b>Reflection For Facilitator</b></th>
												<th><b>Program Rating</b></th>
												<th><b>Facilitator Rating</b></th>
												<th><b>Venue Rating</b></th>
												<th><b>Low Before Program</b></th>
												<th><b>High After Program</b></th>
												<th><b>Remark</b></th>
											</tr>
										</thead>
										<tbody>

											<tr>
												<th>Jay Anjaria</th>
												<td><a href="#"
											     data-toggle="tooltip" title="We are accustomed to making our reactions to the situation that arises in life. But, this workshop has given a life lesson on how to react with awareness and understanding in response to a situation.">We are accustomed to making our reactions to...</a></td>
											     <td><a href="#"
											     data-toggle="tooltip" title="Thus the place, the food and all the learning activities are very much liked and very useful. The approach of bringing a person out of his comfort zone and living with the realities of life is the achievement of this workshop.">Thus the place, the food...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="So there is nothing to dislike but when some participants do not respect the time of the session, it is felt that they have lost something in a short time.">So there is nothing to dislike...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="Each of the facilitators of the workshop has in-depth study and experience of the subject matter. Mehulbhai is a personality who has cultivated resilience in life and has a unique art of teaching participants with a smiling face.">Each of the facilitators of the workshop...</a></td>
												<td>10</td>
												<td>10</td>
												<td>10</td>
												<td><a href="#"
											     data-toggle="tooltip" title="Self Confidence, Happiness, Dream, Leadership, Idealism">Self Confidence, Happiness...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="Self Confidence, Happiness, Idealism, Learning, Giving, Grit, Dream, Leadership, Trustworthiness, Love, Cooperation, Compassion">Self Confidence, Happiness...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="The only suggestion is that even if the meal is oil free, it can be done with some innovation, such as adding various salads, vegetable soups, etc.">The only suggestion is that even...</a></td>
											</tr>
										</tbody>
									</table>
								</div>
							  </div>
							</div>
						</div>
					</div>
					<!--STAR PARTICIPANTS-->
					<!--PARTICIPANT REVIEW BY FACILITATOR-->
					<div class="modal fade" id="participantReviewbyFacilitator" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">PARTICIPANT REVIEW BY FACILITATOR</h5>
								<input type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
							  </div>
							  <div class="modal-body">
							  		<div class="table-responsive">
							  		<table class="table card-table table-vcenter table-bordered">
										<thead>
											<tr>
												<th><b>Name</b></th>
												<th><b>Feeling For Program</b></th>
												<th><b>Liked And Useful</b></th>
												<th><b>Did Not Like And Why</b></th>
												<th><b>Reflection For Facilitator</b></th>
												<th><b>Program Rating</b></th>
												<th><b>Facilitator Rating</b></th>
												<th><b>Venue Rating</b></th>
												<th><b>Low Before Program</b></th>
												<th><b>High After Program</b></th>
												<th><b>Remark</b></th>
											</tr>
										</thead>
										<tbody>

											<tr>
												<th>Jay Anjaria</th>
												<td><a href="#"
											     data-toggle="tooltip" title="We are accustomed to making our reactions to the situation that arises in life. But, this workshop has given a life lesson on how to react with awareness and understanding in response to a situation.">We are accustomed to making our reactions to...</a></td>
											     <td><a href="#"
											     data-toggle="tooltip" title="Thus the place, the food and all the learning activities are very much liked and very useful. The approach of bringing a person out of his comfort zone and living with the realities of life is the achievement of this workshop.">Thus the place, the food...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="So there is nothing to dislike but when some participants do not respect the time of the session, it is felt that they have lost something in a short time.">So there is nothing to dislike...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="Each of the facilitators of the workshop has in-depth study and experience of the subject matter. Mehulbhai is a personality who has cultivated resilience in life and has a unique art of teaching participants with a smiling face.">Each of the facilitators of the workshop...</a></td>
												<td>10</td>
												<td>10</td>
												<td>10</td>
												<td><a href="#"
											     data-toggle="tooltip" title="Self Confidence, Happiness, Dream, Leadership, Idealism">Self Confidence, Happiness...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="Self Confidence, Happiness, Idealism, Learning, Giving, Grit, Dream, Leadership, Trustworthiness, Love, Cooperation, Compassion">Self Confidence, Happiness...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="The only suggestion is that even if the meal is oil free, it can be done with some innovation, such as adding various salads, vegetable soups, etc.">The only suggestion is that even...</a></td>
											</tr>
										</tbody>
									</table>
								</div>
							  </div>
							</div>
						</div>
					</div>
					<!--PARTICIPANT REVIEW BY FACILITATOR-->
					<!--PERSONAL REVIEW(FACILITATOR/CO-FACILITATOR/VOLUNTEER)-->
					<div class="modal fade" id="personalReview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalLongTitle">PERSONAL REVIEW(FACILITATOR/CO-FACILITATOR/VOLUNTEER)</h5>
								<input type="submit" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true" value="&times;" name="close">
							  </div>
							  <div class="modal-body">
							  		<div class="table-responsive">
							  		<table class="table card-table table-vcenter table-bordered">
										<thead>
											<tr>
												<th><b>Name</b></th>
												<th><b>Feeling For Program</b></th>
												<th><b>Liked And Useful</b></th>
												<th><b>Did Not Like And Why</b></th>
												<th><b>Reflection For Facilitator</b></th>
												<th><b>Program Rating</b></th>
												<th><b>Facilitator Rating</b></th>
												<th><b>Venue Rating</b></th>
												<th><b>Low Before Program</b></th>
												<th><b>High After Program</b></th>
												<th><b>Remark</b></th>
											</tr>
										</thead>
										<tbody>

											<tr>
												<th>Jay Anjaria</th>
												<td><a href="#"
											     data-toggle="tooltip" title="We are accustomed to making our reactions to the situation that arises in life. But, this workshop has given a life lesson on how to react with awareness and understanding in response to a situation.">We are accustomed to making our reactions to...</a></td>
											     <td><a href="#"
											     data-toggle="tooltip" title="Thus the place, the food and all the learning activities are very much liked and very useful. The approach of bringing a person out of his comfort zone and living with the realities of life is the achievement of this workshop.">Thus the place, the food...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="So there is nothing to dislike but when some participants do not respect the time of the session, it is felt that they have lost something in a short time.">So there is nothing to dislike...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="Each of the facilitators of the workshop has in-depth study and experience of the subject matter. Mehulbhai is a personality who has cultivated resilience in life and has a unique art of teaching participants with a smiling face.">Each of the facilitators of the workshop...</a></td>
												<td>10</td>
												<td>10</td>
												<td>10</td>
												<td><a href="#"
											     data-toggle="tooltip" title="Self Confidence, Happiness, Dream, Leadership, Idealism">Self Confidence, Happiness...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="Self Confidence, Happiness, Idealism, Learning, Giving, Grit, Dream, Leadership, Trustworthiness, Love, Cooperation, Compassion">Self Confidence, Happiness...</a></td>
												<td><a href="#"
											     data-toggle="tooltip" title="The only suggestion is that even if the meal is oil free, it can be done with some innovation, such as adding various salads, vegetable soups, etc.">The only suggestion is that even...</a></td>
											</tr>
										</tbody>
									</table>
								</div>
							  </div>
							</div>
						</div>
					</div>
					<!--PERSONAL REVIEW(FACILITATOR/CO-FACILITATOR/VOLUNTEER)-->
				</div>
				<!-- table-responsive -->
			</div><!-- col end -->
		</div>
		<!-- row end -->
	</div>
<?php include("footer.php"); ?>