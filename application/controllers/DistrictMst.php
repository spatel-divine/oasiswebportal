<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class DistrictMst extends CI_Controller {
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
		$this->load->model('Master/DistrictModel');
		$this->load->model('Master/StateModel');
    }
	/**
	 * Create from this method.
	 */
	public function createDistrict(){
		$this->form_validation->set_rules('district_name', 'District name', 'required');
		$this->form_validation->set_rules('state_id', 'State name', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
			//Get the current data and load it in list view.
			$data['data'] = $this->DistrictModel->get_district();
			$data['state_data'] = $this->StateModel->get_state();
            $this->load->view('district_master', $data);
        }else{
			if($this->input->post('district_id') !="" ){
				//update the district..
        		$this->DistrictModel->update_district();
			}else{
				//Insert the district..
        		$this->DistrictModel->insert_district();
			}
			redirect('master/district_master');
		}
	}
	public function editDistrict($district_id){
		//Get the current data and load it in list view.
		$data['edit_data'] = $this->DistrictModel->get_district($district_id);
		$data['data'] = $this->DistrictModel->get_district();
		$data['state_data'] = $this->StateModel->get_state();
		if(!empty($data)) {
			$this->load->view('district_master', $data);
		}
	}
	// function: ajax_get_district_by_state()
	// It is used to fetch district list by state id using ajax
	public function ajax_get_district_by_state(){
		$message_arr=array();
		if(isset($_POST['state_id']) && $_POST['state_id']){
			$state_id=$this->input->post('state_id');
			$districts=$this->DistrictModel->getDistrictByStateId($state_id);
			$districtlist='<option value="">--Select--</option>';
			if($districts){
				foreach ($districts as $district){
					$districtlist.='<option value="'.$district->id.'">'.ucfirst($district->district_name).'</option>';
				}
			}
			$message_arr['districtlist']=$districtlist;
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
}
