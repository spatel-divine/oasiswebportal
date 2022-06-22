<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'controllers/JwtToken.php';
class Yearlygoals extends REST_Controller {
    public function __construct(){
       parent::__construct();
       $this->load->model('api/v1/YearlygoalsModel');
    }
    // function: fetch_yearly_goals_list_get()
    // It is used to get yearly goals list from db
    public function fetch_yearly_goals_list_get(){
    	if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $yearlygoals = $this->YearlygoalsModel->getYearlyGoalsList();
            $yearlygoalslist=array();
            if($yearlygoals){
            	$i=0;
            	foreach($yearlygoals as $r){
            		$yearlygoalslist[$i]['program_id']=$r->program_id;
            		$yearlygoalslist[$i]['program_name']=$r->program_name;
            		$yearlygoalslist[$i]['is_checked']=$r->is_checked;
            		$yearlygoalslist[$i]['keyvalue']=array($r->program_id=>$r->ygid);
            		$i++;
            	}
            }
            $data["yearlygoalslist"] = $yearlygoalslist;
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: add_yearly_goals_program_post()
    // It is used to add yearly goals program by center id from login user id
    public function add_yearly_goals_program_post(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
			$this->form_validation->set_rules('program_ids[]', 'Program', 'required', array('required' => 'Please Select Program'));
	        if($this->form_validation->run() == FALSE){
	            $data = $this->form_validation->error_array();
	            $this->response([
	                'status' => False,
	                'message' => $data,
	            ], REST_Controller::HTTP_OK);
	        }else{
	        	$centerid=$this->YearlygoalsModel->checkForCenterId();
	        	if($centerid){
	        		$result=$this->YearlygoalsModel->addYearlyGoals($centerid);
		            if($result==1){
		                $data["success_message"] = "Program yearly goals added successfully.";
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
	        	}else{
	        		$data["error_message"] = "Because of not any 'Center' has been assigned to you, you can not add yearly goals.";
	                $this->response([
	                    'status' => False,
	                    'message' => $data,
	                ], REST_Controller::HTTP_OK);          
	        	}
	        }
        }
    }
    // function: fetch_data_for_yearly_goals_program_form_list_get()
    // It is used to get data for yearly goals program form list from db
    public function fetch_data_for_yearly_goals_program_form_list_get(){
    	if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $data["yearlygoalsformdatalist"] = $this->YearlygoalsModel->getYearlyGoalsFormDataList();
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: save_yearly_goals_program_details_post()
    // It is used to add yearly goals program by center id from login user id
    public function save_yearly_goals_program_details_post(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
			$this->form_validation->set_rules('no_of_programs', 'No Of Programs', 'required', array('required' => 'Enter No Of Programs'));
			$this->form_validation->set_rules('no_of_beneficiaries', 'No Of Beneficiaries', 'required', array('required' => 'Enter No Of Beneficiaries'));
			$this->form_validation->set_rules('no_of_facilitator_trainees', 'No Of Facilitator Trainees', 'required', array('required' => 'Enter No Of Facilitator Trainees'));
			$this->form_validation->set_rules('no_of_facilitators', 'No Of Facilitators', 'required', array('required' => 'Enter No Of Facilitators'));
			$this->form_validation->set_rules('no_of_volunteers', 'No Of Volunteers', 'required', array('required' => 'Enter No Of Volunteers'));
	        if($this->form_validation->run() == FALSE){
	            $data = $this->form_validation->error_array();
	            $this->response([
	                'status' => False,
	                'message' => $data,
	            ], REST_Controller::HTTP_OK);
	        }else{
	        	$result=$this->YearlygoalsModel->saveYearlyGoalsDetails();
	            if($result==1){
	                $data["success_message"] = "Program yearly goals saved successfully.";
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
}