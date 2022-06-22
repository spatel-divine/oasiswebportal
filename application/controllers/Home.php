<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
	public function __construct(){
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
    	$this->load->model('HomeModel');
    }
    // function: index()
	// It is used to display home page
	public function index(){
		$this->load->view('home');
	}
	// function: fetch_all_controller_method()
	// It is used to assign/edit rights to user/role	
	public function fetch_all_controller_method(){
		$this->HomeModel->addAssignRights();
	}
	// function: error403()
	// It is used to assign/edit rights to user/role	
	public function error403(){
		$this->load->view('errors/error403');
	}
}
