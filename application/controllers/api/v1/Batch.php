<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'controllers/JwtToken.php';
class Batch extends REST_Controller {
    public function __construct() {
       parent::__construct();
       $this->load->model('api/v1/BatchModel');
       $this->load->library("pagination");
    }
    // function: batch_list_get()
    // It is used to get batch list
    public function batch_list_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $config = array();
            $config["base_url"] = base_url() . "api/v1/batch/batch_list";
            $config["total_rows"] = $this->BatchModel->getTotalBatch();
            $config["per_page"] = LIST_LIMIT;
            $total_no_of_pages=0;
            if($config["total_rows"]>0){
                $total_no_of_pages=ceil($config["total_rows"]/LIST_LIMIT);
            }
            $config["total_no_of_pages"] = $total_no_of_pages;
            $config["uri_segment"] = 5;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(5))? $this->uri->segment(5) : 0;
            $config["batchlist"] = $this->BatchModel->getBatchList($config["per_page"], $page);
            $this->response([
                'status' => True,
                'message' => $config,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: add_batch_form_get()
    // It is used to get add batch form data
    public function add_batch_form_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
			$this->load->model('Management/UserModel');
			$data['statelist']=getActiveStateList();
			$data['programlist']=getActiveProgramList();
			$data['grouptypelist']=getGroupTypeList();
			$data['facilitatorlist']=$this->UserModel->getFacilitatorList();
			$data['cofacilitatorlist']=$this->UserModel->getCoFacilitatorList();
			$data['coordinatorlist']=$this->UserModel->getCoordinatorList();
			$data['volunteerlist']=$this->UserModel->getVolunteerList();
			$data['participantlist']=$this->UserModel->getParticipantList();
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: region_by_state_get()
    // It is used to get region list by state id
    public function region_by_state_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $state_id='';
			if(isset($_GET['state_id']) && $_GET['state_id']){
				$state_id=$this->input->get('state_id');
			}
			$this->load->model('Master/RegionModel');
			$data['regionlist']=$this->RegionModel->getRegionListByStateId($state_id);
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: center_by_region_get()
    // It is used to get center list by region id
    public function center_by_region_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $region_id='';
			if(isset($_GET['region_id']) && $_GET['region_id']){
				$region_id=$this->input->get('region_id');
			}
			$this->load->model('Management/CenterModel');
			$data['centerlist']=$this->CenterModel->getCenterListByRegionId($region_id);
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: add_batch_post()
    // It is used to save batch
    public function add_batch_post(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
	        $this->form_validation->set_data($this->post());
	       	$this->form_validation->set_rules('state_id', 'State', 'required', array('required' => 'Please Select State'));
			$this->form_validation->set_rules('region_id', 'Region', 'required', array('required' => 'Please Select Region'));
			$this->form_validation->set_rules('center_id', 'Center', 'required', array('required' => 'Please Select Center'));
			$this->form_validation->set_rules('program_id', 'Program', 'required', array('required' => 'Please Select Program'));
			$this->form_validation->set_rules('batch_name', 'Batch Name', 'required', array('required' => 'Enter Batch Name'));
			$this->form_validation->set_rules('start_date', 'Start Date', 'required', array('required' => 'Please Select Start Date'));
			if(isset($_POST['start_date']) && $_POST['start_date']){
				$start_date=$this->input->post('start_date');
				$this->form_validation->set_rules('end_date', 'End Date', 'required|callback_check_valid_end_date['.$start_date.']', array('required' => 'Please Select End Date'));
			}else{
				$this->form_validation->set_rules('end_date', 'End Date', 'required', array('required' => 'Please Select End Date'));
			}
			$this->form_validation->set_rules('location', 'Location', 'required', array('required' => 'Enter Batch Location'));
			$this->form_validation->set_rules('no_of_participant_registered', 'No. of Participant Registered', 'required', array('required' => 'Enter No. of Participant Registered'));
			$this->form_validation->set_rules('group_id', 'Group', 'required', array('required' => 'Please Select Group'));
			$this->form_validation->set_rules('group_name', 'Group Name', 'required', array('required' => 'Enter Group Name'));
			$this->form_validation->set_rules('facilitator[]', 'Facilitator', 'required', array('required' => 'Please Select Facilitator'));
			$this->form_validation->set_rules('co_facilitator[]', 'Co-Facilitator', 'required', array('required' => 'Please Select Co-Facilitator'));
			$this->form_validation->set_rules('coordinator[]', 'Co-Ordinator', 'required', array('required' => 'Please Select Co-Ordinator'));
			$this->form_validation->set_rules('volunteer[]', 'Volunteer', 'required', array('required' => 'Please Select Volunteer'));
			$this->form_validation->set_rules('participant[]', 'Participant', 'required', array('required' => 'Please Select Participant'));
	        if($this->form_validation->run() == FALSE){
	            $data = $this->form_validation->error_array();
	            $this->response([
	                'status' => False,
	                'message' => $data,
	            ], REST_Controller::HTTP_OK);
	        }else{
	            $result=$this->BatchModel->addBatch();
	            if($result==1){
	                $data["success_message"] = "Batch added successfully";
	                $this->response([
	                    'status' => True,
	                    'message' => $data,
	                ], REST_Controller::HTTP_OK);
	            }else{
	                $data["error_message"] = "Something Went Wrong. Please Try Again.";
	                $this->response([
	                    'status' => False,
	                    'message' => $data,
	                ], REST_Controller::HTTP_OK);
	            }
	        }
        }
    }
    // function: check_valid_end_date($end_date)
    // It is used to check end date greater than start date
    public function check_valid_end_date($end_date,$start_date){
        if($end_date){
            $result=$this->BatchModel->checkValidEndDate($end_date,$start_date);
            if(!$result){
               $this->form_validation->set_message('check_valid_end_date', 'End Date must be greater than Start Date.');
                return FALSE; 
            }
        }
        return TRUE;
    }
    // function: edit_batch_form_get()
    // It is used to get edit batch form data
    public function edit_batch_form_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $this->load->model('Management/UserModel');
            $data['batch_id']='';
            $batchdetails='';
        	$batchfacilitator = array();
        	$batchcofacilitator = array();
        	$batchcoordinator = array();
        	$batchvolunteer = array();
        	$batchparticipant = array();
           	if(isset($_GET['batch_id']) && $_GET['batch_id']){
           		$data['batch_id']=$this->input->get('batch_id');
           		$batch_id=base64_decode($this->input->get('batch_id'));
            	$batchdetails=$this->BatchModel->getBatchById($batch_id);
            	$batchfacilitator = $this->BatchModel->getBatchFacilitatorByBatchId($batch_id);
            	$batchcofacilitator = $this->BatchModel->getBatchCoFacilitatorByBatchId($batch_id);
            	$batchcoordinator = $this->BatchModel->getBatchCoordinatorByBatchId($batch_id);
            	$batchvolunteer = $this->BatchModel->getBatchVolunteerByBatchId($batch_id);
            	$batchparticipant = $this->BatchModel->getBatchParticipantByBatchId($batch_id);
            }
            $data['batchdetails']=$batchdetails;
            $data['batchfacilitator'] = $batchfacilitator;
        	$data['batchcofacilitator'] = $batchcofacilitator;
        	$data['batchcoordinator'] = $batchcoordinator;
        	$data['batchvolunteer'] = $batchvolunteer;
        	$data['batchparticipant'] = $batchparticipant;
			$data['statelist']=getActiveStateList();
			$data['programlist']=getActiveProgramList();
			$data['grouptypelist']=getGroupTypeList();
			$data['facilitatorlist']=$this->UserModel->getFacilitatorList();
			$data['cofacilitatorlist']=$this->UserModel->getCoFacilitatorList();
			$data['coordinatorlist']=$this->UserModel->getCoordinatorList();
			$data['volunteerlist']=$this->UserModel->getVolunteerList();
			$data['participantlist']=$this->UserModel->getParticipantList();
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: edit_batch_post()
    // It is used to edit batch
    public function edit_batch_post(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
	        $this->form_validation->set_data($this->post());
	       	$this->form_validation->set_rules('state_id', 'State', 'required', array('required' => 'Please Select State'));
			$this->form_validation->set_rules('region_id', 'Region', 'required', array('required' => 'Please Select Region'));
			$this->form_validation->set_rules('center_id', 'Center', 'required', array('required' => 'Please Select Center'));
			$this->form_validation->set_rules('program_id', 'Program', 'required', array('required' => 'Please Select Program'));
			$this->form_validation->set_rules('batch_name', 'Batch Name', 'required', array('required' => 'Enter Batch Name'));
			$this->form_validation->set_rules('start_date', 'Start Date', 'required', array('required' => 'Please Select Start Date'));
			if(isset($_POST['start_date']) && $_POST['start_date']){
				$start_date=$this->input->post('start_date');
				$this->form_validation->set_rules('end_date', 'End Date', 'required|callback_check_valid_end_date['.$start_date.']', array('required' => 'Please Select End Date'));
			}else{
				$this->form_validation->set_rules('end_date', 'End Date', 'required', array('required' => 'Please Select End Date'));
			}
			$this->form_validation->set_rules('location', 'Location', 'required', array('required' => 'Enter Batch Location'));
			$this->form_validation->set_rules('no_of_participant_registered', 'No. of Participant Registered', 'required', array('required' => 'Enter No. of Participant Registered'));
			$this->form_validation->set_rules('group_id', 'Group', 'required', array('required' => 'Please Select Group'));
			$this->form_validation->set_rules('group_name', 'Group Name', 'required', array('required' => 'Enter Group Name'));
			$this->form_validation->set_rules('facilitator[]', 'Facilitator', 'required', array('required' => 'Please Select Facilitator'));
			$this->form_validation->set_rules('co_facilitator[]', 'Co-Facilitator', 'required', array('required' => 'Please Select Co-Facilitator'));
			$this->form_validation->set_rules('coordinator[]', 'Co-Ordinator', 'required', array('required' => 'Please Select Co-Ordinator'));
			$this->form_validation->set_rules('volunteer[]', 'Volunteer', 'required', array('required' => 'Please Select Volunteer'));
			$this->form_validation->set_rules('participant[]', 'Participant', 'required', array('required' => 'Please Select Participant'));
	        if($this->form_validation->run() == FALSE){
	            $data = $this->form_validation->error_array();
	            $this->response([
	                'status' => False,
	                'message' => $data,
	            ], REST_Controller::HTTP_OK);
	        }else{
	            $result=$this->BatchModel->updateBatch();
	            if($result==1){
	                $data["success_message"] = "Batch updated successfully";
	                $this->response([
	                    'status' => True,
	                    'message' => $data,
	                ], REST_Controller::HTTP_OK);
	            }else{
	                $data["error_message"] = "Something Went Wrong. Please Try Again.";
	                $this->response([
	                    'status' => False,
	                    'message' => $data,
	                ], REST_Controller::HTTP_OK);
	            }
	        }
        }
    }
    // function: delete_batch_get()
    // It is used to delete share stories
    public function delete_batch_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $result=0;
            if(isset($_GET['batch_id']) && $_GET['batch_id']){
                $batch_id=base64_decode($this->input->get('batch_id'));
                $result=$this->BatchModel->deleteBatch($batch_id);
            }
            if($result==1){
                $data["success_message"] = "Batch deleted successfully";
                $this->response([
                    'status' => True,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }else{
                $data["error_message"] = "Something Went Wrong. Please Try Again.";
                $this->response([
                    'status' => False,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }
        }
    }
}