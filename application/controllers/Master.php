<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master extends CI_Controller {
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
    }
	public function user_type_master(){
		$this->load->model('Master/UserTypeModel');
		$data['data'] = $this->UserTypeModel->get_userType();
		$this->load->view('user_type_master', $data);
	}
	 /**
	* Delete User from user type table
    */
	public function delete_user_type(){
		if(isset($_POST['user_type_id'])){
			$data = array(
            	'deleted_at' => date('Y-m-d H:i:s')
        	);
        	$this->db->where('id', $_POST['user_type_id']);
       		echo $this->db->update('user_types', $data);
		}
   	}
    /**
	* Delete User from role table
    */
	public function delete_role(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['role_id'])){
					$data = array(
		            	'deleted_at' => date('Y-m-d H:i:s')
		        	);
		        	$this->db->where('id', $_POST['role_id']);
		       		$message_arr['success']=$this->db->update('roles', $data);
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
  	}
	public function role_master(){
		$this->load->model('Master/RoleModel');
		//$this->roleModelObj = new roleModel; //call the model and create object
		$data['data'] = $this->RoleModel->get_role();
		$this->load->view('role_master', $data);
	}
	public function state_master(){
		$this->load->model('Master/StateModel');
		$data['data'] = $this->StateModel->get_state();
		$this->load->view('state_master', $data);
	}
	/**
	* Delete state from table
    */
	public function delete_state(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['state_id'])){
					$data = array(
		            	'deleted_at' => date('Y-m-d H:i:s')
		        	);
		        	$this->db->where('id', $_POST['state_id']);
		       		$message_arr['success']=$this->db->update('states', $data);
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
   	}
	public function district_master(){
		$this->load->model('Master/StateModel');
		$this->load->model('Master/DistrictModel');

		$data['state_data'] = $this->StateModel->get_state();
		$data['data'] = $this->DistrictModel->get_district();

		$this->load->view('district_master', $data);
	}
	/**
	* Delete district from db
    */
	public function delete_district(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['district_id'])){
					$data = array(
		            	'deleted_at' => date('Y-m-d H:i:s')
		        	);
		        	$this->db->where('id', $_POST['district_id']);
		       		$message_arr['success']=$this->db->update('districts', $data);
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
    }
	public function village_master(){
		$this->load->model('Master/CityModel');
		$this->load->model('Master/DistrictModel');
		$data['data'] = $this->CityModel->get_city();
		$data['district_data'] = $this->DistrictModel->get_district();
		$this->load->view('village_master', $data);
	}
	/**
	* Delete city_town_villages from db
    */
	public function delete_city_town_villages(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['city_id'])){
					$data = array(
		            	'deleted_at' => date('Y-m-d H:i:s')
		        	);
		        	$this->db->where('id', $_POST['city_id']);
		       		$message_arr['success']=$this->db->update('city_town_villages', $data);
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
   	}
	public function taluka_master(){
		$this->load->view('taluka_master');
	}
	public function region_master(){
		$this->load->model('Master/StateModel');
		$this->load->model('Master/RegionModel');
		$data['state_data'] = $this->StateModel->get_state();
		$data['data'] = $this->RegionModel->get_region();
		$this->load->view('region_master', $data);
	}
	/**
	* Delete regions from db
    */
	public function delete_region(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['region_id'])){
					$data = array(
		            	'deleted_at' => date('Y-m-d H:i:s')
		        	);
		        	$this->db->where('id', $_POST['region_id']);
		       		$message_arr['success']=$this->db->update('regions', $data);
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
   	}
	public function reason_type_master(){
		$this->load->view('reason_type_master');
	}
	public function group_type_master(){
		$this->load->model('Master/GroupTypeModel');
		$data['data'] = $this->GroupTypeModel->get_group_type();
		$this->load->view('group_type_master', $data);
	}
	/**
	* Delete group_types from db
    */
	public function delete_group_type(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['group_id'])){
					$data = array(
		            	'deleted_at' => date('Y-m-d H:i:s')
		        	);
		        	$this->db->where('id', $_POST['group_id']);
		       		$message_arr['success']=$this->db->update('group_types', $data);
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
    }
   	// *************** Start Dynamic Feedback Form *********************
	// function: program_feedback_list()
	// It is used to display program feedback list
	public function program_feedback_list(){
		$data=array();
		//Load the dynamic form model
		$this->load->model('Master/DynamicformModel');
		$data['program_feedback_list'] = $this->DynamicformModel->getProgramFeedbackList();
		$this->load->view('program_feedback_list',$data);
	}
	// function: program_feedback_form()
	// It is used to display program feedback field form
	public function program_feedback_form(){
		$data=array();
		//Load the dynamic form model
		$this->load->model('Master/DynamicformModel');
		if(isset($_POST['sequence_no']) && $_POST['sequence_no']){
			$this->DynamicformModel->insertNewFieldsInDynamicForm('program_feedback_form');
			$this->session->set_flashdata('message_success','New Fields have been added successfully.');
		}
		$data['program_feedback'] = $this->DynamicformModel->getProgramFeedback();
		$data['sequence_index']=getTotalRecordFromTable('program_feedback_form');
		$this->load->view('program_feedback_form',$data);
	}
	// function: delete_dynamic_field()
	// It is used to delete dynamic feedback field
	public function delete_dynamic_field($tablename,$field_id,$redirectto){
		//Load the dynamic form model
		$this->load->model('Master/DynamicformModel');
		if($field_id){
			$field_id=base64_decode($field_id);
			$result=$this->DynamicformModel->deleteDynamicField($tablename,$field_id);
			if($result==1){
				$this->session->set_flashdata('success_message','Dynamic Field has been deleted successfully.');
			}else{
				$this->session->set_flashdata('error_message','Sorry, Dynamic Field could not be deleted. Try again.');
			}
		}else{
			$this->session->set_flashdata('error_message','Sorry, Dynamic Field could not be deleted. Try again.');
		}
		redirect('master/'.$redirectto);
	}
	// function: ajax_get_dynamic_form_field_by_id()
	// It is used to fetch edit dynamic form fields html by field id and tablename using ajax
	public function ajax_get_dynamic_form_field_by_id(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['id']) && $_POST['id'] && isset($_POST['tablename']) && $_POST['tablename']){
				//Load the dynamic form model
				$this->load->model('Master/DynamicformModel');
				$id=base64_decode($this->input->post('id'));
				$tablename=$this->input->post('tablename');
				$row=$this->DynamicformModel->getDynamicFieldDetailById($tablename,$id);
				$edit_field_html='';
				if($row){
					$sequence_no='';
					if(isset($row->sequence_no) && $row->sequence_no!='' && $row->sequence_no!=null){ $sequence_no=$row->sequence_no; 
					}
					$field_name='';
					if(isset($row->field_label) && $row->field_label!='' && $row->field_label!=null){ 
						$field_name=($row->field_label); 
					}
					$field_type='';
					if(isset($row->field_type) && $row->field_type!='' && $row->field_type!=null){ 
						$field_type=($row->field_type); 
					}
					$comments='';
					if(isset($row->comments) && $row->comments!='' && $row->comments!=null){ 
						$comments=$row->comments; 
					}
					$field_id='';
					if(isset($row->id) && $row->id!='' && $row->id!=null){ 
						$field_id=base64_encode($row->id); 
					}
					$edit_field_html.='<div class="card-body"><div class="form-group"><label>Field Type: '.ucfirst($field_type).'</lable></div><div class="form-group"><div class="row"><div class="col-lg-6 col-md-12"><label>Sequence No <font color="red">*</font></label><input type="number" class="form-control" id="sequence_no" name="sequence_no" value="'.$sequence_no.'" placeholder="Enter Sequence No" required data-msg-required="Enter Sequence No"><label id="sequence_no-error" class="error validationerror" for="sequence_no"></label></div><div class="col-lg-6 col-md-12"><label>Field Name <font color="red">*</font></label><input type="text" class="form-control" id="field_name" name="field_name" value="'.$field_name.'" placeholder="Enter Field Name" required data-msg-required="Enter Field Name"><label id="field_name-error" class="error validationerror" for="field_name"></label></div></div></div><div class="form-group"><div class="row"><div class="col-lg-6 col-md-12"><label>Required or Not <font color="red">*</font></label><select id="is_required" name="is_required" class="form-control" required data-msg-required="Please Select required or not"><option value="">--Select--</option>';
						if(isset($row->is_required) && $row->is_required==1){
							$edit_field_html.='<option value="1" selected>Required</option>';
						}else{
							$edit_field_html.='<option value="1">Required</option>';
						} 
						if(isset($row->is_required) && $row->is_required==0){
							$edit_field_html.='<option value="0" selected>Not Required</option>';
						}else{
							$edit_field_html.='<option value="0">Not Required</option>';
						} 
							$edit_field_html.='</select><label id="is_required-error" class="error validationerror" for="is_required"></label></div><div class="col-lg-6 col-md-12"><label>Status <font color="red">*</font></label><select id="is_active" name="is_active" class="form-control" required data-msg-required="Please Select Status"><option value="">--Select--</option>';
							if(isset($row->is_active) && $row->is_active==1){
								$edit_field_html.='<option value="1" selected>Active</option>';
							}else{
								$edit_field_html.='<option value="1">Active</option>';
							} 
							if(isset($row->is_active) && $row->is_active==0){
								$edit_field_html.='<option value="0" selected>Inactive</option>';
							}else{
								$edit_field_html.='<option value="0">Inactive</option>';
							}
							$edit_field_html.='</select><label id="is_active-error" class="error validationerror" for="is_active"></label></div></div></div>';
							if($field_type=='number'){
								$edit_field_html.='<div class="form-group"><div class="row"><div class="col-lg-6 col-md-12"><label>Minimum Number Requirement</label><input type="number" class="form-control" id="min_number" name="min_number" value="'.$row->min_number.'" placeholder="Enter Minimum Number" min=0><label id="min_number-error" class="error validationerror" for="min_number"></label></div><div class="col-lg-6 col-md-12"><label>Maximum Number Requirement</label><input type="number" class="form-control" id="max_number" name="max_number" value="'.$row->max_number.'" placeholder="Enter Maximum Number" min=1><label id="max_number-error" class="error validationerror" for="max_number"></label></div></div></div>';
							}
							if($field_type=='file'){
								$file_extension=getFileExtensionOptions($row->file_extension);
								$edit_field_html.='<div class="form-group"><div class="row"><div class="col-lg-6 col-md-12"><label>Maximum Upload <font color="red">*</font></label><input type="number" class="form-control" id="max_upload" name="max_upload" value="'.$row->max_upload.'" placeholder="Enter Max Upload" min=1 required data-msg-required="Enter Max Upload"><label id="max_upload-error" class="error validationerror" for="max_upload"></label></div><div class="col-lg-6 col-md-12"><label>File Extension <font color="red">*</font></label><select class="form-control select2" id="file_extension" name="file_extension[]" multiple required data-msg-required="Please Select File Extension">'.$file_extension.'"</select><label id="file_extension-error" class="error validationerror" for="file_extension"></label></div></div></div>';
							}
							if($field_type=='date'){
								$date_validation='<option value="">--Select--</option>';
								if($row->date_validation=='alldate'){
									$date_validation.='<option value="alldate" selected>All</option>';
								}else{
									$date_validation.='<option value="alldate">All</option>';
								}
								if($row->date_validation=='onlypast'){
									$date_validation.='<option value="onlypast" selected>Only Past Date</option>';
								}else{
									$date_validation.='<option value="onlypast">Only Past Date</option>';
								}
								if($row->date_validation=='onlyfuture'){
									$date_validation.='<option value="onlyfuture" selected>Only Future Date</option>';
								}else{
									$date_validation.='<option value="onlyfuture">Only Future Date</option>';
								}
								$edit_field_html.='<div class="form-group"><div class="row"><div class="col-lg-6 col-md-12"><label>Date Validation <font color="red">*</font></label><select class="form-control" id="date_validation" name="date_validation" required data-msg-required="Please Select Date Validation">'.$date_validation.'"</select><label id="date_validation-error" class="error validationerror" for="date_validation"></label></div></div></div>';
							}
							$edit_field_html.='<div class="form-group"><div class="row"><div class="col-lg-12 col-md-12"><label>Add Note</label><textarea id="comments" name="comments" class="form-control" placeholder="Enter Add Note">'.$comments.'</textarea></div></div></div><input type="hidden" id="field_id" name="field_id" value="'.$field_id.'"><input type="hidden" id="field_type" name="field_type" value="'.$field_type.'"><input type="hidden" id="tablename" name="tablename" value="'.$tablename.'"/><hr/><div class="form-group"  style="float:right;"><div class="row"><input type="submit" name="submit" value="Submit" class="btn btn-app btn-primary mr-2 mt-1 mb-1"></div></div></div>';
					}
					$message_arr['edit_field_html']=$edit_field_html;
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// function: ajax_update_dynamic_field()
	// It is used to fetch update dynamic form fields using ajax
	public function ajax_update_dynamic_field(){
		$message_arr=array();
		$this->form_validation->set_rules('sequence_no', 'Sequence No', 'required',array('required'=>'Enter Sequence No'));
		$this->form_validation->set_rules('field_name', 'Field Name', 'required',array('required'=>'Enter Field Name'));
		$this->form_validation->set_rules('is_required', 'Required or Not', 'required',array('required'=>'Please Select required or not'));
		$this->form_validation->set_rules('is_active', 'Status', 'required',array('required'=>'Please Select Status'));
		if(isset($_POST['field_type']) && $_POST['field_type']=='file'){
			$this->form_validation->set_rules('max_upload', 'Max Upload', 'required',array('required'=>'Enter Max Upload'));
			$this->form_validation->set_rules('file_extension[]', 'File Extension', 'required',array('required'=>'Please Select File Extension'));
		}
		if(isset($_POST['field_type']) && $_POST['field_type']=='date'){
			$this->form_validation->set_rules('date_validation', 'Date Validation', 'required',array('required'=>'Please Select Date Validation'));
		}
		if($this->form_validation->run() == FALSE){
			$message_arr=$this->form_validation->error_array();
		}else{
			if(isset($_POST['field_id']) && $_POST['field_id'] && isset($_POST['tablename']) && $_POST['tablename']){
				//Load the dynamic form model
				$this->load->model('Master/DynamicformModel');
				$message_arr['rowid']='row'.$this->input->post('field_id');
				$message_arr['updated_data']=$this->DynamicformModel->updateDynamicFormField();
				$message_arr['success_message']='<div class="alert alert-success"><font color="white"><b><a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:#fff;">&times;</a>Dynamic Field updated successfully</b></font></div>';
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
	// function: personal_learning_list()
	// It is used to display personal learning form field list
	public function personal_learning_list(){
		$data=array();
		//Load the dynamic form model
		$this->load->model('Master/DynamicformModel');
		$data['personal_learning_list'] = $this->DynamicformModel->getPersonalLearningList();
		$this->load->view('personal_learning_list',$data);
	}
	// function: personal_learning_form()
	// It is used to display personal learning form field
	public function personal_learning_form(){
		$data=array();
		//Load the dynamic form model
		$this->load->model('Master/DynamicformModel');
		if(isset($_POST['sequence_no']) && $_POST['sequence_no']){
			$this->DynamicformModel->insertNewFieldsInDynamicForm('personal_learning_form');
			$this->session->set_flashdata('message_success','New Fields have been added successfully.');
		}
		$data['personal_learning'] = $this->DynamicformModel->getPersonalLearning();
		$data['sequence_index']=getTotalRecordFromTable('personal_learning_form');
		$this->load->view('personal_learning_form',$data);
	}
	// function: feedback_for_participants_list()
	// It is used to display feedback for participants form field list
	public function feedback_for_participants_list(){
		$data=array();
		//Load the dynamic form model
		$this->load->model('Master/DynamicformModel');
		$data['feedback_participants_list'] = $this->DynamicformModel->getFeedbackParticipantsList();
		$this->load->view('feedback_for_participants_list',$data);
	}
	// function: feedback_for_participants_form()
	// It is used to display feedback for participants form field
	public function feedback_for_participants_form(){
		$data=array();
		//Load the dynamic form model
		$this->load->model('Master/DynamicformModel');
		if(isset($_POST['sequence_no']) && $_POST['sequence_no']){
			$this->DynamicformModel->insertNewFieldsInDynamicForm('feedback_for_participants_form');
			$this->session->set_flashdata('message_success','New Fields have been added successfully.');
		}
		$data['feedback_participant'] = $this->DynamicformModel->getFeedbackParticipant();
		$data['sequence_index']=getTotalRecordFromTable('feedback_for_participants_form');
		$this->load->view('feedback_for_participants_form',$data);
	}
	// function: program_feedback_by_participants_list()
	// It is used to display program feedback for participants form field list
	public function program_feedback_by_participants_list(){
		$data=array();
		//Load the dynamic form model
		$this->load->model('Master/DynamicformModel');
		$data['feedback_by_participants_list'] = $this->DynamicformModel->getFeedbackByParticipantsList();
		$this->load->view('program_feedback_by_participants_list',$data);
	}
	// function: program_feedback_by_participant_form()
	// It is used to display program feedback by participants form field
	public function program_feedback_by_participant_form(){
		$data=array();
		//Load the dynamic form model
		$this->load->model('Master/DynamicformModel');
		if(isset($_POST['sequence_no']) && $_POST['sequence_no']){
			$this->DynamicformModel->insertNewFieldsInDynamicForm('program_feedback_by_participants_form');
			$this->session->set_flashdata('message_success','New Fields have been added successfully.');
		}
		$data['feedback_by_participant'] = $this->DynamicformModel->getFeedbackByParticipant();
		$data['sequence_index']=getTotalRecordFromTable('program_feedback_by_participants_form');
		$this->load->view('program_feedback_by_participant_form',$data);
	}
	// function: star_participants_list()
	// It is used to display star participants form field list
	public function star_participants_list(){
		$data=array();
		//Load the dynamic form model
		$this->load->model('Master/DynamicformModel');
		$data['star_participants_list'] = $this->DynamicformModel->getStarParticipantsList();
		$this->load->view('star_participants_list',$data);
	}
	// function: star_participants_form()
	// It is used to display star participants form field
	public function star_participants_form(){
		$data=array();
		//Load the dynamic form model
		$this->load->model('Master/DynamicformModel');
		if(isset($_POST['sequence_no']) && $_POST['sequence_no']){
			$this->DynamicformModel->insertNewFieldsInDynamicForm('star_participants_form');
			$this->session->set_flashdata('message_success','New Fields have been added successfully.');
		}
		$data['star_participant'] = $this->DynamicformModel->getStarParticipant();
		$data['sequence_index']=getTotalRecordFromTable('star_participants_form');
		$this->load->view('star_participants_form',$data);
	}
	// function: impact_on_character_traits_list()
	// It is used to display impact on character traits form field list
	public function impact_on_character_traits_list(){
		$data=array();
		//Load the dynamic form model
		$this->load->model('Master/DynamicformModel');
		$data['impact_on_character_traits_list'] = $this->DynamicformModel->getImactOnCharacterTraitsList();
		$this->load->view('impact_on_character_traits_list',$data);
	}
	// function: impact_on_character_traits_form()
	// It is used to display impact on character traits form field
	public function impact_on_character_traits_form(){
		$data=array();
		//Load the dynamic form model
		$this->load->model('Master/DynamicformModel');
		if(isset($_POST['sequence_no']) && $_POST['sequence_no']){
			
			$this->DynamicformModel->insertNewFieldsInDynamicForm('impact_on_character_traits_form');
			$this->session->set_flashdata('message_success','New Fields have been added successfully.');
		}
		$data['impact_on_character_traits'] = $this->DynamicformModel->getImactOnCharacterTraits();
		$data['parameter_or_characteristics_list'] = $this->DynamicformModel->getParameterOrCharacteristicsList();
		$data['sequence_index']=getTotalRecordFromTable('impact_on_character_traits_form');
		$this->load->view('impact_on_character_traits_form',$data);
	}
	// *************** End Dynamic Feedback Form *********************
	public function quality_observed_master(){
		$this->load->model('Master/QualityObservedModel');
		$data['data'] = $this->QualityObservedModel->get_quality_data();
		$this->load->view('quality_observed_master', $data);
	}
	/**
	* Delete quality observed from db
    */
	public function delete_quality_observed(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['quality_id'])){
					$data = array(
		            	'deleted_at' => date('Y-m-d H:i:s')
		        	);
		        	$this->db->where('id', $_POST['quality_id']);
		       		$message_arr['success']=$this->db->update('quality_data', $data);
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
   	}
	public function post_category_master(){
		$this->load->model('Master/PostCategoryModel');
		$data['data'] = $this->PostCategoryModel->get_post_category();
		$this->load->view('post_category_master', $data);
	}
	/**
	* Delete post category from db
    */
	public function delete_post_category(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['post_categorie_id'])){
					$data = array(
		            	'deleted_at' => date('Y-m-d H:i:s')
		        	);
		        	$this->db->where('id', $_POST['post_categorie_id']);
		       		$message_arr['success']=$this->db->update('post_categories', $data);
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
  	}
	public function download_category_master(){
		$this->load->model('Master/DownloadCategoryModel');
		$data['data'] = $this->DownloadCategoryModel->get_download_category();
		$this->load->view('download_category_master', $data);
	}
	/**
	* Delete download category from db
    */
	public function delete_download_category(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['download_categorie_id'])){
					$data = array(
		            	'deleted_at' => date('Y-m-d H:i:s')
		        	);
		        	$this->db->where('id', $_POST['download_categorie_id']);
		       		$message_arr['success']=$this->db->update('download_categories', $data);
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
    }
	public function program_related_to_master(){
		$this->load->model('Master/ProgramRelatedModel');
		$data['data'] = $this->ProgramRelatedModel->get_program_related();
		$this->load->view('program_related_to_master', $data);
	}
	/**
	* Delete download category from db
    */
	public function delete_program_related(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['program_related_id'])){
					$data = array(
		            	'deleted_at' => date('Y-m-d H:i:s')
		        	);
		        	$this->db->where('id', $_POST['program_related_id']);
		       		$message_arr['success']=$this->db->update('program_related', $data);
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
    }
	public function program_type_master(){
		$this->load->model('Master/ProgramTypeModel');
		$data['data'] = $this->ProgramTypeModel->get_program_type();
		$this->load->view('program_type_master', $data);
	}
	/**
	* Delete download category from db
    */
	public function delete_program_type(){
		$message_arr=array();
		if(!is_logged_in()){
		    $message_arr['notvaliduserurl']=site_url('login');
		}else{
			// Start check Assign Rights
	    	$controller = strtolower($this->router->fetch_class());
			$method = strtolower($this->router->fetch_method());
			$result=checkAssignRights($controller,$method);
			// End check Assign Rights
			if(!$result){
			 	$message_arr['notvaliduserurl']=site_url('home/error403');
			}else{
				if(isset($_POST['program_type_id'])){
					$data = array(
		            	'deleted_at' => date('Y-m-d H:i:s')
		        	);
		        	$this->db->where('id', $_POST['program_type_id']);
		       		$message_arr['success']=$this->db->update('program_types', $data);
				}
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
    }
}
