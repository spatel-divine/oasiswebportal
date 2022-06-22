<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class GroupTypeMst extends CI_Controller {
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
		$this->load->model('Master/GroupTypeModel');
    }
	/**
	 * Create user type from this method.
	 */
	public function createGroupType(){
		$this->form_validation->set_rules('group_type_name', 'Group Type', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
			//Get the current data and load it in list view.
			$data['data'] = $this->GroupTypeModel->get_group_type();
            $this->load->view('group_type_master', $data);
        }else{
			if($this->input->post('group_type_id') !="" ){
				//update..
        		$this->GroupTypeModel->update_group_type();
			}else{
				//Insert..
        		$this->GroupTypeModel->insert_group_type();
			}
			redirect('master/group_type_master');
		}
	}
	public function editGroupType($group_type_id){
		//Get the current data and load it in list view.
		$data['edit_data'] = $this->GroupTypeModel->get_group_type($group_type_id);
		$data['data'] = $this->GroupTypeModel->get_group_type();
		if(!empty($data)) {
			$this->load->view('group_type_master', $data);
		}
	}
}
