<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CityMst extends CI_Controller {
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
		$this->load->model('Master/CityModel');
    }
	/**
	 * Create from this method.
	 */
	public function createCity(){
		$this->form_validation->set_rules('district_id', 'District name', 'required');
		$this->form_validation->set_rules('village_name', 'City/Village name', 'required');
        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
			//Get the current data and load it in list view.
			$data['district_data'] = $this->DistrictModel->get_district();
			$data['data'] = $this->CityModel->get_city();
            $this->load->view('village_master', $data);

        }else{
			if($this->input->post('village_id') !="" ){
				//update the district..
        		$this->CityModel->update_city();
			}else{
				//Insert the district..
        		$this->CityModel->insert_city();
			}
			redirect('master/village_master');
		}
	}
	public function editCity($city_id){
		//Get the current data and load it in list view.
		$data['edit_data'] = $this->CityModel->get_city($city_id);
		$data['data'] = $this->CityModel->get_city();
		$data['district_data'] = $this->DistrictModel->get_district();
		if(!empty($data)) {
			$this->load->view('village_master', $data);
		}
	}
	// function: ajax_get_city_by_state()
	// It is used to fetch city list by state id using ajax
	public function ajax_get_city_by_state(){
		$message_arr=array();
		if(isset($_POST['state_id']) && $_POST['state_id']){
			$state_id=$this->input->post('state_id');
			$sel_city_id=$this->input->post('sel_city_id');
			$cities=$this->CityModel->getCityByStateId($state_id);
			$citylist='<option value="">--Select--</option>';
			if($cities){
				foreach ($cities as $city){
					$selected='';
					if($sel_city_id==$city->id){
						$selected='selected';
					}
					$citylist.='<option value="'.$city->id.'" '.$selected.'>'.ucfirst($city->village_name).'</option>';
				}
			}
			$message_arr['citylist']=$citylist;
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// function: ajax_get_city_by_district()
	// It is used to fetch city list by district id using ajax
	public function ajax_get_city_by_district(){
		$message_arr=array();
		if(isset($_POST['districtid']) && $_POST['districtid']){
			$districtid=$this->input->post('districtid');
			$cities=$this->CityModel->getCityByDistrictId($districtid);
			$citylist='<option value="">--Select--</option>';
			if($cities){
				foreach ($cities as $city){
					$citylist.='<option value="'.$city->id.'">'.ucfirst($city->village_name).'</option>';
				}
			}
			$message_arr['citylist']=$citylist;
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
}
