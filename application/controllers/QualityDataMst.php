<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class QualityDataMst extends CI_Controller {
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
		$this->load->model('Master/QualityObservedModel');
    }
	/**
	 * Create createQualityData 
	 */
	public function createQualityData(){
		$this->form_validation->set_rules('quality_name', 'Group Type', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
			//Get the current data and load it in list view.
			$data['data'] = $this->QualityObservedModel->get_quality_data();
            $this->load->view('quality_observed_master', $data);
        }else{
			if($this->input->post('quality_data_id') !="" ){
				//update..
        		$this->QualityObservedModel->update_quality_data();
			}else{
				//Insert..
        		$this->QualityObservedModel->insert_quality_data();
			}
			redirect('master/quality_observed_master');
		}
	}
	public function editQualityData($quality_data_id){
		//Get the current data and load it in list view.
		$data['edit_data'] = $this->QualityObservedModel->get_quality_data($quality_data_id);
		$data['data'] = $this->QualityObservedModel->get_quality_data();
		if(!empty($data)) {
			$this->load->view('quality_observed_master', $data);
		}
	}
}
