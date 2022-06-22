<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ProgramTypesMst extends CI_Controller {
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
		$this->load->model('Master/ProgramTypeModel');
    }
	/**
	 * Create create program type
	 */
	public function createProgramType(){
		$this->form_validation->set_rules('program_type_name', 'Program Type Name', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
			//Get the current data and load it in list view.
			$data['data'] = $this->ProgramTypeModel->get_program_type();
            $this->load->view('program_type_master', $data);
        }else{
			if($this->input->post('program_type_id') !="" ){
				//update..
        		$this->ProgramTypeModel->update_program_type();
			}else{
				//Insert..
        		$this->ProgramTypeModel->insert_program_type();
			}
			redirect('master/program_type_master');
		}
	}
	/**
	 * Edit Program Related
	 */
	public function editProgramType($program_type_id){
		//Get the current data and load it in list view.
		$data['edit_data'] = $this->ProgramTypeModel->get_program_type($program_type_id);
		$data['data'] = $this->ProgramTypeModel->get_program_type();
		if(!empty($data)) {
			$this->load->view('program_type_master', $data);
		}
	}
}
