<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class RoleMst extends CI_Controller {
	//public $roleModelObj;
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
		$this->load->model('Master/RoleModel');
    }
	/**
	 * Create user type from this method.
	 */
	public function createRole(){
		$this->form_validation->set_rules('role_name', 'Role name', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
			//Get the current data and load it in list view.
			$data['data'] = $this->RoleModel->get_role();
            $this->load->view('role_master', $data);
        }else{
			if($this->input->post('role_id') !="" ){
				//update the user type..
        		$this->RoleModel->update_role();
			}else{
				//Insert the user type..
        		$this->RoleModel->insert_role();
			}
			redirect('master/role_master');
		}
	}
	public function editRole($role_id){
		//Get the current data and load it in list view.
		$data['edit_data'] = $this->RoleModel->get_role($role_id);
		$data['data'] = $this->RoleModel->get_role();
		if(!empty($data)) {
			$this->load->view('role_master', $data);
		}
	}
}
