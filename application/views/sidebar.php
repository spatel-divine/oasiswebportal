				<!-- Horizontal-menu -->
				<div class="horizontal-main hor-menu clearfix">
					<div class="horizontal-mainwrapper container clearfix">
						<nav class="horizontalMenu clearfix">
							<ul class="horizontalMenu-list">
								<?php if(checkAssignRights('dashboard','program_overview') || checkAssignRights('dashboard','monitoring_project_programs') || checkAssignRights('dashboard','monitroing_leaders_team') || checkAssignRights('dashboard','monitroing_facilitators') || checkAssignRights('dashboard','my_journey_with_om')){ 
								?>
								<li aria-haspopup="true"><a href="#" class="sub-icon <?php if($this->uri->segment(2)=="program_overview" || $this->uri->segment(2)=="monitoring_project_programs"||$this->uri->segment(2)=="monitroing_leaders_team" ||$this->uri->segment(2)=="monitroing_facilitators" ||$this->uri->segment(2)=="my_journey_with_om"){echo "active";}?>">Dashboard <i class="fa fa-angle-down horizontal-icon"></i></a>
									<ul class="sub-menu">
										<?php if(checkAssignRights('dashboard','program_overview')){ ?>
											<li aria-haspopup="true"><a href="<?php echo site_url('Dashboard/program_overview/')?>">Oasis Movement Projects/ Program Overview</a></li>
										<?php }
										if(checkAssignRights('dashboard','monitoring_project_programs')){ ?>
											<li aria-haspopup="true"><a href="<?php echo site_url('Dashboard/monitoring_project_programs/')?>">Monitoring Projects/ Programs</a></li>
										<?php }
										if(checkAssignRights('dashboard','monitroing_leaders_team')){ ?>
											<li aria-haspopup="true"><a href="<?php echo site_url('Dashboard/monitroing_leaders_team/')?>">Monitoring Leaders & Team</a></li>
										<?php }
										if(checkAssignRights('dashboard','monitroing_facilitators')){ ?>
											<li aria-haspopup="true"><a href="<?php echo site_url('Dashboard/monitroing_facilitators/')?>">Monitoring Facilitators</a></li>
										<?php }
										if(checkAssignRights('dashboard','my_journey_with_om')){ ?>
											<li aria-haspopup="true"><a href="<?php echo site_url('Dashboard/my_journey_with_om/')?>">My Journey with OM</a></li>
										<?php } ?>
									</ul>
								</li>
								<?php }  
								if(checkAssignRights('programreport','program_summary_report')){ 
								?>
								<li aria-haspopup="true"><a href="#" class="sub-icon <?php if($this->uri->segment(2)=="program_summary_report" || $this->uri->segment(2)=="user_summary_report" || $this->uri->segment(2)=="batch_summary_report"){echo "active";}?>"> Reports <i class="fa fa-angle-down horizontal-icon"></i></a>
									<ul class="sub-menu">
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Summary Reports</a>
											<ul class="sub-menu">
												<li aria-haspopup="true"><a href="<?php echo site_url('ProgramReport/program_summary_report/')?>">Program Summary Report</a></li>
												<li aria-haspopup="true"><a href="<?php echo site_url('ReviewReport/review_summary_report/')?>">Review Summary Report</a></li>
											</ul>
										</li>
									</ul>
								</li>
								<?php }  
								if(checkAssignRights('master','user_type_master') || checkAssignRights('master','role_master') || checkAssignRights('master','state_master') || checkAssignRights('master','district_master') || checkAssignRights('master','village_master') || checkAssignRights('master','region_master') || checkAssignRights('master','group_type_master') || checkAssignRights('master','quality_observed_master') || checkAssignRights('master','post_category_master') || checkAssignRights('master','download_category_master') || checkAssignRights('master','program_related_to_master') ||  checkAssignRights('master','program_type_master') ||  checkAssignRights('master','program_feedback_list') || checkAssignRights('master','personal_learning_list') || checkAssignRights('master','feedback_for_participants_list') || checkAssignRights('master','program_feedback_by_participants_list') || checkAssignRights('master','star_participants_list') || checkAssignRights('master','impact_on_character_traits_list')){ 
								?>
								<li aria-haspopup="true"><a href="#" class="sub-icon <?php if($this->uri->segment(2)=="user_type_master" || $this->uri->segment(2)=="role_master"||$this->uri->segment(2)=="state_master" ||$this->uri->segment(2)=="district_master" ||$this->uri->segment(2)=="village_master" || $this->uri->segment(2)=="region_master"||$this->uri->segment(2)=="group_type_master" ||$this->uri->segment(2)=="quality_observed_master" ||$this->uri->segment(2)=="post_category_master" ||$this->uri->segment(2)=="download_category_master" ||$this->uri->segment(2)=="program_related_to_master" ||$this->uri->segment(2)=="program_type_master" || $this->uri->segment(2)=="program_feedback_list" || $this->uri->segment(2)=="personal_learning_list"||$this->uri->segment(2)=="feedback_for_participants_list" ||$this->uri->segment(2)=="program_feedback_by_participants_list" ||$this->uri->segment(2)=="star_participants_list" || $this->uri->segment(2)=="impact_on_character_traits_list"){echo "active";}?>"> Master <i class="fa fa-angle-down horizontal-icon"></i></a>
									<ul class="sub-menu">
										<?php
										if(checkAssignRights('master','user_type_master') || checkAssignRights('master','role_master') || checkAssignRights('master','state_master') || checkAssignRights('master','district_master') || checkAssignRights('master','village_master') || checkAssignRights('master','region_master') || checkAssignRights('master','group_type_master') || checkAssignRights('master','quality_observed_master') || checkAssignRights('master','post_category_master') || checkAssignRights('master','download_category_master') || checkAssignRights('master','program_related_to_master') ||  checkAssignRights('master','program_type_master')){  
										?>
											<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Common Master</a>
											<ul class="sub-menu scroll_menu">
												<?php if(checkAssignRights('master','user_type_master')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/user_type_master/')?>">User Type</a></li>
												<?php }if(checkAssignRights('master','role_master')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/role_master/')?>">Role Master</a></li>
												<?php }if(checkAssignRights('master','state_master')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/state_master/')?>">State</a></li>
												<?php }if(checkAssignRights('master','district_master')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/district_master/')?>">District</a></li>
												<?php }if(checkAssignRights('master','village_master')){ ?>
												<?php /* <li aria-haspopup="true"><a href="<?php echo site_url('Master/taluka_master/')?>">Taluka</a></li> */ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/village_master/')?>">City/Town/Village</a></li>
												<?php }if(checkAssignRights('master','region_master')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/region_master/')?>">Region</a></li>
												<?php } ?>
												<!--<li aria-haspopup="true"><a href="#">Organization</a></li>-->
												<?php /* <li aria-haspopup="true"><a href="<?php echo site_url('Master/reason_type_master/')?>">Reason Type</a></li> */ ?>
												<?php if(checkAssignRights('master','group_type_master')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/group_type_master/')?>">Group Type Master</a></li>
												<?php }if(checkAssignRights('master','quality_observed_master')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/quality_observed_master/')?>">Quality Observed</a></li>
												<?php }if(checkAssignRights('master','post_category_master')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/post_category_master/')?>">Post Category</a></li>
												<?php }if(checkAssignRights('master','download_category_master')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/download_category_master/')?>">Manage Download Category</a></li>
												<?php }if(checkAssignRights('master','program_related_to_master')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/program_related_to_master/')?>">Program Related To Master</a></li>
												<?php }if(checkAssignRights('master','program_type_master')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Master/program_type_master/')?>">Program Type Master</a></li>
												<?php } ?>
											</ul>
										</li>
										<?php }
										if(checkAssignRights('master','program_feedback_list') || checkAssignRights('master','personal_learning_list') || checkAssignRights('master','feedback_for_participants_list') || checkAssignRights('master','program_feedback_by_participants_list') || checkAssignRights('master','star_participants_list') || checkAssignRights('master','impact_on_character_traits_list')){ ?>
											<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Dynamic Forms<br/> Master</a>
											<ul class="sub-menu">
												<?php 
												if(checkAssignRights('master','program_feedback_list') || checkAssignRights('master','personal_learning_list') || checkAssignRights('master','feedback_for_participants_list') || checkAssignRights('master','program_feedback_by_participants_list')){ ?>
												<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Feedback & <br/>Reflections</a>
													<ul class="sub-menu">
														<?php /* <li aria-haspopup="true"><a href="<?php echo site_url('Master/program_feedback_form/')?>">Program Feedback</a></li> */ ?>
														<?php if(checkAssignRights('master','program_feedback_list')){ ?>
														<li aria-haspopup="true"><a href="<?php echo site_url('Master/program_feedback_list/')?>">Program Feedback</a></li>
														<?php } ?>
														<?php /*<li aria-haspopup="true"><a href="<?php echo site_url('Master/personal_learning_form/')?>">Personal Learning</a></li> */ ?>
														<?php if(checkAssignRights('master','personal_learning_list')){ ?>
														<li aria-haspopup="true"><a href="<?php echo site_url('Master/personal_learning_list/')?>">Personal Learning</a></li>
														<?php } ?>
														<?php /* <li aria-haspopup="true"><a href="<?php echo site_url('Master/feedback_for_participants_form/')?>">Feedback For Participants</a></li> */ ?>
														<?php if(checkAssignRights('master','feedback_for_participants_list')){ ?>
														<li aria-haspopup="true"><a href="<?php echo site_url('Master/feedback_for_participants_list/')?>">Feedback For Participants</a></li>
														<?php } ?>
														<?php /* <li aria-haspopup="true"><a href="<?php echo site_url('Master/program_feedback_by_participant_form/')?>">Program Feedback By Participant</a></li> */ ?>
														<?php if(checkAssignRights('master','program_feedback_by_participants_list')){ ?>
														<li aria-haspopup="true"><a href="<?php echo site_url('Master/program_feedback_by_participants_list/')?>">Program Feedback By Participant</a></li>
														<?php } ?>
													</ul>
												</li>
												<?php } if(checkAssignRights('master','star_participants_list') || checkAssignRights('master','impact_on_character_traits_list')){ ?>
												<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Submissions</a>
													<ul class="sub-menu">
														<?php /* <li aria-haspopup="true"><a href="<?php echo site_url('Master/star_participants_form/')?>">Star Participants</a></li> */ ?>
														<?php if(checkAssignRights('master','star_participants_list')){ ?>
														<li aria-haspopup="true"><a href="<?php echo site_url('Master/star_participants_list/')?>">Star Participants</a></li>
														<?php } ?>
														<?php /*<li aria-haspopup="true"><a href="<?php echo site_url('Master/impact_on_character_traits_form/')?>">Impact on Character Traits</a></li> */?>
														<?php if(checkAssignRights('master','impact_on_character_traits_list')){ ?>
														<li aria-haspopup="true"><a href="<?php echo site_url('Master/impact_on_character_traits_list/')?>">Impact on Character Traits</a></li>
														<?php } ?>
													</ul>
												</li>
												<?php } ?>
											</ul>
										</li>
										<?php } ?>
									</ul>
								</li>
								<?php } 
								if(checkAssignRights('management','add_batch') || checkAssignRights('management','view_batch_list') || checkAssignRights('management','add_user') || checkAssignRights('management','view_user_list') || checkAssignRights('management','user_credentials') || checkAssignRights('management','active_deactive_center') || checkAssignRights('management','active_deactive_user') || checkAssignRights('management','add_program') || checkAssignRights('management','view_program_list') || checkAssignRights('management','view_session_list') || checkAssignRights('management','assign_rights') || checkAssignRights('management','add_center') || checkAssignRights('management','view_centers_list') || checkAssignRights('management','assign_center') || checkAssignRights('management','oasis_calender')){ ?>
								<li aria-haspopup="true"><a href="#" class="sub-icon <?php if($this->uri->segment(2)=="add_batch" || $this->uri->segment(2)=="view_batch_list"||$this->uri->segment(2)=="add_user" ||$this->uri->segment(2)=="view_user_list" ||$this->uri->segment(2)=="user_credentials" || $this->uri->segment(2)=="active_deactive_center"||$this->uri->segment(2)=="active_deactive_user" ||$this->uri->segment(2)=="add_program" ||$this->uri->segment(2)=="view_program_list" ||$this->uri->segment(2)=="assign_rights" ||$this->uri->segment(2)=="add_center" ||$this->uri->segment(2)=="view_centers_list" || $this->uri->segment(2)=="assign_center" || $this->uri->segment(2)=="oasis_calender"){echo "active";}?>">Management <i class="fa fa-angle-down horizontal-icon"></i></a>
									<ul class="sub-menu">
										<?php 
										if(checkAssignRights('management','add_batch') || checkAssignRights('management','view_batch_list')){ ?>
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Batch Master</a>
											<ul class="sub-menu">
												<?php if(checkAssignRights('management','add_batch')){ ?>
												<li aria-haspopup="true" class="sub-menu"><a href="<?php echo site_url('Management/add_batch/')?>">Add New Batch</a></li>
												<?php } if(checkAssignRights('management','view_batch_list')){ ?>
												<li aria-haspopup="true" class="sub-menu"><a href="<?php echo site_url('Management/view_batch_list/')?>">View Batch List</a></li>
												<?php } ?>
											</ul>
										</li>
										<?php } 
										if(checkAssignRights('management','add_user') || checkAssignRights('management','view_user_list') || checkAssignRights('management','user_credentials')){ ?>
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">User Master</a>
											<ul class="sub-menu">
												<?php  if(checkAssignRights('management','add_user')){ ?>
												<li aria-haspopup="true" class="sub-menu"><a href="<?php echo site_url('Management/add_user/')?>">Add New User</a></li>
												<?php } if(checkAssignRights('management','view_user_list')){ ?>
												<li aria-haspopup="true" class="sub-menu"><a href="<?php echo site_url('Management/view_user_list/')?>">View User List</a></li>
												<?php } if(checkAssignRights('management','user_credentials')){ ?>
												<li aria-haspopup="true" class="sub-menu"><a href="<?php echo site_url('Management/user_credentials/')?>">Reset Username / Password</a></li>
												<?php } ?>
											</ul>
										</li>
										<?php } 
										if(checkAssignRights('management','active_deactive_center') || checkAssignRights('management','active_deactive_user')){ ?>
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Active-deactive</a>
											<ul class="sub-menu">
												<?php if(checkAssignRights('management','active_deactive_center')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Management/active_deactive_center/')?>">Active-deactive Center</a></li>
												<?php  } if(checkAssignRights('management','active_deactive_user')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Management/active_deactive_user/')?>">Active-deactive User</a></li>
												<?php } ?>
											</ul>
										</li>
										<?php } 
										if(checkAssignRights('management','add_program') || checkAssignRights('management','view_program_list') || checkAssignRights('management','view_session_list')){ ?>
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Program Master</a>
											<ul class="sub-menu">
												<?php if(checkAssignRights('management','add_program')){ ?>
												<li aria-haspopup="true" class="sub-menu"><a href="<?php echo site_url('Management/add_program/')?>">Add New Program</a></li>
												<?php  } if(checkAssignRights('management','view_program_list')){ ?>
												<li aria-haspopup="true" class="sub-menu"><a href="<?php echo site_url('Management/view_program_list/')?>">View Program List</a></li>
												<?php  } if(checkAssignRights('management','view_session_list')){ ?>
												<li aria-haspopup="true" class="sub-menu"><a href="<?php echo site_url('Management/view_session_list/')?>">Session Management</a></li>
												<?php } ?>
											</ul>
										</li>
										<?php } 
										if(checkAssignRights('management','assign_rights')){ ?>	
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Role Management</a>
											<ul class="sub-menu">
												<li aria-haspopup="true"><a href="<?php echo site_url('Management/assign_rights/')?>">Assign/Edit Rights</a></li>
												<!--<li aria-haspopup="true"><a href="#">View Rights List</a></li>-->
											</ul>
										</li>
										<?php } 
										if(checkAssignRights('management','add_center') || checkAssignRights('management','view_centers_list') || checkAssignRights('management','assign_center')){ ?>	
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Manage Center</a>
											<ul class="sub-menu">
												<?php if(checkAssignRights('management','add_center')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Management/add_center/')?>">Add New Center</a></li>
												<?php  } if(checkAssignRights('management','view_centers_list')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Management/view_centers_list/')?>">View Center List</a></li>
												<?php  } if(checkAssignRights('management','assign_center')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Management/assign_center/')?>">Assign Center</a></li>
												<?php } ?>
											</ul>
										</li>
										<?php } 
										if(checkAssignRights('management','oasis_calender')){ ?>	
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Calender</a>
											<ul class="sub-menu">
												<li aria-haspopup="true"><a href="<?php echo site_url('Management/oasis_calender/')?>">Oasis Calender</a></li>
											</ul>
										</li>
										<?php } ?>
									</ul>
								</li>
								<?php } if(checkAssignRights('review','program_feedback_preview') || checkAssignRights('review','personal_reflection_preview') || checkAssignRights('review','feedback_for_participants_preview') || checkAssignRights('review','program_feedback_by_participant_preview') || checkAssignRights('review','star_participants_preview') || checkAssignRights('review','impact_on_character_traits_preview')){  ?>
								<li aria-haspopup="true"><a href="#" class="sub-icon <?php if($this->uri->segment(2)=="program_feedback_preview" || $this->uri->segment(2)=="personal_reflection_preview"||$this->uri->segment(2)=="feedback_for_participants_preview" ||$this->uri->segment(2)=="program_feedback_by_participant_preview" ||$this->uri->segment(2)=="star_participants_preview" || $this->uri->segment(2)=="impact_on_character_traits_preview"){echo "active";}?>">Reviews <i class="fa fa-angle-down horizontal-icon"></i></a>
									<ul class="sub-menu">
										<?php if(checkAssignRights('review','program_feedback_preview') || checkAssignRights('review','personal_reflection_preview') || checkAssignRights('review','feedback_for_participants_preview') || checkAssignRights('review','program_feedback_by_participant_preview')){  ?>
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Feedback & <br/>Reflections</a>
											<ul class="sub-menu">
												<?php if(checkAssignRights('review','program_feedback_preview')){ ?>	
												<li aria-haspopup="true"><a href="<?php echo site_url('Review/program_feedback_preview/')?>">Program Feedback</a></li>
												<?php  } if(checkAssignRights('review','personal_reflection_preview')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Review/personal_reflection_preview/')?>">Personal Learning</a></li>
												<?php  } if(checkAssignRights('review','feedback_for_participants_preview')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Review/feedback_for_participants_preview/')?>">Feedback For Participants</a></li>
												<?php  } if(checkAssignRights('review','program_feedback_by_participant_preview')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Review/program_feedback_by_participant_preview/')?>">Program Feedback By Participant</a></li>
												<?php } ?>
											</ul>
										</li>
										<?php } if(checkAssignRights('review','star_participants_preview') || checkAssignRights('review','impact_on_character_traits_preview')){  ?>
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Submissions</a>
											<ul class="sub-menu">
												<?php if(checkAssignRights('review','star_participants_preview')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Review/star_participants_preview/')?>">Star Participants</a></li>
												<?php  } if(checkAssignRights('review','impact_on_character_traits_preview')){ ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('Review/impact_on_character_traits_preview/')?>">Impact on Character Traits</a></li>
												<?php } ?>
											</ul>
										</li>
										<?php } ?>
									</ul>
								</li>
								<?php } if(checkAssignRights('connectom','contact_us') || checkAssignRights('connectom','share_post') || checkAssignRights('connectom','view_shared_post_list') || checkAssignRights('connectom','ask_us') || checkAssignRights('connectom','add_download_data') || checkAssignRights('connectom','view_downloads_data_list')){  ?>
								<li aria-haspopup="true"><a href="#" class="sub-icon <?php if($this->uri->segment(2)=="contact_us" || $this->uri->segment(2)=="share_post"||$this->uri->segment(2)=="view_shared_post_list" ||$this->uri->segment(2)=="ask_us" ||$this->uri->segment(2)=="add_download_data" || $this->uri->segment(2)=="view_downloads_data_list"){echo "active";}?>">
									Connect With OM <i class="fa fa-angle-down horizontal-icon"></i></a>
									<ul class="sub-menu">
										<?php if(checkAssignRights('connectom','contact_us')){ ?>
										<li aria-haspopup="true"><a href="<?php echo site_url('ConnectOM/contact_us/')?>">Contact Us</a></li>
										<?php } if(checkAssignRights('connectom','share_post') || checkAssignRights('connectom','view_shared_post_list')){  ?>
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Share With Us</a>
											<ul class="sub-menu">
												<?php if(checkAssignRights('connectom','share_post')){  ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('ConnectOM/share_post/')?>">Share Post</a></li>
												<?php } if(checkAssignRights('connectom','view_shared_post_list')){  ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('ConnectOM/view_shared_post_list/')?>">View Shared Post List</a></li>
												<?php } ?>
											</ul>
										</li>	
										<?php } if(checkAssignRights('connectom','ask_us')){  ?>
										<li aria-haspopup="true"><a href="<?php echo site_url('ConnectOM/ask_us/')?>">Ask Us</a></li>
										<?php /* <li aria-haspopup="true"><a href="<?php echo site_url('ConnectOM/download_management/')?>">Download Management</a></li> */ ?>
										<?php } if(checkAssignRights('connectom','add_download_data') || checkAssignRights('connectom','view_downloads_data_list')){  ?>
										<li aria-haspopup="true" class="sub-menu-sub"><a href="#">Download<br/> Management</a>
											<ul class="sub-menu">
												<?php if(checkAssignRights('connectom','add_download_data')){  ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('ConnectOM/add_download_data/')?>">Add Data in Downloads</a></li>
												<?php } if(checkAssignRights('connectom','view_downloads_data_list')){  ?>
												<li aria-haspopup="true"><a href="<?php echo site_url('ConnectOM/view_downloads_data_list/')?>">View Downloads List</a></li>
												<?php } ?>
											</ul>
										</li>	
										<?php } ?>		
									</ul>
								</li>
								<?php } ?>
								<li aria-haspopup="true"><a href="#"> Misaal Project <i class="fa fa-angle-down horizontal-icon"></i></a>
									<ul class="sub-menu">
										<li aria-haspopup="true"><a href="https://oasismissalproject.divineinfosyshosting.com/" target="_blank">Go To Missal Portal</a></li>
									</ul>			
								</li>
							</ul>
						</nav>
						<!--Nav end -->
					</div>
				</div>
				<!-- Horizontal-menu end -->