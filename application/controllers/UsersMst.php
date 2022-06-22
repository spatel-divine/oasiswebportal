<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class UsersMst extends CI_Controller {
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
		$this->load->model('Management/UserModel');
    }
	/**
	 * Create user from this method.
	 */
	public function createUser(){
		if(isset($_POST['bulkaction']) && $_POST['bulkaction']==1){
			// Start bulk upload functionality
			$haserror='';
			if(isset($_FILES['bulk_upload']) && $_FILES['bulk_upload']){
				if(empty($_FILES['bulk_upload']['name'])){
					$haserror='Image file not found for bulk upload. Please try again.';
				}else{
					$validextension = array("csv");
					$filename_arr=explode(".",basename($_FILES['bulk_upload']['name']));
		        	$ext=end($filename_arr);
		        	if(!in_array($ext,$validextension)){
		        		$haserror='Please select only csv file for bulk upload.';
		        	}
				}
	        }else{	
	        	$haserror='Image file not found for bulk upload. Please try again.';
	        }
			if($haserror != ''){
				$this->session->set_flashdata('errors', $haserror);
                $this->load->model('Master/StateModel');
				$this->load->model('Master/RoleModel');
				$data['UserTypeData'] = $this->UserModel->get_user_type();
				$data['state_data'] = $this->StateModel->get_state();
				$data['role_data'] = $this->RoleModel->get_role();
				$this->load->view('add_user', $data);
			}else{
				$csv = $_FILES['bulk_upload']['tmp_name'];
				$handle = fopen($csv,"r");
				$i=0;
				$k=0;
				$col_arr=array();
				$insert_arr=array();
				$password_arr=array();
				$username_validation_error='';
				$role_validation_error='';
				$email_validation_error='';
				$missing_required_fields=0;
				$userNameArr=array();
				$emailArr=array();
				while (($row = fgetcsv($handle)) != FALSE){ //get row vales
					if($i==0){
						$col_arr=$row;
					}else{
						for($j=0;$j<count($col_arr);$j++){
							if(isset($col_arr[$j])){
								/*
								if($col_arr[$j]=='EmpName'){
									$fullnamearr=explode(" ",$row[$j]);
									if(isset($fullnamearr[0]) && $fullnamearr[0]){
										$insert_arr[$k]['first_name']=$fullnamearr[0];
									}else{
										$missing_required_fields=1;
										$insert_arr[$k]=array();
										break;
									}
									if(isset($fullnamearr[1]) && $fullnamearr[1]){
										$insert_arr[$k]['last_name']=$fullnamearr[1];
									}else{
										$missing_required_fields=1;
										$insert_arr[$k]=array();
										break;
									}
								}
								*/
								if($col_arr[$j]=='FirstName'){
									if($row[$j]){
										$insert_arr[$k]['first_name']=$row[$j];
									}else{
										$missing_required_fields=1;
										$insert_arr[$k]=array();
										break;
									}
								}else if($col_arr[$j]=='MiddleName'){
									if($row[$j]){
										$insert_arr[$k]['middle_name']=$row[$j];
									}else{
										$missing_required_fields=1;
										$insert_arr[$k]=array();
										break;
									}
								}else if($col_arr[$j]=='LastName'){
									if($row[$j]){
										$insert_arr[$k]['last_name']=$row[$j];
									}else{
										$missing_required_fields=1;
										$insert_arr[$k]=array();
										break;
									}
								}else if($col_arr[$j]=='UserName'){
									if($row[$j]){
										$checkUserExist=$this->UserModel->checkUserNameExist($row[$j]);
										if($checkUserExist){
											if($username_validation_error!=''){
												$username_validation_error.=", ";
											}
											$username_validation_error.=$row[$j];
											$insert_arr[$k]=array();
											break;
										}else{
											if(in_array($row[$j],$userNameArr)){
												$insert_arr[$k]=array();
												break;
											}else{
												$insert_arr[$k]['user_name']=$row[$j];
												$userNameArr[]=$row[$j];
											}
										}
									}else{
										$missing_required_fields=1;
										$insert_arr[$k]=array();
										break;
									}
								}else if($col_arr[$j]=='Password'){
									if($row[$j]){
										$insert_arr[$k]['password']=md5($row[$j]);
										$password_arr[$k]['pwd']=$row[$j];
									}else{
										$insert_arr[$k]['password']=md5('admin@123');
										$password_arr[$k]['pwd']='admin@123';
									}
								}else if($col_arr[$j]=='RoleID'){
									if($row[$j]){
										$checkRoleIdExist=$this->UserModel->checkRoleIdExist($row[$j]);
										if($checkRoleIdExist){
											$insert_arr[$k]['role_id']=$row[$j];
										}else{
											if($role_validation_error!=''){
												$role_validation_error.=", ";
											}
											$role_validation_error.=$row[$j];
											$insert_arr[$k]=array();
											break;
										}
									}else{
										$missing_required_fields=1;
										$insert_arr[$k]=array();
										break;
									}
								}else if($col_arr[$j]=='DOB'){
									$insert_arr[$k]['birth_date']=date("y-m-d", strtotime($row[$j]));
								}else if($col_arr[$j]=='Gender'){
									$insert_arr[$k]['gender']=$row[$j];
								}else if($col_arr[$j]=='State'){
									$insert_arr[$k]['state_id']=$row[$j];
								}else if($col_arr[$j]=='District'){
									$insert_arr[$k]['district_id']=$row[$j];
								}else if($col_arr[$j]=='Village/City'){
									$insert_arr[$k]['city_id']=$row[$j];
								}else if($col_arr[$j]=='MobileNo'){
									if($row[$j]){
										$insert_arr[$k]['mobile_number']=$row[$j];
									}else{
										$missing_required_fields=1;
										$insert_arr[$k]=array();
										break;
									}
								}else if($col_arr[$j]=='AltMobileNo'){
									$insert_arr[$k]['alternate_mobile']=$row[$j];
								}else if($col_arr[$j]=='Email'){
									$checkEmailExist=$this->UserModel->checkAddUniqueEmail($row[$j]);
									if(!$checkEmailExist){
										if($email_validation_error!=''){
											$email_validation_error.=", ";
										}
										$email_validation_error.=$row[$j];
										$insert_arr[$k]=array();
										break;
									}else{
										if(in_array($row[$j],$emailArr)){
											$insert_arr[$k]=array();
											break;
										}else{
											$insert_arr[$k]['email']=$row[$j];
											$emailArr[]=$row[$j];
										}
									}
								}
								if($insert_arr[$k]){
									$insert_arr[$k]['via_bulk_upload']=1;
									$insert_arr[$k]['is_active']=1;
									$insert_arr[$k]['created_by']=$this->session->userdata['id'];
									$insert_arr[$k]['created_at']=date('Y-m-d H:i:s');
									//$insert_arr[$k]['updated_by']=$this->session->userdata['id'];
									//$insert_arr[$k]['updated_at']=date('Y-m-d H:i:s');
								}
							}
						}
						$k++;
					}
					$i++;
				}
				$errormsg='';
				if($username_validation_error){
					$errormsg.="Sorry, User Name ".$username_validation_error." already exist.";
				}
				if($role_validation_error){
					if($errormsg!=""){
						$errormsg.="<br/>";
					}
					$errormsg.="Sorry, Role Id ".$role_validation_error." not exist or may be deleted.";
					//$this->session->set_flashdata('errors', $role_validation_error);
				}
				if($email_validation_error){
					if($errormsg!=""){
						$errormsg.="<br/>";
					}
					$errormsg.="Sorry, Email ".$email_validation_error." already exist.";
					//$this->session->set_flashdata('errors', $email_validation_error);
				}
				if($missing_required_fields==1){
					if($errormsg!=""){
						$errormsg.="<br/>";
					}
					$errormsg.='Sorry, Required fields are missing in some records, so that records have not been inserted. Please fill required fields and try again.';
				}
				if($errormsg){
					$this->session->set_flashdata('errors',$errormsg);
				}else{
					$this->session->set_flashdata('message','Bulk Users added successfully');
				}
				$insert_arr=array_filter($insert_arr);
				if($insert_arr){
					$this->UserModel->insertBulkUser($insert_arr,$password_arr);
				}
				redirect('management/view_user_list');
			}
			// End bulk upload functionality
		}else{
			$post = $this->input->post(); 
			// echo "<pre>";	
			// print_r($post);

			// if(isset($post['chk_bulk_upload']) &&  $post['chk_bulk_upload'] == 1 ){
			// 	//Check the validation for bulk upload..
			// 	echo "bulk";
			// }else{
			// 	//Check the validationf ro single record.
			// 	echo "single";
			// }
			$this->form_validation->set_rules('first_name', 'First Name', 'required');
			$this->form_validation->set_rules('middle_name', 'Middle Name', 'required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'required');
			if(!isset($_POST['user_id']) || $_POST['user_id']==""){
				$this->form_validation->set_rules('user_name', 'User Name', 'required');
			}
			$this->form_validation->set_rules('role_id', 'Role', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required');
			if(isset($_POST['user_id']) && $_POST['user_id']!=""){
				$this->form_validation->set_rules('email','Email','trim|valid_email|callback_check_edit_unique_email',array('valid_email'=>'Please Enter Valid Email ID'));
			}else{
				$this->form_validation->set_rules('email','Email','trim|valid_email|callback_check_add_unique_email',array('valid_email'=>'Please Enter Valid Email ID'));
			}
			// Need to check the duplicate user name.
			if(!isset($_POST['user_id']) || $_POST['user_id']==""){
				$chk_user_duplicate = $this->UserModel->check_user_name($this->input->post('user_name'), $this->input->post('user_id') );
				if($chk_user_duplicate >0 ){
					$this->form_validation->set_rules('user_name_valid', 'unique user name', 'required');
				}
			}
	        if ($this->form_validation->run() == FALSE){
				$this->load->model('Master/StateModel');
				$this->load->model('Master/RoleModel');
				$action=$this->input->post('action');
				if($action  == 'add') {
				//Get the current data and load it in list view.
					$data['UserTypeData'] = $this->UserModel->get_user_type();
					$data['state_data'] = $this->StateModel->get_state();
					$data['role_data'] = $this->RoleModel->get_role();

					$this->load->view('add_user', $data);
				}else{
					$data['UsersData'] = $this->UserModel->get_user_list($this->input->post('user_id'));
					$data['role_data'] = $this->RoleModel->get_role();
					$data['UserTypeData'] = $this->UserModel->get_user_type();
					$this->load->view('add_user', $data);
				}
	        }else{
				if($this->input->post('user_id') !="" ){
					//update the user type..
	        		$this->UserModel->update_user();
				}else{
					//Insert the user type..
	        		$this->UserModel->insert_user();
				}
				redirect('management/view_user_list');
			}
		}
	}
	// function: ajax_get_user_by_id()
	// It is used to fetch user list by id using ajax
	public function ajax_get_user_by_id(){
		$message_arr=array();
		if(isset($_POST['user_id']) && $_POST['user_id']){
			$user_id=$this->input->post('user_id');
			$user=$this->UserModel->getUserById($user_id);
			if(isset($user->is_active)){
				$message_arr['is_active']=$user->is_active;
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($message_arr));
	}
    // function: check_add_unique_email($email)
    // It is used to check for unique email id for user
    public function check_add_unique_email($email){
        if($email){
            $result=$this->UserModel->checkAddUniqueEmail($email);
            if(!$result){
               $this->form_validation->set_message('check_add_unique_email', 'Email ID already exists.');
                return FALSE; 
            }
        }
        return TRUE;
    }
    // function: check_edit_unique_email($email)
    // It is used to check for unique email id for user
    public function check_edit_unique_email($email){
        if($email){
            $result=$this->UserModel->checkEditUniqueEmail($email);
            if(!$result){
               $this->form_validation->set_message('check_edit_unique_email', 'Email ID already exists.');
                return FALSE; 
            }
        }
        return TRUE;
    }
}
