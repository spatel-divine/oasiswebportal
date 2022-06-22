<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'controllers/JwtToken.php';
class Home extends REST_Controller {
    public function __construct() {
       parent::__construct();
       $this->load->model('api/v1/HomeModel');
    }
    // function: index_get()
    // It is used to display home page
    public function index_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            // $jwt = new JwtToken();
            // $received_Token = $this->input->request_headers('Authorization');
            // $user = $jwt->GetTokenData($received_Token);
            $data["totalomprograms"] = $this->HomeModel->getTotalOmPrograms();
            $data["programsthisyear"] = $this->HomeModel->getTotalOmPrograms(date('Y'));
            $data["lateststories"] = $this->HomeModel->geLatestStories();
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    public function index_post(){
    } 
    public function index_put($id){
    }
    public function index_delete($id){
    }
    // function: signup_post()
    // It is used to save user data
    public function signup_post(){
        $data=array();
        $this->form_validation->set_data($this->post());
        $this->form_validation->set_rules('user_name', 'User Name','trim|required|callback_check_unique_user_name',array('required'=>'Enter User Name'));
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[32]|callback_is_password_strong',array('required'=>'Enter Password'));
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]',array('required'=>'Enter Confirm Password','matches'=>'Password does not match'));
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required',array('required'=>'Enter First Name'));
        $this->form_validation->set_rules('middle_name', 'Middle Name', 'trim|required',array('required'=>'Enter Middle Name'));
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required',array('required'=>'Enter Last Name'));
        $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required|min_length[10]|max_length[10]',array('required'=>'Enter Mobile Number'));
        $this->form_validation->set_rules('alternate_mobile', 'Alternate Number', 'trim|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('email','Email','trim|valid_email|callback_check_unique_email',array('valid_email'=>'Please Enter Valid Email ID'));
        if($this->form_validation->run() == FALSE){
            $data = $this->form_validation->error_array();
            //$data = strip_tags($this->form_validation->error_string());
            //$data['error']=$this->form_validation->error_array();
            $this->response([
                'status' => False,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }else{
            $result=$this->HomeModel->signUp();
            if(is_array($result) && $result){
                $user=$result;
                //Generate the JWT token..
                $jwt = new JwtToken();
                $token = $jwt->JwtTokenGenerate($user['id'], $user['first_name'], $user['last_name'], $user['email']);
                $data['id'] = $user['id'];
                $data['first_name'] = $user['first_name'];
                $data['last_name'] = $user['last_name'];
                $data['mobile_number'] = $user['mobile_number'];
                $data['email'] = $user['email'];
                $data['birth_date'] = $user['birth_date'];
                $data['role_id'] = '';
                $data['role_name'] = '';
                $data['user_type_id'] = '';
                $data['user_type'] = '';
                $data['token'] = $token;
                $this->session->set_userdata('token', $token); 
                $data["success_message"] = "Sign Up Successfully.";
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
    // function: login_post()
    // It is used to check login for user
    public function login_post(){
        $data=array();
        $this->form_validation->set_data($this->post());
        $this->form_validation->set_rules('user_name', 'User Name','trim|required',array('required'=>'Enter User Name'));
        $this->form_validation->set_rules('password', 'Password', 'required',array('required'=>'Enter Password'));
        if($this->form_validation->run() == FALSE){
            $data = $this->form_validation->error_array();
            $this->response([
                'status' => False,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }else{
            $result=$this->HomeModel->checkLogin();
            if(isset($result['status']) && $result['status']==2 && isset($result['user']) && $result['user']){
                $user=$result['user'];
                //Generate the JWT token..
                $jwt = new JwtToken();
                $token = $jwt->JwtTokenGenerate($user->id, $user->first_name, $user->last_name, $user->email);
                $data['id'] = $user->id;
                $data['first_name'] = $user->first_name;
                $data['last_name'] = $user->last_name;
                $data['mobile_number'] = $user->mobile_number;
                $data['email'] = $user->email;
                $data['birth_date'] = $user->birth_date;
                $data['role_id'] = $user->role_id;
                $data['role_name'] = $user->role_name;
                $data['user_type_id'] = $user->user_type_id;
                $data['user_type'] = $user->user_type;
                $data['token'] = $token;
                $this->session->set_userdata('token', $token); 
                //print_r($_SESSION);
                $data["success_message"] = "Welcome to Oasis Movement!";
                $this->response([
                    'status' => True,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }else if(isset($result['status']) && $result['status']==1){
                $data["error_message"] = "Your account is currently inactive. Please contact administration for further details.";
                $this->response([
                    'status' => False,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }else if(isset($result['status']) && $result['status']==0){
                $data["error_message"] = "Invalid Username Or Password. Please Try Again.";
                $this->response([
                    'status' => False,
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
    // function: forgot_password_post()
    // It is used to send email to user to change password
    public function forgot_password_post(){
        $data=array();
        $this->form_validation->set_data($this->post());
        $this->form_validation->set_rules('email','Email','trim|required|valid_email',array('required'=>'Enter Email','valid_email'=>'Please Enter Valid Email ID'));
        if($this->form_validation->run() == FALSE){
            $data = $this->form_validation->error_array();
            $this->response([
                'status' => False,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }else{
            $email=$this->input->post('email');
            $result=$this->HomeModel->checkForValidEmail($email);
            if(isset($result['status']) && $result['status']==2 && isset($result['user']) && $result['user']){
                $result=$this->HomeModel->sendForgotPasswordEmail($result['user']);
                if($result==1){
                    $data["success_message"] = "Please check your email to reset password.";
                    $this->response([
                        'status' => True,
                        'message' => $data,
                    ], REST_Controller::HTTP_OK);
                }else if($result==2){
                    $data["error_message"] = "Email Can Not Be Sent. Please Try Again.";
                    $this->response([
                        'status' => False,
                        'message' => $data,
                    ], REST_Controller::HTTP_OK);
                }else{
                    $data["error_message"] = "Something Went Wrong. Please Try Again.";
                    $this->response([
                        'status' => False,
                        'message' => $data,
                    ], REST_Controller::HTTP_OK);
                }
            }else if(isset($result['status']) && $result['status']==1){
                $data["error_message"] = "Your account is currently inactive. Please contact administration for further details.";
                $this->response([
                    'status' => False,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }else if(isset($result['status']) && $result['status']==0){
                $data["error_message"] = "Email ID not found. Please Try Again.";
                $this->response([
                    'status' => False,
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
    // function: reset_password_form_get()
    // It is used to fetch reset password form
    public function reset_password_form_get(){
        $id=base64_decode($this->input->get('id'));
        $code=base64_decode($this->input->get('code'));
        $result=$this->HomeModel->checkForValidUser($id,$code);
        if($result){
            $data['user_id']=$this->input->get('id');
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
    // function: reset_password_post()
    // It is used to reset password
    public function reset_password_post(){
        $data=array();
        $this->form_validation->set_rules('password', 'New Password', 'trim|required|min_length[6]|max_length[32]|callback_is_password_strong',array('required'=>'Enter New Password'));
        $this->form_validation->set_rules('confirm_password', 'Confirm New Password', 'required|matches[password]',array('required'=>'Enter Confirm New Password','matches'=>'Password does not match'));
        if($this->form_validation->run() == FALSE){
            $data = $this->form_validation->error_array();
            $this->response([
                'status' => False,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }else{
            $result=$this->HomeModel->resetPassword();
            if($result==1){
                $data["success_message"] = "Password reset successfully.";
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
    // function: logout_get()
    // It is used to logout user from system
    public function logout_get(){
        $this->session->sess_destroy();
        $this->response([
            'status' => TRUE,
            'message' => 'Logout Successfully',
        ], REST_Controller::HTTP_OK);
    }
    // function: check_authentication()
    // It is used to check user authention
    public function check_authentication_get(){
        if(check_token()){
            $this->response([
                'status' => TRUE,
                'message' => 'Valid User!',
            ], REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }
    }
    // function: profile_details_get()
    // It is used to get login user details
    public function profile_details_get(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data['profiledetails']=$this->HomeModel->getProfileDetails();
            $this->response([
                'status' => True,
                'message' => $data,
            ], REST_Controller::HTTP_OK);
        }
    }
    // function: change_profile()
    // It is used to edit login user profile
    public function change_profile_post(){
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
            $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required|min_length[10]|max_length[10]',array('required'=>'Enter Mobile Number'));
            $this->form_validation->set_rules('alternate_mobile', 'Alternate Number', 'trim|min_length[10]|max_length[10]');
            $this->form_validation->set_rules('email','Email','trim|valid_email|callback_check_unique_email_edit',array('valid_email'=>'Please Enter Valid Email ID'));
            if($this->form_validation->run() == FALSE){
                $data = $this->form_validation->error_array();
                $this->response([
                    'status' => False,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }else{
                $result=$this->HomeModel->changeProfile();
                if($result==1){
                    $data["success_message"] = "Profile updated successfully";
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
    // function: check_unique_email_edit($email)
    // It is used to check for unique email id for user
    public function check_unique_email_edit($email){
        if($email){
            $result=$this->HomeModel->checkUniqueEmailEdit($email);
            if(!$result){
               $this->form_validation->set_message('check_unique_email_edit', 'Email ID already exists.');
                return FALSE; 
            }
        }
        return TRUE;
    }
    // function: change_password_post()
    // It is used to change password
    public function change_password_post(){
        if(!check_token()){
            $this->response([
                'status' => False,
                'message' => 'Invalid User!',
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }else{
            $data=array();
            $this->form_validation->set_data($this->post());
            $this->form_validation->set_rules('old_password', 'Old Password', 'required|callback_check_old_password',array('required'=>'Enter Old Password'));
            $this->form_validation->set_rules('password', 'Password', 'required',array('required'=>'Enter Password'));
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]',array('required'=>'Enter Confirm Password','matches'=>'Password does not match'));
            if($this->form_validation->run() == FALSE){
                $data = $this->form_validation->error_array();
                $this->response([
                    'status' => False,
                    'message' => $data,
                ], REST_Controller::HTTP_OK);
            }else{
                $result=$this->HomeModel->changePassword();
                if($result==1){
                    $data["success_message"] = "Password changed successfully";
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
    // function: check_old_password($old_password)
    // It is used to check for old password
    public function check_old_password($old_password){
        if($old_password){
            $result=$this->HomeModel->checkOldPassword($old_password);
            if(!$result){
               $this->form_validation->set_message('check_old_password', 'Old password does not match.');
                return FALSE; 
            }
        }
        return TRUE;
    }
    //Create strong password 
    public function is_password_strong($password){
        $password = trim($password);
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>ยง~]/';
        if(!(preg_match('#[0-9]#', $password) && preg_match('#[a-zA-Z]#', $password))){
            $this->form_validation->set_message('is_password_strong', 'Password must contain alphanumeric characters.');
            return FALSE;
        }
        if(preg_match_all($regex_special, $password) < 1){
            $this->form_validation->set_message('is_password_strong', 'Password must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>ยง~'));
            return FALSE;
        }
        return TRUE;
    }
    //strong password end
}