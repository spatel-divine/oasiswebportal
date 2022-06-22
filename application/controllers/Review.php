<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Review extends CI_Controller {
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
		//Load the dynamic form model
		$this->load->model('Master/DynamicformModel');
    }
    // *************** Start Preview Feedback Form *********************
	// function: program_feedback_preview()
	// It is used to display preview of program feedback form
    public function program_feedback_preview(){
    	$data=array();
		$this->load->model('Master/BatchModel');
		$data['batch_list']=$this->BatchModel->getBatchList();
		$this->load->model('Master/UserTypeModel');
		$data['user_types']=$this->UserTypeModel->getUserTypesListByTypeName(USER_TYPE_IDS_FOR_F_CF_V);
		$data['program_feedback'] = $this->DynamicformModel->getProgramFeedback();
		$this->load->view('program_feedback_preview',$data);
	}
	// function: personal_reflection_preview()
	// It is used to display preview of program feedback form
    public function personal_reflection_preview(){
    	$data=array();
		$this->load->model('Master/BatchModel');
		$data['batch_list']=$this->BatchModel->getBatchList();
		$this->load->model('Master/UserTypeModel');
		$data['user_types']=$this->UserTypeModel->getUserTypesListByTypeName(USER_TYPE_IDS_FOR_F_CF);
		$data['personal_learning'] = $this->DynamicformModel->getPersonalLearning();
		$this->load->view('personal_reflection_preview',$data);
	}
	// function: feedback_for_participants_preview()
	// It is used to display preview of feedback for participants form
    public function feedback_for_participants_preview(){
    	$data=array();
		$this->load->model('Master/BatchModel');
		$data['batch_list']=$this->BatchModel->getBatchList();
		$this->load->model('Master/UserTypeModel');
		$data['user_types']=$this->UserTypeModel->getUserTypesListByTypeName(USER_TYPE_IDS_FOR_F_CF);
		$data['feedback_participant'] = $this->DynamicformModel->getFeedbackParticipant();
		$this->load->view('feedback_for_participants_preview',$data);
	}
	// function: program_feedback_by_participant_preview()
	// It is used to display preview of program feedback by participants form
	public function program_feedback_by_participant_preview(){
		$data=array();
		$this->load->model('Master/BatchModel');
		$data['batch_list']=$this->BatchModel->getBatchList();
		$data['feedback_by_participant'] = $this->DynamicformModel->getFeedbackByParticipant();
		$this->load->view('program_feedback_by_participant_preview',$data);
	}
	// function: star_participants_preview()
	// It is used to display preview of star participants form
	public function star_participants_preview(){
		$data=array();
		$this->load->model('Master/BatchModel');
		$data['batch_list']=$this->BatchModel->getBatchList();
		$this->load->model('Master/UserTypeModel');
		$data['user_types']=$this->UserTypeModel->getUserTypesListByTypeName(USER_TYPE_IDS_FOR_F);
		$data['star_participant'] = $this->DynamicformModel->getStarParticipant();
		$this->load->view('star_participants_preview',$data);
	}
	// function: star_participants_preview()
	// It is used to display preview of star participants form
	public function impact_on_character_traits_preview(){
		$data=array();
		$this->load->model('Master/BatchModel');
		$data['batch_list']=$this->BatchModel->getBatchList();
		$data['impact_on_character_traits'] = $this->DynamicformModel->getImactOnCharacterTraits();
		$data['parameter_or_characteristics_list'] = $this->DynamicformModel->getParameterOrCharacteristicsList();
		$this->load->view('impact_on_character_traits_preview',$data);
	}
	// *************** End Preview Feedback Form *********************
}