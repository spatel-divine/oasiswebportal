<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {
	public function __construct(){
    	parent::__construct();
    	if(!(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest')){
    		// Start check Login
            if(!is_logged_in()){
			    redirect('login');
			}
			// End check Login
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			if(!$result){
			 	redirect('home/error403');
			}
			// End check Assign Rights
        }
        $this->load->model('DashboardModel');
    }
    // function: program_overview()
	// It is used to display program overview
	public function program_overview(){
		$data=array();
		$this->load->model('Master/StateModel');
		$this->load->model('Master/RegionModel');
		$this->load->model('Management/CenterModel');
		$data['statelist']=$this->StateModel->getActiveStateList();
		$data['regionlist']=$this->RegionModel->getRegionByStateId();
		$data['centerlist']=$this->CenterModel->getCenterByRegionId();
		$data['yearlist']=array_combine(range(date("Y"), 2019), range(date("Y"), 2019));
		$this->load->view('program_overview',$data);
	}
	// function: ajax_get_program_overview()
	// It is used to get program overview by ajax
	public function ajax_get_program_overview(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST) && $_POST){
					$programoverview_list=$this->DashboardModel->getProgramOverviewByFilter();
					$programoverviewhtml='';
					if($programoverview_list){
						$total_batch_count=0;
						$total_participant_count=0;
						$total_batch_by_year_count=0;
						$total_participant_by_year_count=0;
						$total_participant_by_children_youth_count=0;
						$total_participant_by_adult_count=0;
						foreach($programoverview_list as $programoverview){
							$program_id='';
							if(isset($programoverview->id) && $programoverview->id){
								$program_id=base64_encode($programoverview->id);
							}
							$program_name='-';
							if(isset($programoverview->program_name) && $programoverview->program_name){
								$program_name=$programoverview->program_name;
							}
							$total_batch='-';
							if(isset($programoverview->total_batch) && $programoverview->total_batch){
								$total_batch=$programoverview->total_batch;
								$total_batch_count+=$programoverview->total_batch;
							}
							$total_participant='-';
							if(isset($programoverview->total_participant) && $programoverview->total_participant){
								$total_participant=$programoverview->total_participant;
								$total_participant_count+=$programoverview->total_participant;
							}
							$total_batch_by_year='-';
							if(isset($programoverview->total_batch_by_year) && $programoverview->total_batch_by_year){
								$total_batch_by_year=$programoverview->total_batch_by_year;
								$total_batch_by_year_count+=$programoverview->total_batch_by_year;
							}
							$total_participant_by_year='-';
							if(isset($programoverview->total_participant_by_year) && $programoverview->total_participant_by_year){
								$total_participant_by_year=$programoverview->total_participant_by_year;
								$total_participant_by_year_count+=$programoverview->total_participant_by_year;
							}
							$total_participant_by_children_youth='-';
							if(isset($programoverview->total_participant_by_children_youth) && $programoverview->total_participant_by_children_youth){
								$total_participant_by_children_youth=$programoverview->total_participant_by_children_youth;
								$total_participant_by_children_youth_count+=$programoverview->total_participant_by_children_youth;
							}
							$total_participant_by_adult='-';
							if(isset($programoverview->total_participant_by_adult) && $programoverview->total_participant_by_adult){
								$total_participant_by_adult=$programoverview->total_participant_by_adult;
								$total_participant_by_adult_count+=$programoverview->total_participant_by_adult;
							}
							$programoverviewhtml.='<tr><td><b>'.$program_name.'</b></td><td class="text-center">'.$total_batch.'</td><td class="text-center">'.$total_participant.'</td><td class="text-center">'.$total_batch_by_year.'</td><td class="text-center">'.$total_participant_by_year.'</td><td class="text-center">'.$total_participant_by_children_youth.'</td><td class="text-center">'.$total_participant_by_adult.'</td></tr>';
						}
						$programoverviewhtml.='<tr><td class="text-right"><b>Total</b></td><td class="text-center">'.$total_batch_count.'</td><td class="text-center">'.$total_participant_count.'</td><td class="text-center">'.$total_batch_by_year_count.'</td><td class="text-center">'.$total_participant_by_year_count.'</td><td class="text-center">'.$total_participant_by_children_youth_count.'</td><td class="text-center">'.$total_participant_by_adult_count.'</td></tr>';
					}
					$message_arr['programoverviewhtml']=$programoverviewhtml;
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// function: monitoring_project_programs()
	// It is used to display project programs
	public function monitoring_project_programs(){
		$data=array();
		$this->load->model('Master/StateModel');
		$this->load->model('Master/RegionModel');
		$this->load->model('Management/CenterModel');
		$data['statelist']=$this->StateModel->getActiveStateList();
		$data['regionlist']=$this->RegionModel->getRegionByStateId();
		$data['centerlist']=$this->CenterModel->getCenterByRegionId();
		$this->load->view('monitoring_project_programs',$data);
	}
	// function: ajax_get_monitoring_project_program()
	// It is used to get monitoring project program by ajax
	public function ajax_get_monitoring_project_program(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST) && $_POST){
					$projectprogram_list=$this->DashboardModel->getMonitoringProjectProgramByFilter();
					$projectprogramhtml='';
					if($projectprogram_list){
						$no_of_programs_count=0;
						$total_completed_program_count=0;
						$pending_program_count=0;
						$totalnum=0;
						$applycls='';
						foreach($projectprogram_list as $projectprogram){
							$clsname='';
							$program_id='';
							if(isset($projectprogram->id) && $projectprogram->id){
								$program_id=base64_encode($projectprogram->id);
							}
							$program_name='-';
							if(isset($projectprogram->program_name) && $projectprogram->program_name){
								$program_name=$projectprogram->program_name;
							}
							$no_of_programs='-';
							if(isset($projectprogram->no_of_programs) && $projectprogram->no_of_programs){
								$no_of_programs=$projectprogram->no_of_programs;
								$no_of_programs_count+=$projectprogram->no_of_programs;
								$clsname='btn-primary highlight';
								$applycls='btn-primary highlight';
							}
							$total_completed_program='-';
							if(isset($projectprogram->total_completed_program) && $projectprogram->total_completed_program){
								$total_completed_program=$projectprogram->total_completed_program;
								$total_completed_program_count+=$projectprogram->total_completed_program;
								if($no_of_programs!='-'){
									$totalnum+=$projectprogram->total_completed_program;
								}
							}
							$pending_program='-';
							if(isset($projectprogram->pending_program) && $projectprogram->pending_program){
								$pending_program=$projectprogram->pending_program;
								$pending_program_count+=$projectprogram->pending_program;
							}
							$achievement='-';
							if(isset($projectprogram->achievement) && $projectprogram->achievement){
								$achievement=$projectprogram->achievement;
							}
							$projectprogramhtml.='<tr class="'.$clsname.'"><td><b>'.$program_name.'</b></td><td class="text-center">'.$no_of_programs.'</td><td class="text-center">'.$total_completed_program.'</td><td class="text-center">'.$pending_program.'</td><td class="text-center">'.$achievement.'</td></tr>';
						}
						$avg='0';
						if($no_of_programs_count>0){
							$avg=ROUND(((100*$totalnum)/$no_of_programs_count),2);
						}
						$projectprogramhtml.='<tr class="'.$applycls.'"><td class="text-right"><b>Total</b></td><td class="text-center">'.$no_of_programs_count.'</td><td class="text-center">'.$totalnum.'</td><td class="text-center">'.$pending_program_count.'</td><td class="text-center">'.$avg.'%</td></tr>';
					}
					$message_arr['projectprogramhtml']=$projectprogramhtml;
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	public function monitroing_leaders_team(){
		$data=array();
		$this->load->model('Master/StateModel');
		$this->load->model('Master/RegionModel');
		$this->load->model('Management/CenterModel');
		$data['statelist']=$this->StateModel->getActiveStateList();
		$data['regionlist']=$this->RegionModel->getRegionByStateId();
		$data['centerlist']=$this->CenterModel->getCenterByRegionId();
		$this->load->view('monitroing_leaders_team',$data);
	}
	// function: ajax_get_monitoring_leaders_team()
	// It is used to get monitoring leaders team by ajax
	public function ajax_get_monitoring_leaders_team(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST) && $_POST){
					$monitoringleadersteam_list=$this->DashboardModel->getMonitoringLeadersTeamByFilter();
					$leaderprofilehtml='';
					if($monitoringleadersteam_list){
						foreach($monitoringleadersteam_list as $monitoringleadersteam){
							$user_id='';
							if(isset($monitoringleadersteam->user_id) && $monitoringleadersteam->user_id){
								$user_id=base64_encode($monitoringleadersteam->user_id);
							}
							$fullname='-';
							if(isset($monitoringleadersteam->fullname) && $monitoringleadersteam->fullname){
								$fullname='<a class="btn btn-dark" data-toggle="modal" data-target="#largeModal" href="javascript:void(0);" onclick="fetchUserDetailById(\''.$user_id.'\');">'.$monitoringleadersteam->fullname.'</a>';
							}
							$role_name='-';
							if(isset($monitoringleadersteam->role_name) && $monitoringleadersteam->role_name){
								$role_name=$monitoringleadersteam->role_name;
							}
							$active_since='-';
							if(isset($monitoringleadersteam->active_since) && $monitoringleadersteam->active_since && $monitoringleadersteam->active_since!='0000-00-00 00:00:00'){
								$active_since=date('d-m-Y',strtotime($monitoringleadersteam->active_since));
							}
							$total_program_attended='-';
							if(isset($monitoringleadersteam->total_program_attended) && $monitoringleadersteam->total_program_attended){
								$total_program_attended='<a class="btn btn-info" data-toggle="modal" data-target="#programDetails" href="javascript:void(0);" onclick="fetchBatchlistByUserId(\''.$user_id.'\');">'.$monitoringleadersteam->total_program_attended.'</a>';
							}
							$leaderprofilehtml.='<tr><td>'.$fullname.'</td><td>'.$role_name.'</td><td>'.$active_since.'</td><td>'.$total_program_attended.'</td></tr>';
						}
					}
					$message_arr['leaderprofilehtml']=$leaderprofilehtml;
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// function: ajax_fetch_user_details_by_id()
	// It is used to fetch user details by id using ajax
	public function ajax_fetch_user_details_by_id(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['user_id']) && $_POST['user_id']){
					$user_id=base64_decode($this->input->post('user_id'));
					$this->load->model('Management/UserModel');
					$userdetails=$this->UserModel->getUserById($user_id);
					$user_html='';
					if($userdetails){
						$fullname='';
						if(isset($userdetails->first_name) && $userdetails->first_name){
							$fullname.=$userdetails->first_name;
						}
						if(isset($userdetails->last_name) && $userdetails->last_name){
							if($fullname){
								$fullname.=' ';
							}
							$fullname.=$userdetails->last_name;
						}
						if($fullname==''){
							$fullname='-';
						}
						$birth_date='-';
						if(isset($userdetails->birth_date) && $userdetails->birth_date){
							$birth_date=date('d-m-Y',strtotime($userdetails->birth_date));
						}
						$gender='-';
						if(isset($userdetails->gender) && $userdetails->gender){
							$gender=$userdetails->gender;
						}
						$address='-';
						if(isset($userdetails->address) && $userdetails->address){
							$address=$userdetails->address;
						}
						$mobile_number='-';
						if(isset($userdetails->mobile_number) && $userdetails->mobile_number){
							$mobile_number=$userdetails->mobile_number;
						}
						$email='-';
						if(isset($userdetails->email) && $userdetails->email){
							$email=$userdetails->email;
						}
						$edu_qualification='-';
						if(isset($userdetails->edu_qualification) && $userdetails->edu_qualification){
							$edu_qualification=$userdetails->edu_qualification;
						}
						$occupation='-';
						if(isset($userdetails->occupation) && $userdetails->occupation){
							$occupation=$userdetails->occupation;
						}
						$languages_known='-';
						if(isset($userdetails->languages_known) && $userdetails->languages_known){
							$languages_known=$userdetails->languages_known;
						}
						$marital_status='-';
						if(isset($userdetails->marital_status) && $userdetails->marital_status){
							$marital_status=$userdetails->marital_status;
						}
						$user_html.='<tr><td><b>Name</b></td><td>'.$fullname.'</td></tr><tr><td><b>DOB</b></td><td>'.$birth_date.'</td></tr><tr><td><b>Gender</b></td><td>'.$gender.'</td></tr><tr><td><b>Address</b></td><td>'.$address.'</td></tr><tr><td><b>Mobile No</b></td><td>'.$mobile_number.'</td></tr><tr><td><b>Email Id</b></td><td>'.$email.'</td></tr><tr><td><b>Education</b></td><td>'.$edu_qualification.'</td></tr><tr><td><b>Occupation</b></td><td>'.$occupation.'</td></tr><tr><td><b>Languages Known</b></td><td>'.$languages_known.'</td></tr><tr><td><b>Martial Status</b></td><td>'.$marital_status.'</td></tr>';
					}
					$message_arr['user_html']=$user_html;
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// function: ajax_fetch_batch_list_by_userid()
	// It is used to fetch batch list by id using ajax
	public function ajax_fetch_batch_list_by_userid(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['user_id']) && $_POST['user_id']){
					$user_id=base64_decode($this->input->post('user_id'));
					$this->load->model('Management/UserModel');
					$userdetails=$this->UserModel->getUserById($user_id);
					$fullname='';
					if($userdetails){
						if(isset($userdetails->first_name) && $userdetails->first_name){
							$fullname.=$userdetails->first_name;
						}
						if(isset($userdetails->last_name) && $userdetails->last_name){
							if($fullname){
								$fullname.=' ';
							}
							$fullname.=$userdetails->last_name;
						}
					}
					$message_arr['userfullname']=$fullname;
					$batchlist=$this->DashboardModel->getBatchListByUserId($user_id);
					$batch_html='';
					if($batchlist){
						foreach ($batchlist as $batch){
							$batch_name='-';
							if(isset($batch->batch_name) && $batch->batch_name){
								$batch_name=$batch->batch_name;
							}
							$program_name='-';
							if(isset($batch->program_name) && $batch->program_name){
								$program_name=$batch->program_name;
							}
							$location='-';
							if(isset($batch->location) && $batch->location){
								$location=$batch->location;
							}
							$start_date='-';
							if(isset($batch->start_date) && $batch->start_date){
								$start_date=date('d-m-Y',strtotime($batch->start_date));
							}
							$end_date='-';
							if(isset($batch->end_date) && $batch->end_date){
								$end_date=date('d-m-Y',strtotime($batch->end_date));
							}
							$batch_html.='<tr><th>'.$batch_name.'</th><td>'.$program_name.'</td><td>'.$location.'</td><td>'.$start_date.'</td><td>'.$end_date.'</td></tr>';
						}
					}
					$message_arr['batch_html']=$batch_html;
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// function: monitroing_facilitators()
	// It is used to get monitoring facilitators list
	public function monitroing_facilitators(){
		$data=array();
		$this->load->model('Master/StateModel');
		$this->load->model('Master/RegionModel');
		$this->load->model('Management/CenterModel');
		$data['statelist']=$this->StateModel->getActiveStateList();
		$data['regionlist']=$this->RegionModel->getRegionByStateId();
		$data['centerlist']=$this->CenterModel->getCenterByRegionId();
		$this->load->view('monitroing_facilitators',$data);
	}
	// function: ajax_monitroing_facilitators()
	// It is used to get monitoring facilitators by ajax
	public function ajax_monitroing_facilitators(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST) && $_POST){
					$monitoringfacilitator_list=$this->DashboardModel->getMonitoringFacilitatorsByFilter();
					$monitoringfacilitatorhtml='';
					if($monitoringfacilitator_list){
						foreach($monitoringfacilitator_list as $monitoringfacilitator){
							$program_name='-';
							if(isset($monitoringfacilitator->program_name) && $monitoringfacilitator->program_name){
								$program_name=$monitoringfacilitator->program_name;
							}
							$training_given='-';
							if(isset($monitoringfacilitator->training_given) && $monitoringfacilitator->training_given){
								$training_given=$monitoringfacilitator->training_given;
							}
							$total_active_facilitator='-';
							if(isset($monitoringfacilitator->total_active_facilitator) && $monitoringfacilitator->total_active_facilitator){
								$total_active_facilitator='<a class="btn btn-dark" data-toggle="modal" data-target="#active_faclitator" href="javascript:void(0);" onclick="fetchActiveFacilitatorByUserIds(
							\''.str_replace("'","",$monitoringfacilitator->active_facilitator_list).'\');">'.$monitoringfacilitator->total_active_facilitator.'</a>';
							}
							$total_inactive_facilitator='-';
							if(isset($monitoringfacilitator->active_facilitator_list) && $monitoringfacilitator->active_facilitator_list){
								$inactive_facilitator=$this->DashboardModel->getTotalInactiveFacilitators($monitoringfacilitator->active_facilitator_list);
								$total_inactive_facilitator='<a class="btn btn-secondary" data-toggle="modal" data-target="#inactive_faclitator" href="javascript:void(0);" onclick="fetchInactiveFacilitatorByUserIds(\''.str_replace("'","",$monitoringfacilitator->active_facilitator_list).'\');">'.$inactive_facilitator.'</a>';
							}
							$no_of_facilitators='-';
							if(isset($monitoringfacilitator->no_of_facilitators) && $monitoringfacilitator->no_of_facilitators){
								$no_of_facilitators=$monitoringfacilitator->no_of_facilitators;
							}
							$learners='-';
							if(isset($monitoringfacilitator->learners) && $monitoringfacilitator->learners){
								$learners=$monitoringfacilitator->learners;
							}
							$achievement='-';
							if(isset($monitoringfacilitator->achievement) && $monitoringfacilitator->achievement){
								$achievement=$monitoringfacilitator->achievement;
							}
							$monitoringfacilitatorhtml.='<tr><td>'.$program_name.'</td><td>'.$training_given.'</td><td>'.$total_active_facilitator.'</td><td>'.$total_inactive_facilitator.'</td><td>'.$no_of_facilitators.'</td><td>'.$learners.'</td><td>'.$achievement.'</td></tr>';
						}
					}
					$message_arr['monitoringfacilitatorhtml']=$monitoringfacilitatorhtml;
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// function: my_journey_with_om()
	// It is used to display login user journey with om
	public function my_journey_with_om(){
		$data=array();
		$user_id=$this->session->userdata('id');
		$this->load->model('ProgramreportModel');
		$fullname='';
		if(isset($_SESSION['first_name']) && $_SESSION['first_name']){
			$fullname.=$this->session->userdata('first_name');
		}
		if(isset($_SESSION['last_name']) && $_SESSION['last_name']){
			if($fullname){
				$fullname.=' ';
			}
			$fullname.=$this->session->userdata('last_name');
		}
		$data['fullname']=ucwords($fullname);
		$data['batchlist']=$this->ProgramreportModel->getBatchListByUserId($user_id);
		//print_r($data['batchlist']);die();
		$this->load->view('my_journey_with_om',$data);
	}
	// function: ajax_fetch_active_user_details_by_ids()
	// It is used to fetch active user details by ids using ajax
	public function ajax_fetch_active_user_details_by_ids(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['user_ids']) && $_POST['user_ids']){
					$user_ids=$this->input->post('user_ids');
					$users=$this->DashboardModel->getActiveUserByIds($user_ids);
					$active_faclitator_html='';
					if($users){
						foreach($users as $u){
							$active_faclitator_html.='<tr><td>'.$u->fullname.'</td><td>'.$u->gender.'</td><td>'.$u->age.'</td><td>'.$u->state_name.'</td><td>'.$u->region_name.'</td><td>'.$u->center_name.'</td><td>'.$u->active_since.'</td></tr>';
						}
					}
					$message_arr['active_faclitator_html']=$active_faclitator_html;
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// function: ajax_fetch_inactive_user_details_by_ids()
	// It is used to fetch inactive user details by ids using ajax
	public function ajax_fetch_inactive_user_details_by_ids(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['user_ids']) && $_POST['user_ids']){
					$user_ids=$this->input->post('user_ids');
					$users=$this->DashboardModel->getInactiveUserByIds($user_ids);
					$inactive_faclitator_html='';
					if($users){
						foreach($users as $u){
							if($u->active_since>0){ 
								$active_since=$u->active_since; 
							}else{ 
								$active_since='-'; 
							}
							$inactive_faclitator_html.='<tr><td>'.$u->fullname.'</td><td>'.$u->gender.'</td><td>'.$u->age.'</td><td>'.$u->state_name.'</td><td>'.$u->region_name.'</td><td>'.$u->center_name.'</td><td>'.$active_since.'</td></tr>';
						}
					}
					$message_arr['inactive_faclitator_html']=$inactive_faclitator_html;
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
}
