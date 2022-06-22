<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class UserType extends CI_Controller {
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
		$this->load->model('Master/UserTypeModel');
    }
	/**
	 * Create user type from this method.
	 */
	public function createUserType(){
		$this->form_validation->set_rules('user_type', 'User Type', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
			//Get the current data and load it in list view.
			$data['data'] = $this->UserTypeModel->get_userType();
            $this->load->view('user_type_master', $data);
        }else{
			if($this->input->post('user_type_id') !="" ){
				//update the user type..
        		$this->UserTypeModel->update_user_type();
			}else{
				//Insert the user type..
        		$this->UserTypeModel->insert_user_type();
			}
			redirect('master/user_type_master');
		}
	}
	public function editUserType($user_type_id){
		//Get the current data and load it in list view.
		$data['edit_data'] = $this->UserTypeModel->get_userType($user_type_id);
		$data['data'] = $this->UserTypeModel->get_userType();
		if(!empty($data)) {
			$this->load->view('user_type_master', $data);
		}
	}
}
