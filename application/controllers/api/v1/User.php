<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'controllers/JwtToken.php';
class User extends REST_Controller {
    public function __construct() {
       parent::__construct();
       $this->load->model('api/v1/UserModel');
       $this->load->model('api/v1/HomeModel');
       $this->load->library("pagination");
    }
    // function: user_list_get()
    // It is used to get user list
    public function user_list_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $config = array();
            $config["base_url"] = base_url() . "api/v1/user/user_list";
            $config["total_rows"] = $this->UserModel->getTotalUser();
            $config["per_page"] = LIST_LIMIT;
            $total_no_of_pages=0;
            if($config["total_rows"]>0){
                $total_no_of_pages=ceil($config["total_rows"]/LIST_LIMIT);
            }
            $config["total_no_of_pages"] = $total_no_of_pages;
            $config["uri_segment"] = 5;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(5))? $this->uri->segment(5) : 0;
            $config['userlist'] = $this->UserModel->getUserList($config["per_page"], $page);
            $this->response([
                'status' => True,
                'message' => $config,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: add_user_form_get()
    // It is used to get add user form data
    public function add_user_form_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $data['rolelist']=getRoleList();
            $data['usertypelist']=getUserTypeList();
            $data['statelist']=getActiveStateList();
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: district_by_state_get()
    // It is used to get district list by state id
    public function district_by_state_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $state_id='';
            if(isset($_GET['state_id']) && $_GET['state_id']){
                $state_id=$this->input->get('state_id');
            }
            $this->load->model('Master/DistrictModel');
            $data['districtlist']=$this->DistrictModel->getDistrictListByStateId($state_id);
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: city_by_district_get()
    // It is used to get city list by district id
    public function city_by_district_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $district_id='';
            if(isset($_GET['district_id']) && $_GET['district_id']){
                $district_id=$this->input->get('district_id');
            }
            $this->load->model('Master/CityModel');
            $data['citylist']=$this->CityModel->getCityListByDistrictId($district_id);
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: add_user_post()
    // It is used to add user
    public function add_user_post(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $this->form_validation->set_data($this->post());
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required',array('required'=>'Enter First Name'));
            $this->form_validation->set_rules('middle_name', 'Middle Name', 'trim|required',array('required'=>'Enter Middle Name'));
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required',array('required'=>'Enter Last Name'));
            $this->form_validation->set_rules('user_name', 'User Name','trim|required|callback_check_unique_user_name',array('required'=>'Enter User Name'));
            $this->form_validation->set_rules('password', 'Password', 'required',array('required'=>'Enter Password'));
            $this->form_validation->set_rules('role_id', 'Role', 'required',array('required'=>'Please Select Role'));
            $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required',array('required'=>'Enter Mobile Number'));
            $this->form_validation->set_rules('email','Email','trim|valid_email|callback_check_unique_email',array('valid_email'=>'Please Enter Valid Email ID'));
            if($this->form_validation->run() == FALSE){
                $data = $this->form_validation->error_array();
                $this->response([
                    'status' => False,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }else{
                $result=$this->UserModel->addUser();
                if($result==1){
                    $data["success_message"] = "User added successfully";
                    $this->response([
                        'status' => True,
                        'message' => $data,
                    ], REST_Controller::HTTP_OK);
                }else{
                    $data["error_message"] = "Something Went Wrong. Please Try Again.";
                    $this->response([
                        'status' => False,
                        'message' => $data,
                    ], REST_Controller::HTTP_OK);
                }
            }
        }
    }
    // function: check_unique_user_name($user_name)
    // It is used to check for unique user name for user
    public function check_unique_user_name($user_name){
        if($user_name){
            $result=$this->HomeModel->checkUniqueUserName($user_name);
            if(!$result){
               $this->form_validation->set_message('check_unique_user_name', 'Username already exists.');
                return FALSE; 
            }
        }
        return TRUE;
    }
    // function: check_unique_email($email)
    // It is used to check for unique email id for user
    public function check_unique_email($email){
        if($email){
            $result=$this->HomeModel->checkUniqueEmail($email);
            if(!$result){
               $this->form_validation->set_message('check_unique_email', 'Email ID already exists.');
                return FALSE; 
            }
        }
        return TRUE;
    }
    // function: edit_user_form_get()
    // It is used to get edit user form data
    public function edit_user_form_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $data['user_id']='';
            $userdetails='';
            if(isset($_GET['user_id']) && $_GET['user_id']){
                $data['user_id']=$this->input->get('user_id');
                $user_id=base64_decode($this->input->get('user_id'));
                $userdetails=$this->UserModel->getUserById($user_id);
            }
            $data['userdetails']=$userdetails;
            $data['rolelist']=getRoleList();
            $data['usertypelist']=getUserTypeList();
            $data['statelist']=getActiveStateList();
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: edit_user_post()
    // It is used to edit user
    public function edit_user_post(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $this->form_validation->set_data($this->post());
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required',array('required'=>'Enter First Name'));
            $this->form_validation->set_rules('middle_name', 'Middle Name', 'trim|required',array('required'=>'Enter Middle Name'));
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required',array('required'=>'Enter Last Name'));
            $this->form_validation->set_rules('password', 'Password', 'required',array('required'=>'Enter Password'));
            $this->form_validation->set_rules('role_id', 'Role', 'required',array('required'=>'Please Select Role'));
            $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required',array('required'=>'Enter Mobile Number'));
            $this->form_validation->set_rules('email','Email','trim|valid_email|callback_check_update_unique_email',array('valid_email'=>'Please Enter Valid Email ID'));
            if($this->form_validation->run() == FALSE){
                $data = $this->form_validation->error_array();
                $this->response([
                    'status' => False,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }else{
                $result=$this->UserModel->updateUser();
                if($result==1){
                    $data["success_message"] = "User updated successfully";
                    $this->response([
                        'status' => True,
                        'message' => $data,
                    ], REST_Controller::HTTP_OK);
                }else{
                    $data["error_message"] = "Something Went Wrong. Please Try Again.";
                    $this->response([
                        'status' => False,
                        'message' => $data,
                    ], REST_Controller::HTTP_OK);
                }
            }
        }
    }
    // function: check_update_unique_email($email)
    // It is used to check for unique email id for user
    public function check_update_unique_email($email){
        if($email){
            $result=$this->UserModel->checkEditUniqueEmail($email);
            if(!$result){
               $this->form_validation->set_message('check_update_unique_email', 'Email ID already exists.');
                return FALSE; 
            }
        }
        return TRUE;
    }
    // function: delete_user_get()
    // It is used to delete user
    public function delete_user_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $result=0;
            if(isset($_GET['user_id']) && $_GET['user_id']){
                $user_id=base64_decode($this->input->get('user_id'));
                $result=$this->UserModel->deleteUser($user_id);
            }
            if($result==1){
                $data["success_message"] = "User deleted successfully";
                $this->response([
                    'status' => True,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }else{
                $data["error_message"] = "Something Went Wrong. Please Try Again.";
                $this->response([
                    'status' => False,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }
        }
    }
    public function bulk_user_upload_post(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            // Start bulk upload functionality
            $haserror='';
            if(isset($_FILES['bulk_upload']) && $_FILES['bulk_upload']){
                if(empty($_FILES['bulk_upload']['name'])){
                    $haserror='File not found for bulk upload. Please try again.';
                }else{
                    $validextension = array("csv");
                    $filename_arr=explode(".",basename($_FILES['bulk_upload']['name']));
                    $ext=end($filename_arr);
                    if(!in_array($ext,$validextension)){
                        $haserror='Please select only csv file for bulk upload.';
                    }
                }
            }else{  
                $haserror='File not found for bulk upload. Please try again.';
            }
            if($haserror != ''){
                $data['bulk_upload']=$haserror;
                $this->response([
                    'status' => False,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
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
                                    $checkEmailExist=$this->HomeModel->checkUniqueEmail($row[$j]);
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
                                if(isset($insert_arr[$k]) && $insert_arr[$k]){
                                    $jwt = new JwtToken();
                                    $received_Token = $this->input->request_headers('Authorization');
                                    $user = $jwt->GetTokenData($received_Token);
                                    $user_id='';
                                    if(isset($user['user_id']) && $user['user_id']){
                                        $user_id=$user['user_id'];
                                    }
                                    $insert_arr[$k]['via_bulk_upload']=1;
                                    $insert_arr[$k]['is_active']=1;
                                    $insert_arr[$k]['created_by']=$user_id;
                                    $insert_arr[$k]['created_at']=date('Y-m-d H:i:s');
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
                }
                if($email_validation_error){
                    if($errormsg!=""){
                        $errormsg.="<br/>";
                    }
                    $errormsg.="Sorry, Email ".$email_validation_error." already exist.";
                }
                if($missing_required_fields==1){
                    if($errormsg!=""){
                        $errormsg.="<br/>";
                    }
                    $errormsg.='Sorry, Required fields are missing in some records, so that records have not been inserted. Please fill required fields and try again.';
                }
                if($errormsg){
                    $data["error_message"] = $errormsg;
                }
                $insert_arr=array_filter($insert_arr);
                if($insert_arr){
                    $result=$this->UserModel->insertBulkUser($insert_arr,$password_arr);
                    if($result){
                        $data["success_message"] = "Bulk Users added successfully";
                        $this->response([
                            'status' => True,
                            'message' => $data,
                        ], REST_Controller::HTTP_OK);
                    }else{
                        if(!isset($data["error_message"]) || $data["error_message"]==''){
                            $data["error_message"] = "Something Went Wrong. Please Try Again.";
                        }
                        $this->response([
                            'status' => False,
                            'message' => $data,
                        ], REST_Controller::HTTP_OK);
                    }
                }else{
                    if(!isset($data["error_message"]) || $data["error_message"]==''){
                        $data["error_message"] = "Something Went Wrong. Please Try Again.";
                    }
                    $this->response([
                        'status' => False,
                        'message' => $data,
                    ], REST_Controller::HTTP_OK);
                }
            }
            // End bulk upload functionality
        }
    }
}