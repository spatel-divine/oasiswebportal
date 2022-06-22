<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ProgramReport extends CI_Controller {
	public function __construct() {
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
        $this->load->model('ProgramreportModel');
    }
    // function: program_summary_report()
	// It is used to display program summary report
	public function program_summary_report(){
		$data=array();
		$this->load->model('Master/StateModel');
		$this->load->model('Master/RegionModel');
		$this->load->model('Management/CenterModel');
		$data['statelist']=$this->StateModel->getActiveStateList();
		$data['regionlist']=$this->RegionModel->getRegionByStateId();
		$data['centerlist']=$this->CenterModel->getCenterByRegionId();
		$this->load->view('program_summary_report',$data);
	}
	// function: ajax_get_program_summary_report()
	// It is used to get program summary report list by ajax
	public function ajax_get_program_summary_report(){
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
					$programsummaryreport_list=$this->ProgramreportModel->getProgramSummaryReportByFilter();
					$programsummaryreportlisthtml='';
					if($programsummaryreport_list){
						$total_batch_count=0;
						$total_participant_count=0;
						$total_facilitator_count=0;
						$total_cofacilitator_count=0;
						$total_coordinator_count=0;
						$total_volunteer_count=0;
						$total_star_participant_count=0;
						foreach($programsummaryreport_list as $programsummaryreport){
							$program_id='';
							if(isset($programsummaryreport->id) && $programsummaryreport->id){
								$program_id=base64_encode($programsummaryreport->id);
							}
							$program_name='-';
							if(isset($programsummaryreport->program_name) && $programsummaryreport->program_name){
								$program_name=$programsummaryreport->program_name;
							}
							$total_batch='-';
							if(isset($programsummaryreport->total_batch) && $programsummaryreport->total_batch){
								//$total_batch='<a href="'.site_url('ProgramReport/batch_summary_report/').$program_id.'" target="_blank"  style="color:unset;" class="btn btn-dark text-white">'.$programsummaryreport->total_batch.'</a>';
								$total_batch=$programsummaryreport->total_batch;
								$total_batch_count+=$programsummaryreport->total_batch;
							}
							$total_participant='-';
							if(isset($programsummaryreport->total_participant) && $programsummaryreport->total_participant){
								// $total_participant='<a href="'.site_url('ProgramReport/user_summary_report/batch_participant/').$program_id.'" target="_blank"  style="color:unset;" class="btn btn-danger text-white">'.$programsummaryreport->total_participant.'</a>';
								$url=site_url('ProgramReport/user_summary_report').'?tablename=batch_participant&id='.$program_id;
								$total_participant='<a class="btn btn-danger text-white" href="javascript:void(0);" onclick="fetchUserSummaryReportByProgramId(\''.$url.'\');">'.$programsummaryreport->total_participant.'</a>';
								$total_participant_count+=$programsummaryreport->total_participant;
							}
							$total_facilitator='-';
							if(isset($programsummaryreport->total_facilitator) && $programsummaryreport->total_facilitator){
								// $total_facilitator='<a href="'.site_url('ProgramReport/user_summary_report/batch_facilitator/').$program_id.'" target="_blank"  style="color:unset;" class="btn btn-info text-white">'.$programsummaryreport->total_facilitator.'</a>';
								$url=site_url('ProgramReport/user_summary_report').'?tablename=batch_facilitator&id='.$program_id;
								$total_facilitator='<a class="btn btn-info text-white" href="javascript:void(0);" onclick="fetchUserSummaryReportByProgramId(\''.$url.'\');">'.$programsummaryreport->total_facilitator.'</a>';
								$total_facilitator_count+=$programsummaryreport->total_facilitator;
							}
							$total_cofacilitator='-';
							if(isset($programsummaryreport->total_cofacilitator) && $programsummaryreport->total_cofacilitator){
								//$total_cofacilitator='<a href="'.site_url('ProgramReport/user_summary_report/batch_co_facilitator/').$program_id.'" target="_blank"  style="color:unset;" class="btn btn-secondary text-white">'.$programsummaryreport->total_cofacilitator.'</a>';
								$url=site_url('ProgramReport/user_summary_report').'?tablename=batch_co_facilitator&id='.$program_id;
								$total_cofacilitator='<a class="btn btn-secondary text-white" href="javascript:void(0);" onclick="fetchUserSummaryReportByProgramId(\''.$url.'\');">'.$programsummaryreport->total_cofacilitator.'</a>';
								$total_cofacilitator_count+=$programsummaryreport->total_cofacilitator;
							}
							$total_coordinator='-';
							if(isset($programsummaryreport->total_coordinator) && $programsummaryreport->total_coordinator){
								//$total_coordinator='<a href="'.site_url('ProgramReport/user_summary_report/batch_coordinator/').$program_id.'" target="_blank"  style="color:unset;" class="btn btn-primary text-white">'.$programsummaryreport->total_coordinator.'</a>';
								$url=site_url('ProgramReport/user_summary_report').'?tablename=batch_coordinator&id='.$program_id;
								$total_coordinator='<a class="btn btn-primary text-white" href="javascript:void(0);" onclick="fetchUserSummaryReportByProgramId(\''.$url.'\');">'.$programsummaryreport->total_coordinator.'</a>';
								$total_coordinator_count+=$programsummaryreport->total_coordinator;
							}
							$total_volunteer='-';
							if(isset($programsummaryreport->total_volunteer) && $programsummaryreport->total_volunteer){
								//$total_volunteer='<a href="'.site_url('ProgramReport/user_summary_report/batch_volunteer/').$program_id.'" target="_blank"  style="color:unset;" class="btn btn-warning text-white">'.$programsummaryreport->total_volunteer.'</a>';
								$url=site_url('ProgramReport/user_summary_report').'?tablename=batch_volunteer&id='.$program_id;
								$total_volunteer='<a class="btn btn-warning text-white" href="javascript:void(0);" onclick="fetchUserSummaryReportByProgramId(\''.$url.'\');">'.$programsummaryreport->total_volunteer.'</a>';
								$total_volunteer_count+=$programsummaryreport->total_volunteer;
							}
							$total_star_participant='-';
							if(isset($programsummaryreport->total_star_participant) && $programsummaryreport->total_star_participant){
								$total_star_participant='<a class="btn btn-purple text-white" data-toggle="modal" data-target="#largeModal" href="javascript:void(0);" onclick="fetchStarParticipantsByProgramId(\''.$program_id.'\');">'.$programsummaryreport->total_star_participant.'</a>';
								$total_star_participant_count+=$programsummaryreport->total_star_participant;

							}
							$programsummaryreportlisthtml.='<tr><th>'.$program_name.'</th><td>'.$total_batch.'</td><td>'.$total_participant.'</td><td>'.$total_star_participant.'</td><td>'.$total_facilitator.'</td><td>'.$total_cofacilitator.'</td><td>'.$total_coordinator.'</td><td>'.$total_volunteer.'</td></tr>';
						}
						$programsummaryreportlisthtml.='<tr><th>Total</th><td>'.$total_batch_count.'</td><td>'.$total_participant_count.'</td><td>'.$total_star_participant_count.'</td><td>'.$total_facilitator_count.'</td><td>'.$total_cofacilitator_count.'</td><td>'.$total_coordinator_count.'</td><td>'.$total_volunteer_count.'</td></tr>';
					}
					$message_arr['programsummaryreportlisthtml']=$programsummaryreportlisthtml;
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// function: ajax_fetch_star_participants_by_program_id()
	// It is used to fetch star participants detail by program id using ajax
	public function ajax_fetch_star_participants_by_program_id(){
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
				if(isset($_POST['program_id']) && $_POST['program_id']){
					$program_id=base64_decode($this->input->post('program_id'));
					$star_participants_list=$this->ProgramreportModel->getStartParticipantsByProgramId($program_id);
					$star_participants_html='';
					if($star_participants_list){
						foreach($star_participants_list as $star_participants){
							$first_name='-';
							if(isset($star_participants->first_name) && $star_participants->first_name){
								$first_name=ucfirst($star_participants->first_name);
							}
							$last_name='-';
							if(isset($star_participants->last_name) && $star_participants->last_name){
								$last_name=ucfirst($star_participants->last_name);
							}
							$date_of_birth='-';
							if(isset($star_participants->date_of_birth) && $star_participants->date_of_birth){
								$date_of_birth=date('d-m-Y',strtotime($star_participants->date_of_birth));
							}
							$state_name='-';
							if(isset($star_participants->state_name) && $star_participants->state_name){
								$state_name=$star_participants->state_name;
							}
							$district_name='-';
							if(isset($star_participants->district_name) && $star_participants->district_name){
								$district_name=$star_participants->district_name;
							}
							$village_name='-';
							if(isset($star_participants->village_name) && $star_participants->village_name){
								$village_name=$star_participants->village_name;
							}
							$qualities_observed='-';
							if(isset($star_participants->qualities_observed) && $star_participants->qualities_observed){
								$qualities_observed=$this->ProgramreportModel->getQualitiesObservedByIds($star_participants->qualities_observed);
							}
							$star_participants_html.='<tr><td>'.$first_name.'</td><td>'.$last_name.'</td><td>'.$date_of_birth.'</td><td>'.$state_name.'</td><td>'.$district_name.'</td><td>'.$village_name.'</td><td>'.$qualities_observed.'</td></tr>';
						}
					}
					$message_arr['star_participants_html']=$star_participants_html;
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// function: batch_summary_report($program_id)
	// It is used to display batch summary report by program id
	public function batch_summary_report($program_id){
		$data=array();
		$program_id=base64_decode($program_id);
		$data['batchsummaryreport_list']=$this->ProgramreportModel->getBatchSummaryReportByProgramId($program_id);
		$this->load->view('batch_program_report',$data);
	}
	// function: user_summary_report($program_id)
	// It is used to display user summary report by program id
	public function user_summary_report(){
		$data=array();
		$data['usersummaryreport_list']=$this->ProgramreportModel->getUserSummaryReportByProgramId();
		$this->load->view('user_summary_report',$data);
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
						$birth_date='-';
						if(isset($userdetails->birth_date) && $userdetails->birth_date){
							$birth_date=date('d-m-Y',strtotime($userdetails->birth_date));
						}
						$languages_known='-';
						if(isset($userdetails->languages_known) && $userdetails->languages_known){
							$languages_known=$userdetails->languages_known;
						}
						$edu_qualification='-';
						if(isset($userdetails->edu_qualification) && $userdetails->edu_qualification){
							$edu_qualification=$userdetails->edu_qualification;
						}
						$user_html.='<tr><td><b>Name</b></td><td>'.$fullname.'</td></tr><tr><td><b>Address</b></td><td>'.$address.'</td></tr><tr><td><b>Mobile No</b></td><td>'.$mobile_number.'</td></tr><tr><td><b>Email Id</b></td><td>'.$email.'</td></tr><tr><td><b>DOB</b></td><td>'.$birth_date.'</td></tr><tr><td><b>Languages Known</b></td><td>'.$languages_known.'</td></tr><tr><td><b>Educational Backgorund</b></td><td>'.$edu_qualification.'</td></tr>';
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
					$batchlist=$this->ProgramreportModel->getBatchListByUserId($user_id);
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
	// function: ajax_fetch_user_type_batch_list_by_userid_type()
	// It is used to fetch user type batch list by user id and table name using ajax
	public function ajax_fetch_user_type_batch_list_by_userid_type(){
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
				if(isset($_POST['tablename']) && $_POST['tablename'] && isset($_POST['user_id']) && $_POST['user_id']){
					$tablename=$this->input->post('tablename');
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
					$batchlist=$this->ProgramreportModel->getUserTypeBatchListByUserId($tablename,$user_id);
					$usertypehtml='';
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
							$usertypehtml.='<tr><th>'.$batch_name.'</th><td>'.$program_name.'</td><td>'.$location.'</td><td>'.$start_date.'</td><td>'.$end_date.'</td></tr>';
						}
					}
					$message_arr['usertypehtml']=$usertypehtml;
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
}
