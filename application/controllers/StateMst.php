<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class StateMst extends CI_Controller {
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
		$this->load->model('Master/StateModel');
    }
	/**
	 * Create user type from this method.
	 */
	public function createState(){
		$this->form_validation->set_rules('state_name', 'State name', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
			//Get the current data and load it in list view.
			$data['data'] = $this->StateModel->get_state();
            $this->load->view('state_master', $data);
        }else{
			if($this->input->post('state_id') !="" ){
				//update the user type..
        		$this->StateModel->update_state();
			}else{
				//Insert the user type..
        		$this->StateModel->insert_state();
			}
			redirect('master/state_master');
		}
	}
	public function editState($state_id){
		//Get the current data and load it in list view.
		$data['edit_data'] = $this->StateModel->get_state($state_id);
		$data['data'] = $this->StateModel->get_state();
		if(!empty($data)) {
			$this->load->view('state_master', $data);
		}
	}
}
