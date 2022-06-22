				<!-- Horizontal-menu -->
				<div class="horizontal-main hor-menu clearfix">
					<div class="horizontal-mainwrapper container clearfix">
						<nav class="horizontalMenu clearfix">
							<ul class="horizontalMenu-list">
								
								<li aria-haspopup="true"><a href="#" class="sub-icon active"><i class="fa fa-server"></i> Dashboard <i class="fa fa-angle-down horizontal-icon"></i></a>
									<ul class="sub-menu">
										<li aria-haspopup="true"><a href="<?php echo site_url('Dashboard/program_overview/')?>">Oasis Movement Projects/ Program Overview</a></li>
										<li aria-haspopup="true"><a href="<?php echo site_url('Dashboard/monitoring_project_programs/')?>">Monitoring Projects/ Programs</a></li>
										<li aria-haspopup="true"><a href="<?php echo site_url('Dashboard/monitroing_leaders_team/')?>">Monitoring Leaders & Team</a></li>
										<li aria-haspopup="true"><a href="<?php echo site_url('Dashboard/monitroing_facilitators/')?>">Monitoring Facilitators</a></li>
										<li aria-haspopup="true"><a href="<?php echo site_url('Dashboard/my_journey_with_om/')?>">My Journey with OM</a></li>
									</ul>
								</li>

								<li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fa fa-server"></i> Reports <i class="fa fa-angle-down horizontal-icon"></i></a>
									<ul class="sub-menu">
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Summary Reports</a>
											<ul class="sub-menu">
												<li aria-haspopup="true"><a href="<?php echo site_url('ProgramReport/program_summary_report/')?>">Program Summary Report</a></li>
											</ul>
										</li>
					
									</ul>
								</li>


								<li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fa fa-server"></i> Master <i class="fa fa-angle-down horizontal-icon"></i></a>
									<ul class="sub-menu">
										

										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Common Master</a>
											<ul class="sub-menu scroll_menu">
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/user_type_master/')?>">User Type</a></li>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/role_master/')?>">Role Master</a></li>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/state_master/')?>">State</a></li>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/district_master/')?>">District</a></li>
												<!--<li aria-haspopup="true"><a href="<?php echo site_url('Master/taluka_master/')?>">Taluka</a></li>-->
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/village_master/')?>">City/Town/Village</a></li>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/region_master/')?>">Region</a></li>
												<!--<li aria-haspopup="true"><a href="#">Organization</a></li>-->
												<!--<li aria-haspopup="true"><a href="<?php echo site_url('Master/reason_type_master/')?>">Reason Type</a></li>-->
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/group_type_master/')?>">Group Type Master</a></li>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/quality_observed_master/')?>">Quality Obbserved</a></li>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/post_category_master/')?>">Post Category</a></li>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/download_category_master/')?>">Manage Download Category</a></li>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/program_related_to_master/')?>">Related To Master</a></li>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/program_type_master/')?>">Program Type Master</a></li>
											</ul>
										</li>

										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Dynamic Forms<br/> Master</a>
											<ul class="sub-menu">
												<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Feedback & <br/>Reflections</a>
													<ul class="sub-menu">
														<li aria-haspopup="true"><a href="<?php echo site_url('Master/program_feedback_form/')?>">Program Feedback</a></li>
														<li aria-haspopup="true"><a href="<?php echo site_url('Master/personal_learning_form/')?>">Personal Learning</a></li>
														<li aria-haspopup="true"><a href="<?php echo site_url('Master/feedback_for_participants_form/')?>">Feedback For Participants</a></li>
														<li aria-haspopup="true"><a href="<?php echo site_url('Master/program_feedback_by_participant_form/')?>">Program Feedback By Participant</a></li>
													</ul>
												</li>

												<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Submissions</a>
													<ul class="sub-menu">
														<li aria-haspopup="true"><a href="<?php echo site_url('Master/star_participants_form/')?>">Star Participants</a></li>
														<li aria-haspopup="true"><a href="<?php echo site_url('Master/impact_on_character_traits_form/')?>">Impact on Character Traits</a></li>
													</ul>
												</li>
											</ul>
										</li>

									</ul>
								</li>

								<li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fa fa-server"></i> Management <i class="fa fa-angle-down horizontal-icon"></i></a>
									<ul class="sub-menu">
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Batch Master</a>
											<ul class="sub-menu">
												<li aria-haspopup="true" class="sub-menu"><a href="<?php echo site_url('Management/add_batch/')?>">Add New Batch</a></li>
												<li aria-haspopup="true" class="sub-menu"><a href="<?php echo site_url('Management/view_batch_list/')?>">View Batch List</a></li>
											</ul>
										</li>

										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">User Master</a>
											<ul class="sub-menu">
												<li aria-haspopup="true" class="sub-menu"><a href="<?php echo site_url('Management/add_user/')?>">Add New User</a></li>
												<li aria-haspopup="true" class="sub-menu"><a href="<?php echo site_url('Management/view_user_list/')?>">View User List</a></li>
												<li aria-haspopup="true" class="sub-menu"><a href="<?php echo site_url('Management/user_credentials/')?>">Reset Username / Password</a></li>
											</ul>
										</li>
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Active-deactive</a>
											<ul class="sub-menu">
												<li aria-haspopup="true"><a href="<?php echo site_url('Management/active_deactive_center/')?>">Active-deactive Center</a></li>
												<li aria-haspopup="true"><a href="<?php echo site_url('Management/active_deactive_user/')?>">Active-deactive User</a></li>
											</ul>
										</li>
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Program Master</a>
											<ul class="sub-menu">
												<li aria-haspopup="true" class="sub-menu"><a href="<?php echo site_url('Management/add_program/')?>">Add New Program</a></li>
												<li aria-haspopup="true" class="sub-menu"><a href="<?php echo site_url('Management/view_program_list/')?>">View Program List</a></li>
											</ul>
										</li>	
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Role Management</a>
											<ul class="sub-menu">
												<li aria-haspopup="true"><a href="<?php echo site_url('Management/assign_rights/')?>">Assign Rights</a></li>
												<li aria-haspopup="true"><a href="#">View Rights List</a></li>
											</ul>
										</li>

										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Manage Center</a>
											<ul class="sub-menu">
												<li aria-haspopup="true"><a href="<?php echo site_url('Management/add_center/')?>">Add New Center</a></li>
												<li aria-haspopup="true"><a href="<?php echo site_url('Management/view_centers_list/')?>">View Center List</a></li>
												<li aria-haspopup="true"><a href="<?php echo site_url('Management/assign_center/')?>">Assign Center</a></li>
											</ul>
										</li>

										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Calender</a>
											<ul class="sub-menu">
												<li aria-haspopup="true"><a href="<?php echo site_url('Management/oasis_calender/')?>">Oasis Calender</a></li>
											</ul>
										</li>

					
									</ul>
								</li>

								<li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fa fa-server"></i> Reviews <i class="fa fa-angle-down horizontal-icon"></i></a>
									<ul class="sub-menu">
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Feedback & <br/>Reflections</a>
											<ul class="sub-menu">
												<li aria-haspopup="true"><a href="<?php echo site_url('Review/program_feedback_preview/')?>">Program Feedback</a></li>
												<li aria-haspopup="true"><a href="<?php echo site_url('Review/personal_reflection_preview/')?>">Personal Learning</a></li>
												<li aria-haspopup="true"><a href="<?php echo site_url('Review/feedback_for_participants_preview/')?>">Feedback For Participants</a></li>
												<li aria-haspopup="true"><a href="<?php echo site_url('Review/program_feedback_by_participant_preview/')?>">Program Feedback By Participant</a></li>
											</ul>
										</li>

										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Submissions</a>
											<ul class="sub-menu">
												<li aria-haspopup="true"><a href="<?php echo site_url('Review/star_participants_preview/')?>">Star Participants</a></li>
												<li aria-haspopup="true"><a href="<?php echo site_url('Review/impact_on_character_traits_preview/')?>">Impact on Character Traits</a></li>
											</ul>
										</li>
									</ul>
								</li>

								
								<li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fa fa-server"></i> Connect With OM <i class="fa fa-angle-down horizontal-icon"></i></a>
											<ul class="sub-menu">
												<li aria-haspopup="true"><a href="<?php echo site_url('ConnectOM/contact_us/')?>">Contact Us</a></li>
												<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Share With Us</a>
													<ul class="sub-menu">
														<li aria-haspopup="true"><a href="<?php echo site_url('ConnectOM/share_post/')?>">Share Post</a></li>
														<li aria-haspopup="true"><a href="<?php echo site_url('ConnectOM/view_shared_post_list/')?>">View Shared Post List</a></li>
													</ul>
												</li>	
												<li aria-haspopup="true"><a href="<?php echo site_url('ConnectOM/ask_us/')?>">Ask Us</a></li>
												<!--<li aria-haspopup="true"><a href="<?php echo site_url('ConnectOM/download_management/')?>">Download Management</a></li>	-->
												<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Download<br/> Management</a>
													<ul class="sub-menu">
														<li aria-haspopup="true"><a href="<?php echo site_url('ConnectOM/add_download_data/')?>">Add Data in Downloads</a></li>
														<li aria-haspopup="true"><a href="<?php echo site_url('ConnectOM/view_downloads_data_list/')?>">View Downloads List</a></li>
													</ul>
												</li>			
											</ul>
								</li>

								<li aria-haspopup="true"><a href="https://oasismissalproject.divineinfosyshosting.com/" target="_blank"><i class="fa fa-server"></i> Misaal Project</a></li>
							</ul>
						</nav>
						<!--Nav end -->
					</div>
				</div>
				<!-- Horizontal-menu end -->