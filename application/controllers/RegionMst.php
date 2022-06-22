<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class RegionMst extends CI_Controller {
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
		$this->load->model('Master/RegionModel');
		$this->load->model('Master/StateModel');
    }
	/**
	 * Create from this method.
	 */
	public function createRegion(){
		$this->form_validation->set_rules('region_name', 'Region name', 'required');
		$this->form_validation->set_rules('state_id', 'State name', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
			//Get the current data and load it in list view.
			$data['data'] = $this->RegionModel->get_region();
			$data['state_data'] = $this->StateModel->get_state();
            $this->load->view('region_master', $data);
        }else{
			if($this->input->post('region_id') !="" ){
				//update the region..
        		$this->RegionModel->update_region();
			}else{
				//Insert the region..
        		$this->RegionModel->insert_region();
			}
			redirect('master/region_master');
		}
	}
	public function editRegion($region_id){
		//Get the current data and load it in list view.
		$data['edit_data'] = $this->RegionModel->get_region($region_id);
		$data['data'] = $this->RegionModel->get_region();
		$data['state_data'] = $this->StateModel->get_state();
		if(!empty($data)) {
			$this->load->view('region_master', $data);
		}
	}
	// function: ajax_get_region_by_state()
	// It is used to fetch region list by state id using ajax
	public function ajax_get_region_by_state(){
		$message_arr=array();
		$state_id='';
		if(isset($_POST['state_id']) && $_POST['state_id']){
			$state_id=$this->input->post('state_id');
		}
		$regions=$this->RegionModel->getRegionByStateId($state_id);
		$regionlist='<option value="">--Select--</option>';
		if($regions){
			foreach ($regions as $region){
				$regionlist.='<option value="'.$region->id.'">'.ucfirst($region->region_name).'</option>';
			}
		}
		$message_arr['regionlist']=$regionlist;
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
}
