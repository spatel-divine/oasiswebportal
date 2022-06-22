<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Checkassignrights extends CI_Controller {
	public function __construct(){
    	parent::__construct();
    }
	// function: check_assign_rights()
	// It is used to check assign rights to user/role
	public function check_assign_rights(){
		$controller = strtolower($this->router->fetch_class());
		$method = strtolower($this->router->fetch_method());
		$result=checkAssignRights($controller,$method);
		if(!$result){
		 	redirect('home/error403');
		}
	}
}