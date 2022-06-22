<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AssignCenterMst extends CI_Controller {
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
		$this->load->model('Management/CenterModel');
    }
	/**
	 * Create assign center this method.
	 */
	public function createAssignCenter(){
		$post = $this->input->post(); 
		$this->form_validation->set_rules('user_id', 'User Name', 'required',array('required'=>'Please Select User'));
		$this->form_validation->set_rules('state_id', 'State', 'required',array('required'=>'Please Select State'));
		$this->form_validation->set_rules('region_id', 'Region', 'required',array('required'=>'Please Select Region'));
		$this->form_validation->set_rules('center_id', 'Center', 'required',array('required'=>'Please Select Center'));
		$this->form_validation->set_rules('is_active', 'Status', 'required',array('required'=>'Please Select Status'));
        if ($this->form_validation->run() == FALSE){
        	$data=array();
            $this->session->set_flashdata('errors', validation_errors());
			$this->load->model('Master/StateModel');
			$this->load->model('Management/UserModel');
			//Get the current data and load it in list view.
			$assigned_center_id='';
			if(isset($_POST['user_center_id']) && $_POST['user_center_id']){
				$assigned_center_id=$this->input->post('user_center_id');
				$data['user_center_id']=base64_decode($this->input->post('user_center_id'));
			}
			if($assigned_center_id!='' && $assigned_center_id!=null){
				$assigned_center_id=base64_decode($assigned_center_id);
				$data['usercenter'] = $this->CenterModel->getUserCenterById($assigned_center_id);
			}
			$condition=" AND is_active=1 ";
			$data['users'] = $this->UserModel->getUserList($condition);
			$data['state_data'] = $this->StateModel->get_state();
			$data['usercenterlist'] = $this->CenterModel->getUserCenterList();
			$this->load->view('assign_center', $data);
        }else{
        	if(isset($_POST['user_center_id']) && $_POST['user_center_id']){
        		$result=$this->CenterModel->updateAssignCenter();
				if($result==1){
					$this->session->set_flashdata('success_message','Assigned Center has been updated successfully.');
				}else{
					$this->session->set_flashdata('error_message','Sorry, Assigned Center could not be updated. Please try again.');
				}
        	}else{
        		$result=$this->CenterModel->createAssignCenter();
				if($result==1){
					$this->session->set_flashdata('success_message','Center has been assigned successfully.');
				}else{
					$this->session->set_flashdata('error_message','Sorry, Center could not be assigned. Please try again.');
				}
        	}
			redirect('management/assign_center');
		}
	}
	// function: delete_user_center()
	// It is used to delete user center
	public function delete_user_center($user_center_id){
		if($user_center_id){
			$user_center_id=base64_decode($user_center_id);
			$result=$this->CenterModel->deleteAssignUserCenter($user_center_id);
			if($result==1){
				$this->session->set_flashdata('success_message','Assigned user center has been deleted successfully.');
			}else{
				$this->session->set_flashdata('error_message','Sorry, Assigned user center could not be deleted. Try again.');
			}
		}else{
			$this->session->set_flashdata('error_message','Sorry, Assigned user center could not be deleted. Try again.');
		}
		redirect('management/assign_center');
	}
}
