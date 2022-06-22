<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ProgramRelatedMst extends CI_Controller {
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
		$this->load->model('Master/ProgramRelatedModel');
    }
	/**
	 * Create create program related
	 */
	public function createProgramRelated(){
		$this->form_validation->set_rules('program_related_to_name', 'Program Related Name', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
			//Get the current data and load it in list view.
			$data['data'] = $this->ProgramRelatedModel->get_program_related();
            $this->load->view('program_related_to_master', $data);
        }else{
			if($this->input->post('program_related_id') !="" ){
				//update..
        		$this->ProgramRelatedModel->update_program_related();
			}else{
				//Insert..
        		$this->ProgramRelatedModel->insert_program_related();
			}
			redirect('master/program_related_to_master');
		}
	}
	/**
	 * Edit Program Related
	 */
	public function editProgramRelated($program_related_id){
		//Get the current data and load it in list view.
		$data['edit_data'] = $this->ProgramRelatedModel->get_program_related($program_related_id);
		$data['data'] = $this->ProgramRelatedModel->get_program_related();
		if(!empty($data)) {
			$this->load->view('program_related_to_master', $data);
		}
	}
}
