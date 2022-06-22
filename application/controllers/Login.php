<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	public $userLoginModalObj;
	public function __construct() {
    	 parent::__construct();
		 $this->load->model('UserloginModel');
		 $this->userLoginModalObj = new UserloginModel;
    }
	public function index(){
		if(is_logged_in()){
		    redirect('home');
		}else{
			$this->load->view('index');
		}
	}
	public function loginAuth(){
		//Check the validation as blank..
		$this->form_validation->set_rules('user_name', 'User Name', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE){
            $this->session->set_flashdata('errors', validation_errors());
            $this->load->view('index');
        }else{
			$result =  $this->userLoginModalObj->login_auth();
			if($result == '')
			{
			 	redirect('home');
			}
			else
			{
			 	$this->session->set_flashdata('message',$result);
				$this->load->view('index');
			}
		}
	}
	/** 
	 * Session logout
	 */
	function logout(){
		$data = $this->session->all_userdata();
		foreach($data as $row => $rows_value){
			$this->session->unset_userdata($row);
		}
		redirect('login');
	}
}
