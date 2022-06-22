<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CenterMst extends CI_Controller {
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
	 * Create center this method.
	 */
	public function createCenter(){
		$post = $this->input->post(); 
		$this->form_validation->set_rules('center_name', 'Center Name', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('city_id', 'City', 'required');
		$this->form_validation->set_rules('state_id', 'State', 'required');
		$this->form_validation->set_rules('center_contact_no', 'Contact No', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
			$this->load->model('Master/CityModel');
			$this->load->model('Master/RegionModel');
			$this->load->model('Master/StateModel');
			$action = $this->input->post('action');
			//Get the current data and load it in list view.
			$data['city_data'] = $this->CityModel->get_city();
			$data['region_data'] = $this->RegionModel->get_region();
			$data['state_data'] = $this->StateModel->get_state();
			if($action  == 'add') {
				$this->load->view('add_center', $data);
			}else{
				$data['CenterData'] = $this->CenterModel->get_center_list($this->input->post('center_id'));
				$this->load->view('add_center', $data);
			}
        }else{
			if($this->input->post('center_id') !="" ){
				//update..
        		$this->CenterModel->update_center_master();
				$this->session->set_flashdata('message','Center has been updated successfully.');
			}else{
				//Insert...
        		$this->CenterModel->insert_center_master();
				$this->session->set_flashdata('message','Center has been created successfully.');
			}
			redirect('Management/view_centers_list');
			
		}

	}
	// function: ajax_get_center_by_region()
	// It is used to fetch center list by region id using ajax
	public function ajax_get_center_by_region(){
		$message_arr=array();
		if(isset($_POST['region_id']) && $_POST['region_id']){
			$region_id=$this->input->post('region_id');
			$centers=$this->CenterModel->getCenterByRegionId($region_id);
			$centerlist='<option value="">--Select--</option>';
			if($centers){
				$center_id='';
				if(isset($_POST['center_id']) && $_POST['center_id']){
					$center_id=$this->input->post('center_id');
				}
				foreach ($centers as $center){
					$selected='';
					if($center_id==$center->id){
						$selected="selected";
					}
					$centerlist.='<option value="'.$center->id.'" '.$selected.'>'.ucfirst($center->center_name).'</option>';
				}
			}
			$message_arr['centerlist']=$centerlist;
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// function: ajax_get_center_by_id()
	// It is used to fetch center list by id using ajax
	public function ajax_get_center_by_id(){
		$message_arr=array();
		if(isset($_POST['center_id']) && $_POST['center_id']){
			$center_id=$this->input->post('center_id');
			$center=$this->CenterModel->getCenterById($center_id);
			if(isset($center->is_active)){
				$message_arr['is_active']=$center->is_active;
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// function: ajax_get_center_by_state_or_region()
	// It is used to fetch center list by region or state id using ajax
	public function ajax_get_center_by_state_or_region(){
		$message_arr=array();
		if(isset($_POST['region_id']) && $_POST['region_id']){
			$region_id=$this->input->post('region_id');
			$centers=$this->CenterModel->getCenterByRegionId($region_id);
		}else if(isset($_POST['state_id']) && $_POST['state_id']){
			$state_id=$this->input->post('state_id');
			$centers=$this->CenterModel->getCenterByStateId($state_id);
		}else{
			$centers=$this->CenterModel->getCenterByRegionId();
		}
		$centerlist='<option value="">--Select--</option>';
		if($centers){
			$center_id='';
			if(isset($_POST['center_id']) && $_POST['center_id']){
				$center_id=$this->input->post('center_id');
			}
			foreach ($centers as $center){
				$selected='';
				if($center_id==$center->id){
					$selected="selected";
				}
				$centerlist.='<option value="'.$center->id.'" '.$selected.'>'.ucfirst($center->center_name).'</option>';
			}
		}
		$message_arr['centerlist']=$centerlist;
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
}
