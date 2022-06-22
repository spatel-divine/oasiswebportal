<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Management extends CI_Controller {
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
		//get user type.
		$this->load->model('Management/UserModel');
		$this->load->model('Master/StateModel');
		$this->load->model('Master/RoleModel');
		$this->load->model('Master/DistrictModel');
		$this->load->model('Master/CityModel');
		$this->load->model('Master/BatchModel');
    }
    // *************** Start Batch Master Code*********************
    // function: view_batch_list()
	// It is used to display batch list
	public function view_batch_list(){
		$data['batch_list']=$this->BatchModel->getBatchList();	
		$this->load->view('view_batch_list',$data);
	}
    // function: add_batch()
	// It is used to add batch
	public function add_batch($batch_id=''){
		$data=array();
		$this->load->model('Management/ProgramMasterModel');
		$this->load->model('Master/GroupTypeModel');
		if(isset($_POST) && $_POST){
			$this->form_validation->set_rules('state_id', 'State', 'required', array('required' => 'Please Select State'));
			$this->form_validation->set_rules('region_id', 'Region', 'required', array('required' => 'Please Select Region'));
			$this->form_validation->set_rules('center_id', 'Center', 'required', array('required' => 'Please Select Center'));
			$this->form_validation->set_rules('program_id', 'Program', 'required', array('required' => 'Please Select Program'));
			$this->form_validation->set_rules('batch_name', 'Batch Name', 'required', array('required' => 'Enter Batch Name'));
			$this->form_validation->set_rules('start_date', 'Start Date', 'required', array('required' => 'Please Select Start Date'));
			$this->form_validation->set_rules('end_date', 'End Date', 'required', array('required' => 'Please Select End Date'));
			$this->form_validation->set_rules('location', 'Location', 'required', array('required' => 'Enter Batch Location'));
			$this->form_validation->set_rules('no_of_participant_registered', 'No. of Participant Registered', 'required', array('required' => 'Enter No. of Participant Registered'));
			$this->form_validation->set_rules('group_id', 'Group', 'required', array('required' => 'Please Select Group'));
			$this->form_validation->set_rules('group_name', 'Group Name', 'required', array('required' => 'Enter Group Name'));
			$this->form_validation->set_rules('facilitator[]', 'Facilitator', 'required', array('required' => 'Please Select Facilitator'));
			$this->form_validation->set_rules('co_facilitator[]', 'Co-Facilitator', 'required', array('required' => 'Please Select Co-Facilitator'));
			$this->form_validation->set_rules('coordinator[]', 'Co-Ordinator', 'required', array('required' => 'Please Select Co-Ordinator'));
			$this->form_validation->set_rules('volunteer[]', 'Volunteer', 'required', array('required' => 'Please Select Volunteer'));
			$this->form_validation->set_rules('participant[]', 'Participant', 'required', array('required' => 'Please Select Participant'));
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('errors', validation_errors());
			}else{
				if(isset($_POST['batch_id']) && $_POST['batch_id']){
					//Update Batch
					$result=$this->BatchModel->updateBatch();
					if($result==1){
						$this->session->set_flashdata('message','Batch has been updated successfully.');
					}else{
						$this->session->set_flashdata('message','Sorry, Batch could not be updated. Try again.');
					}
				}else{
					//Insert Batch
					$result=$this->BatchModel->insertBatch();	
					if($result==1){				
						$this->session->set_flashdata('message','Batch has been added successfully.');
					}else{
						$this->session->set_flashdata('message','Sorry, Batch could not be added. Try again.');
					}

				}
				redirect('management/view_batch_list');
			}
		}
		$data['statelist']=$this->StateModel->getActiveStateList();
		$data['programlist']=$this->ProgramMasterModel->getActiveProgramList();
		$data['grouptypelist']=$this->GroupTypeModel->getGroupTypeList();
		$data['facilitatorlist']=$this->UserModel->getFacilitatorList();
		$data['cofacilitatorlist']=$this->UserModel->getCoFacilitatorList();
		$data['coordinatorlist']=$this->UserModel->getCoordinatorList();
		$data['volunteerlist']=$this->UserModel->getVolunteerList();
		$data['participantlist']=$this->UserModel->getParticipantList();
		//get the batch data from batch id.
		if($batch_id=='' && isset($_POST['batch_id']) && $_POST['batch_id']){
			$batch_id=$this->input->post('batch_id');
		}
		if($batch_id){
			$batch_id=base64_decode($batch_id);
			$batchdetails = $this->BatchModel->getBatchById($batch_id);
			$data['batchdetails'] = $batchdetails;
		}
		if(isset($_POST['state_id'])){
			$state_id = $this->input->post('state_id');	
		}else if(isset($batchdetails->state_id) && $batchdetails->state_id!='' && $batchdetails->state_id!=null){
			$state_id = $batchdetails->state_id;
		}
		if(isset($_POST['region_id'])){
			$region_id = $this->input->post('region_id');
		}else if(isset($batchdetails->region_id) && $batchdetails->region_id!='' && $batchdetails->region_id!=null){
			$region_id = $batchdetails->region_id;
		}
		if(isset($_POST['center_id'])){
			$center_id = $this->input->post('center_id');
		}else if(isset($batchdetails->center_id) && $batchdetails->center_id!='' && $batchdetails->center_id!=null){
			$center_id = $batchdetails->center_id;
		}
		if(isset($state_id) && $state_id!='' && $state_id!=null){
			$this->load->model('Master/RegionModel');
			$regions=$this->RegionModel->getRegionByStateId($state_id);
			$regionlist='<option value="">--Select--</option>';
			if($regions){
				foreach ($regions as $region){
					$selected="";
					if(isset($region_id) && $region_id==$region->id){
						$selected="selected";
					}
					$regionlist.='<option value="'.$region->id.'" '.$selected.'>'.ucfirst($region->region_name).'</option>';
				}
			}
			$data['regionlist']=$regionlist;
			$data['state_id']=$state_id;
			if(isset($region_id) && $region_id!='' && $region_id!=null){
				$this->load->model('Management/CenterModel');
				$centers=$this->CenterModel->getCenterByRegionId($region_id);
				$centerlist='<option value="">--Select--</option>';
				if($centers){
					foreach ($centers as $center){
						$selected="";
						if(isset($center_id) && $center_id==$center->id){
							$selected="selected";
						}
						$centerlist.='<option value="'.$center->id.'" '.$selected.'>'.ucfirst($center->center_name).'</option>';
					}
				}
				$data['centerlist']=$centerlist;
				$data['region_id']=$region_id;
				if(isset($center_id) && $center_id!='' && $center_id!=null){
					$data['center_id']=$center_id;
				}
			}
		}
		if(isset($_POST['facilitator']) && $_POST['facilitator']!='' && $_POST['facilitator']!=null){
			$data['batchfacilitator'] = $_POST['facilitator'];
		}else if(isset($batchdetails->id) && $batchdetails->id!='' && $batchdetails->id!=null){
			$data['batchfacilitator'] = $this->BatchModel->getBatchFacilitatorByBatchId($batchdetails->id);
		}
		if(isset($_POST['co_facilitator']) && $_POST['co_facilitator']!='' && $_POST['co_facilitator']!=null){
			$data['batchcofacilitator'] = $_POST['co_facilitator'];
		}else if(isset($batchdetails->id) && $batchdetails->id!='' && $batchdetails->id!=null){
			$data['batchcofacilitator'] = $this->BatchModel->getBatchCoFacilitatorByBatchId($batchdetails->id);
		}
		if(isset($_POST['coordinator']) && $_POST['coordinator']!='' && $_POST['coordinator']!=null){
			$data['batchcoordinator'] = $_POST['coordinator'];
		}else if(isset($batchdetails->id) && $batchdetails->id!='' && $batchdetails->id!=null){
			$data['batchcoordinator'] = $this->BatchModel->getBatchCoordinatorByBatchId($batchdetails->id);
		}
		if(isset($_POST['volunteer']) && $_POST['volunteer']!='' && $_POST['volunteer']!=null){
			$data['batchvolunteer'] = $_POST['volunteer'];
		}else if(isset($batchdetails->id) && $batchdetails->id!='' && $batchdetails->id!=null){
			$data['batchvolunteer'] = $this->BatchModel->getBatchVolunteerByBatchId($batchdetails->id);
		}
		if(isset($_POST['participant']) && $_POST['participant']!='' && $_POST['participant']!=null){
			$data['batchparticipant'] = $_POST['participant'];
		}else if(isset($batchdetails->id) && $batchdetails->id!='' && $batchdetails->id!=null){
			$data['batchparticipant'] = $this->BatchModel->getBatchParticipantByBatchId($batchdetails->id);
		}
		$this->load->view('add_batch',$data);
	}
	// function: delete_batch()
	// It is used to delete batch
	public function delete_batch($batch_id){
		if($batch_id){
			$batch_id=base64_decode($batch_id);
			$result=$this->BatchModel->deleteBatch($batch_id);
			if($result==1){
				$this->session->set_flashdata('message','Batch has been deleted successfully.');
			}else{
				$this->session->set_flashdata('message','Sorry, Batch could not be deleted. Try again.');
			}
		}else{
			$this->session->set_flashdata('message','Sorry, Batch could not be deleted. Try again.');
		}
		redirect('management/view_batch_list');
	}
	// function: ajax_get_batchlist_by_date()
	// It is used to get batch list by start date and end date
	public function ajax_get_batchlist_by_date(){
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
					$batch_list=$this->BatchModel->getBatchlistByDateRange();
					$data['batch_list']=$this->BatchModel->getBatchList();	
					$batchlisthtml='';
					if($batch_list){
						foreach ($batch_list as $batch){
							$program_name='N/A';
							if(isset($batch->program_name) && $batch->program_name!='' && $batch->program_name!=null){ 
								$program_name=ucfirst($batch->program_name);
							}
							$batch_name='N/A';
							if(isset($batch->batch_name) && $batch->batch_name!='' && $batch->batch_name!=null){ 
								$batch_name=ucfirst($batch->batch_name);
							}
							$location='N/A';
							if(isset($batch->location) && $batch->location!='' && $batch->location!=null){ 
								$location=$batch->location;
							}
							$start_date='N/A';
							if(isset($batch->start_date) && $batch->start_date!='' && $batch->start_date!=null){ 
								$start_date=date('d-m-Y',strtotime($batch->start_date));
							}
							$end_date='N/A';
							if(isset($batch->end_date) && $batch->end_date!='' && $batch->end_date!=null){ 
								$end_date=date('d-m-Y',strtotime($batch->end_date));
							}
							$editlink=site_url('management/add_batch/'.base64_encode($batch->id));
							$deletelink=base64_encode($batch->id);
							$batchlisthtml.='<tr><td>'.$program_name.'</td><td>'.$batch_name.'</td><td>'.$location.'</td><td>'.$start_date.'</td><td>'.$end_date.'</td><td  style="width:20px;"><a class="btn btn-secondary btn-sm" href="'.$editlink.'"><i class="fa fa-edit"></i> Edit</a>&nbsp<a class="btn btn-secondary btn-sm" onclick="deleteBatch(\''.$deletelink.'\');" href="javascript:void(0);"><i class="fa fa-delete"></i> Delete</a></td></tr>';
						}
					}
					$message_arr['batchlisthtml']=$batchlisthtml;
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// *************** End Batch Master Code*********************
	//Get the district data...
	public function get_district(){
		$state_id = $_POST['state_id'];
		$sel_dist_id = $_POST['sel_dist_id'];
		if($state_id !="") {
			$district_data = $this->DistrictModel->get_district_from_state($state_id);
			$district_select = "<option value=''>Select District</option>";
			if(count($district_data) >0) {
				 foreach($district_data as $dist_value) {
					 $select = "";
					if($sel_dist_id == $dist_value->id ) {
						$select = 'selected';
					}
			 		$district_select .= "<option value='".$dist_value->id."' ".$select."> ".$dist_value->district_name." </option>";
				}
			}
			echo $district_select;
		}
	}
	//Get city ajax data..
	public function get_city_ajax_controller(){
		$dist_id = $_POST['dist_id'];
		$sel_city_id = $_POST['sel_city_id'];
		if($dist_id !="") {
			$city_data = $this->CityModel->get_city_from_dist($dist_id);
			$city_select = "<option value=''>Select City</option>";
			if(count($city_data) >0) {
				foreach($city_data as $city_val) {
					$select = "";
					if($sel_city_id == $city_val->id ) {
						$select = 'selected';
					}
					$city_select .= "<option value='".$city_val->id."' ".$select.">".$city_val->village_name." </option>";
				}
			}
			echo $city_select;
		}
    }
   /**
	* Delete User from user table
    */
    public function delete_user(){
		if(isset($_POST['user_id'])){
			$data = array(
            	'deleted_by' => $this->session->userdata('id'),
            	'deleted_at' => date('Y-m-d H:i:s')
        	);
        	$this->db->where('id', $_POST['user_id']);
       		echo $this->db->update('users', $data);
		}
    }
   /**
	* Change Password.
    */
	public function PasswordChange(){
		$change_pw = $this->UserModel->change_user_password();
		if($change_pw) {
			$this->session->set_flashdata('success', 'Successfully Updated user password');
			redirect('management/user_credentials');
		}else{
			$this->session->set_flashdata('error', 'Error in updated user password');
		}
	}
	public function add_user($user_id = ""){
		$dataUserType['UserTypeData'] = $this->UserModel->get_user_type();

		if($user_id !=""){
			$dataUserType['UsersData'] = $this->UserModel->get_user_list($user_id);
		}

		//get the state
		$dataUserType['state_data'] = $this->StateModel->get_state();
		$dataUserType['role_data'] = $this->RoleModel->get_role();
		
		$this->load->view('add_user', $dataUserType);
	}
	public function view_user_list(){
		//get the user list from database..
		$data['UserList'] = $this->UserModel->get_user_list();
		$this->load->view('view_user_list', $data);
	}
	/**
	 * Add Program in the program master table.
	 */
	public function add_program($program_id = ""){
		//Load the program master model
		$this->load->model('Management/ProgramMasterModel');
		//Load the Program related model
		$this->load->model('Master/ProgramRelatedModel');
		$data['data_program_related'] = $this->ProgramRelatedModel->get_program_related();
		//Load the program type model
		$this->load->model('Master/ProgramTypeModel');
		$data['data_program_type'] = $this->ProgramTypeModel->get_program_type();
		//Get the post data on Add/Edit form
		$post = $this->input->post();
		if(isset($post['action']) && $post['action'] !='' ){
			$this->form_validation->set_rules('program_name', 'Program Name', 'required');
			$this->form_validation->set_rules('program_related_id', 'Program Related to', 'required');
			$this->form_validation->set_rules('program_type_id', 'Program Type', 'required');
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('errors', validation_errors());
				//redirect($this->uri->uri_string().'/'.$this->input->post('program_master_id'));
			}else{
				if($this->input->post('program_master_id') !="" ){
					//update the program master..
					$this->ProgramMasterModel->update_program_master();
					$this->session->set_flashdata('message','Successfully updated program!');
				}else{
					//Insert the program master ..
					$this->ProgramMasterModel->insert_program_master();					
					$this->session->set_flashdata('message','Successfully created program!');

				}
				redirect('Management/view_program_list');
			}
		}
		//get the program data from program id.
		if($program_id !=""){
			$data['program_data'] = $this->ProgramMasterModel->get_program_master($program_id);
		}
		$this->load->view('add_program', $data);
	}
	public function view_program_list(){
		$this->load->model('Management/ProgramMasterModel');
		$data['program_data_list'] = $this->ProgramMasterModel->get_program_master();
		$this->load->view('view_program_list', $data);
	}
	public function user_credentials(){
		$data['UsersData'] = $this->UserModel->get_user_list();
		$this->load->view('password_change', $data);
	}
	// function: active_deactive_user()
	// It is used to active, deactive or delete user 
	public function active_deactive_user(){
		$data=array();
		if(isset($_POST) && $_POST){
			$this->form_validation->set_rules('user', 'User', 'required', array('required' => 'Please Select User'));
			$this->form_validation->set_rules('active_deactive_date', 'Date', 'required', array('required' => 'Please Select Date'));
			$this->form_validation->set_rules('active_deactive_reason_type', 'Reason Type', 'required', array('required' => 'Enter Reason Type'));
			$this->form_validation->set_rules('active_deactive_reason', 'Reason', 'required', array('required' => 'Enter Reason'));
			$this->form_validation->set_rules('is_active', 'Active / Deactive', 'required', array('required' => 'Please Select Active/Deactive'));
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('errors', validation_errors());
			}else{
				$result=$this->UserModel->updateActiveDeactiveUser();
				if($result==1){
					$this->session->set_flashdata('success_message','User Status has been updated successfully.');
				}else{
					$this->session->set_flashdata('error_message','Sorry, User Status could not be updated. Please try again.');
				}
				redirect('Management/active_deactive_user');
			}
		}
		$data['users']=$this->UserModel->getUserList();
		$this->load->view('active_deactive_user',$data);
	}
	// function: active_deactive_center()
	// It is used to active, deactive center 
	public function active_deactive_center(){
		$data=array();
		$this->load->model('Management/CenterModel');
		if(isset($_POST) && $_POST){
			$this->form_validation->set_rules('center', 'Center', 'required', array('required' => 'Please Select Center'));
			$this->form_validation->set_rules('active_deactive_date', 'Date', 'required', array('required' => 'Please Select Date'));
			$this->form_validation->set_rules('active_deactive_reason_type', 'Reason Type', 'required', array('required' => 'Enter Reason Type'));
			$this->form_validation->set_rules('active_deactive_reason', 'Reason', 'required', array('required' => 'Enter Reason'));
			$this->form_validation->set_rules('is_active', 'Active / Deactive', 'required', array('required' => 'Please Select Active/Deactive'));
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('errors', validation_errors());
			}else{
				$result=$this->CenterModel->updateActiveDeactiveCenter();
				if($result==1){
					$this->session->set_flashdata('success_message','Center Status has been updated successfully.');
				}else{
					$this->session->set_flashdata('error_message','Sorry, Center Status could not be updated. Please try again.');
				}
				redirect('Management/active_deactive_center');
			}
		}
		$data['centers']=$this->CenterModel->getCenterList();
		$this->load->view('active_deactive_center',$data);
	}	
	public function add_center($center_id = ""){
		$data=array();
		$data['state_data'] = $this->StateModel->get_state();
		if($center_id !=""){
			$this->load->model('Management/CenterModel');
			$data['CenterData'] = $this->CenterModel->get_center_list($center_id);
		}
		$this->load->view('add_center', $data);
	}	
	/**
	 * Get the region based on selected state.
	 */
	public function get_region(){
		$state_id = $_POST['state_id'];
		$sel_region_id = $_POST['sel_region_id'];
		$this->load->model('Master/RegionModel');
		if($state_id !="") {
			$region_data = $this->RegionModel->get_region_from_state($state_id);
			$select_option = "<option value=''>--Select--</option>";
			if(count($region_data) >0) {
				 foreach($region_data as $region_value) {
					 $select = "";
					if($sel_region_id == $region_value->id ) {
						$select = 'selected';
					}
			 		$select_option .= "<option value='".$region_value->id."' ".$select."> ".$region_value->region_name." </option>";
				 }
			}
			 echo $select_option;
		}
	}
	public function view_centers_list()
	{
		$this->load->model('Management/CenterModel');
		//get the center list from database..
		$data['CenterList'] = $this->CenterModel->get_center_list();
		$this->load->view('view_centers_list', $data);
	}	
	// function: assign_center()
	// It is used to assign center to selected user
	public function assign_center($assigned_center_id=''){
		$data=array();
		$this->load->model('Management/CenterModel');
		if($assigned_center_id!='' && $assigned_center_id!=null){
			$assigned_center_id=base64_decode($assigned_center_id);
			$data['usercenter'] = $this->CenterModel->getUserCenterById($assigned_center_id);
		}
		$condition=" AND is_active=1 ";
		$data['users'] = $this->UserModel->getUserList($condition);
		$data['state_data'] = $this->StateModel->get_state();
		$data['usercenterlist'] = $this->CenterModel->getUserCenterList();
		$this->load->view('assign_center', $data);
	}
	// function: assign_rights()
	// It is used to assign/edit rights to user/role	
	public function assign_rights(){
		$data=array();
		$this->load->model('HomeModel');
		if(isset($_POST) && $_POST){
			$assign_rights_type=$this->input->post('assign_rights_type');
			$this->form_validation->set_rules('rights[]', 'Assign Rights', 'required', array('required' => 'Note: Please select atleast one rights from below table.'));
			if($assign_rights_type=='Role'){
				$this->form_validation->set_rules('role_id', 'Role', 'required', array('required' => 'Please Select Role'));
			}else{
				$this->form_validation->set_rules('user_id', 'User', 'required', array('required' => 'Please Select User'));
			}
			if($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('errors', validation_errors());
			}else{
				$result=$this->HomeModel->assignRights();
				if($result==1){
					$this->session->set_flashdata('success_message','Rights have been assigned successfully.');
				}else{
					$this->session->set_flashdata('error_message','Sorry, Rights could not be assigned. Try again.');
				}
			}
		}
		$condition=" AND is_active=1 ";
		$data['users'] = $this->UserModel->getUserList($condition);
		$data['roles'] = $this->RoleModel->getRoleList();
		$data['assign_rights_list'] = $this->HomeModel->getAssignRightsList();
		$this->load->view('assign_rights', $data);
	}
	// function: ajax_get_assign_rights_by_user()
	// It is used to fetch assign rigths by user using ajax
	public function ajax_get_assign_rights_by_user(){
		$message_arr=array();
		$this->load->model('HomeModel');
		$assign_rights_list=$this->HomeModel->getAssignRightsList();
		$rights_arr=array();
		if(isset($_POST['user_id']) && $_POST['user_id']){
			$user_id=$this->input->post('user_id');
			$rights_arr=$this->HomeModel->getAssignRightsByUser($user_id);
		}
		$message_arr['assign_rights_html']=getAssignRightsHtml($assign_rights_list,$rights_arr);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}	
	// function: ajax_get_assign_rights_by_role()
	// It is used to fetch assign rigths by role using ajax
	public function ajax_get_assign_rights_by_role(){
		$message_arr=array();
		$this->load->model('HomeModel');
		$assign_rights_list=$this->HomeModel->getAssignRightsList();
		$rights_arr=array();
		if(isset($_POST['role_id']) && $_POST['role_id']){
			$role_id=$this->input->post('role_id');
			$rights_arr=$this->HomeModel->getAssignRightsByRole($role_id);
		}
		$message_arr['assign_rights_html']=getAssignRightsHtml($assign_rights_list,$rights_arr);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}	
	public function oasis_calender(){
		$this->load->view('oasis_calender');
	}
	// *************** Start Program Session Module Code*********************
	// function: view_session_list()
	// It is used to display active program session list
	public function view_session_list(){
		//Load the program master model
		$this->load->model('Management/ProgramMasterModel');
		$data['program_session_list'] = $this->ProgramMasterModel->getProgramSession();
		$this->load->view('view_session_list', $data);
	}
	// function: program_session()
	// It is used to add/edit program session
	public function program_session($session_id=''){
		//Load the program master model
		$this->load->model('Management/ProgramMasterModel');
		$data['program_list'] = $this->ProgramMasterModel->getActiveProgramList();
		if(isset($_POST) && $_POST){
			$this->form_validation->set_rules('program_id', 'Program', 'required', array('required' => 'Please Select Program'));
			$this->form_validation->set_rules('session_name', 'Session Name', 'required', array('required' => 'Enter Session Name'));
			$this->form_validation->set_rules('status', 'Status', 'required', array('required' => 'Please Please Select Status'));
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('errors', validation_errors());
			}else{
				if(isset($_POST['session_id']) && $_POST['session_id']){
					//Update program session
					$result=$this->ProgramMasterModel->updateProgramSession();
					if($result==1){
						$this->session->set_flashdata('message','Session has been updated successfully.');
					}else{
						$this->session->set_flashdata('message','Sorry, Session could not be updated. Try again.');
					}
				}else{
					//Insert program session
					$result=$this->ProgramMasterModel->insertProgramSession();	
					if($result==1){				
						$this->session->set_flashdata('message','Session has been added successfully.');
					}else{
						$this->session->set_flashdata('message','Sorry, Session could not be added. Try again.');
					}

				}
				redirect('management/view_session_list');
			}
		}
		//get the program data from program id.
		if($session_id=='' && isset($_POST['session_id']) && $_POST['session_id']){
			$session_id=$this->input->post('session_id');
		}
		if($session_id){
			$data['sessiondetails'] = $this->ProgramMasterModel->getSessionById($session_id);
		}
		$this->load->view('program_session', $data);
	}
	// function: delete_program_session()
	// It is used to delete program session
	public function delete_program_session($session_id){
		//Load the program master model
		$this->load->model('Management/ProgramMasterModel');
		if($session_id){
			$result=$this->ProgramMasterModel->deleteProgramSession($session_id);
			if($result==1){
				$this->session->set_flashdata('message','Session has been deleted successfully.');
			}else{
				$this->session->set_flashdata('message','Sorry, Session could not be deleted. Try again.');
			}
		}else{
			$this->session->set_flashdata('message','Sorry, Session could not be deleted. Try again.');
		}
		redirect('management/view_session_list');
	}
	// function: ajax_get_sessionlist_by_program()
	// It is used to fetch session list by program name using ajax
	public function ajax_get_sessionlist_by_program(){
		$message_arr=array();
		//Load the program master model
		$this->load->model('Management/ProgramMasterModel');
		if(isset($_POST['program_name']) && $_POST['program_name']){
			$program_name=$this->input->post('program_name');
			$sessions=$this->ProgramMasterModel->getSessionByProgram($program_name);
		}else{
			$sessions=$this->ProgramMasterModel->getActiveSessionList();
		}
		$sessionlist='<option value="">--Select--</option>';
		if($sessions){
			$session_id='';
			if(isset($_POST['session_id']) && $_POST['session_id']){
				$session_id=$this->input->post('session_id');
			}
			foreach($sessions as $session){
				$selected='';
				if($session_id==$session->id){
					$selected="selected";
				}
				$sessionlist.='<option value="'.$session->id.'" '.$selected.'>'.ucfirst($session->session_name).'</option>';
			}
		}
		$message_arr['sessionlist']=$sessionlist;
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// *************** End Program Session Module Code*********************
}
